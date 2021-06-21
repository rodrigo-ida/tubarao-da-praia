<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Product;

use App\ProductPromotion;

use App\Client;

use App\LojaPaymentMethods;

use App\PromotionsBanners;

use App\Loja;

use App\Order;

use App\User;

use App\OrderProduct;

use App\OrderTax;

use App\DeliveryConfig;

use App\OrderStatus;

use App\PromotionBanner;

use App\ProductVariation;

use App\Services\ClientService;

use App\Jobs\SendMail;

use App\Mail\DeliveryMail;

use Illuminate\Contracts\Support\MessageProvider;

use Illuminate\Support\Facades\Mail;

use App\ProductCategories;

use App\Complement;

use App\OrderComplements;

use App\Http\Controllers\AvaliationController;

use Hash;
use App\ComboVariation;
use function GuzzleHttp\json_decode;
use App\Http\Controllers\Admin\OrderTaxController;
use App\PaymentMethod;
use App\Htpp\Controllers\eRedeController;
use Rede\eRede;

class DeliveryController extends Controller
{

    public function index(Request $request)
    {

        $data = $request->all();

        $products = Product::select(

            'product.id',

            'product.product_pic_src',

            'product.name_product',

            'product.description_product',

            'product.price_product',

            'product.promotion_active',

            'product.promotion_id',

            'product.status_product',

            'product.product_type'
        )

            ->with('getPromotionPrice')

            // ->where('product.product_lojas_id', 'like', '%' . $data->id . '%')
            ->where('product.product_lojas_id', 'like', '%' . $data['id'] . '%')

            ->orderBy('id', 'desc')

            ->paginate(20);

        return view('delivery.first', compact('products'));
    }

    public function prodCategorie(Request $request)
    {

        $promoProducts = Product::getPromoProducts($data['id-loja'] ?? null);
        $showPromoProducts = false;

        $data = $request->all();

        $products = Product::select(

            'product.id',

            'product.product_pic_src',

            'product.name_product',

            'product.description_product',

            'product.price_product',

            'product.promotion_active',

            'product.category_id',

            'product.status_product',

            'product.promotion_price',

            'product.promotion_day',

            'product.product_type',

            'product.product_comps'
        )

            ->join('product_categories', 'product.category_id', '=', 'product_categories.id')

            ->where('product.category_id', '=', $data['category_id'])

            ->where('product.status_product', '=', '1')

            ->orderBy('product.product_order', 'asc')

            ->get();

        $configs = DeliveryConfig::select('*')
            ->get();

        $categories = ProductCategories::select('*')
            ->orderBy('category_order', 'asc')
            ->get();

        $day = date('w');

        $bannerCarrinho = PromotionBanner::select('*')
            ->with('getProduct')
            ->where('promo_banner_day', '=', $day)
            ->where('promo_status', '=', '1')
            ->where('promo_carrinho', '=', '1')
            // ->where('promo_banner_loja_id', '=', $data['id-loja'])
            ->get();


        $banner = PromotionBanner::select('*')
            ->with('getProduct')
            ->where('promo_banner_day', '=', $day)
            ->where('promo_banner_home', '=', '1')
            ->get();

        $variations = ProductVariation::select('*')
            ->where('prod_var_status', '!=', '2')
            ->where('prod_var_status', '!=', '0')
            ->get();

        $catId = $data['category_id'];

        return view('delivery.index-new', compact('products', 'categories', 'banner', 'variations', 'catId', 'promoProducts', 'showPromoProducts', 'bannerCarrinho'));
    }

    public function deliveryProducts(Request $request)
    {

        $data = $request->all();

        $promoProducts = Product::getPromoProducts($data['id-loja'] ?? null);

        $showPromoProducts = true;

        $products = Product::select(

            'product.id',

            'product.product_pic_src',

            'product.name_product',

            'product.description_product',

            'product.price_product',

            'product.promotion_active',

            'product.category_id',

            'product.status_product',

            'product.promotion_price',

            'product.promotion_day',

            'product.product_type',

            'product.product_comps'
        )

            ->join('product_categories', 'product.category_id', '=', 'product_categories.id')
            ->when(isset($data['id-loja']), function ($query, $data) {
                $query->where('product.product_lojas_id', 'like', '%' . $data['id-loja'] . '%');
            })
            //->where('product.product_lojas_id', 'like', '%' . $data['id-loja'] . '%')

            ->where('product.status_product', '=', '1')

            ->orderBy('product.product_order', 'asc')

            ->get();

        $loja = $data['id-loja'] ?? null;

        $configs = DeliveryConfig::select('*')
            ->where('config_loja_id', '=', $data['id-loja'] ?? null)
            ->get();

        $categories = ProductCategories::select('*')
            ->orderBy('category_order', 'asc')
            ->get();

        $day = date('w');



        $banner = PromotionBanner::select('*')
        ->with('getProduct')
        ->where('promo_banner_day', '=', $day)
        ->where('promo_banner_home', '=', '1')
        ->get();


        $bannerCarrinho = PromotionBanner::select('*')
            ->with('getProduct')
            ->where('promo_banner_day', '=', $day)
            ->where('promo_status', '=', '1')
            ->where('promo_carrinho', '=', '1')
            ->where('promo_banner_loja_id', '=', $data['id-loja'] ?? null)
            ->get();

        $variations = ProductVariation::select('*')
            ->where('prod_var_status', '!=', '2')
            ->where('prod_var_status', '!=', '0')
            ->get();

        // $shopName = Loja::find($data['id-loja']);

        // $tax = OrderTax::find($data['cep-id']);

        // return view('delivery.index', compact('tax', 'shopName', 'products', 'loja', 'configs', 'categories', 'banner', 'variations', 'promoProducts'));
        return view('delivery.index-new', compact('products', 'categories', 'banner', 'variations', 'promoProducts', 'showPromoProducts', 'bannerCarrinho'));
    }



