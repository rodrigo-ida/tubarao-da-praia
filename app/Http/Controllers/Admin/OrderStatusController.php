<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\OrderStatus;
use Illuminate\Support\Facades\Redirect;

class OrderStatusController extends Controller
{
    
    public function index()
    {
        $status = OrderStatus::select('*')
        ->paginate(15);

        return view('admin.orderstatus.index', compact('status'));
    }

    public function create()
    {
        return view('admin.orderstatus.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $status = new OrderStatus();

        $status->fill($data);

        if (!$status->validate(true)){
            return Redirect::back()->withInput($request->all())->withErrors($status->getErrors());
        }

        $status->save();

        return redirect()->route('admin.orderstatus.index');
    }

    public function destroy($id)
    {
        $status = OrderStatus::find($id);

        if($status)
        {
            $destroy = OrderStatus::destroy($id);
        }

        return redirect()->route('admin.orderstatus.index');
    } 

}
