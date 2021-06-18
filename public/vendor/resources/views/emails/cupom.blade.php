@extends('layouts.tubarao-email')

@section('content')

    <div class="show-form">
        <h1 class="first">LEGAL! Este é o seu cupom</h1>
        <div class="mensagem">
            <p><span>Cupom: {{ $cupom->offer()->first()->titulo }}</span></p>
            <p><span>{{ $cupom->offer()->first()->descricao }}</span></p>
        </div>
        <div class="banner">
            <img src="{{ $cupom->offer->getImageURL() }}" />
        </div>
        @if(!is_null($cupom->offer->expires_at))
        <div class="expires-at">
            * oferta válida até {{ Carbon\Carbon::parse($cupom->offer->expires_at)->format('d/m/Y') }}
        </div>
        @endif
        <div class="cupom-token">
            <span>{{ $cupom->validation_token }}</span>
        </div>
        <div class="mensagem">
            <p>Apresente este cupom em nossas lojas e ganhe seu desconto!</p>
        </div>
    </div>

@endsection