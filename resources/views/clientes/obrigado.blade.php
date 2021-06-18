@extends('layouts.tubarao')

@section('content')
    <div class="external-container">
        <div class="imagem mail-icon">
            <img src="/img/email.png"/>
        </div>
        @if($action == 'token'):
        <h1 class="first regular">As informações foram enviadas.</h1>
        <h1 class="regular">Verifique seu e-mail com o link para gerar o seu cupom</h1>
                    <a href="https://www.tubaraodapraia.com.br/"> Página Inicial </a>

        @else
            <h1 class="first regular">PARABÉNS, seu cadastro foi realizado com sucesso!</h1>
            <h1 class="regular">Enviamos um e-mail para você com o link para gerar o seu cupom</h1>
                        <a href="https://www.tubaraodapraia.com.br/"> Página Inicial </a>

        @endif
        <div class="social clearfix">
            <a href="http://tubaraodapraia.com.br" target="_blank">
                <img src="/img/icon-shark.png"/>
            </a>
            <a href="https://instagram.com/tubaraodapraia/">
                <img src="img/icon-instagram.png"/>
            </a>
            <a href="https://facebook.com/tubaraodapraia/" target="_blank">
                <img src="/img/icon-facebook.png"/>
            </a>
        </div>
    </div>
@endsection