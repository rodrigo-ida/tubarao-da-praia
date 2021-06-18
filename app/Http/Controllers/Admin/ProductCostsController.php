<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductCost;
use App\Product;
use Illuminate\Support\Facades\Redirect;

class ProductCostsController extends Controller
{
    
    public function index()
    {
        $costs = ProductCost::select()
        ->with(['product'])
        ->paginate(15);

        return view('admin.productcosts.index', compact('costs'));
    }

    public function create()
    {
        $product = Product::getProducts();
        return view('admin.productcosts.create', compact('product'));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $cost = new ProductCost();

        $cost->fill($data);

        if (!$cost->validate(true)){
            return Redirect::back()->withInput($request->all())->withErrors($cost->getErrors());
        }

        $cost->save();

        return redirect()->route('admin.prodcosts.index');

    }

    public function edit($id)
    {

        $cost = ProductCost::find($id);

        $product = Product::getProducts();

        return view('admin.productcosts.edit', compact('cost', 'product'));
    }

    public function update(Request $request, $id)
    {
        $cost = ProductCost::findOrFail($id);

        $data = $request->all();

        $required_fields = [];
        if (!$cost->validate(false)) {
            $required_fields = [];
            foreach ($cost->getErrors()->getMessages() as $key => $value){
                $required_fields[] = $key;
            }
        }
        
        $cost->fill($data);
        
        if (!$cost->validate(false)) 
        {          
            return Redirect::back()->withInput($request->all())->withErrors($cost->getErrors());
        }

        $cost->save();

        return redirect()->route('admin.prodcosts.index');
    }

    public function destroy($id)
    {
        $cost = ProductCost::findOrFail($id);

        $cost->destroy($id);

        return redirect()->route('admin.prodcosts.index');
    }

}
