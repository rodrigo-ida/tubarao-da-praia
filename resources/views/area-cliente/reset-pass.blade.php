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


@if(isset($resToken) && !$resToken->isEmpty())

<div class="verify-token">
    <div class="conteudo">

        <div class="recu-email">
            <h3>Verificar código</h3>
            <label for="token">Digite o código enviado no seu email:</label>
            <input type="hidden" name="id" value="{{ $resToken->First()->client_id }}">
            <input type="text" name="token" required>
            <!-- <p class="alert alert-danger" id="email-error" style="display: none;">Nenhum e-mail cadastrado, tente novamente.</p> -->
            <input style="background-image: url({{ asset('/img/continuar.png') }}" id="btn-verify-token" class="btn" value="Continuar" type="button"/>
        </div>

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

            <h3 style="text-align: center;">Token inválido.</h3>

        </div>

    </div>
</div>
@endif

<script>
    $(document).ready(function(){
        $('#btn-verify-token').click(function(){

            var token = $('input[name="token"]').val();

            var id = $('input[name="id"]').val();

            $.ajax({
                url: '/client/area-do-cliente/reset-password/' + $('input[name="token"]').val() + '/' + $('input[name="id"]').val(),
                type: 'GET',
                success: function (response) {
                    if(response.reset.toString() == 'true')
                    {
                        var html = `<div class="recu-email">
                                        <h3>Nova senha</h3>
                                        <input type="hidden" name="id" value="${id}">
                                        <label for="password"> Nova senha: </label>
                                        <input type="password" name="password" required>
                                        <label for="confirm-password"> Confirmar nova senha </label>
                                        <input type="password" name="confirm-password" required>
                                        <input style="background-image: url({{ asset('/img/continuar.png') }}" id="btn-reset-pass" class="btn" value="resetar senha" type="button"/>
                                    </div>`;

                            $('.recu-email').remove();

                            $('.conteudo').append(html);

                        return;
                    }
                    alert('Código inválido, tente novamente.');
                }
            })
        });

        $(document.body).on('click', '#btn-reset-pass', function(){
            if($('input[name="password"]').val() == $('input[name="confirm-password"]').val()) {
                $.ajax({
                    url: '/client/area-do-cliente/resetar-senha',
                    type: 'POST',
                    data: { _token: '{{ csrf_token() }}', password: $('input[name="password"]').val(), id: $('input[name="id"]').val() },
                    success: function(response) {
                        $('.recu-email').html(' ');
                        $('.recu-email').append(`
                        <h3 style="text-align: center;">
                        Senha alterada com sucesso!
                        </h3>
                        </br>
                        <a href="{{ route('clientes.entrar') }}"><input class="btn" type="button" value="Fazer login"></a>`)
                    },
                    error: function(response) {
                        alert('Não foi possível resetar sua senha, contate o administrador do sistema.')
                    }
                })
            }
        });
    });
</script>

@endsection