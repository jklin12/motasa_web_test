<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DeliveryOrder;
use App\Models\HistoryDo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeliveryOrderController extends Controller
{
    public function index(){

        $do = DeliveryOrder::where('do_status','!=','Draft')->get();        
         
        $load['message'] = "success";
        $load['data'] = $do;

        return response()->json($load);
    }

    public function show($doId){

        $do = DeliveryOrder::with('products','history.owner','owner')->find($doId);        
         
        $load['message'] = "success";
        $load['data'] = $do;

        return response()->json($load);
    }

    public function update($doId,Request $request){

        $validator = Validator::make($request->all(), [
            'do_status' => 'required',
            'history_notes' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 401);
        }
    
        $do = DeliveryOrder::find($doId);        
        $do->do_status = $request->do_status;
        $do->save();

        $history = new HistoryDo();
        $history->do_id = $do->do_id;
        $history->do_status = $request->do_status;
        $history->history_notes = $request->history_notes;
        $history->save();

        $load['status'] = true;
        $load['message'] = "Update data do berhasil";
        $load['data'] = $do;

        return response()->json($load);
    }
}
