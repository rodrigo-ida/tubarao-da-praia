<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Product;

use Mockery\Exception;

use App\ProductCategories;

use App\Http\Controllers\Admin\ProductsCategoriesController;

use App\Loja;

use App\Http\Controllers\StaticMethodsController;

use App\ProductPromotion;

use App\ProductVariation;

use App\Complement;

use Illuminate\Support\Facades\Redirect;

use App\ComboVariation;

class ProductsController extends Controller
{

    /**

     * @var Product

     */

    private $model;

    public function __construct(Product $model)
    {

        $this->model = $model;
    }
    public function ajax(Request $request)
    {
        $proId = $request['idProd'];

        $products = Product::getProducts();
        $prodTest= Product::getProductsForAjax();
        
        $v = "<option value=></option>";
        $result = "";
        $product = Product::find($proId);
        $comboVars= [];
        $i = 0;
        
        $id = explode(",",$request['varName']);

        foreach($products[$request['id']] as $key => $prot){

           

            

            $protSelect = explode(" ", $prot);
           

            if($request["varName"] != "" && $id[0] == $key){
            

            $result .= '<option value=' . $key.','.$protSelect[0].' selected>'. $prot.'</option>';
            
            
            }else{

                $result .= '<option value=' . $key.','.$protSelect[0].'> '. $prot.'</option>';
            
            }
            
            
        }
        
        
        $t =  <<<EOT
        <div class="combo-variation">
    
        <label for="variation_name">
        
        
        
            <div class="form-group col-md-3">

                    Nome
                    
                    <select name="variation_name[]" id="produtos">
                    $result
                    </select>

                </div>
        
        </label>
        
        <input type="hidden" name="num_esc[]" value="$request[num]">
        <input type="hidden" name="cat_id[]" value="$request[id]">
        <input type="hidden" name="combo_id[]" value="$id[0]">
        
        <hr>
        
        </div>
        
EOT;

        return $t;
    }


        public function ajaxEdit(Request $request){

        $proId = $request['idProd']; // Id Do Produto

        $products = Product::getProducts(); // Id Com nome
        $prodTest= Product::getProductsForAjax(); // Id Com Combos
        $v = "<option value=></option>"; // Start variavel html
        $result = ""; // Starta variavel
        $product = Product::find($proId);
        $comboVars= [];
        $i = 0;
        
    //$product['combo_id'] = Combo Ids
    //$request['id'] = Categoria Id


        foreach($products[$request['id']] as $key => $prot){

            $comboIdpass = $request['idComboId'];

            $id = explode(",",$request['varName']);
            
            $protSelect = explode(" ", $prot);
           
            

            if($id[0] == "$key"){
            
            

            $result .= '<option value=' . $key.','.$protSelect[0].' selected>'. $prot.'</option>';
            
            
            }else{

                $result .= '<option value=' . $key.','.$protSelect[0].'> '. $prot.'</option>';
            
            }
            
            
        }
        
        
        $t =  <<<EOT
        <div class="combo-variation">
    
        <label for="variation_name">
        
        
        
            <div class="form-group col-md-3">

                    Nome
                    
                    <select name="variation_name[]" id="produtos">
                    $result
                    </select>

                </div>
        
        </label>
        
        <input type="hidden" name="num_esc[]" value="$request[num]">
        <input type="hidden" name="cat_id[]" value="$request[id]">
        <input type="hidden" name="combo_id[]" value="$comboIdpass">
        <input type="hidden" name="idProduto" value="$proId">
        <hr>
        
        </div>
        </div>
        
EOT;

        return $t;
    }     

