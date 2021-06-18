@extends('layouts.tubarao')

@section('content')

    <div class="show-form">
        @if(isset($mensagem))
            <div class="info noprint">{{ $mensagem }}</div>
        @endif
        <h1 class="first">LEGAL! Este é o seu cupom</h1>
        <div class="mensagem">
            <p><span>Cupom: {{ $titulo }}</span></p>
            <p><span>{{ $descricao }}</span></p>
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

            <div class="cupom-token">
                <h1 class="first" style="color:#f00; background-color: #fff; padding:10px;"> Faça Agora seu Pedido  Pelo  Whats! Só Clicar na Unidade</h1>
                <style>
                    .bto-whats {
                        max-width: 280px;
                        color: #6d1357;
                        background-color: #feee00;
                        -webkit-box-shadow: inset 0 0 5px 1px rgba(0,0,0,.5);
                        box-shadow: inset 0 0 5px 1px rgba(0,0,0,.5);

                        line-height: 62px;
                    }


                    }


                </style>
                <a class="cupom-link bto-whats  noprint btn " target="_blank" href="http://api.whatsapp.com/send?1=pt_BR&phone=5513991396212&text={{$whats}} - Meu endereço é {{$client->logradouro}}, {{$client->numero}}, {{$client->complemento}}, {{$client->bairro}},{{$client->cep}}, {{$client->cidade}}/{{$client->estado}} , e meu telefone é {{$client->whatsapp}} - Unidade Boqueirão - By Ótima Ideia "> Unidade Boqueirão</a>
                <a class="cupom-link bto-whats noprint btn  " target="_blank" href="http://api.whatsapp.com/send?1=pt_BR&phone=5513996760970&text={{$whats}} - Meu endereço é {{$client->logradouro}}, {{$client->numero}}, {{$client->complemento}}, {{$client->bairro}},{{$client->cep}}, {{$client->cidade}}/{{$client->estado}} , e meu telefone é {{$client->whatsapp}} - Unidade Vila Tupi - By Ótima Ideia"> Unidade Vila Tupi</a>
<br>            <a class="cupom-link bto-whats noprint btn  " target="_blank" href="http://api.whatsapp.com/send?1=pt_BR&phone=551333239389&text={{$whats}} - Meu endereço é {{$client->logradouro}}, {{$client->numero}}, {{$client->complemento}}, {{$client->bairro}},{{$client->cep}}, {{$client->cidade}}/{{$client->estado}} , e meu telefone é {{$client->whatsapp}} - Unidade São Vicente - By Ótima Ideia"> Unidade São Vicente</a>
                <br>
                <br>
                <br>
                <br>

            </div>

        <div class="mensagem">
            <p>Apresente este cupom em nossas lojas e ganhe seu desconto!</p>
            <p class="mensagem noprint">Deseja enviar este cupom para o email cadastrado? ({{ $cupom->client()->first()->email }})</p>
            {{ Form::open(['route' => 'enviar.email', 'class' => 'enviar-email noprint']) }}
            {{ Form::hidden('cupom_utilizado', $cupom->id) }}
            {{ Form::button('Enviar e-mail', ['type' => 'submit', 'class' => 'ativo']) }}
            {{ Form::close() }}
        </div>

        <a href="{{ route('cupons.por.oferta', ['offer' => $cupom->offer]) }}" class="cupom-link  noprint btn btn-default"><span class="glyphicon glyphicon-backward"></span> Voltar</a>
        <a href="#" class="cupom-link  noprint btn btn-default" onclick="window.print()"><span class="glyphicon glyphicon-print"></span> Imprimir</a>
        <a href="{{ route('visualizar.cupons') }}" class="cupom-link  noprint btn btn-default"><span class="glyphicon glyphicon-tag"></span> Ver outros cupons</a>
    </div>

@endsection