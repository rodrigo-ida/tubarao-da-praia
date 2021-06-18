<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\OrderUpdatedStatusTime;

use App\Http\Controllers\Controller;

class OrderUpdateStatusTime extends Controller
{
    public function index()
    {
        $times = OrderUpdatedStatusTime::select('*')
        ->with('getUser')
        ->orderBy('order_status_updated_id')
        ->paginate(15);


        return view('admin.orderstatustime.index', compact('times'));
    }
}