    public function deliveryProductsByShop(Request $request, $slug)
    {

        $shops = ['boqueirao', 'mallet'];
        if (!in_array($slug, $shops)) {
            abort(404);
        }
        $data = [];
        switch ($slug) {

            case 'boqueirao':
                $data['id-loja'] = "1";
                break;
            case 'tupi':
                $data['id-loja'] = "3";
                break;
            case 'mallet':
                $data['id-loja'] = "6";
                break;
        }

        //$data = $request->all();

        $promoProducts = Product::getPromoProducts($data['id-loja'] ?? null);


        $products = Product::select(

            'product.id',

            'product.product_pic_src',

            'product.name_product',

            'product.description_product',

            'product.price_product',

            'product.promotion_active',

            'product.category_id',

            'product.status_product',

            'product.promotion_price',

            'product.promotion_day',

            'product.product_type',

            'product.product_comps'
        )

            ->join('product_categories', 'product.category_id', '=', 'product_categories.id')

            ->where('product.product_lojas_id', 'like', '%' . $data['id-loja'] . '%')

            //->where('product.product_lojas_id', 'like', '%' . $data['id-loja'] . '%')

            ->where('product.status_product', '=', '1')

            ->orderBy('product.product_order', 'asc')

            ->get();

        $loja = $data['id-loja'] ?? null;

        $configs = DeliveryConfig::select('*')
            ->where('config_loja_id', '=', $data['id-loja'] ?? null)
            ->get();

        $categories = ProductCategories::select('*')
            ->orderBy('category_order', 'asc')
            ->get();

        $day = date('w');

        $banner = PromotionBanner::select('*')
            ->with('getProduct')
            ->where('promo_banner_day', '=', $day)
            ->where('promo_status', '=', '1')


            ->where('promo_banner_loja_id', '=', $data['id-loja'] ?? null)
            ->get();


        $bannerCarrinho = PromotionBanner::select('*')
            ->with('getProduct')
            ->where('promo_banner_day', '=', $day)
            ->where('promo_status', '=', '1')
            ->where('promo_carrinho', '=', '1')
            ->where('promo_banner_loja_id', '=', $data['id-loja'] ?? null)
            ->get();

        $variations = ProductVariation::select('*')
            ->where('prod_var_status', '!=', '2')
            ->where('prod_var_status', '!=', '0')
            ->get();

        // $shopName = Loja::find($data['id-loja']);

        // $tax = OrderTax::find($data['cep-id']);

        // return view('delivery.index', compact('tax', 'shopName', 'products', 'loja', 'configs', 'categories', 'banner', 'variations', 'promoProducts'));
        return view('delivery.index-new', compact('products', 'categories', 'banner', 'variations', 'promoProducts', 'bannerCarrinho'));
    }



    public function view($id)
    {

        $product = Product::find($id);

        return $product;
    }

    public function finalizar()
    {


        if (Hash::check(session()->get('client_id'), session()->get('login_client_token'))) {

            $data = $this->getUserByEmail(null, session()->get('client_id'));

            if (!empty($data) && $data != null) {

                return redirect()->route('productdelivery.entrega')->with('data', compact('data'));
            }
        }

        $lojas = Loja::pluck('nome_loja', 'id');

        return redirect()->route('clientes.entrar');
    }

    public function idCadastro()
    {
        return view('delivery.identificacao-cadastro');
    }

    public function idEntrega()
    {

        if (!empty(session()->get('client_id'))) {

            $data = $this->getUserByEmail(null, session()->get('client_id'));

            session()->put('data', $data);
        } else {
            $data = session()->get('data');
        }

        if (!empty($data) && isset($data)) {

            return view('delivery.identificacao-entrega')->with('data', compact('data'));
        }

        return redirect()->route('productdelivery.finalizar');
    }

    public function promotionPrice($id)
    {

        $promotion = ProductPromotion::find($id);

        return $promotion;
    }

    public function getClient(Request $request)
    {

        $email = $request->all();

        $data = $this->getUserByEmail($email['email']);

        // $client = Client::whereEmail($email['email']);

        // if (isset($client->First()->id)) {

        //     $data['id'] = $client->First()->id;

        //     $data['nome'] = $client->First()->nome;

        //     $data['cep'] = $client->First()->cep;

        //     $data['logradouro'] = $client->First()->logradouro;

        //     $data['numero'] = $client->First()->numero;

        //     $data['cidade'] = $client->First()->cidade;

        //     $data['bairro'] = $client->First()->bairro;

        //     $data['estado'] = $client->First()->estado;

        //     $data['email'] = $client->First()->email;

        // }

        if ($data) {

            session([
                'data' => $data
            ]);

            return redirect()->route('productdelivery.entrega');
        }

        return redirect()->route('productdelivery.cadastro')->with('email', $email['email']);
    }

