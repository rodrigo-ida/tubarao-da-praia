<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Cashier;

use App\FacePurchase;

use App\CaixaStatus;

use App\Order;
use App\Product; 
use App\ProductCategories;
use Auth;

use Carbon\Carbon; 

use Illuminate\Support\Collection;

class CashierController extends Controller
{
     private $model;

    public function __construct(Cashier $model)
    {
        $this->model = $model;
    }
    
    public function index()
    {
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
 
            ->orderBy('product.product_order', 'asc')

            ->get();
            
            $prodK = $products->toArray();
            
            //dd($prodK);
            
            $categories = ProductCategories::select('*')
            ->orderBy('category_order', 'asc')
            ->get();

  $day = date('w');
  
 //dd( Auth::user()->id );

        $caixaAberto = false;
        
        
        $testUm = CaixaStatus::select('*')
        ->where('user_id','=',Auth::user()->id)
        ->where('status','=',1)
        
            ->first();
            
            if($testUm != null){
            
            $caixaAberto = true;
        }
        
        $caixaToday = 0;
        if($caixaAberto)
{        
       $caixaToday = $this->getCaixa()[0]->total - $this->getNegative()[0]->total ;
}       
        
        
        
        // dd( Cashier::pluck('id'));
        
        
        
        
        return view('admin.cashier.index', 
        compact(
            'caixaToday','categories','products','day','prodK','caixaAberto'
        ));
    }
     public function store(Request $request)
    {
        
          $caixaID = CaixaStatus::select('*')
        ->where('user_id','=',Auth::user()->id)
        ->where('status','=',1)
        
            ->first();
         
         $data =  $request->all();
         
         $cashier = new Cashier;
         
         $cashier->fill($data);
         
         $cashier->caixa_status_id = $caixaID->id;


       // dd($cashier);
            
         $cashier->save();
         
         
        // return view('admin.cashier.index');
        return redirect()->route('admin.cashier.index');
        
        
    }
     public function storeC(Request $request)
    {
        
         
         //Decidir como vai ser a logica de interacao entre tabelas para ser o mais eficiente possivel
        //Troquei nome do LogCaixa pq Log e reservado buga o sistema
         
         $caixa = new CaixaStatus();
         
         $caixa->user_id = Auth::user()->id;
         
         $caixa->status = 1;

         $caixa->save();
         
         
         
        $caixaID = CaixaStatus::select('*')
        ->where('user_id','=',Auth::user()->id)
        ->where('status','=',1)
        ->first();
         
         $data =  $request->all();
         
         $cashier = new Cashier;
         
         $cashier->fill($data);
         
         $cashier->caixa_status_id = $caixaID->id;


       // dd($cashier);
            
         $cashier->save();
         
         
        // return view('admin.cashier.index');
        return redirect()->route('admin.cashier.index');
        
        
    }
      public function storeD(Request $request)
    {
        
         
         //Decidir como vai ser a logica de interacao entre tabelas para ser o mais eficiente possivel
        //Troquei nome do LogCaixa pq Log e reservado buga o sistema
         
         $caixa = CaixaStatus::select('*')
         ->where('user_id','=',Auth::user()->id)
        ->where('status','=',1)
        
            ->first();
         
         
         
         $caixa->status = 0;

         $caixa->save();
         
         
        // return view('admin.cashier.index');
        return redirect()->route('admin.cashier.index');
        
        
    }
     public function storeP(Request $request)
    { 
        
        //criar new FacePurchase e Cashier e dps atribuir em ambos pq um depende do outro
        
        //Novos FacePurchase e LogCaixa
        
        //Log caixa e pra verificar aberto e fechado
        
        //Face purchase e pra log de comprar in loco
        
        //Cashier registro de entrada e saida de dinheiro tbm oriundos do facePurchase
         $requestVar = $request->all();
         
        
         
         //Face Side
         $face = new FacePurchase();
         $face->product_id = $requestVar['idProd'];
         $face->user_id = Auth::id();
         
         $faceSaved = $face->save();
        //End Face side
         
          //Cashier Side
          $cashier = new Cashier();
          $cashier->valor = $requestVar['Price'];
          $cashier->acao = 'Compra';
          $cashier->obs = $requestVar['obs'];
          $cashier->face_purchase_id = $face->id;
          $cashier->conta = "Loja";
          $cashier->tipo = "Suprimento";
          $cashier->caixa_status_id = CaixaStatus::select('*')
        ->where('user_id','=',Auth::user()->id)
        ->where('status','=',1)->first()->id;
          
          $cashier->save();
          
         //End Cashier
          
        
         
        
         
         
         $data =  $request->all();
         
        
         
        // return view('admin.cashier.index');
        return redirect()->route('admin.cashier.index');
        
        
    }
    public function list(){
        
        

      

        $query = $this->model->orderBy('cashier.created_at', 'desc')
        ->join('caixa_status', 'cashier.caixa_status_id', '=', 'caixa_status.id');

   

        /* @var $paginator LengthAwarePaginator */
        $paginator = $query->paginate();

        $clients = new Collection($paginator->items());

        $viewData = compact(['clients', 'paginator']);
        return view('admin.cashier.list', $viewData);
    }
    public function getCaixa()
    {
        
       $testUm = CaixaStatus::select('*')
        ->where('user_id','=',Auth::user()->id)
        ->where('status','=',1)
        
            ->first();
        
        

        $withTax = Cashier::select(\DB::raw('SUM(cashier.valor) as total,COUNT(cashier.id) as total_orders'))
        ->where('cashier.caixa_status_id', '=', $testUm->id)
        ->where('cashier.acao', '<>', 'sangria')
       ->get();

       

        return $withTax;
        
        
        
    }
    
     public function getNegative()
    {
        $testUm = CaixaStatus::select('*')
        ->where('user_id','=',Auth::user()->id)
        ->where('status','=',1)
        
            ->first();
       

        $withTax = Cashier::select(\DB::raw('SUM(cashier.valor) as total,COUNT(cashier.id) as total_orders'))
        ->where('cashier.caixa_status_id', '=', $testUm->id)
        ->where('cashier.acao', '=', 'sangria')
       ->get();

        return $withTax;
        
        
        
    }
   

}
