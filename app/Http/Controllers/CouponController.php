<?php

namespace App\Http\Controllers;

use App\Client;
use App\Contracts\Services\CouponService;
use App\Coupon;
use App\Criteria\ActiveOffersCriteria;
use App\Jobs\SendMail;
use App\Mail\CouponMail;
use App\Offer;
use Illuminate\Contracts\Support\MessageProvider;
use App\Repositories\OfferRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CouponController extends Controller
{
    /**
     * @var OfferRepository
     */
    private $repository;

    /**
     * CouponController constructor.
     * @param OfferRepository $repository
     */
    public function __construct(OfferRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(){
        $cupons_utilizados = [];
        $client = Auth::guard('web2')->user();

        if (!$client->validate(false)){
            return response()->redirectToRoute('editar.cadastro');
        }
        $cvs = $client->couponValidations()->get();
        foreach ($cvs as $cupom){
            if ($cupom->hasBeenUsed()){
                $cupons_utilizados[] = $cupom->offer()->first()->id;
            }
        }

        $offers = $this->repository->getByCriteria(new ActiveOffersCriteria());
        return view('cupom.index', compact(['cupons_utilizados', 'offers']));
    }

    public function verCupons(Request $request, Offer $offer){
        if (!$offer->canClientUseIt()){
            return response()->redirectToRoute('visualizar.cupons')->withErrors(['cannot_use_it' => 'Está oferta não está mais ativa, ou está fora do prazo.']);
        }
        $client = Auth::guard('web2')->user();
        $cupons = $client->couponValidations()->where(['offer_id' => $offer->id])->get();
        $cuponsUtilizados = $client->couponValidations()->where(['offer_id' => $offer->id])->count();
        $titulo = $offer->titulo;
        $descricao = $offer->descricao;
        $limite = $offer->coupon_limit;

        return view('cupom.by-offer', compact('offer', 'cupons', 'titulo', 'descricao', 'limite', 'cuponsUtilizados'));
    }

    public function selecionar(Request $request, CouponService $couponService){
        if ($cupom = $request->get('cupom_id')){
            $c = new Coupon();
            $cupom = $c->find($cupom);
            $offer = $cupom->offer;
            $titulo = $offer->titulo;
            $descricao = $offer->descricao;
        } else {
            $offer = new Offer();
            try {
                $offer = $offer->findOrFail($request->get('offer'));
                if ($offer == null) {
                    throw new \RuntimeException("Não foi possível encontrar a oferta informada");
                }
            } catch (\Exception $e) {
                throw new \RuntimeException("Houve um problema com sua solicitação", $e->getCode(), $e);
            }
            $titulo = $offer->titulo;
            $descricao = $offer->descricao;

            $limit = $offer->coupon_limit;

            $client = Auth::guard('web2')->user();

            $utilizados = $client->couponValidations()->where(['offer_id' => $offer->id])->count();


            if ($utilizados < $limit || $limit == 0) {
                $cupomValidation = new Coupon();
                $cupomValidation->generateToken($couponService);
                $cupomValidation->client()->associate($client);
                $cupomValidation->offer()->associate($offer);
                $cupomValidation->save();
                $cupom = $cupomValidation;
            }else {
                $mp = array('limite_excedido' => 'Limite de cupons para esta oferta excedido teste!');
                 return response()->redirectToRoute('cupons.por.oferta', ['offer' => $offer->id])->withErrors($mp);
            }
        }

    $whats =  "Olá, meu nome é " . $client->nome . " gostaria de fazer um pedido, meu cupom é " . $cupom->validation_token ;
        return view('cupom.show', compact('cupom','titulo', 'descricao', 'whats', 'client'));
    }

    public function imprimir(Request $request){
       $cupom = $request->get('cupom_id');
        $c = new Coupon();
        $cupom = $c->find($cupom);
        $offer = $cupom->offer;
        $titulo = $offer->titulo;
        $descricao = $offer->descricao;
        return view('cupom.show', compact('cupom','titulo', 'descricao'))->render();
    }


    public function email(Request $request){
        $c = $request->get('cupom_utilizado');
        $cupom = Coupon::whereId($c)->first()->getModel();
        $client = Auth::guard('web2')->user();

        $mail = new CouponMail($cupom);
        Mail::to($client)->send($mail);
// Linhas abaixo foram comentadas pois estamos no aguardo para implementar o esquema de queue
//        $mail->to($client);
//        $job = (new SendMail($mail))->onQueue('email');
//        dispatch($job);

        $mensagem = 'E-mail enviado para ' . $client->email;
        $titulo = $cupom->offer()->first()->titulo;
        $descricao = $cupom->offer()->first()->descricao;
        $whats =  "Olá, meu nome é " . $client->nome . " gostaria de fazer um pedido, meu cupom é " . $cupom->validation_token ;
        return view('cupom.show', compact('cupom', 'mensagem', 'titulo', 'descricao', 'whats', 'client'));
    }

    public function ajaxEmail(Request $request){
        $c = $request->get('cupom_utilizado');
        $cupom = Coupon::whereId($c)->first()->getModel();
        $client = Auth::guard('web2')->user();
        $mail = new CouponMail($cupom);
        Mail::to($client)->send($mail);
        return "ok";
    }


}