    public function getUserByEmail($email = null, $id = null)
    {
        $data = [];

        if (isset($email)) {

            $client = Client::whereEmail($email);

            if (isset($client->First()->id)) {

                $data['id'] = $client->First()->id;

                $data['nome'] = $client->First()->nome;

                $data['cep'] = $client->First()->cep;

                $data['logradouro'] = $client->First()->logradouro;

                $data['numero'] = $client->First()->numero;

                $data['cidade'] = $client->First()->cidade;

                $data['bairro'] = $client->First()->bairro;

                $data['estado'] = $client->First()->estado;

                $data['email'] = $client->First()->email;
            }
        } else {

            $client = Client::find($id);

            if (isset($client->id)) {

                $data['id'] = $client->id;

                $data['nome'] = $client->nome;

                $data['cep'] = $client->cep;

                $data['logradouro'] = $client->logradouro;

                $data['numero'] = $client->numero;

                $data['cidade'] = $client->cidade;

                $data['bairro'] = $client->bairro;

                $data['estado'] = $client->estado;

                $data['email'] = $client->email;
            }
        }

        return $data;
    }

    public function getPaymentMethods($id)
    {

        $methods = LojaPaymentMethods::select('*')

            ->with(['getPaymentMethods'])

            ->where('payment_method_loja_id', '=', $id)->get();

        $encode = $methods->toJson();

        return json_decode($encode);
    }

    public function finalizarPedido(Request $request)
    {

        $pedido = $request->all();



        $json = json_encode($pedido);
        $jsonDecoded = json_decode($json);


        $p = PaymentMethod::find($jsonDecoded->payment_method);

        if ($jsonDecoded->payment_method == $p->id && preg_match('/eRede/', $p->name_method)) {
            $erede = (new \App\Http\Controllers\eRedeController())->store($jsonDecoded, $p->name_method);
            if ($erede !== null)
                $jsonDecoded->tid = $erede;
            else
                return redirect()->route('productdelivery.entrega')->with('msg', 'Transação não autorizada pelo banco ou os dados estão incorretos, tente novamente por favor.');
        }

        $jsonDecoded->complements = json_decode(json_decode($jsonDecoded->complements));

        $jsonDecoded->products = json_decode(json_decode($jsonDecoded->products));

        if (($jsonDecoded->date == "null" && $jsonDecoded->time == "null") || ($jsonDecoded->date == null && $jsonDecoded->time == null)) {

            $date = new \DateTime('2000-01-01');

            $jsonDecoded->date = $date->format('Y-m-d');

            $jsonDecoded->time = $date->format('H:i:s');
        }


        $loja = Loja::find($jsonDecoded->loja);

        /*if (isset($jsonDecoded->cep) && isset($jsonDecoded->bairro)) {
            
            if ($this->verifyOrderTaxRate($loja->logradouro_loja . ' ' . $loja->numero_loja ?? $loja->cidade_loja, $jsonDecoded->logradouro . ', ' . $jsonDecoded->cidade, $jsonDecoded->taxa) == false)
                return $msg = [
                    'msg' => "Valor da taxa de entrega está incorreto, por favor, entre em contato conosco ou refaça seu pedido :(",
                    'status' => 401
                ];
        } else {
            return $msg = [
                'msg' => "O bairro ou o CEP informado está incorreto, por favor, entre em contato conosco ou refaça seu pedido :(",
                'status' => 401
            ];
        }*/

        // $verifyProdPrice = $this->verifyProductPrice($jsonDecoded);
        $verifyProdPrice = 1;
        if ($verifyProdPrice == 1) {

            $order = $this->createOrder($this->serializeData($jsonDecoded));

            if (isset($jsonDecoded->complements)) {

                $compl = $jsonDecoded->complements;
            } else {
                $compl = null;
            }

            if ($order) {

                $createProds = $this->createProductOrder($this->serializeProductData($jsonDecoded, $order->id), $compl);
            }

            $this->sendFinalEmailOrder($order->id);

            $this->generateAvaliationToken($order->order_client_id, $order->id);

            //$dataOrder = $this->acompanharPedido($jsonDecoded->email, $order->id);

            //return '/delivery/pedido/'. $jsonDecoded->email . '/'. $order->id;
            // if (\Auth::check() && \Auth::user()->hasRole(User::ROLE_ADMIN)) {
            //     return redirect()->route('admin.orders.index');
            // }

            return redirect()->route('clientes.order');
        }

        return $verifyProdPrice;
    }

