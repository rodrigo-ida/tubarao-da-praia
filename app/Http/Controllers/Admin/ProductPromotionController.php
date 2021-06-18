<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductPromotion;
use App\Product;
use Illuminate\Support\Facades\Redirect;

class ProductPromotionController extends Controller
{
    /**
     * @var Product
     */
    private $model;

    public function __construct(ProductPromotion $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $productPromotion = ProductPromotion::select('*')
        ->orderBy('id', 'desc')
        ->paginate(15);
        
        return view('admin.productspromotion.index', compact('productPromotion'));
    }

    public function create()
    {
        return view('admin.productspromotion.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        
        $data['price_promotion_after'] = doubleval($data['price_promotion_after']);
        
        $promotion = new ProductPromotion();

        $promotion->fill($data);

        if (!$promotion->validate(true)){
            return Redirect::back()->withInput($request->all())->withErrors($promotion->getErrors());
        }

        $promotion->save();
        
        return redirect()->route('admin.prodpromotions.index');
    }

    public function edit($id)
    {
        $promotion = ProductPromotion::find($id);

        return view('admin.productspromotion.edit', compact('promotion'));
    }

    public function update(Request $request, $id)
    {
        $promotion = ProductPromotion::findOrFail($id);

        $data = $request->all();

        $required_fields = [];
        if (!$promotion->validate(false)) {
            $required_fields = [];
            foreach ($promotion->getErrors()->getMessages() as $key => $value){
                $required_fields[] = $key;
            }
        }
        
        $promotion->fill($data);
        
        if (!$promotion->validate(false)) 
        {          
            return Redirect::back()->withInput($request->all())->withErrors($promotion->getErrors());
        }

        $promotion->save();

        return redirect()->route('admin.prodpromotions.index');
    }

    public function destroy($id)
    {
        $promotion = new ProductPromotion();

        $promotion->find($id);

        if($promotion)
        {
            
        $products = Product::select('*')
        ->where('product.promotion_id', '=', $id)
        ->get();

        foreach($products as $product)
        {

            $update = Product::where('id', $product->id)->update(array(
                'promotion_id'     => "0",
                'promotion_active' => "0"
            ));
    
        }
    
        $promotion->destroy($id);

        return redirect()->route('admin.prodpromotions.index');
        
        }

    }
}
