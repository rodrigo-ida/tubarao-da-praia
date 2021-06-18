<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use Mockery\Exception;
use App\ProductCategories;
use Illuminate\Support\Facades\Redirect;

class ProductCategoriesController extends Controller
{
    
    /**
     * @var Product
     */
    private $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $categories = ProductCategories::select('*')
        ->orderBy('id', 'desc')
        ->paginate(15);

        return view('admin.productscategories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.productscategories.create');
    }

    public function store(Request $request)
    {

        $data    = $this->getInputFromRequest($request);

        $image   = $this->storeImageIfExists($request);

        if($image !== false)
        {

            $data['category_pic_src'] = $image;

        }

        $categorie = new ProductCategories();

        $categorie->fill($data);

        if (!$categorie->validate(true)){
            return Redirect::back()->withInput($request->all())->withErrors($categorie->getErrors());
        }

        $categorie->save();
        
        return redirect()->route('admin.pcategories.index');
    }

    public function edit($id)
    {
        $categorie = ProductCategories::find($id);

        return view('admin.productscategories.edit', compact('categorie'));
    }

    public function update(Request $request, $id)
    {
        $categorie = ProductCategories::findOrFail($id);

        $data    = $this->getInputFromRequest($request);

        $image   = $this->storeImageIfExists($request);

        if($image !== false)
        {

            $data['category_pic_src'] = $image;

        }

        $data['category_pic_src'] = json_encode($data);

        $required_fields = [];
        if (!$categorie->validate(false)) {
            $required_fields = [];
            foreach ($categorie->getErrors()->getMessages() as $key => $value){
                $required_fields[] = $key;
            }
        }
        
        $categorie->fill($data);
        
        if (!$categorie->validate(false)) 
        {          
            return Redirect::back()->withInput($request->all())->withErrors($categorie->getErrors());
        }

        $categorie->save();

        return redirect()->route('admin.pcategories.index');
    }

    public function destroy($id)
    {
        $categorie = new ProductCategories();

        $categorie->find($id);

        if($categorie)
        {
            
        $categorie->destroy($id);

        return redirect()->route('admin.pcategories.index');
        
        }

    }

    private function storeImageIfExists($request)
    {
        
        if ($request->hasFile('image')) {


            $image = $request->file('image');
            if ($image->isValid()) {

                $image->store(ProductCategories::$images_storage_path, 'public');

                return $image->hashName();

            }

        }

        return false;

    }

    private function getInputFromRequest($request)
    {

        //Offer fillable fields except 'image_filename'

        $fields = array_diff(ProductCategories::getModel()->getFillable(), ['category_pic_src']);
        
        $data = $request->only($fields);

        return $data;

    }
}