    public function index()
    {

        $products = Product::select(

            'product.id',

            'product.product_pic_src',

            'product.name_product',

            'product.description_product',

            'product.price_product',

            'product.status_product',

            'product.category_id',

            'product_categories.name_category',
            
            'product.promotion_day'
        )

            ->join('product_categories', 'product.category_id', '=', 'product_categories.id')

            //->with(['productCategories'])

            ->where('product.status_product', '!=', '2')

            ->paginate(15);

        $categories = StaticMethodsController::getCategories();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {

        $categories = StaticMethodsController::getCategories();

        $lojas = Loja::where('status', '=', strval(Loja::LOJA_ATIVA))->get();

        $promotions = StaticMethodsController::getPromotions();

        $complements = Complement::all();

        $products = Product::getProducts();

      // dd($products);

        return view('admin.products.create', compact('categories','products' ,'lojas', 'promotions', 'complements'));
    }

    public function store(Request $request)
    {
           
        
        try {

            $data = $this->getInputFromRequest($request);

            $image = $this->storeImageIfExists($request);

            $dataAll = $request->all();
            
            //$dataCombo = $request['produto_selecionado'];
            

            if ($dataAll['product_type'] == Product::PROD_COMBO && !empty($dataAll['variation_name'])) {

                // $varIds = $this->addComboVariations($this->addComboVariations($dataCombo));

                $varIds = $this->addComboVariations($this->serializeComboVariations($dataAll));
                $data['combo_id'] = $varIds;
               
                 
                 
            }

            if ($this->verifyPosition($dataAll['product_order']) != false) {

                return Redirect::back()->withInput('product_order')->withErrors('Já existe a posição selecionada.');
            }

            if ($image !== false) {

                $data['product_pic_src'] = $image;
            }

            $data['product_lojas_id'] = json_encode($data['product_lojas_id']);

            if (isset($dataAll['product_comps']) && $dataAll['product_type'] == Product::PROD_COMPL) {

                $data['product_comps'] = strval(json_encode($dataAll['product_comps']));
            } else {

                $data['product_comps'] = null;
            }

            $product = new Product();

            $product->fill($data);
            
            

            if (!$product->validate(true)) {

                return Redirect::back()->withInput($request->all())->withErrors($product->getErrors());
            }

            $product->save();

            if ($dataAll['product_type'] == Product::PROD_VARIABLE) {

                $variations = $this->serializeVariations($dataAll);

                $variations = $this->addProdIdToVariation($product->id, $variations);

                $this->createProdVariation($variations);
             } 
            else if ($dataAll['product_type'] == Product::PROD_COMBO) {

                
                 $ids = json_decode($varIds);


                 for ($i = 0; $i < sizeof($ids); $i++) {
                     $combo = ComboVariation::find($ids[$i]);
                     $combo->prod_id = $product->id;
                     $combo->save();
                 }
             }

            return redirect()->back()->with('msg-success', $dataAll['name_product']);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function edit($id)
    {

        $product = Product::find($id);

        $categories = StaticMethodsController::getCategories();

        $lojas = Loja::where('status', '=', strval(Loja::LOJA_ATIVA))->get();

        $promotions = StaticMethodsController::getPromotions();

        $variations = ProductVariation::all();

        $complements = Complement::all();

        $comboVars = [];
        
        $products = Product::getProducts();
 
        if ($product->product_type == Product::PROD_COMBO) {

            $i = 0;
            
            foreach (json_decode($product->combo_id) as $ida) {

                $comboVar = ComboVariation::with(['getComboCategory'])->where('id', '=', $ida)->get();

                if (!empty($comboVar->First())) {

                    $comboVars[$i] = $comboVar;
                }

                $i++;
            }
        }
        //dd($comboVars);
        return view('admin.products.edit', compact('id','complements', 'variations','products', 'product', 'categories', 'lojas', 'promotions', 'comboVars'));
    }

    public function update(Request $request, $id)
    {   
        

        $product = Product::findOrFail($id);

        $data = $this->getInputFromRequest($request);

        $image = $this->storeImageIfExists($request);
        //dd($request);
        $dataAll = $request->all();

        if ($dataAll['product_type'] == Product::PROD_COMBO && !empty($dataAll['variation_name'])) {
            $varIds = $this->updateComboVariations($this->serializeUpdateComboVar($dataAll));
            
            $data['combo_id'] = $varIds;
        }

        if (isset($dataAll['variation_name']) && sizeof($dataAll['variation_name']) > sizeof($dataAll['variation_name'])) {
            $data['combo_id'] = $this->createUpdateComboVar($this->serializeComboVariations($dataAll), sizeof($dataAll['var_id']), $data['combo_id']);
        }

        if ($this->verifyPosition($dataAll['product_order']) != false) {

            return Redirect::back()->withInput('product_order')->withErrors('Já existe a posição selecionada.');
        }

        if ($image !== false) {

            $data['product_pic_src'] = $image;
        }

        if ($data['product_lojas_id'] != null) {

            $data['product_lojas_id'] = json_encode($data['product_lojas_id']);
        } else {

            $data['product_lojas_id'] = null;
        }

        $required_fields = [];

        if (!$product->validate(false)) {

            $required_fields = [];

            foreach ($product->getErrors()->getMessages() as $key => $value) {

                $required_fields[] = $key;
            }
        }

        if ($data['product_type'] == Product::PROD_COMPL) {

            $data['product_comps'] = strval(json_encode($data['product_comps']));
        } else {
            $data['product_comps'] = null;
        }

        $product->fill($data);

        if (!$product->validate(true)) {

            return Redirect::back()->withInput($request->all())->withErrors($product->getErrors());
        }

        $product->save();

        if ($dataAll['product_type'] == '1') {

            $variations = $this->serializeVariations($dataAll);

            if (isset($dataAll['prod_var_name'])) {

                $countNewVars = sizeof($dataAll['prod_var_name']);

                if (isset($dataAll['var_id'])) {

                    $countVars = sizeof($dataAll['var_id']);

                    if ($countVars > 0) {

                        $this->editProdVariation($variations, $dataAll['var_id']);
                    }
                }

                if (isset($countVars) && $countNewVars > $countVars) {

                    $variations = $this->addProdIdToVariation($product->id, $variations);

                    $this->createProdVariation(array_slice($variations, $countVars));
                } elseif (isset($countVars) == 0) {

                    $variations = $this->addProdIdToVariation($product->id, $variations);

                    $this->createProdVariation($variations);
                }
            }
        }
        if ($dataAll['product_type'] == Product::PROD_COMBO) {

                
            $ids = json_decode($varIds);


            for ($i = 0; $i < sizeof($ids); $i++) {
                $combo = ComboVariation::find($ids[$i]);
                $combo->prod_id = $product->id;
                $combo->save();
            }
        }

        return redirect()->back();
    }

    public function destroy($id)
    {

        $product = new Product();

        $prod = $product->where('id', '=', $id);

        if ($prod) {

            $p = Product::where('id', $prod->First()->id)->update(array(

                'status_product' => '2',

            ));
        }

        return redirect()->back();
    }

    public function searchProductsByCategory($id)
    {

        $products = Product::select('*')

            ->where('product.category_id', '=', $id)

            ->where('product.status_product', '!=', '2')

            ->orderBy('id')->paginate(15);

        $categories = StaticMethodsController::getCategories();

        $catID = $id;

        return view('admin.products.index', compact(['products', 'categories', 'catID']));
    }

    public function searchProductsByName($name)
    {

        $name = str_replace(' ', '%', $name);

        $products = Product::select('*')

            ->where('product.name_product', 'LIKE', $name)

            ->where('product.status_product', '!=', '2')

            ->orderBy('id')->paginate(15);

        if ($products->count() <= 0) {
            $name = '%' . $name . '%';

            $products = Product::select('*')

                ->where('product.name_product', 'LIKE', $name)

                ->where('product.status_product', '!=', '2')

                ->orderBy('id')->paginate(15);
        }

        $categories = StaticMethodsController::getCategories();

        return view('admin.products.index', compact(['products', 'categories']));
    }

    private function storeImageIfExists($request)
    {

        if ($request->hasFile('image')) {

            $image = $request->file('image');

            if ($image->isValid()) {

                $image->store(Product::$images_storage_path, 'public');
                //dd(Product::$images_storage_path);
                
                return $image->hashName();
            }
        }

        return false;
    }

    private function getInputFromRequest($request)
    {

        //Offer fillable fields except 'image_filename'

        $fields = array_diff(Product::getModel()->getFillable(), ['product_pic_src']);

        $data = $request->only($fields);

        return $data;
    }

    public function serializeVariations($data)
    {
        $obj = [];

        for ($i = 0; $i < sizeof($data['prod_var_name']); $i++) {

            $obj[$i]["prod_var_name"] = $data['prod_var_name'][$i];
            $obj[$i]["prod_var_price"] = $data['prod_var_price'][$i];
            $obj[$i]["prod_var_active"] = $data['prod_var_active'][$i];
            $obj[$i]["prod_var_promo_id"] = $data['prod_var_promo_id'][$i] ?? null;
            $obj[$i]["prod_var_status"] = $data['prod_var_status'][$i] ?? "1";
            $obj[$i]["prod_var_promo_day"] = $data['prod_var_promo_day'][$i];
            $obj[$i]['prod_var_promo_price'] = $data['prod_var_promo_price'][$i];
        }


        return $obj;
    }

    public function addProdIdToVariation($id, $data)
    {
        for ($i = 0; $i < sizeof($data); $i++) {
            $data[$i]['prod_id'] = strval($id);
        }

        return $data;
    }

    public function createProdVariation($data)
    {
        
        if (sizeof($data) == 1) {

            $var = new ProductVariation();
            

            $var->fill($data[0]);
             
//$var = $data;
            
            $var->save();
            
        } else {

            for ($i = 0; $i < sizeof($data); $i++) {

                $var = new ProductVariation();

                $var->fill($data[$i]);

                $var->save();
            }
        }
    }

    public function deleteVariation($id)
    {

        return $variation = ProductVariation::where('id', '=', $id)->update([
            'prod_var_status' => '2'
        ]);
    }

    public function editProdVariation($data, $ids)
    {

        for ($i = 0; $i < sizeof($ids); $i++) {

            $var = ProductVariation::findOrFail($ids[$i]);

            $var->fill($data[$i]);

            $var->save();
        }
    }

    public function verifyPosition($position)
    {

        $find = Product::select('*')
            ->where('product_order', '=', $position)
            ->get();

        if (isset($find->id)) {

            return $find;
        }

        return false;
    }

    public function serializeComboVariations($data)
    {
        $obj = [];

        for ($i = 0; $i < sizeof($data['variation_name']); $i++) {
           $variation_name = explode(",",$data['variation_name'][$i])[1];
            $id = explode(",",$data['variation_name'][$i])[0];
            $obj[$i]['variation_name'] = $variation_name;
            $obj[$i]['refer_product'] = $id;
            
            $obj[$i]['num_esc'] = $data['num_esc'][$i];
            $obj[$i]['cat_id'] = $data['cat_id'][$i];
            $obj[$i]['create_at'] = new \DateTime('now');
            $obj[$i]['updated_at'] = new \DateTime('now');
        }
        
        return $obj;
    }

    public function addComboVariations($data)
    {
        $ids = [];
        
        for ($i = 0; $i < sizeof($data); $i++) {
            $var = new ComboVariation();
           
            $var->fill($data[$i]);
            
            $var->save();
            $ids[$i] = strval($var->id);
        }
        return json_encode($ids);
    }

    public function serializeUpdateComboVar($data)
    {
        $obj = [];
        //dd(preg_replace( '/[^0-9]/', '', explode(",",$prodTest[5][$proId])));
       
        for ($i = 0; $i < sizeof($data['variation_name']); $i++) {
            $variation_name = explode(",",$data['variation_name'][$i])[1];
            $id = explode(",",$data['variation_name'][$i])[0];
            $obj[$i]['variation_name'] = $variation_name;
            $obj[$i]['refer_product'] = $id;
            $obj[$i]['id'] = $data['combo_id'][$i];
            $obj[$i]['prod_id'] = intval($data['idProduto']);
            
            $obj[$i]['num_esc'] = $data['num_esc'][$i];
            $obj[$i]['cat_id'] = $data['cat_id'][$i];
        }
        
    
        return $obj;
    }

    public function updateComboVariations($data)
    {
       
        $ids = [];
        for ($i = 0; $i < sizeof($data); $i++) {
        
            if( ($data[$i]['id']) == null){

                $var = new ComboVariation();
           
                $var->fill($data[$i]);
                
                $var->save();
                $ids[$i] = strval($var->id);


            }else{
           
            $var = ComboVariation::find($data[$i]['id']);
            
            $var->fill($data[$i]);
            
            $var->save();
            $ids[$i] = strval($var->id);
        }
    }
        
        return json_encode($ids);
    }
 
    public function createUpdateComboVar($data, $size, $ids)
    {

        $ids = json_decode($ids);

        for ($i = $size; $i < sizeof($data); $i++) {
            $var = new ComboVariation();
            $var->fill($data[$i]);
            $var->save();
            $ids[$i] = strval($var->id);
        }

        return json_encode($ids);
    }

    public function deleteComboVariation(Request $request)
    {
        try {
            $data = $request->all();
            return response()->json(["response" => $data]);
            ComboVariation::destroy($data['id']);
            return response()->json(['response' => true]);
        } catch (Exception $e) {
            return response()->json(['response' => false]);
        }
    }
}