    public function serializeData($data)
    {

        if ($data->status == "Pdt") {
            $orderStatus = OrderStatus::select('*')
                ->where('status_name', '=', 'Pendente')
                ->get();
        } else {
            $orderStatus = OrderStatus::select('*')
                ->where('status_name', '=', 'Agendado')
                ->get();
        }

        $obj = [

            'order_total' => $data->total,

            'order_prod_qtd' => $data->total_prod / 2,

            'order_tax_rate' => $data->taxa,

            'order_street' => $data->logradouro,

            'order_number' => $data->numero,

            'order_neighborhood' => $data->bairro,

            'order_city' => $data->cidade,

            'order_obs_payment' => $data->obs_payment ? $data->obs_payment : null,

            'order_state' => $data->estado,

            'order_complement' => $data->complemento,

            'order_reference' => $data->referencia,

            'order_status' => $orderStatus[0]->id,

            'order_obs' => $data->obs,

            'order_payment_method' => $data->payment_method,

            'order_client_id' => $data->id,

            'order_loja_id' => $data->loja,

            'order_dev_time' => $data->time,

            'order_dev_date' => $data->date,

            'cpf_nota' => $data->cpf_nota ?? '',

            'tid_erede' => $data->tid ?? null,

            'order_client_name' => $data->nome ?? null

            //'order_tax_store' => $data->retirar_na_loja,

        ];

        return $obj;
    }

    public function serializeProductData($data, $id = "")
    {

        $obj = [];

        $varsDB = [];

        if (gettype($data->products) == 'string') {
            $data->products = json_decode(json_decode($data->products));
        }

        for ($i = 0; $i < sizeof($data->products); $i++) {

            $obj[$i]['order_id'] = $id;

            $obj[$i]['product_id'] = intval($data->products[$i]->id);

            $obj[$i]['order_product_price'] = floatval($data->products[$i]->preco);

            $obj[$i]['order_product_total'] = floatval($data->products[$i]->preco * $data->products[$i]->qtd);

            $obj[$i]['order_product_qtd'] = intval($data->products[$i]->qtd);

            if ($data->products[$i]->tf !== 0 && !isset($data->products[$i]->comboVars)) {
                $obj[$i]['comp'] = $data->products[$i]->comp;
                $obj[$i]['order_product_comp'] = intval($data->products[$i]->tf);
            }

            if (isset($data->products[$i]->id_var)) {

                $obj[$i]['order_products_var_id'] = intval($data->products[$i]->id_var);
            } else if (isset($data->products[$i]->comboVars)) {
                $vars = json_decode($data->products[$i]->comboVars);

                if (gettype($vars) == 'string') {
                    $vars = json_decode($vars);
                }

                foreach ($vars as $var) {

                    if ($var != null) {

                        array_push($varsDB, $var);
                    }
                }

                $obj[$i]['order_combo_ids'] = json_encode($vars);
            }
        }

        return $obj;
    }

    public function serializeProductComplementData($data, $id = "", $id_prod)
    {

        $obj = [];

        $obj['order_id'] = $id;

        $obj['id_prod'] = intval($data->id_produto);

        $obj['price_comp'] = floatval($data->preco);

        $obj['qtd_comp'] = 1;

        $obj['id_comp'] = intval($data->id_complemento);

        $obj['order_product_id'] = $id_prod;


        return $obj;
    }

    public function verifyProductPrice($data, $complements = null)
    {
        $array = [];

        if ($complements != null) {
            for ($i = 0; $i < sizeof($complements); $i++) {
                $c = Complement::find($complements[$i]->id);

                if ($c->price_complement != $complements[$i]->preco) {

                    $array = ["msg" => "Preço do complemento: " . $c->name_complement
                        . " não condiz com a base de dados, impossível concluir o pedido.", "status" => 401];
                }
            }
        }

        for ($i = 0; $i < sizeof($data->products); $i++) {
            if (!isset($data->products[$i]->id_var)) {

                $p = Product::find($data->products[$i]->id);

                if ($p->promotion_price != 0 && $p->promotion_active != 0 && $p->price_product != $data->products[$i]->preco) {

                    if ($p->promotion_price != $data->products[$i]->preco) {

                        return $array = ["msg" => "Preço do produto: " . $p->name_product
                            . " não condiz com a base de dados, impossível concluir o pedido.", "status" => 401];
                    }
                } elseif ($p->price_product != $data->products[$i]->preco) {

                    return $array = ["msg" => "Preço do produto: " . $p->name_product
                        . " não condiz com a base de dados, impossível concluir o pedido.", "status" => 401];
                }
            }
        }

        return 1;
    }

    public function createOrder($data)
    {

        return $order = Order::create($data);
    }

    public function createProductOrder($data, $data_comp)
    {

        for ($i = 0; $i < sizeof($data); $i++) {

            $orderProducts = OrderProduct::create($data[$i]);

            if ($data_comp != null) {
                for ($c = 0; $c < sizeof($data_comp); $c++) {
                    if (isset($data[$i]['comp'])) {
                        if ($data_comp[$c]->id_produto == $data[$i]['product_id'] && $data[$i]['comp'] == $data_comp[$c]->comp && isset($data[$i]['order_product_comp']) == 1) {
                            $createProdComplements = $this->createProductComplementOrder($this->serializeProductComplementData($data_comp[$c], $data[$i]['order_id'], $orderProducts->id));
                        }
                    }
                }
            }
        }

        return $orderProducts;
    }

    public function createProductComplementOrder($data)
    {

        $orderComplements = OrderComplements::create($data);

        return $orderComplements;
    }

