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

    public function sync(Request $request)
    {
        // dump($request->all());

        foreach (Order::all() as $order) {
            foreach ($request->all()['orders'] as $wirecardOrder) {
                if($wirecardOrder['id'] == json_decode($order->wirecard_data)->id) {
                    $order->wirecard_data = json_encode($wirecardOrder);
                    $order->save();
                }
            }
        }

        return response()->json(['success'=>true]);
    }

    public function sendOrderEmail($order) {
        $data = [
            'payment_method' => $order['payment_method'],
            'wirecardData' => json_decode($order->wirecard_data, true)
        ];
        try {
            if(class_exists('\App\Notifications\NewPaymentCreatedNotification')) {
                $company = Company::where('cnpj', $order->company_cnpj)->first();
                $company->notify(new \App\Notifications\NewPaymentCreatedNotification($order));
            } else {
                Mail::to($order->company->email)->send(new NewOrderPlaced($data));
            }
            return ['success'=>true];
        } catch (\Exception $ex) {
            return ['success' => false, 'error' => $ex->getMessage()];
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dump($request->all());

        $order = [
            'company_cnpj' => json_decode($request->company)->cnpj,
            'plan_id' => json_decode($request->plan)->id,
            'max_portions' => $request->max_portions,
            'wirecard_data' => $request->wirecard_data
        ];

        if ($request->has(['credit_card', 'boleto'])) {
            $order['payment_method'] = null;
        } elseif ($request->has('credit_card')) {
            $order['payment_method'] = 'CREDIT_CARD';
        } elseif ($request->has('boleto')) {
            $order['payment_method'] = 'BOLETO';
        }

        $order = new Order($order);

        if($order->save()) {
            $this->sendOrderEmail($order);
        }

        // dump($order);

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
