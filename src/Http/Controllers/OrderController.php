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

        $payment = $order->createPayment();

        if(!$payment['success'])
            return response()->json(['success'=>false, 'data'=>$payment['data']]);

        if($order) {
            $order->sendPaymentEmail();
        }

        return response()->json(['success'=>true]);
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
