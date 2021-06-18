<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\LojaPaymentMethods;

use Illuminate\Support\Facades\Redirect;

use App\Http\Controllers\StaticMethodsController;

class LojaPaymentMethodsController extends Controller
{

    public function index()
    {

        $methods = LojaPaymentMethods::select(
            'payment_methods_loja.id',
            'loja.nome_loja',
            'payment_methods.name_method'
        )

            ->join('loja', 'payment_methods_loja.payment_method_loja_id', '=', 'loja.id')

            ->join('payment_methods', 'payment_methods_loja.payment_method_ids', '=', 'payment_methods.id')

            ->where('loja.status', '=', strval(\App\Loja::LOJA_ATIVA))

        // ->with(['getLojas'])

        // ->with(['getPaymentMethods'])

            ->paginate(15);

        return view('admin.lojamethods.index', compact('methods'));

    }

    public function create()
    {

        $lojas = StaticMethodsController::getLojasList();

        $methods = StaticMethodsController::getPaymentMethods();

        return view('admin.lojamethods.create', compact(['lojas', 'methods']));

    }

    public function store(Request $request)
    {

        $data = $request->all();

        //$data['payment_method_ids'] = $this->prepareMethods($request->input('payment_method_ids'));

        $method = new LojaPaymentMethods();

        $method->fill($data);

        if (!$method->validate(true)) {

            return Redirect::back()->withInput($request->all())->withErrors($method->getErrors());
        }

        $method->save();

        return redirect()->route('admin.lojapaymentmethod.index');
    }

    public function destroy($id)
    {

        $method = LojaPaymentMethods::findOrFail($id);

        if ($method) {

            $method->destroy($id);

        }

        return redirect()->route('admin.lojapaymentmethod.index');
    }
}

