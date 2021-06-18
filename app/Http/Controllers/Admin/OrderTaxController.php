<?php



namespace App\Http\Controllers\Admin;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\OrderTax;

use Illuminate\Support\Facades\Redirect;

use App\Http\Controllers\StaticMethodsController;



class OrderTaxController extends Controller

{

    public function index()

    {

        $taxes = OrderTax::select('*')

            ->with(['getLoja'])
            ->where('order_tax_loja_id','4')

            ->orderBy('id', 'desc')

            ->paginate(100);

    //dd($taxes);
            
        return view('admin.ordertax.index', compact(['taxes']));
    }

    public function create()
    {

        $lojas = StaticMethodsController::getLojasList();

        return view('admin.ordertax.create', compact(['lojas']));
    }

    public function calculateOrderTax($add, $add2)
    {

        $vl = StaticMethodsController::getDistance($add, $add2);

        $vl = intval(str_replace('.', '', strval($vl)));

        $vl = ($vl / 1000) * env('TAXA') + env('TAXA_BASE');
        
        //$vl = env('TAXA_BASE');

        return round($vl);
    }

    public function store(Request $request)
    {

        try {

            $data = $request->all();

            $tax = new OrderTax();

            $tax->fill($data);

            if (!$tax->validate(true)) {

                return Redirect::back()->withInput($request->all())->withErrors($tax->getErrors());
            }

            $tax->save();

            return redirect()->route('admin.ordertax.index');;
        } catch (\Exception $e) {

            return redirect()->route('admin.ordertax.index');
        }
    }

    public function edit($id)
    {
        
        $tax = OrderTax::find($id);
        //New Code
        
        $d = new \DateTime($tax['order_shipping_time']);
        $d =date_format($d, 'H:i');
        $tax['order_shipping_time'] = $d;
        
        //End Of New Code 20/08/2020 Lass

        $lojas = StaticMethodsController::getLojasList();

        return view('admin.ordertax.edit', compact(['tax', 'lojas']));
    }

    public function update(Request $request, $id)
    {

        try {

            if ($request) {

                $data = $request->all();

                $tax  = OrderTax::find($id);

                $tax->fill($data);

                if (!$tax->validate(true)) {

                    return Redirect::back()->withInput($request->all())->withErrors($tax->getErrors());
                }

                $tax->save();
            }

            return redirect()->route('admin.ordertax.index');
        } catch (\Exception $e) {

            return redirect()->route('admin.ordertax.index');
        }
    }
    
    
     public function searchOrderTaxName($name)
    {

        $name = str_replace(' ', '%', $name);

        $taxes = OrderTax::select('*')

            ->where('order_tax.order_tax_neighborhood', 'LIKE', $name)

            ->where('order_tax.order_tax_status', '!=', '2')

            ->orderBy('id')->paginate(15);

        if ($taxes->count() <= 0) {
            $name = '%' . $name . '%';

            $taxes = OrderTax::select('*')

                  ->where('order_tax.order_tax_neighborhood', 'LIKE', $name)

            ->where('order_tax.order_tax_status', '!=', '2')

                ->orderBy('id')->paginate(15);
        }

        
        
        return view('admin.ordertax.index', compact(['taxes']));
    }

    public function destroy($id)
    {

        if (!empty($id)) {

            $destroy = OrderTax::find($id);

            if ($destroy) {

                $destroy->destroy($id);
            }
        }

        return redirect()->route('admin.ordertax.index');
    }
}