    public function acompanharPedido($email = "", $id = "")
    {

        try {

            $order = null;

            $products = null;

            $variableProds = null;

            $loja = null;

            $tax = null;

            if (!empty($id) && !empty($email)) {

                $order = Order::select('*', 'orders.id', 'orders.created_at')

                    ->join('order_status', 'orders.order_status', '=', 'order_status.id')

                    ->join('payment_methods', 'orders.order_payment_method', '=', 'payment_methods.id')

                    ->join('clients', 'orders.order_client_id', '=', 'clients.id')

                    ->with('getLoja')

                    ->where('clients.email', '=', $email)

                    ->where('orders.id', '=', $id)

                    ->orderBy('orders.id', 'desc')->get();

                $products = OrderProduct::with(['getOrderProducts'])
                    ->with(['getVariations'])
                    ->where('order_id', '=', $id)->get();

                $variableProds = OrderComplements::with(['getOrderVariableProducts'])
                    ->with(['getComplement'])
                    ->where('order_id', '=', $id)->get();

                if (!isset($order->First()->order_loja_id)) {

                    $order = null;

                    return compact('order');
                }

                $loja = Loja::find($order->First()->order_loja_id);

                $tax = OrderTax::select('*')
                    ->where('order_tax_neighborhood', '=', $order->First()->order_neighborhood)
                    ->get();
            }
            return compact('order', 'products', 'variableProds', 'loja', 'tax');
        } catch (\Exception $e) {

            return redirect()->route('productdelivery.index');
        }
    }

    public function acompanharPedidoPorEmail(Request $request)
    {

        try {

            $data = $request->all();

            $orders = Order::select('*', 'orders.id')

                ->with(['getLoja'])

                ->join('order_status', 'orders.order_status', '=', 'order_status.id')

                ->join('payment_methods', 'orders.order_payment_method', '=', 'payment_methods.id')

                ->join('clients', 'orders.order_client_id', '=', 'clients.id')

                ->where('clients.email', '=', $data['email'])

                ->orderBy('orders.id', 'desc')

                ->get();

            // $products = OrderProduct::with(['getOrderProducts'])

            // ->where('order_id', '=', $order->First()->id)->get();

            // $variableProds = OrderComplements::with(['getOrderVariableProducts'])
            // ->with(['getComplement'])
            // ->where('order_id', '=', $order->First()->id)->get();

            return view('delivery.historico-pedidos', compact('orders'));
        } catch (\Exception $e) {

            return back()->with('alert-danger', 'Não há pedidos pendentes com o email pesquisado!');
        }
    }

    public function statusOrder($id)
    {

        try {

            $order = Order::find($id)

                ->with(['getStatus'])

                ->where('orders.id', '=', $id);

            return $order->First()->getStatus()->First()->status_name;
        } catch (\Exception $e) {

            return;
        }
    }

    public function getCep($bairro)
    {
        // return $cep = OrderTax::with(['getLojas'])
        // ->where('order_tax_status', '=', '1')
        // ->where('order_tax_cep_inicial', '<=', $cep)
        // ->where('order_tax_cep_final', '>=', $cep )->get();

        return $cep = OrderTax::with(['getLojas'])
            ->where('order_tax_status', '=', '1')
            ->where('order_tax_neighborhood', '=', $bairro)->get();
    }

    public function getLojas(Request $request)
    {
        $data = $request->all();


        $taxas = array();

        $lojas = OrderTax::with(['getLojas'])
            ->with(['getDeliveryConfig'])
            ->where('order_tax_status', '=', '1')
            ->where('order_tax_neighborhood', '=', $data['bairro'])
            ->where('id', '=', $data['cep-id'])
            ->get();



        foreach ($lojas as $loja) {

            $taxas[$loja->getLojas->First()->id] = (new OrderTaxController)->calculateOrderTax(
                $loja->getLojas->First()->logradouro_loja . ' ' .
                    $loja->getLojas->First()->numero_loja . ', ' .
                    $loja->getLojas->First()->cidade_loja,
                $data['rua'] . ', ' . $data['bairro'] . ', ' . $data['cidade']
            );



            $configs[$loja->getLojas->First()->id] = $this->verifyLojaTime($loja->getDeliveryConfig);
        }

        $lojas = $this->serializeLojas($lojas, $configs, $taxas);

        if ($lojas == null) {

            $lojas[0]['configs']['existe'] = 0;
            return view('delivery.loja_error_entrega', compact('lojas'));
        }



        $configz = DeliveryConfig::select('*')
            ->where('config_loja_id', '=', $lojas[0]['id'])
            ->where('config_status', '=', '1')
            ->get();

        $day = date('w');

        $banner = PromotionBanner::select('*')
            ->with('getProduct')
            ->where('promo_banner_day', '=', $day)
            ->where('promo_banner_loja_id', '=', $lojas[0]['id'])
            ->get();

        $shopName = Loja::find($lojas[0]['id']);



        return view('delivery.selecionar-loja', compact('lojas', 'data', 'configz', 'banner', 'shopName'));
    }

    // public function getLojasPrev(Request $request)
    // {
    //     $data = $request->all();

    //     $lojas = OrderTax::with(['getLojas'])
    //         ->where('order_tax_status', '=', '1')
    //         ->where('order_tax_neighborhood', '=', $data['bairro'])
    //         ->get();

