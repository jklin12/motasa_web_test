<?php

namespace App\Http\Controllers;

use App\Services\BiteshipService;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getAreaID(Request $request)
    {

        $request->validate([
            'q' => 'required'
        ]);
        $biteShip = new BiteshipService();
        $response = $biteShip->getAreaID($request->q);

        $result[] = [];
        if (count($response['areas']) > 0) {
            foreach ($response['areas'] as $key => $value) {
                $result[] = [
                    'id' => $value['id'],
                    'text' => $value['name'],
                ];
            }
        }
        return response()->json(['results' => $result]);
    }

    public function getCourierRate(Request $request)
    {

        $request->validate([
            'from' => 'required',
            'to' => 'required'
        ]);
        $biteShip = new BiteshipService();
        $items[] = [
            "name" => "Shoes",
            "description" => "Black colored size 45",
            "value" => 199000,
            "length" => 30,
            "width" => 15,
            "height" => 20,
            "weight" => 200,
            "quantity" => 2,
        ];

        $payload = [
            "origin_area_id" => $request->from,
            "destination_area_id" => $request->to,
            "couriers" => "paxel,jne,sicepat,jnt,idexpress",
            "items" => $items
        ];

        $response = $biteShip->getCourierRate($payload);
        //$response['success'] = false;
    
        $result = '<div class="alert alert-warning alert-dismissible fade show mx-2 my-2" role="alert"><strong>Maaf!</strong> harga tidak bisa dimuat! <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
        if ($response['success']) {
            $result = '';
            foreach ($response['pricing'] as $key => $value) {
                $result .= '<tr>
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="selected_courier" value="'.$value['courier_name'].'" id="selected-courier-">
                        <label class="form-check-label" for="selected-courier-"></label>
                    </div>
                </td>
                <td><input type="hidden" name="'.$value['courier_name'].'[courier_name]" value="'.$value['courier_name'].'">'.$value['courier_name'].'</td>
                <td><input type="hidden" name="'.$value['courier_name'].'[courier_service_name]" value="'.$value['courier_service_name'].'">'.$value['courier_service_name'].'</td>
                <td>'.$value['description'].'</td>
                <td><input type="hidden" name="'.$value['courier_name'].'[shipping_duration]" value="'.$value['duration'].'">'.$value['duration'].'</td>
                <td><input type="hidden" name="'.$value['courier_name'].'[shipping_price]" value="'.$value['price'].'">Rp.'.number_format($value['price'],0,2).'</td>
            </tr>';
            }
        }
        return response()->json($result);
    }
}
