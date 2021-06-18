<?php

namespace App\Http\Controllers\Client;

use Illuminate\Http\Request;

use App\User;

use Hash;

use App\Http\Controllers\Controller;

use App\Product;

use App\Order;

use App\OrderProduct;

use App\OrderStatus;

use App\PaymentMethod;

use App\OrderComplements;

use App\Http\Controllers\DeliveryController;

use Illuminate\Support\Facades\Redirect;

use App\Client;

use App\Http\Controllers\StaticMethodsController;

class ClientAreaController extends Controller
{

    private $deliveryController;

    public function __construct()
    {

        $this->deliveryController = new DeliveryController();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = null)
    {

        if ($this->verificaSessao()) {

            $order = Order::select('*')

                ->with(['getLoja'])

                ->with(['getStatus'])

                ->with(['getPaymentMethod'])

                ->where('order_client_id', '=', session()->get('client_id'))

                ->orderBy('id', 'desc')

                ->limit(1)

                ->get();

            return view('area-cliente.order', compact('order'));
        }

        return redirect()->route('clientes.entrar');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function login(Request $request)
    {

        $prev = $request->session()->all();
        
        $url = $prev['_previous']['url'] ?? null;
        if (\Auth::check()) {

            if (\Auth::user()->hasRole(User::ROLE_ADMIN) || \Auth::user()->hasRole(User::ROLE_LOJA)) {
                return redirect()->route('delivery.create-order', $request->all());
            }
        }

        if (session()->get('login_client_token') && session()->get('client_id') && preg_match('/delivery/', $url)) {

            return redirect()->route('productdelivery.entrega');
        } elseif (session()->get('login_client_token') && session()->get('client_id') && preg_match('/\//', $url)) {

            return redirect('delivery');
        }

        return view('area-cliente.login', compact('url'));
    }

    public function userData()
    {

        if (!$this->verificaSessao()) {
            return redirect()->route('clientes.entrar');
        }

        $user = StaticMethodsController::getClientById(session()->get('client_id'));

        return view('area-cliente.userdata', compact('user'));
    }

    public function address()
    {

        if (!$this->verificaSessao()) {
            return redirect()->route('clientes.entrar');
        }

        $user = StaticMethodsController::getClientById(session()->get('client_id'));

        return view('area-cliente.address', compact('user'));
    }

    public function fazerLogin(Request $request)
    {

        $msg = [

            'email_ou_senha' => 'email ou senha incorreto, tente novamente.'

        ];

        $data = $request->all();

        $sess = $request->session()->all();

        $url = $data['url_redirect'] ?? $sess['_previous']['url'];

        if (preg_match('/reset-password/', $url)) {
            $url = '/delivery';
        }

        $user = User::select('*')
            ->where('email', '=', $data['email'])
            ->get();


        if (isset($user->First()->id)) {
            if (Hash::check($data['password'], $user->First()->password)) {

                session([
                    'login_client_token' => Hash::make($user->First()->client_id),
                    'client_id' => $user->First()->client_id,
                    'client_name' => $user->First()->name
                ]);

                if (preg_match('/selecionar-loja/', $data['url_redirect'])) {

                    return redirect()->route('productdelivery.entrega');
                }

                // $order = Order::select('*', 'orders.id')
                //     ->join('clients', 'orders.order_client_id', '=', 'clients.id')
                //     ->where('clients.email', '=', $user->First()->email)
                //     ->where('orders.order_client_id', '=', 'clients.id')
                //     ->orderBy('orders.id', 'desc')
                //     ->get();

                return redirect($url);
            } else {
                return redirect()->route('clientes.entrar')->withInput($request->all())->withErrors($msg);
            }
        } else {

            $client = Client::whereEmail($data['email'])->get();

            if (!empty($client->First())) {

                return redirect()->route('clientes.primeiro-acesso', ['id' => $client->First()->id, 'token' => hash::make($client->First()->id), 'redirect' => $url]);
            }
        }

        return Redirect::back()->withInput($request->all())->withErrors($msg);
    }

    public function fazerLogout(Request $request)
    {
        $prev = $request->session()->all();

        $url = $prev['_previous']['url'] ?? "/";

        if (session()->get('login_client_token')) {
            session()->forget('login_client_token');
            session()->forget('client_id');
            session()->flush();
        }

        return redirect($url);
    }

    public function lastOrder()
    {

        if (!$this->verificaSessao()) {
            return redirect()->route('clientes.entrar');
        }

        $id = session()->get('client_id');

        $user = StaticMethodsController::getClientById($id);

        $order = Order::select('*', 'orders.id', 'orders.created_at')
            ->join('clients', 'orders.order_client_id', '=', 'clients.id')
            ->with('getLoja')
            ->where('orders.order_client_id', '=', $user->id)
            ->orderBy('orders.id', 'desc')
            ->limit(1)
            ->get();

        if (isset($order->First()->id)) {

            return view('area-cliente.order', $this->deliveryController->acompanharPedido($user->email, $order->First()->id));
        }

        return view('area-cliente.order', $this->deliveryController->acompanharPedido('', ''));
    }

    public function todosPedidos()
    {

        if (!$this->verificaSessao()) {
            return redirect()->route('clientes.entrar');
        }

        $products = [];

        $variableProds = [];

        $i = 0;

        $orders = Order::select('*')

            ->with(['getLoja'])

            ->with(['getStatus'])

            ->with(['getPaymentMethod'])

            ->with(['getOrderProducts'])

            ->with(['getOrderComplements' => function ($query) {
                $query->join('product_complements', 'order_complements.id_comp', '=', 'product_complements.id');
            }])

            ->with(['getOrderProducts' => function ($query) {
                $query->join('product', 'order_products.product_id', '=', 'product.id');
            }])

            ->where('order_client_id', '=', session()->get('client_id'))

            ->orderBy('id', 'desc')

            ->get();

        // foreach ($orders as $order) {

        //     $products[$i] = OrderProduct::with(['getOrderProducts'])

        //         ->with(['getVariations'])

        //         ->where('order_id', '=', $order->id)->get();

        //     $variable = OrderComplements::with(['getOrderVariableProducts'])

        //         ->with(['getComplement'])

        //         ->where('order_id', '=', $order->id)->get();

        //     if (!$variable->isEmpty()) {
        //         $variableProds[$i] = $variable;
        //     }

        //     $i++;

        // }

        return view('area-cliente.orders', compact('orders'));
    }

    public function atualizarDados(Request $request)
    {
        try {

            if (!$this->verificaSessao()) {
                return redirect()->route('clientes.entrar');
            }

            $data = $request->all();

            if (!empty($data)) {

                $client = Client::find(session()->get('client_id'));

                if (
                    str_replace(' ', '', str_replace('-', '', str_replace(')', '', str_replace('(', '', $client->whatsapp))))
                    == str_replace(' ', '', str_replace('-', '', str_replace(')', '', str_replace('(', '', $data['whatsapp']))))
                ) {

                    unset($data['whatsapp']);
                }

                if (!empty($data['password'])) {

                    $this->atualizaUsuario($data, session()->get('client_id'));
                }


                $client->fill($data);

                $client->save();

                return redirect()->back()->with('success', 'Dados Atualizados com sucesso!');
            }

            return redirect()->back()->with('error', 'Houve um erro ao atualizar seus dados.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Houve um erro ao atualizar seus dados.');
        }
    }

    public function verificaSessao()
    {
        if (!Hash::check(session()->get('client_id'), session()->get('login_client_token'))) {
            return false;
        }

        return true;
    }

    private function atualizaUsuario($data, $id)
    {

        $user = User::where('client_id', '=', $id)->firstOrFail();

        if ($data['password'] != null) {
            $user->password = Hash::make($data['password']);
        }

        $user->email = $data['email'];

        $user->save();
    }

    public function atualizaEndereco(Request $request)
    {
        try {

            if (!$this->verificaSessao()) {
                return redirect()->route('clientes.entrar');
            }

            $data = $request->all();

            if (strlen($data['cep']) < 9) {
                return redirect()->back()->with('error', 'Houve um erro atualizar seu endereço. CEP inválido!');
            }

            $client = Client::find(session()->get('client_id'));

            $client->fill($data);

            $client->save();

            return redirect()->back()->with('success', 'Endereço atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Houve um atualizar seu endereço. ' . $e->getMessage());
        }
    }

    public function firstAccess(Request $request)
    {
        $data = $request->all();

        if (isset($data['id'], $data['token']) && Hash::check($data['id'], $data['token'])) {

            $user = StaticMethodsController::getUserById($data['id']);

            if (!$user) {

                $client = StaticMethodsController::getClientById($data['id']);

                return view('area-cliente.first-access', compact('client'));
            }
        }

        dd(Hash::check($data['id'], $data['token']));

        return redirect()->route('clientes.entrar');
    }

    public function firstAccessSend(Request $request)
    {

        $data = $request->all();

        if ($data['id']) {

            $client = StaticMethodsController::getClientById($data['id']);

            if (isset($client->id)) {

                $user = \DB::table('users')
                    ->insert([
                        'name' => $client->nome,
                        'email' => $client->email,
                        'password' => Hash::make($data['confirm-password']),
                        'role' => 2,
                        'loja_id' => 1,
                        'client_id' => $client->id,
                        'created_at' => date('Y/m/d H:i:s')
                    ]);

                if ($user) {

                    session([
                        'login_client_token' => Hash::make($client->id),
                        'client_id' => $client->id
                    ]);

                    return redirect($data['url']);
                }
            }
        }
        return redirect()->back();
    }
}
