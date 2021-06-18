<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

  use AuthenticatesUsers;

  protected $redirectTo = '/';

  /**
   * Where to redirect users after login.
   *
   * @var string
   */
  //protected $redirectTo = '/admin';

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest')->except('logout');
  }

  /**
   * Log the user out of the application.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function logout(Request $request)
  {
    $this->guard()->logout();

    $request->session()->invalidate();

    return redirect('/admin');
  }

  protected function redirectTo()
  {

    if (\Auth::user()->role == \App\User::ROLE_ADMIN) {

      return '/admin/dashboard';
      // return redirect()->route('admin.dashboard.index');
    } elseif (\Auth::user()->role == \App\User::ROLE_DELIVERYMAN) {

      return '/deliveryman';
    } elseif (\Auth::user()->role == \App\User::ROLE_LOJA) {

      return '/admin/cupom/validation';
    }
    \Auth::logout();
    return redirect()->route('login');
  }

  protected function authenticated()
  {
    if (\Auth::user()->role == \App\User::ROLE_ADMIN) {
      return redirect('/admin/dashboard');
    } elseif (\Auth::user()->role == \App\User::ROLE_DELIVERYMAN) {
      return redirect('/deliveryman');
    } elseif (\Auth::user()->role == \App\User::ROLE_LOJA) {

      return redirect('/admin/cupom/validation');
    }
    \Auth::logout();
    return redirect()->route('login');
  }
}
