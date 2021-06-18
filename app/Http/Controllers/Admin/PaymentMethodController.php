<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PaymentMethod;
use Illuminate\Support\Facades\Redirect;

class PaymentMethodController extends Controller
{

    public function index()
    {
        $methods = PaymentMethod::select('*')
        ->paginate(15);

        return view('admin.paymentmethod.index', compact(['methods']));
    }

    public function create()
    {
        return view('admin.paymentmethod.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $method = new PaymentMethod();

        $method->fill($data);

        if (!$method->validate(true)){
            return Redirect::back()->withInput($request->all())->withErrors($method->getErrors());
        }

        $method->save();

        return redirect()->route('admin.paymentmethod.index');
    }

    public function destroy($id)
    {
        $method = PaymentMethod::find($id);

        if($method)
        {
            $method->destroy($id);
        }

        return redirect()->route('admin.paymentmethod.index');
    }

}
