@extends('layouts.tubarao-email')

@section('content')
    <div class="show-form">
        <div class="mensagem">
            <h3>Foi solicitado um link de acesso para ganhar descontos através de nosso site!</h3>
            <p>Aqui está o link solicitado: <br> <a href="{{route('visualizar.cupons', ['login_token' => $cliente->login_token])}}" target="_blank">{{route('visualizar.cupons', ['login_token' => $cliente->login_token])}}</a></p>
            <p style="margin: 16px 0"><strong>Importante:</strong> este link é unicamente para utilização pessoal. Não compartilhe esse link.</p>
            
            <p style="margin: 16px 0"><strong>Tubarão da Praia - Promoções acesse: <a href="https://pedidos.tubaraodapraia.com.br"> Pedidos.tubaraodapraia.com.br</a></strong></p>
        </div>
    </div>
@endsection