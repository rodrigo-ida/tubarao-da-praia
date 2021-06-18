<?php

namespace App\Http\Controllers\Admin;

use App\Coupon;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\StaticMethodsController;

class CuponsController extends Controller
{
    //

    public function showValidationForm()
    {
        $showCupomRoute = route('admin.cupom.show.bycode', ['code' => '']);
        $validateCupomRoute = route('admin.cupom.validate', ['code' => '']);
        return view('admin.cupom.validation', compact(['showCupomRoute', 'validateCupomRoute']));
    }

    public function cuponsValidate()
    {
        $coupons = \DB::table('coupons_validados')
            ->select(['coupons_validados.coupon_validation_user_name', 'coupons.validation_token', 'loja.nome_loja', 'clients.email', 'clients.nome'])
            ->join('users', 'coupons_validados.coupon_validation_user_id', '=', 'users.id')
            ->join('loja', 'users.loja_id', '=', 'loja.id')
            ->join('coupons', 'coupons_validados.coupon_id', '=', 'coupons.id')
            ->join('clients', 'coupons.client_id', '=', 'clients.id')
            ->orderBy('coupons_validados.id')
            ->paginate(15); 
        // $query = "SELECT coupons_validados.coupon_validation_user_name, 
        // c.validation_token, lj.nome_loja
        // FROM coupons_validados 
        // INNER JOIN users us ON coupons_validados.coupon_validation_user_id = us.id 
        // INNER JOIN loja lj ON us.loja_id = lj.id 
        // INNER JOIN coupons c ON coupons_validados.coupon_id = c.id ORDER BY coupons_validados.id LIMIT 15";
        // $coupons = \DB::select($query);

        $users = StaticMethodsController::getAdminUsers();
        return view('admin.cupom.validados', compact('coupons', 'users'));
    }

    public function showByCode(Request $request, $code)
    {
        $coupon = Coupon::where('validation_token', $code)
            ->with(['offer'])
            ->firstOrFail();
        return $coupon;
    }

    public function validateCupom(Request $request, $code)
    {
        $coupon = Coupon::where('validation_token', $code)
            ->firstOrFail();


        if ($coupon->validation_date != null) {
            return [
                'status' => 'error',
                'message' => 'Cupom já utilizado',
                'coupon' => $coupon,
            ];
        }

        $coupon->validation_date = Carbon::now();

        $saved = $coupon->save();

        $this->saveValidateCupomUser($coupon);

        return [
            'status' => 'success',
            'message' => "Cupom $coupon->validation_token utilizado com sucesso",
            'coupon' => $coupon,
        ];
    }

    public function saveValidateCupomUser($coupon)
    {

        $userValidation = \DB::table('coupons_validados')
            ->insert([
                'coupon_id' => $coupon->id,
                'coupon_validation_user_name' => \Auth::user()->name,
                'coupon_validation_user_id' => \Auth::user()->id
            ]);
        return;
    }

    public function searchCoupons($id)
    {
        $coupons = \DB::table('coupons_validados')
            ->select(['coupons_validados.coupon_validation_user_name', 'coupons.validation_token', 'loja.nome_loja', 'clients.email', 'clients.nome'])
            ->join('users', 'coupons_validados.coupon_validation_user_id', '=', 'users.id')
            ->join('loja', 'users.loja_id', '=', 'loja.id')
            ->join('coupons', 'coupons_validados.coupon_id', '=', 'coupons.id')
            ->join('clients', 'coupons.client_id', '=', 'clients.id')
            ->where('coupons_validados.coupon_validation_user_id', '=', $id)
            ->paginate(15);

        $users = StaticMethodsController::getAdminUsers();

        return view('admin.cupom.validados', compact('coupons', 'users'));
    }
}
