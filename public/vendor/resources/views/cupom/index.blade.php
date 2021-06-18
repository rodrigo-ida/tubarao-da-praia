@extends('layouts.tubarao')

@section('content')

    @if (isset($errors) && !$errors->isEmpty())
        <div class="alert alert-danger">
            @foreach($errors->getMessages() as $key => $value)
                {{ $value[0] }}
            @endforeach
        </div>
    @endif

    @if (!$offers->isEmpty())
    <h1 class="first">TUDO PRONTO! Escolha o desconto para gerar seu cupom</h1>
    {{--<h2 class="season_offers_title alternative-title">
        Promoção dia do Cliente
        você merece um Tubarão!
    </h2>--}}
    <div class="caixas clearfix">
        @foreach($offers as $offer)
        <div class="colm colm_6m col_4 colxl_xl3">
            <a href="{{ route('cupons.por.oferta', ['id' => $offer->id]) }}" style="text-decoration: none">
                <div class="box" data-cupom-id="{{$offer->id}}" id="cupom{{$offer->id}}">
                    <img src="{{ $offer->getImageUrl() }}" />
                    @if (in_array($offer->id, $cupons_utilizados))
                   <!-- <span class="unavailable-text">Cupom já utilizado!</span>-->
                    @endif
                    @if(!is_null($offer->expires_at))
                    
               <br/>
               <div style="font-size:14px; color:#ffff00">{{$offer->titulo}}</div>
               
                    <span class="expires-at">* oferta válida até {{ Carbon\Carbon::parse($offer->expires_at)->format('d/m/Y') }}</span>
                    @endif
                </div>
            </a>

        </div>
        @endforeach
    </div>

    <div class="description-general">
        * As ofertas são válidas apenas para quem se cadastrar nesta página e apresentar o código do cupom, impresso ou por e-mail, no caixa durante a compra.<br />
        * Válido até a data de validade de cada oferta ou enquanto durarem os estoques.<br />
    </div>
    @else
    <div class="no-cupons">
        <h2 class="alternative-title">
            Que pena! Não há cupons de desconto disponíveis nesse momento.
        </h2>
        <p>
            Mas não fique triste, em breve traremos mais descontos para você.
        </p>
    </div>
    @endif
@endsection