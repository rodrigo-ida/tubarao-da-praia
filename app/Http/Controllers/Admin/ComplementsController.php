<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Complement;
use App\Http\Controllers\Admin\ProductCategoriesController;
use App\Product;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\StaticMethodsController;

class ComplementsController extends Controller
{
    /**
     * @var Product
     */
    private $model;

    public function __construct(Complement $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        $complements = Complement::select(
            'product_complements.id',
            'product_complements.name_complement',
            'product_complements.price_complement'
        )
        // ->join('product', 'product_complements.product_id', '=', 'id')
            ->with(['productCategories'])
            ->paginate(15);

        return view('admin.productscomp.index', compact('complements'));
    }

    public function create()
    {

        $categories = StaticMethodsController::getCategories();

        $products = StaticMethodsController::products();

        return view('admin.productscomp.create', compact('categories', 'products'));
    }

    public function store(Request $request)
    {

        $data = UploadController::getInputFromRequest($request, Complement::class, 'complement_pic_src');

        $image = UploadController::storeImageIfExists($request, Complement::class, Complement::$images_storage_path);

        if ($image !== false) {
            $data['complement_pic_src'] = $image;
        }

        $complement = new Complement();

        $complement->fill($data);

        if (!$complement->validate(true)) {
            return Redirect::back()->withInput($request->all())->withErrors($complement->getErrors());
        }

        $complement->save();

        return redirect()->route('admin.complements.index');
    }

    public function edit($id)
    {
        $complement = Complement::find($id);

        $categories = StaticMethodsController::getCategories();

        $products = StaticMethodsController::products();

        return view('admin.productscomp.edit', compact('complement', 'categories', 'products'));
    }

    public function update(Request $request, $id)
    {
        $complement = Complement::findOrFail($id);

        $data = UploadController::getInputFromRequest($request, Complement::class, 'complement_pic_src');

        $image = UploadController::storeImageIfExists($request, Complement::class, Complement::$images_storage_path);

        if ($image !== false) {
            $data['complement_pic_src'] = $image;
        }

        $required_fields = [];
        if (!$complement->validate(false)) {
            $required_fields = [];
            foreach ($complement->getErrors()->getMessages() as $key => $value) {
                $required_fields[] = $key;
            }
        }

        $complement->fill($data);

        if (!$complement->validate(false)) {
            return Redirect::back()->withInput($request->all())->withErrors($complement->getErrors());
        }

        $complement->save();

        return redirect()->route('admin.complements.index');
    }

    public function destroy($id)
    {
        $complement = new Complement();

        $complement->find($id);

        if ($complement) {

            $complement->destroy($id);

            return redirect()->route('admin.complements.index');

        }

    }
}