    //     $lojas = $this->serializeLojas($lojas);

    //     return view('delivery.selecionar-loja-prev', compact('lojas'));
    // }

    private function verifyLojaTime($configs)
    {
        $day = date('w');
        $hora = new \DateTime("now");
        $bool = false;
        $status = false;
        foreach ($configs as $config) {
            if ($day == 0 && $config->config_date == 'domingo') {
                if ($hora > new \DateTime($config->config_time) && $hora < new \DateTime($config->config_time_end) && $config->config_status != 0) {

                    $bool = true;
                    $status = true;
                }

                if ($config->config_status == 0) {
                    $desativado = true;
                } else {
                    $desativado = false;
                    $status = false;
                }
            } elseif ($day == 1 && $config->config_date == 'segunda-feira') {
                if ($hora > new \DateTime($config->config_time) && $hora < new \DateTime($config->config_time_end) && $config->config_status != 0) {

                    $bool = true;
                    $status = true;
                }


                if ($config->config_status == 0) {
                    $desativado = true;
                } else {
                    $desativado = false;
                    $status = false;
                }
            } elseif ($day == 2 && $config->config_date == 'terca-feira') {
                if ($hora > new \DateTime($config->config_time) && $hora < new \DateTime($config->config_time_end) && $config->config_status != 0) {

                    $bool = true;
                    $status = true;
                }

                if ($config->config_status == 0) {
                    $desativado = true;
                } else {
                    $desativado = false;
                    $status = false;
                }
            } elseif ($day == 3 && $config->config_date == 'quarta-feira') {
                if ($hora > new \DateTime($config->config_time) && $hora < new \DateTime($config->config_time_end) && $config->config_status != 0) {

                    $bool = true;
                    $status = true;
                }

                if ($config->config_status == 0) {
                    $desativado = true;
                } else {
                    $desativado = false;
                    $status = false;
                }
            } elseif ($day == 4 && $config->config_date == 'quinta-feira') {
                if ($hora > new \DateTime($config->config_time) && $hora < new \DateTime($config->config_time_end) && $config->config_status != 0) {

                    $bool = true;
                    $status = true;
                }

                if ($config->config_status == 0) {
                    $desativado = true;
                } else {
                    $desativado = false;
                    $status = false;
                }
            } elseif ($day == 5 && $config->config_date == 'sexta-feira') {
                if ($hora > new \DateTime($config->config_time) && $hora < new \DateTime($config->config_time_end) && $config->config_status != 0) {

                    $bool = true;
                    $status = true;
                    $status = false;
                }

                if ($config->config_status == 0) {
                    $desativado = true;
                } else {
                    $desativado = false;
                    $status = false;
                }
            } elseif ($day == 6 && $config->config_date == 'sabado') {
                if ($hora > new \DateTime($config->config_time) && $hora < new \DateTime($config->config_time_end) && $config->config_status != 0) {

                    $bool = true;
                    $status = true;
                }

                if ($config->config_status == 0) {
                    $desativado = true;
                } else {
                    $desativado = false;
                    $status = false;
                }
            }
        }

        return array(
            'desativado' => $desativado,
            'status' => $status,
            'bool' => $bool
        );
    }

    private function serializeLojas($lojas, $configs, $taxas)
    {

        $passadas = [];

        $data = [];

        $i = 0;

        foreach ($lojas as $loja) {

            $bool = false;

            foreach ($passadas as $p) {
                if ($p == $loja->getLojas->First()->id) {

                    $bool = true;
                }
            }

            if (!$bool && $loja->getLojas->First()->status != '0') {

                $data[$i]['loja_pic_src'] = $loja->getLojas->First()->loja_pic_src;

                $data[$i]['nome_loja'] = $loja->getLojas->First()->nome_loja;

                $data[$i]['id'] = $loja->getLojas->First()->id;

                $data[$i]['tax_id'] = $loja->id;

                $data[$i]['time'] = $loja->order_shipping_time;

                $data[$i]['price'] = (float) $taxas[$loja->getLojas->First()->id];

                $data[$i]['neighborhood'] = $loja->order_tax_neighborhood;

                $data[$i]['configs'] = $configs[$loja->getLojas->First()->id];

                $passadas[$i] = $loja->getLojas->First()->id;

                $i++;
            }
        }

        return $data;
    }

    public function getLojasByCep()
    {
        dd("a");
        return $lojas = OrderTax::with(['getLojas'])
            ->where('order_tax_status', '=', '1')
            ->get();
    }

    public function first()
    {
        $configs = DeliveryConfig::select('*')
            ->where('config_loja_id', '=', 1);

        return view('delivery.first', compact('configs'));
    }
    public function consulta()
    {
        $configs = DeliveryConfig::select('*')
            ->where('config_loja_id', '=', 1);

        return view('delivery.first', compact('configs'));
    }

    public function cadClient(Request $request, ClientService $clientService)
    {
        try {
            $client = new Client();

            $data = $request->all();

            $ver = $this->verifyEmailAndWpp($data['email'], $data['whatsapp']);

            if ($ver == true) {
                $msg = 'Email ou Whatsapp já cadastrado, tente novamente.';
                return redirect()->back()->withInput($request->all())->with('msg', $msg);
            }

            $client->resetLoginToken($clientService);

            $client->fill($data);

            $client->save();

            $this->createUser($client, $data['password']);

            return redirect($data['url_redirect']);
        }
         catch (Request $e) {
            return $e;
        }
    }

