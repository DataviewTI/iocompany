<?php

namespace Dataview\IOCompany;

use Dataview\IntranetOne\IOController;
use Illuminate\Http\Request;
use Dataview\IOCompany\Order;
use Dataview\IOCompany\Company;
use Validator;
use DataTables;
use Session;
use Illuminate\Support\Facades\Mail;
use Dataview\IOCompany\Mail\NewOrderPlaced;

class OrderController extends IOController
{
    public function list(){
        $query = Order::with(['company', 'plan'])->get();
        // dump(json_decode($query[0]->wirecard_data));
        foreach ($query as $key => $order) {
            $query[$key]->wirecard_data = json_decode($order->wirecard_data);
        }

        return Datatables::of($query)->make(true);
        // return response()->json([$query]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function syncPayments(Request $request)
    {
        try {
            $token = base64_encode(config('wirecard.token').':'.config('wirecard.key'));

            $http = new \GuzzleHttp\Client;

            $res = $http->get(config('wirecard.endpoint').'/v2/orders', [
                'headers' => [
                    'Authorization' => 'Basic '.$token,
                ],
            ]);

            $ret = json_decode($res->getBody());

            foreach (Order::all() as $order) {
                foreach ($ret->orders as $wirecardOrder) {
                    if($order->wirecard_data != null) {
                        if($wirecardOrder->id == json_decode($order->wirecard_data)->id) {
                            $order->wirecard_data = json_encode($wirecardOrder);
                            $order->save();
                        }
                    }
                }
            }
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            report($e);
            return response()->json(['success'=>false, 'error' => $e->getMessage()]);
        }

        return response()->json(['success'=>true]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $token = base64_encode(config('wirecard.token').':'.config('wirecard.key'));

        $order = [
            'company_cnpj' => $request['company']['cnpj'],
            'plan_id' => $request['plan']['id'],
            'max_portions' => $request['max_portions'],
        ];

        if ($request->has(['credit_card', 'boleto'])) {
            $order['payment_method'] = null;
        } else if ($request->has('credit_card')) {
            $order['payment_method'] = 'CREDIT_CARD';
        } else if ($request->has('boleto')) {
            $order['payment_method'] = 'BOLETO';
        }

        $order = Order::create($order);

        try {
            $http = new \GuzzleHttp\Client;

            $res = $http->post(config('wirecard.endpoint').'/v2/orders',[
                'headers' => [
                    'Authorization' => 'Basic '.$token,
                ],
                'json' => [
                    'ownId' => $order->id,
                    'amount' => [
                        'currency' => 'BRL',
                    ],
                    'items' => [
                        [
                            'product' => 'Plano Palmjob =>  '.$order->plan->name,
                            'category' => 'BUSINESS_AND_INDUSTRIAL',
                            'quantity' => 1,
                            'detail' => $order->plan->description,
                            'price' => str_replace('.', '', $order->plan->amount)
                        ]
                    ],
                    'checkoutPreferences' => [
                        'redirectUrls' => [
                            'urlSuccess' => config('app.url').'/payment-success'
                        ]
                    ],
                    'customer' => [
                        'ownId' => $order->company->cnpj,
                        'fullname' => $order->company->razaoSocial,
                        'email' => $order->company->email,
                        'birthDate' => '2019-01-01',
                        'taxDocument' => [
                            'type' => 'CNPJ',
                            'number' => $order->company->cnpj
                        ],
                        'phone' => [
                            'countryCode' => '55',
                            'areaCode' => '00',
                            'number' => $order->company->phone
                        ],
                        'shippingAddress' => [
                            'city' => $order->company->city_id,
                            'district' => $order->company->address2,
                            'street' => $order->company->address,
                            'streetNumber' => $order->company->numberApto,
                            'zipCode' => $order->company->zipCode,
                            'state' => $order->company->city->state,
                            'country' => 'BRA'
                        ]
                    ],
                ]
            ]);

            $ret = json_decode($res->getBody());

            $order->update([
                'wirecard_data' => json_encode($ret)
            ]);
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            report($e);
            return response()->json(['success'=>false, 'error' => $e->getMessage()]);
        }

        if($order) {
            $order->sendPaymentEmail();
        }

        return response()->json(['success'=>$order]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
