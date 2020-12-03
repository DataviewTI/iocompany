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

    }
}
