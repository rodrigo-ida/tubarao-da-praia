<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\PromotionBanner;

use App\Http\Controllers\Controller;

use App\Http\Controllers\StaticMethodsController;

use App\Http\Controllers\Admin\UploadController;

use Illuminate\Support\Facades\Redirect;

class PromotionBannerController extends Controller
{

    private $model;

    public function __construct(PromotionBanner $model)
    {

        $this->model = $model;
    }

    public function index()
    {
        $banners = PromotionBanner::select('*')
            ->with('getProduct')
            ->with('getLoja')
            ->paginate(15);

        return view('admin.promobanners.index', compact('banners'));
    }

    public function create()
    {
        $products = StaticMethodsController::products();

        $lojas    = StaticMethodsController::getLojasList();

        return view('admin.promobanners.create', compact('products', 'lojas'));
    }

    public function store(Request $request)
    {
        $banner = new PromotionBanner();

        $data   = UploadController::getInputFromRequest($request, PromotionBanner::class, 'promotion_banner');

        $image  = UploadController::storeImageIfExists($request, PromotionBanner::class, PromotionBanner::$images_storage_path);

        if ($image !== false) {
            $data['promo_banner_pic_src'] = $image;
        }

        $required_fields = [];
        if (!$banner->validate(false)) {
            $required_fields = [];
            foreach ($banner->getErrors()->getMessages() as $key => $value) {
                $required_fields[] = $key;
            }
        }

        $banner->fill($data);

        if (!$banner->validate(false)) {
            return Redirect::back()->withInput($data)->withErrors($banner->getErrors());
        }

        $banner->save();

        return redirect()->route('banner.index');
    }

    public function edit($id)
    {
        $banner   = PromotionBanner::findOrFail($id);

        $products = StaticMethodsController::products();

        $lojas    = StaticMethodsController::getLojasList();

        return view('admin.promobanners.edit', compact('banner', 'products', 'lojas'));
    }

    public function update(Request $request, $id)
    {
        $banner   = PromotionBanner::findOrFail($id);

        $data     = UploadController::getInputFromRequest($request, PromotionBanner::class, 'promotion_banner');

        $image    = UploadController::storeImageIfExists($request, PromotionBanner::class, PromotionBanner::$images_storage_path);

        if ($image !== false) {
            $data['promo_banner_pic_src'] = $image;
        } else if (!empty($banner->promo_banner_pic_src)) {
            $data['promo_banner_pic_src'] = $banner->promo_banner_pic_src;
        }


        $required_fields = [];
        if (!$banner->validate(false)) {
            $required_fields = [];
            foreach ($banner->getErrors()->getMessages() as $key => $value) {
                $required_fields[] = $key;
            }
        }

        $banner->fill($data);

        if (!$banner->validate(false)) {
            return Redirect::back()->withInput($data)->withErrors($banner->getErrors());
        }

        $banner->save();

        return redirect()->route('admin.banner.index');
    }
}
