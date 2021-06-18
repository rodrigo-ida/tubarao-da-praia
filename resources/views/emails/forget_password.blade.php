@extends('layouts.tubarao-delivery-email')

@section('content')

<div class="show-form" style="font-family: Sans-serif; margin-bottom: 20px; background-color: #fff; padding: 20px;">
    <p class="first" style="color: #6d1357; font-size: 42px; font-weight: 200; text-align: center;">Olá {{ $client->name }}, esse é seu código de recuperação de senha!</p>
        <div class="mensagem">
            <p><h1 style="text-align: center;">Código de verificação</h1></p>
            <p><h2 style="color: #6d1357; font-size: 36px; font-weight: 200; text-align: center;">{{ $hash }}</h2></p>
            <p style="color: #fdec01; font-size: 30px; text-align: center;">Acesse o link abaixo para recuperar sua senha.</p>

            <a href="https://www.pedidos.tubaraodapraia.com.br/client/area-do-cliente/reset-password?token={{ $fp }}&id={{ $client->client_id }}" target="_BLANK">
            <!-- <a href="https://www.pedidos.tubaraodapraia.com.br/client/area-do-cliente/reset-password?token=" target="_BLANK"> -->
                <p style="background-color: #0275d8!important; color: #fff; border: 1px solid #5bc0de!important; padding: 20px; border-radius: 4px; margin: 0 auto; display: block;" >Recuperar Senha</p>
            </a>    
        </div>
        
    </div>

@endsection