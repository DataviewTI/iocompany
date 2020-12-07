<?php

namespace Dataview\IOCompany;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class Order extends Model implements AuditableContract
{
    use Auditable;
	use SoftDeletes;
    protected $auditTimestamps = true;

    protected $fillable = [
        'company_cnpj',
        'plan_id',
        'max_portions',
        'wirecard_data',
        'payment_method',
    ];

    protected $casts = [
        'wirecard_data' => 'json',
    ];

    public $timestamps = true;

    public function plan() {
        return $this->belongsTo('Dataview\IOCompany\Plan');
    }

    public function company() {
        return $this->belongsTo('Dataview\IOCompany\Company', 'company_cnpj', 'cnpj');
    }

    public function sendPaymentEmail() {
        $data = [
            'payment_method' => $this['payment_method'],
            'wirecardData' => json_decode($this->wirecard_data, true)
        ];

        try {
            if(class_exists('\App\Notifications\NewPaymentCreatedNotification')) {
                $company = Company::where('cnpj', $this->company_cnpj)->first();
                $company->notify(new \App\Notifications\NewPaymentCreatedNotification($this));
            } else {
                Mail::to($this->company->email)->send(new NewOrderPlaced($data));
            }
            return ['success'=>true];
        } catch (\Exception $ex) {
            report($ex);
            return ['success' => false, 'error' => $ex->getMessage()];
        }
    }

    public function paymentLink() {
        if($this->wirecard_data != null) {
            return \json_decode($this->wirecard_data, true)['_links']['checkout']['payCheckout']['redirectHref'];
        }

        return '';
    }

    public function createPayment() {
        $token = base64_encode(config('wirecard.token').':'.config('wirecard.key'));

        try {
            $http = new \GuzzleHttp\Client;

            $res = $http->post(config('wirecard.endpoint').'/v2/orders',[
                'headers' => [
                    'Authorization' => 'Basic '.$token,
                ],
                'json' => [
                    'ownId' => $this->id,
                    'amount' => [
                        'currency' => 'BRL',
                    ],
                    'items' => [
                        [
                            'product' => 'Plano Empresarial Trampo Jobs '.$this->plan->name,
                            'category' => 'BUSINESS_AND_INDUSTRIAL',
                            'quantity' => 1,
                            'detail' => $this->plan->description,
                            'price' => str_replace('.', '', $this->plan->amount)
                        ]
                    ],
                    'checkoutPreferences' => [
                        'redirectUrls' => [
                            'urlSuccess' => config('app.url').'/empresa/login'
                        ]
                    ],
                    'customer' => [
                        'ownId' => $this->company->cnpj,
                        'fullname' => $this->company->razaoSocial,
                        'email' => $this->company->email,
                        'birthDate' => '2019-01-01',
                        'taxDocument' => [
                            'type' => 'CNPJ',
                            'number' => $this->company->cnpj
                        ],
                        'phone' => [
                            'countryCode' => '55',
                            'areaCode' => '00',
                            'number' => $this->company->phone
                        ],
                        'shippingAddress' => [
                            'city' => $this->company->city_id,
                            'district' => $this->company->address2,
                            'street' => $this->company->address,
                            'streetNumber' => $this->company->numberApto,
                            'zipCode' => $this->company->zipCode,
                            'state' => $this->company->city->state,
                            'country' => 'BRA'
                        ]
                    ],
                ]
            ]);

            $ret = json_decode($res->getBody());

            $this->update([
                'wirecard_data' => json_encode($ret)
            ]);

            return ['success'=>true, 'data' => $ret];
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            report($e);
            return ['success'=>false, 'error' => $e->getMessage()];
        }
    }
}