    public function idPagamento(Request $request)
    {


        $data = $request->all();

        $payments = StaticMethodsController::getPaymentMethodsByShop($data['id_loja']);

        return view('delivery.identificacao-pagamento', compact('payments', 'data'));
    }

    public function idFinalizar(Request $request)
    {

        $data = $request->all();

        if ($data['cpf_nota'] != null || $data['cpf_nota'] != '') {
            if (isset($data['XXSSAA$IIE_OQP']) != '1') {

                $payments = StaticMethodsController::getPaymentMethods();

                return view('delivery.identificacao-pagamento', compact('payments', 'data'));
            }
        }

        return view('delivery.identificacao-finalizar', compact('data'));
    }

    public function verifyEmailAndWpp($email, $wpp)
    {
        $client = Client::where('email', '=', $email)
            ->get();

        if (isset($client->First()->id)) {
            return $true = true;
        } else {

            $client = Client::where('whatsapp', '=', $wpp)
                ->get();

            if (isset($client->First()->id)) {
                return $true = true;
            }
        }

        return $false = false;
    }

    public function sendFinalEmailOrder($id)
    {
        $order = Order::with('getClient')
            ->where('id', '=', $id)
            ->First();

        $products = OrderProduct::select('*')

            ->with(['getOrderProducts'])->get()

            ->where('order_id', '=', $id);

        $mail = new DeliveryMail($order);

        return Mail::to($order->getClient->email)->send($mail);
    }

    // public function sendStatusEmailOrder($id)
    // {
    //     $order = Order::with('getClient')
    //         ->with('getStatus')
    //         ->where('id', '=', $id)
    //         ->First();

    //     $mail = new DeliveryStatusMail($order);

    //     return Mail::to($order->getClient->email)->send($mail);
    // }

    public function getProductsComplements()
    {

        $complement = Complement::select('*')
            ->where('complements_status', '=', '1')
            ->get();

        return response()->json($complement);
    }

    public function verifyOrderTaxRate($add, $add2, $tax)
    {

        // $order_tax = OrderTax::where('order_tax_neighborhood', '=', $neighborhood)
        //     ->where('order_tax_loja_id', '=', $lId)->get();

        // if (isset($order_tax->First()->id)) {
        //     if (floatval($order_tax->First()->order_tax_price) == floatval($taxa)) {

        //     }
        // }

        $bool = (new OrderTaxController)->calculateOrderTax($add, $add2);

        if ($bool == $tax) {

            return $true = true;
        }

        return $false = false;
    }

    public function recuperarEmail(Request $request)
    {
        $data = $request->all();

        $findClient = Client::select('*')
            ->where('whatsapp', 'like', '%' . $data['num'] . '%')
            ->get();

        if (isset($findClient->First()->id)) {
            return $findClient->First()->email;
        }

        return $stat = 'false';
    }

    public function getProdVariations()
    {
        $var = ProductVariation::all();

        return response()->json($var);
    }

    public function generateAvaliationToken($clId, $order)
    {

        $avaliation = AvaliationController::create($clId, $order);
    }

