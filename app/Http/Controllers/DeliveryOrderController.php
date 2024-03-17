<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOrder;
use App\Models\HistoryDo;
use App\Models\PrefixNumber;
use App\Models\ProductOrder;
use App\Services\BiteshipService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryOrderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = (auth()->user());

        $do = DeliveryOrder::where('created_by', $user->id)->paginate(10);

        $load['do'] = $do;
        return view('pages.do.index', $load);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.do.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $postVal = $request->all();
        if (!$request->draft) {
            $request->validate(
                [
                    'order_date' => 'required',
                    'order_number' => 'required',
                    'cust_name' => 'required',
                    'cust_phone' => 'required',
                    'cust_email' => 'required|email',
                    'cust_address' => 'required',
                    'do_notes' => 'nullable',
                    'do_from' => 'required',
                    'do_from_detail' => 'required',
                    'do_to' => 'required',
                    'do_to_detail' => 'required',
                    'selected_courier' => 'required',
                    //'product_data.product_data.*.product_name' => 'required',
                    //'product_data.product_data.*.product_qty' => 'required',
                    //'product_data.product_data.*.product_price' => 'required',
                ]
            );
        }

        $do = new DeliveryOrder();
        $do->order_date = $request->order_date;
        $do->order_number = $request->order_number;
        $do->cust_name = $request->cust_name;
        $do->cust_phone = $request->cust_phone;
        $do->cust_email = $request->cust_email;
        $do->cust_address = $request->cust_address;
        $do->do_notes = $request->do_notes;
        $do->do_from = $request->do_from;
        $do->do_from_detail = $request->do_from_detail;
        $do->do_to = $request->do_to;
        $do->do_to_detail = $request->do_to_detail;
        $do->courier_name = isset($postVal[$request->selected_courier]['courier_name']) ? $postVal[$request->selected_courier]['courier_name'] : '';
        $do->courier_service_name = isset($postVal[$request->selected_courier]['courier_service_name']) ? $postVal[$request->selected_courier]['courier_service_name'] : '';
        $do->shipping_duration = isset($postVal[$request->selected_courier]['shipping_duration']) ? $postVal[$request->selected_courier]['shipping_duration'] : '';
        $do->shipping_price = isset($postVal[$request->selected_courier]['shipping_price']) ? $postVal[$request->selected_courier]['shipping_price'] : '';
        if ($request->draft) {
            $do->do_status = 'Draft';
        } else {
            $do->do_status = 'New';
        }

        $do->save();

        $products = [];
        $productOrder = new ProductOrder();
        foreach ($request['product_data']['product_data'] as $key => $value) {
            if ($value['produk']) {
                $products[] = [
                    'do_id' => $do->do_id,
                    'product_name' => $value['produk'],
                    'product_qty' => $value['qty'],
                    'product_price' => $value['price']
                ];
            }
        }
        if ($products) {
            $productOrder->insert($products);
        }


        return redirect()->intended(route('do.show', $do->do_id))
            ->withSuccess(__('Do berhasil disimpan.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DeliveryOrder  $deliveryOrder
     * @return \Illuminate\Http\Response
     */
    public function show($doId)
    {
        $biteShip = new BiteshipService();
        $do = DeliveryOrder::with('products', 'history')->find($doId);

        //$detailPengirim = $biteShip->getLocation($do->do_from);

        $load['do'] = $do;

        return view('pages.do.show', $load);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeliveryOrder  $deliveryOrder
     * @return \Illuminate\Http\Response
     */
    public function edit($doId)
    {
        $do = DeliveryOrder::find($doId);

        $load['do'] = $do;
        return view('pages.do.edit', $load);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DeliveryOrder  $deliveryOrder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $doId)
    {
        $postVal = $request->all();
        if (!$request->draft) {
            $request->validate(
                [
                    'order_date' => 'required',
                    'order_number' => 'required',
                    'cust_name' => 'required',
                    'cust_phone' => 'required',
                    'cust_email' => 'required|email',
                    'cust_address' => 'required',
                    'do_notes' => 'nullable',
                    /*'do_from' => 'required',
                    'do_from_detail' => 'required',
                    'do_to' => 'required',
                    'do_to_detail' => 'required',
                    'selected_courier' => 'required',*/
                    //'product_data.product_data.*.product_name' => 'required',
                    //'product_data.product_data.*.product_qty' => 'required',
                    //'product_data.product_data.*.product_price' => 'required',
                ]
            );
        }

        $do =  DeliveryOrder::find($doId);
        $do->order_date = $request->order_date;
        $do->order_number = $request->order_number;
        $do->cust_name = $request->cust_name;
        $do->cust_phone = $request->cust_phone;
        $do->cust_email = $request->cust_email;
        $do->cust_address = $request->cust_address;
        $do->do_notes = $request->do_notes;
        $do->do_from = $request->do_from;
        $do->do_from_detail = $request->do_from_detail;
        $do->do_to = $request->do_to;
        $do->do_to_detail = $request->do_to_detail;
        $do->courier_name = isset($postVal[$request->selected_courier]['courier_name']) ? $postVal[$request->selected_courier]['courier_name'] : $do->courier_name;
        $do->courier_service_name = isset($postVal[$request->selected_courier]['courier_service_name']) ? $postVal[$request->selected_courier]['courier_service_name'] : $do->courier_service_name;
        $do->shipping_duration = isset($postVal[$request->selected_courier]['shipping_duration']) ? $postVal[$request->selected_courier]['shipping_duration'] : $do->shipping_duration;
        $do->shipping_price = isset($postVal[$request->selected_courier]['shipping_price']) ? $postVal[$request->selected_courier]['shipping_price'] : $do->shipping_price;
        if ($request->draft) {
            $do->do_status = 'Draft';
        } else {
            if ($do->do_status == 'Revisi') {
                $do->do_status = 'New';

                $history = new HistoryDo();
                $history->do_id = $do->do_id;
                $history->do_status = $do->do_status;
                //$history->history_notes = $request->history_notes;
                $history->save();
            }elseif ($do->do_status == 'Draft') {
                $sequence = PrefixNumber::where('key', 'do')->firstOrFail();

                $do->do_status = 'New'; 
                $do->do_number = 'DO-'.date('my').'-'.$sequence->value;
                $do->do_date = date('Y-m-d');
                $sequence->increment('value');  
            }
        }

        $do->save();
        //dd($request->all()); 
        if ($request->edit) {
            foreach ($request->edit as $key => $value) {
                ProductOrder::updateOrCreate(
                    [
                        'do_id' => $do->do_id,
                        'product_id' => $key,
                    ],
                    [
                        'product_name' => $value['produk'],
                        'product_qty' => $value['qty'],
                        'product_price' => $value['price'],
                    ]
                );
            }
        }

        $products = [];
        $productOrder = new ProductOrder();
        foreach ($request['product_data']['product_data'] as $key => $value) {
            if ($value['produk']) {
                $products[] = [
                    'do_id' => $do->do_id,
                    'product_name' => $value['produk'],
                    'product_qty' => $value['qty'],
                    'product_price' => $value['price']
                ];
            }
        }

        if ($products) {
            $productOrder->insert($products);
        }


        return redirect()->intended(route('do.show', $do->do_id))
            ->withSuccess(__('Do berhasil diupdate.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeliveryOrder  $deliveryOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy($doId)
    {
        DeliveryOrder::where('do_id', $doId)->delete();
        ProductOrder::where('do_id', $doId)->delete();

        return redirect()->intended(route('do.index'))
            ->withSuccess(__('Delivery Order berhasil dihapus.'));
    }
}
