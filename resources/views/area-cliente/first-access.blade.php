@extends('layouts.tubarao-delivery')

@section('content')

<style>
.verify-token {
    -webkit-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    background-color: #ffffff;
    padding: 70px;
    border-radius: 10px;
    position: relative;
    left: 50%;
    margin-top: 18.7%;
    -webkit-box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    max-width: 480px;
    width: calc(100% - 24px);
}

.verify-token h3 {
    font-size: 40px;
    margin-bottom: 20px;
}

.verify-token label {
    float: left;
    color: #757575;
    font-size: 20px;
    font-weight: 300;
    margin-bottom: 10px;
}

.verify-token input {
    width: 100%;
    margin-top: 12px;
    margin-bottom: 20px;
    display: block;
    font-size: 20px;
    font-family: 'Oswald', sans-serif;
    padding: 8px;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    border: solid 2px #cccccc;
    outline: none;
    color: #848484;
}

.verify-token .btn {
    display: block;
    border: solid 3px #7b0654;
    font-size: 24px;
    font-family: 'Oswald', sans-serif;
    border-radius: 25px;
    padding: 5px 20px;
    cursor: pointer;
    width: 45%;
    margin: 0 2.5%;
    text-align: center;
    background-color: #7b0654;
    color: #fdec01;
    margin: 0 auto;
}

</style>


@if(isset($client->id))

<div class="verify-token">
    <div class="conteudo">
        <form action="{{ route('clientes.primeiro-acesso-enviar') }}" method="POST" id="primeiro-acesso">
            <div class="recu-email">
                <h3>Primeiro acesso</h3>
                <label for="password">Olá {{ $client->nome }}, digite sua senha de acesso abaixo!</label>
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $client->id }}">
                    <input type="hidden" name="url" value="{{ $_GET['redirect'] ?? route('delivery') }}">
                <label for="password">Senha</label>
                    <input type="password" name="password" required>
                <label for="password">Confirmar senha</label>
                    <input type="password" name="confirm-password" required>
                <!-- <p class="alert alert-danger" id="email-error" style="display: none;">Nenhum e-mail cadastrado, tente novamente.</p> -->
                <input style="background-image: url({{ asset('/img/continuar.png') }}" id="btn-form" class="btn" value="Continuar" type="button"/>
            </div>
        </form>
            <!-- <div class="success-email">	
                <h3>Senha recuperada com sucesso!</h3>
                <p id="email-success"></p>
            </div> -->


    </div>
</div>

    @else 
<div class="verify-token">
    <div class="conteudo">

        <div class="recu-email">

            <h3 style="text-align: center;">Houve um erro.</h3>

        </div>

    </div>
</div>
@endif

<script>
    $(document.body).on('click', '#btn-form', function(){
        if($('input[name="password"]').val() == $('input[name="confirm-password"]').val()) {
            $('#primeiro-acesso').submit();
        }
    });
</script>

@endsection