    public function createUser($client, $psw)
    {
        try {

            $data = $this->serializeUserData($client, $psw);

            $user = new User();

            $user->fill($data);

            $user->save();

            session([
                'client_id' => $user->client_id,
                'login_client_token' => Hash::make($user->client_id)
            ]);

            return $user;
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function serializeUserData($info, $psw)
    {
        $data = [];

        $data['name'] = $info->nome;
        $data['email'] = $info->email;
        $data['password'] = Hash::make($psw);
        $data['loja_id'] = 1;
        $data['role'] = 2;
        $data['client_id'] = $info->id;

        return $data;
    }

    public function queroCadastrar(Request $request)
    {
        $data = $request->all();

        $user = $this->getUserByEmail($data['email']);

        if (!empty($user)) {
            return redirect()->back()->with('error-cadastro', 'Email já cadastrado em nossa base de dados, por favor, tente novamente com outro email.');
        }

        return redirect()->route('productdelivery.cadastro')->with('email', $data['email'])->with('url', $data['url_redirect']);
    }

    public function getComboVariations()
    {
        return response()->json(ComboVariation::select('*')->with(['getCategory'])->leftJoin('product', 'combo_variation.refer_product', '=', 'product.id')->orderBy('cat_id')->get());
    }

    public function getProductPage($name)
    {

        $name = str_replace('-', '%', $name);

        $product = Product::where('name_product', 'like', $name)->get();

        $categories = ProductCategories::select('*')
            ->orderBy('category_order', 'asc')
            ->get();

        return view('delivery.product_page', compact('product', 'categories'));
    }

    public function adminCreateOrder()
    {
        $paymentsShop = StaticMethodsController::getAllPaymentMethods();
        $payments = StaticMethodsController::getPaymentMethods();

        return view('delivery.create-order', compact('payments', 'paymentsShop'));
    }

    public function productsDeliverySearch($name)
    {
        $promoProducts = Product::getPromoProducts(null);

        $name = str_replace('-', '%', $name);

        $products = Product::select(

            'product.id',

            'product.product_pic_src',

            'product.name_product',

            'product.description_product',

            'product.price_product',

            'product.promotion_active',

            'product.category_id',

            'product.status_product',

            'product.promotion_price',

            'product.promotion_day',

            'product.product_type',

            'product.product_comps'
        )

            ->join('product_categories', 'product.category_id', '=', 'product_categories.id')

            //->where('product.product_lojas_id', 'like', '%' . $data['id-loja'] . '%')

            ->where('product.status_product', '=', '1')

            ->where('name_product', 'LIKE', $name)

            ->orderBy('product.product_order', 'asc')

            ->get();

        if ($products->count() <= 0) {
            $name = '%' . $name . '%';
            $products = Product::select(

                'product.id',

                'product.product_pic_src',

                'product.name_product',

                'product.description_product',

                'product.price_product',

                'product.promotion_active',

                'product.category_id',

                'product.status_product',

                'product.promotion_price',

                'product.promotion_day',

                'product.product_type',

                'product.product_comps'
            )

                ->join('product_categories', 'product.category_id', '=', 'product_categories.id')

                //->where('product.product_lojas_id', 'like', '%' . $data['id-loja'] . '%')

                ->where('product.status_product', '=', '1')

                ->where('name_product', 'LIKE', $name)

                ->orderBy('product.product_order', 'asc')

                ->get();
        }

        // $loja = $data['id-loja'];

        $configs = DeliveryConfig::select('*')
            ->get();

        $categories = ProductCategories::select('*')
            ->orderBy('category_order', 'asc')
            ->get();

        $day = date('w');

        $banner = PromotionBanner::select('*')
            ->with('getProduct')
            ->where('promo_banner_day', '=', $day)
            // ->where('promo_banner_loja_id', '=', $data['id-loja'])
            ->get();

        $variations = ProductVariation::select('*')
            ->where('prod_var_status', '!=', '2')
            ->where('prod_var_status', '!=', '0')
            ->get();

        // $shopName = Loja::find($data['id-loja']);

        // $tax = OrderTax::find($data['cep-id']);

        // return view('delivery.index', compact('tax', 'shopName', 'products', 'loja', 'configs', 'categories', 'banner', 'variations', 'promoProducts'));
        return view('delivery.pesquisado', compact('products', 'categories', 'banner', 'variations', 'promoProducts', 'configs'));
    }


    public function getLojascep(Request $request)
    {
        $data = $request->all();

        if (isset($data['allLojas'])) {

            $taxas = array();

            $lojas = OrderTax::with(['getLojas'])
                ->with(['getDeliveryConfig'])
                ->where('order_tax_status', '=', '1')
                ->distinct('order_tax_loja_id')
                ->get();



            foreach ($lojas as $loja) {

                $taxas = 0;



                $configs[$loja->getLojas->First()->id] = $this->verifyLojaTime($loja->getDeliveryConfig);
            }

            $lojas = $this->serializeLojas($lojas, $configs, $taxas);

            $configz = DeliveryConfig::select('*')
                ->where('config_loja_id', '=', $lojas[0]['id'])
                ->where('config_status', '=', '1')
                ->get();

            $day = date('w');

            $banner = PromotionsBanners::select('*')
                ->with('getProduct')
                ->where('promo_banner_day', '=', $day)
                ->where('promo_banner_loja_id', '=', $lojas[0]['id'])
                ->get();

            $shopName = Loja::find($lojas[0]['id']);

            return view('delivery.selecionar-loja', compact('lojas', 'data', 'configz', 'banner', 'shopName'));
        } else {

            $taxas = array();

            $lojas = OrderTax::with(['getLojas'])
                ->with(['getDeliveryConfig'])
                ->where('order_tax_status', '=', '1')
                ->where('order_tax_neighborhood', '=', $data['bairro'])
                ->where('id', '=', $data['cep-id'])
                ->get();



            foreach ($lojas as $loja) {

                $taxas[$loja->getLojas->First()->id] = (new OrderTaxController)->calculateOrderTax(
                    $loja->getLojas->First()->logradouro_loja . ' ' .
                        $loja->getLojas->First()->numero_loja . ', ' .
                        $loja->getLojas->First()->cidade_loja,
                    $data['rua'] . ', ' . $data['bairro'] . ', ' . $data['cidade']
                );



                $configs[$loja->getLojas->First()->id] = $this->verifyLojaTime($loja->getDeliveryConfig);
            }

            $lojas = $this->serializeLojas($lojas, $configs, $taxas);

            $configz = DeliveryConfig::select('*')
                ->where('config_loja_id', '=', $lojas[0]['id'])
                ->where('config_status', '=', '1')
                ->get();

            $day = date('w');

            $banner = PromotionsBanners::select('*')
                ->with('getProduct')
                ->where('promo_banner_day', '=', $day)
                ->where('promo_banner_loja_id', '=', $lojas[0]['id'])
                ->get();

            $shopName = Loja::find($lojas[0]['id']);

            return view('delivery.selecionar-cep', compact('lojas', 'data', 'configz', 'banner', 'shopName'));
        }
    }
}
