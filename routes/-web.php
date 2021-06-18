<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => 'auth:web2'], function(){
    Route::get( '/','CouponController@index');
    Route::group(['prefix' => 'cupons'], function(){
        Route::get('/', 'CouponController@index')->name('visualizar.cupons');
        Route::post('/selecionar', 'CouponController@selecionar')->name('selecionar.cupons');
        Route::get('/imprimir', 'CouponController@imprimir')->name('imprimir.cupons');
        Route::post('/email', 'CouponController@email')->name('enviar.email');
        Route::post('/ajax-email', 'CouponController@ajaxEmail')->name('enviar.email.ajax');
        Route::get('/oferta-{offer}', 'CouponController@verCupons')->name('cupons.por.oferta');
    });
    Route::get('editar-cadastro', 'ClientsController@edit')->name('editar.cadastro');
    Route::post('atualizar', 'ClientsController@update')->name('atualizar');
    Route::get('logout', 'ClientsController@logout')->name('cliente.logout');
});

Route::get( 'link-invalido', [
    'as' => 'token.invalido',
    'uses' => 'ClientsController@tokenInvalido'
]);
Route::get( '/', 'ClientsController@solicitarToken');
Route::get( '/acepg', 'ClientsController@acepgToken');
Route::get( 'solicitar-login', 'ClientsController@solicitarToken')->name('solicitar.token');
Route::post('solicitar-login', 'ClientsController@verificarCadastro')->name('verificar.cadastro');
Route::post('cadastrar', 'ClientsController@store')->name('cadastrar');
Route::get('cadastrar', 'ClientsController@cadastrar')->name('exibir.cadastro');
Route::get('obrigado', 'ClientsController@success')->name('success');


/**
 * Admin routes
 */

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {

    // Authentication Routes...
    $this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
    $this->post('login', 'Auth\LoginController@login');
    $this->post('logout', 'Auth\LoginController@logout')->name('logout');

    // Registration Routes...
    $this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    $this->post('register', 'Auth\RegisterController@register');

    // Password Reset Routes...
    $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    $this->post('password/reset', 'Auth\ResetPasswordController@reset');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin'], function(){

    /**
     * Rotas protegidas
     */

    Route::group(['middleware' => 'auth:admin'], function(){

        Route::get('/', [
            'as' => 'index',
            'uses' => function() {
                //return view('admin.home');
                return redirect()->route('admin.dashboard.index');
            }
        ]);

        Route::get('/dashboard', [
            'as' => 'dashboard.index',
            'uses' => 'DashboardController@index'
        ]);

        Route::get('/dashboard/data/coupon', [
            'as' => 'dashboard.data.coupon',
            'uses' => 'DashboardController@couponData'
        ]);

        Route::get('/cupom/validation', [
            'as' => 'cupom.validation',
            'uses' => 'CuponsController@showValidationForm'
        ]);

        Route::get('/cupom/validate/{code}', [
            'as' => 'cupom.validate',
            'uses' => 'CuponsController@validateCupom'
        ]);

        Route::get('/cupom/bycode/{code}', [
            'as' => 'cupom.show.bycode',
            'uses' => 'CuponsController@showByCode'
        ]);

        Route::get('/offers', [
            'as' => 'offers.index',
            'uses' => 'OffersController@index'
        ]);

        Route::get('/offers/show/{id}', [
            'as' => 'offers.show',
            'uses' => 'OffersController@show'
        ]);

        Route::get('/offers/edit/{id}', [
            'as' => 'offers.edit',
            'uses' => 'OffersController@edit'
        ]);

        Route::post('/offers/update/{id}', [
            'as' => 'offers.update',
            'uses' => 'OffersController@update'
        ]);

        Route::get('/offers/create', [
            'as' => 'offers.create',
            'uses' => 'OffersController@create'
        ]);

        Route::post('/offers/store', [
            'as' => 'offers.store',
            'uses' => 'OffersController@store'
        ]);

        Route::get('/clients', [
            'as' => 'clients.index',
            'uses' => 'ClientsController@index'
        ]);

        Route::get('/clients/{id}', [
            'as' => 'clients.show',
            'uses' => 'ClientsController@show'
        ]);


    });
});