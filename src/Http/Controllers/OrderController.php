<?php

namespace Dataview\IOCompany;

use Dataview\IntranetOne\IOController;
use Illuminate\Http\Request;
use Dataview\IOCompany\Order;
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

    public function sendOrderEmail($orderId) {
        $order = Order::where('id', $orderId)->with('company')->first();
        Mail::to($order->company->email)->send(new NewOrderPlaced($order->toArray()));
        return response()->json(['success'=>true, 'order' => $order]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dump($request->wirecard_data);

        $order = new Order([
            'company_cnpj' => json_decode($request->company)->cnpj,
            'plan_id' => json_decode($request->plan)->id,
            'max_portions' => $request->max_portions,
            'wirecard_data' => $request->wirecard_data
        ]);

        if($order->save()) {
            $this->sendOrderEmail($order->id);
        }
        dump($order);

        // return response()->json(['success'=>$customer]);
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
