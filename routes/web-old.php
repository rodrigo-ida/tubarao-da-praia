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

Route::group(['middleware' => 'auth:web2'], function () {

    Route::get('/', 'CouponController@index');

    Route::group(['prefix' => 'cupons'], function () {

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

Route::get('link-invalido', [

    'as' => 'token.invalido',

    'uses' => 'ClientsController@tokenInvalido'

]);

Route::get('/', function () {

    if ($_SERVER['HTTP_HOST'] == 'descontos.tubaraodapraia.com.br') {
        return redirect('/desconto');
    }

    return redirect('delivery');
});

Route::get('delivery', [
    'as' => 'productdelivery.index',
    'uses' => 'DeliveryController@first'
]);

Route::get('acepg', 'ClientsController@acepgToken');

//Route::get( '/', );

Route::get('acepg', 'ClientsController@acepgToken');

Route::get('solicitar-login', 'ClientsController@solicitarToken')->name('solicitar.token');

Route::post('solicitar-login', 'ClientsController@verificarCadastro')->name('verificar.cadastro');

Route::post('cadastrar', 'ClientsController@store')->name('cadastrar');

Route::get('cadastrar', 'ClientsController@cadastrar')->name('exibir.cadastro');

Route::get('obrigado', 'ClientsController@success')->name('success');

// ROTA DE DELIVERY

Route::get('/desconto', 'ClientsController@solicitarToken');

Route::get('/delivery/cep/loja', [

    'as' => 'productdelivery.cep',

    'uses' => 'DeliveryController@getLojasByCep'

]);

Route::get('/delivery/finalizar/recu-email', [

    'as' => 'delivery.cadclient',

    'uses' => 'DeliveryController@recuperarEmail'

]);

Route::get('/delivery/cep/{bairro}', [

    'as' => 'productdelivery.cep',

    'uses' => 'DeliveryController@getCep'

]);

Route::get('/delivery/avaliacao/{token}', [

    'as' => 'delivery.avaliacao',

    'uses' => 'AvaliationController@index'

]);

Route::post('/avaliacao/enviar', [

    'as' => 'avaliacao.enviar',

    'uses' => 'AvaliationController@update'

]);

Route::get('/delivery/loja/produto/variacoes', [

    'as' => 'productdelivery.variations',

    'uses' => 'DeliveryController@getProdVariations'

]);

Route::get('/delivery/loja/produto/comboVariacoes', [

    'as' => 'productdelivery.comboVariations',

    'uses' => 'DeliveryController@getComboVariations'

]);

Route::get('/delivery/loja-{loja}/category/{cat}', [

    'as' => 'productdelivery.categoria',

    'uses' => 'DeliveryController@prodCategorie'

]);

Route::post('/delivery/selecionar-loja', [

    'as' => 'productdelivery.selecionarLoja',

    'uses' => 'DeliveryController@getLojas'

]);

Route::get('/delivery/identificacao', [

    'as' => 'productdelivery.finalizar',

    'uses' => 'DeliveryController@finalizar'

]);

Route::get('/delivery/loja-{loja}', [

    'as' => 'productsdelivery.products',

    'uses' => 'DeliveryController@deliveryProducts'

]);

Route::post('/delivery/finalizar/cadclient', [

    'as' => 'delivery.cadclient',

    'uses' => 'DeliveryController@cadClient'

]);

Route::get('/delivery/loja/{id}', [

    'as' => 'productsdelivery.products',

    'uses' => 'DeliveryController@'

]);

Route::get('/delivery/products/promotion/{id}', [

    'as' => 'productsdelivery.promotionPrice',

    'uses' => 'DeliveryController@promotionPrice'

]);

Route::post('/delivery/client', [

    'as' => 'productdelivery.client',

    'uses' => 'DeliveryController@getClient'

]);

Route::get('/delivery/payment/{id}', [

    'as' => 'productdelivery.payment',

    'uses' => 'DeliveryController@getPaymentMethods'

]);

Route::post('/delivery/identificacao/finalizar-pedido', [

    'as' => 'productdelivery.finalizarPedido',

    'uses' => 'DeliveryController@finalizarPedido'

]);

Route::get('/delivery/pedido/finalizado', [

    'as' => 'productdelivery.acompanharPedido',

    'uses' => 'DeliveryController@acompanharPedido'

]);

Route::post('/delivery/pedido/pesquisa', [

    'as' => 'productdelivery.acompanharPedidoPorEmail',

    'uses' => 'DeliveryController@acompanharPedidoPorEmail'

]);

Route::get('/delivery/status/{id}', [

    'as' => 'productdelivery.statusOrder',

    'uses' => 'DeliveryController@statusOrder'

]);

Route::get('/delivery/identificacao/cadastro', [

    'as' => 'productdelivery.cadastro',

    'uses' => 'DeliveryController@idCadastro'

]);

Route::get('/delivery/identificacao/entrega', [

    'as' => 'productdelivery.entrega',

    'uses' => 'DeliveryController@idEntrega'

]);

Route::post('/delivery/identificacao/pagamento', [

    'as' => 'productdelivery.pagamento',

    'uses' => 'DeliveryController@idPagamento'

]);

Route::post('/delivery/identificacao/finalizacao-pedido', [

    'as' => 'productdelivery.idFinalizar',

    'uses' => 'DeliveryController@idFinalizar'

]);

Route::get('/delivery/template-email/{id}', [

    'as' => 'productdelivery.templateOrder',

    'uses' => 'DeliveryController@sendStatusEmailOrder'

]);

Route::post('/delivery/finalizar/cadclient/', [

    'as' => 'clientdelivery.cadclient',

    'uses' => 'DeliveryController@cadClient'

]);

Route::post('/delivery/finalizar/quero-me-cadastrar', [

    'as' => 'clientdelivery.queroCadastrar',

    'uses' => 'DeliveryController@queroCadastrar'

]);

Route::get('/delivery/product/complements', [

    'as' => 'productdelivery.prodComp',

    'uses' => 'DeliveryController@getProductsComplements'

]);

Route::group(['prefix' => 'client', 'namespace' => 'client'], function () {
    Route::get('/area-do-cliente', [

        'as' => 'clientes.entrar',

        'uses' => 'ClientAreaController@login'

    ]);

    Route::get('/area-do-cliente/meus-dados', [

        'as' => 'clientes.userdata',

        'uses' => 'ClientAreaController@userData'

    ]);

    Route::post('/area-do-cliente/atualizar-dados', [

        'as' => 'clientes.atualizardados',

        'uses' => 'ClientAreaController@atualizarDados'

    ]);

    Route::get('/area-do-cliente/index', [

        'as' => 'clientes.index',

        'uses' => 'ClientAreaController@index'

    ]);

    Route::get('/area-do-cliente/ultimo-pedido', [

        'as' => 'clientes.order',

        'uses' => 'ClientAreaController@lastOrder'

    ]);

    Route::post('/area-do-cliente/login', [

        'as' => 'clientes.login',

        'uses' => 'ClientAreaController@fazerLogin'

    ]);

    Route::get('/area-do-cliente/logout', [

        'as' => 'clientes.logout',

        'uses' => 'ClientAreaController@fazerLogout'

    ]);

    Route::get('/area-do-cliente/pedidos', [

        'as' => 'clientes.orders',

        'uses' => 'ClientAreaController@todosPedidos'

    ]);

    Route::get('/area-do-cliente/endereco', [

        'as' => 'clientes.address',

        'uses' => 'ClientAreaController@address'

    ]);

    Route::post('/area-do-cliente/atualizar-endereco', [

        'as' => 'clientes.atualizarendereco',

        'uses' => 'ClientAreaController@atualizaEndereco'

    ]);

    Route::get('/area-do-cliente/recuperar-senha/{email}', [

        'as' => 'clientes.recuperarsenha',

        'uses' => 'ForgotPasswordController@verifyClient'

    ]);

    Route::get('/area-do-cliente/reset-password', [

        'as' => 'clientes.verifyresettoken',

        'uses' => 'ForgotPasswordController@resetPassword'

    ]);

    Route::get('/area-do-cliente/reset-password/{token}/{id}', [

        'as' => 'clientes.resetpassword',

        'uses' => 'ForgotPasswordController@verifyClientToken'

    ]);

    Route::get('/area-do-cliente/primeiro-acesso', [

        'as' => 'clientes.primeiro-acesso',

        'uses' => 'ClientAreaController@firstAccess'

    ]);

    Route::post('/area-do-cliente/primeiro-acesso/enviar', [

        'as' => 'clientes.primeiro-acesso-enviar',

        'uses' => 'ClientAreaController@firstAccessSend'

    ]);

    Route::get('/area-do-cliente/inserir-usuarios', [

        'as' => 'clientes.inserirclientes',

        'uses' => 'ForgotPasswordController@createUsers'

    ]);

    Route::post('/area-do-cliente/resetar-senha', [

        'as' => 'clientes.resetar-senha',

        'uses' => 'ForgotPasswordController@newPassword'

    ]);

    Route::get('/area-do-cliente/teste-email', [

        'as' => 'clientes.teste-email',

        'uses' => 'ForgotPasswordController@testeEmail'

    ]);
});


/**

 * Admin routes

 */

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {



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



Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin'], function () {



    /**

     * Rotas protegidas

     */



    Route::group(['middleware' => 'auth:admin'], function () {

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

        // ROTA PÚBLICA DE PEDIDO

        Route::get('/orders/get-new-orders/order/{id_prod}', [

            'as' => 'orders.newOrders',

            'uses' => 'OrderController@getNewOrders'

        ]);

        Route::get('/pusher/{data}', function ($data) {
            event(new App\Events\UpdateStatusPusher($data));
            return "Event has been sent!";
        })->name('pusher');

        Route::get('/orders', [

            'as' => 'orders.index',

            'uses' => 'OrderController@index'

        ]);

        Route::get('/order/print/{id}', [

            'as' => 'order.print',

            'uses' => 'OrderController@print'

        ]);

        Route::get('/order/show/{id}', [

            'as' => 'orders.show',

            'uses' => 'OrderController@show'

        ]);



        Route::get('/order/status/update/{id}/{status}', [

            'as' => 'orders.updateStatus',

            'uses' => 'OrderController@updateStatus'

        ]);



        Route::post('/order/export', [

            'as' => 'order.export',

            'uses' => 'OrderController@exportOrder'

        ]);



        Route::get('/order/next/{id}', [

            'as' => 'order.next',

            'uses' => 'OrderController@next'

        ]);

        Route::group(['middleware' => 'can:admin'], function () {

            Route::get('/admin', [

                'as' => 'index',

                'uses' => function () {

                    //return view('admin.home');

                    return redirect()->route('admin.dashboard.index');
                }

            ]);

            Route::get('/', [

                'as' => 'index',

                'uses' => function () {

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



            // ROTAS DE CUPOM VALIDADO



            Route::get('/cupom/validated', [

                'as' => 'cupom.validated',

                'uses' => 'CuponsController@cuponsValidate'

            ]);



            Route::get('/cupom/validated/search/{id}', [

                'as' => 'cupom.validated.search',

                'uses' => 'CuponsController@searchCoupons'

            ]);





            Route::get('/offers', [

                'as' => 'offers.index',

                'uses' => 'OffersController@index'

            ]);



            Route::get('/offers/show/{id}', [

                'as' => 'offers.show',

                'uses' => 'OffersController@show'

            ]);





            Route::get('/offers/showno/{id}', [

                'as' => 'offers.showno',

                'uses' => 'OffersController@showno'

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



            // ROTAS DE USUARIO



            Route::get('/users', [

                'as' => 'users.index',

                'uses' => 'UserController@index'

            ]);



            Route::get('/users/create', [

                'as' => 'users.create',

                'uses' => 'UserController@create'

            ]);



            Route::post('/users/store', [

                'as' => 'users.store',

                'uses' => 'UserController@store'

            ]);



            Route::get('/users/destroy/{id}', [

                'as' => 'users.destroy',

                'uses' => 'UserController@destroy'

            ]);



            Route::get('/users/edit/{id}', [

                'as' => 'users.edit',

                'uses' => 'UserController@edit'

            ]);



            Route::post('/users/edit/{id}', [

                'as' => 'users.update',

                'uses' => 'UserController@update'

            ]);



            Route::get('/users/search/{id}', [

                'as' => 'users.search',

                'uses' => 'UserController@searchUsers'

            ]);



            // Rotas de Loja



            Route::get('/lojas', [

                'as' => 'lojas.index',

                'uses' => 'LojaController@index'

            ]);



            Route::get('/lojas/create', [

                'as' => 'lojas.create',

                'uses' => 'LojaController@create'

            ]);



            Route::post('/lojas/store', [

                'as' => 'lojas.store',

                'uses' => 'LojaController@store'

            ]);



            Route::get('/lojas/show/{id}', [

                'as' => 'lojas.show',

                'uses' => 'LojaController@show'

            ]);



            Route::get('/lojas/edit/{id}', [

                'as' => 'lojas.edit',

                'uses' => 'LojaController@edit'

            ]);



            Route::post('/lojas/update/{id}', [

                'as' => 'lojas.update',

                'uses' => 'LojaController@update'

            ]);





            Route::get('/lojas/destroy/{id}', [

                'as' => 'lojas.destroy',

                'uses' => 'LojaController@destroy'

            ]);



            // ROTAS DE CATEGORIA DE PRODUTO



            Route::get('/pcategories', [

                'as' => 'pcategories.index',

                'uses' => 'ProductCategoriesController@index'

            ]);



            Route::get('/pcategories/create', [

                'as' => 'pcategories.create',

                'uses' => 'ProductCategoriesController@create'

            ]);



            Route::post('/pcategories/store', [

                'as' => 'pcategories.store',

                'uses' => 'ProductCategoriesController@store'

            ]);



            Route::get('/pcategories/edit/{id}', [

                'as' => 'pcategories.edit',

                'uses' => 'ProductCategoriesController@edit'

            ]);



            Route::post('/pcategories/update/{id}', [

                'as' => 'pcategories.update',

                'uses' => 'ProductCategoriesController@update'

            ]);





            Route::get('/pcategories/destroy/{id}', [

                'as' => 'pcategories.destroy',

                'uses' => 'ProductCategoriesController@destroy'

            ]);



            // ROTAS DE PRODUTO



            Route::get('/products', [

                'as' => 'products.index',

                'uses' => 'ProductsController@index'

            ]);



            Route::get('/products/create', [

                'as' => 'products.create',

                'uses' => 'ProductsController@create'

            ]);



            Route::post('/products/store', [

                'as' => 'products.store',

                'uses' => 'ProductsController@store'

            ]);



            Route::get('/products/edit/{id}', [

                'as' => 'products.edit',

                'uses' => 'ProductsController@edit'

            ]);

            Route::get('/products/variation/exclude/{id}', [

                'as' => 'products.variationExclude',

                'uses' => 'ProductsController@deleteVariation'

            ]);

            Route::post('/products/update/{id}', [

                'as' => 'products.update',

                'uses' => 'ProductsController@update'

            ]);

            Route::get('/products/destroy/{id}', [

                'as' => 'products.destroy',

                'uses' => 'ProductsController@destroy'

            ]);

            Route::get('/products/search/{id}', [

                'as' => 'products.search',

                'uses' => 'ProductsController@searchProductsByCategory'

            ]);

            Route::post('/products/combo-variation/exclude', [

                'as' => 'products.comboVarExclude',

                'uses' => 'ProductsController@deleteComboVariation'

            ]);

            // ROTAS DE COMPLEMENTO DE PRODUTO



            Route::get('/products/complements', [

                'as' => 'complements.index',

                'uses' => 'ComplementsController@index'

            ]);



            Route::get('/products/complements/create', [

                'as' => 'complements.create',

                'uses' => 'ComplementsController@create'

            ]);



            Route::post('/products/complements/store', [

                'as' => 'complements.store',

                'uses' => 'ComplementsController@store'

            ]);



            Route::get('/products/complements/edit/{id}', [

                'as' => 'complements.edit',

                'uses' => 'ComplementsController@edit'

            ]);



            Route::post('/products/complements/update/{id}', [

                'as' => 'complements.update',

                'uses' => 'ComplementsController@update'

            ]);



            Route::get('/products/complements/destroy/{id}', [

                'as' => 'complements.destroy',

                'uses' => 'ComplementsController@destroy'

            ]);



            // ROTAS DE PROMOÇÃO DE PRODUTO



            Route::get('/products/promotions', [

                'as' => 'prodpromotions.index',

                'uses' => 'ProductPromotionController@index'

            ]);



            Route::get('/products/promotions/create', [

                'as' => 'prodpromotions.create',

                'uses' => 'ProductPromotionController@create'

            ]);



            Route::post('/products/promotions/store', [

                'as' => 'prodpromotions.store',

                'uses' => 'ProductPromotionController@store'

            ]);



            Route::get('/products/promotions/edit/{id}', [

                'as' => 'prodpromotions.edit',

                'uses' => 'ProductPromotionController@edit'

            ]);



            Route::post('/products/promotions/update/{id}', [

                'as' => 'prodpromotions.update',

                'uses' => 'ProductPromotionController@update'

            ]);



            Route::get('/products/promotions/destroy/{id}', [

                'as' => 'prodpromotions.destroy',

                'uses' => 'ProductPromotionController@destroy'

            ]);



            // ROTAS DE CUSTO DE PRODUTO 



            Route::get('/products/costs', [

                'as' => 'prodcosts.index',

                'uses' => 'ProductCostsController@index'

            ]);



            Route::get('/products/costs/create', [

                'as' => 'prodcosts.create',

                'uses' => 'ProductCostsController@create'

            ]);



            Route::post('/products/costs/store', [

                'as' => 'prodcosts.store',

                'uses' => 'ProductCostsController@store'

            ]);



            Route::get('/products/costs/edit/{id}', [

                'as' => 'prodcosts.edit',

                'uses' => 'ProductCostsController@edit'

            ]);



            Route::post('/products/costs/update/{id}', [

                'as' => 'prodcosts.update',

                'uses' => 'ProductCostsController@update'

            ]);



            Route::get('/products/costs/destroy/{id}', [

                'as' => 'prodcosts.destroy',

                'uses' => 'ProductCostsController@destroy'

            ]);



            // ROTAS DE PEDIDOS



            // Route::get('/orders', [

            //     'as' => 'orders.index',

            //     'uses' => 'OrderController@index'

            //     ]);



            Route::get('/order/create', [

                'as' => 'orders.create',

                'uses' => 'OrderController@create'

            ]);


            Route::get('/order/edit/user/{email}/{password}', [

                'as' => 'orders.login',

                'uses' => 'OrderController@editLogin'

            ]);

            Route::get('/order/edit/prod/exclude/{id}/{order_id}/{value}/{qtd}', [

                'as' => 'orders.prodExclude',

                'uses' => 'OrderController@excludeOrderProd'

            ]);

            Route::post('/order/store', [

                'as' => 'orders.store',

                'uses' => 'OrderController@store'

            ]);



            Route::get('/order/edit/{id}', [

                'as' => 'orders.edit',

                'uses' => 'OrderController@edit'

            ]);



            Route::get('/order/show/{id}', [

                'as' => 'orders.show',

                'uses' => 'OrderController@show'

            ]);

            // ROTA DE TAXA DE ENTREGA DO PEDIDO

            Route::get('/order/tax', [

                'as' => 'ordertax.index',

                'uses' => 'OrderTaxController@index'

            ]);



            Route::get('/order/tax/create', [

                'as' => 'ordertax.create',

                'uses' => 'OrderTaxController@create'

            ]);



            Route::post('/order/tax/store', [

                'as' => 'ordertax.store',

                'uses' => 'OrderTaxController@store'

            ]);



            Route::get('/order/tax/edit/{id}', [

                'as' => 'ordertax.edit',

                'uses' => 'OrderTaxController@edit'

            ]);



            Route::get('/order/tax/show/{id}', [

                'as' => 'ordertax.show',

                'uses' => 'OrderTaxController@show'

            ]);



            Route::post('/order/tax/update/{id}', [

                'as' => 'ordertax.update',

                'uses' => 'OrderTaxController@update'

            ]);



            Route::get('/order/tax/destroy/{id}', [

                'as' => 'ordertax.destroy',

                'uses' => 'OrderTaxController@destroy'

            ]);



            // ROTA DE STATUS DE PEDIDO



            Route::get('/order/status', [

                'as' => 'orderstatus.index',

                'uses' => 'OrderStatusController@index'

            ]);



            Route::get('/order/status/create', [

                'as' => 'orderstatus.create',

                'uses' => 'OrderStatusController@create'

            ]);



            Route::post('/order/status/store', [

                'as' => 'orderstatus.store',

                'uses' => 'OrderStatusController@store'

            ]);



            Route::get('/order/status/destroy/{id}', [

                'as' => 'orderstatus.destroy',

                'uses' => 'OrderStatusController@destroy'

            ]);



            // ROTA DE MÉTODO DE PAGAMENTO



            Route::get('/lojas/payment/method', [

                'as' => 'paymentmethod.index',

                'uses' => 'PaymentMethodController@index'

            ]);



            Route::get('/lojas/payment/method/create', [

                'as' => 'paymentmethod.create',

                'uses' => 'PaymentMethodController@create'

            ]);



            Route::post('/lojas/payment/method/store', [

                'as' => 'paymentmethod.store',

                'uses' => 'PaymentMethodController@store'

            ]);



            Route::get('/lojas/payment/method/destroy/{id}', [

                'as' => 'paymentmethod.destroy',

                'uses' => 'PaymentMethodController@destroy'

            ]);



            // ROTA DE MÉTODO DE PAGAMENTO POR LOJA



            Route::get('/loja/payment/method', [

                'as' => 'lojapaymentmethod.index',

                'uses' => 'LojaPaymentMethodsController@index'

            ]);



            Route::get('/loja/payment/method/create', [

                'as' => 'lojapaymentmethod.create',

                'uses' => 'LojaPaymentMethodsController@create'

            ]);

            Route::post('/loja/payment/method/store', [

                'as' => 'lojapaymentmethod.store',

                'uses' => 'LojaPaymentMethodsController@store'

            ]);

            Route::get('/loja/payment/method/destroy/{id}', [

                'as' => 'lojapaymentmethod.destroy',

                'uses' => 'LojaPaymentMethodsController@destroy'

            ]);

            Route::get('/loja/delivery/config', [

                'as' => 'lojadeliveryconfig.index',

                'uses' => 'DeliveryConfigController@index'

            ]);

            Route::get('/loja/delivery/config/create', [

                'as' => 'lojadeliveryconfig.create',

                'uses' => 'DeliveryConfigController@create'

            ]);

            Route::get('/loja/delivery/config/edit/{id}', [

                'as' => 'lojadeliveryconfig.edit',

                'uses' => 'DeliveryConfigController@edit'

            ]);

            Route::post('/loja/delivery/config/store', [

                'as' => 'lojadeliveryconfig.store',

                'uses' => 'DeliveryConfigController@store'

            ]);

            Route::post('/loja/delivery/config/update/{id}', [

                'as' => 'lojadeliveryconfig.update',

                'uses' => 'DeliveryConfigController@update'

            ]);

            Route::get('/orders/time', [

                'as' => 'orderstime.index',

                'uses' => 'OrderUpdateStatusTime@index'

            ]);

            // ROTAS DE BANNER DE PROMOÇÃO

            Route::get('/promotion/banner', [

                'as' => 'banner.index',

                'uses' => 'PromotionBannerController@index'

            ]);

            Route::get('/promotion/banner/create', [

                'as' => 'banner.create',

                'uses' => 'PromotionBannerController@create'

            ]);

            Route::post('/promotion/banner/store', [

                'as' => 'banner.store',

                'uses' => 'PromotionBannerController@store'

            ]);

            Route::get('/promotion/banner/edit/{id}', [

                'as' => 'banner.edit',

                'uses' => 'PromotionBannerController@edit'

            ]);

            Route::post('/promotion/banner/update/{id}', [

                'as' => 'banner.update',

                'uses' => 'PromotionBannerController@update'

            ]);

            Route::get('/reports', [

                'as' => 'reports.index',

                'uses' => 'ReportsController@index'

            ]);

            Route::get('/avaliations', [

                'as' => 'avaliation.index',

                'uses' => 'AvaliationController@index'

            ]);
        });
    });
});
