<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use App\Avaliation;

class AvaliationController extends Controller
{
    public function index($token)
    {

        $ava = Avaliation::select('*')
        ->where('token', '=', $token)
        ->get();

        return view('delivery.avaliacao', compact('ava'));
    }

    public static function create($id, $orderId)
    {
       $token = Hash::make($id);

       $data['token']     = $token;

       $data['client_id'] = $id;

       $data['order_id']  = $orderId;
        
       $ava = new Avaliation();

       $ava->fill($data);

       $ava->save();
    }

    public function update(Request $request)
    {
        $data = $request->all();

        $ava  = Avaliation::find($data['data_id']);

        $data['avaliation_status'] = '1';

        $ava->fill($data);
        
        $ava->save();
    }
}
