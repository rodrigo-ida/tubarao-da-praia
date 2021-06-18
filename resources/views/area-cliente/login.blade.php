@extends('layouts.tubarao-delivery')

<?php
  //echo phpinfo();


?>

@section('content')

<div class="modal-recu-email">



    <div class="bg"></div>



    <div class="conteudo">

        <div class="x">X</div>



        <div class="recu-email">

            <h3>Esqueceu sua senha?</h3>

            <label for="cel-recu">Digite seu email cadastrado:</label>

            <input type="text" id="email-recu" required>

            <p class="alert alert-danger" id="email-error" style="display: none;"></p>

            <input style="background-image: url({{ asset('/img/continuar.png') }}" id="btn-recup-email" class="btn" value="Continuar" type="button" />

        </div>



        <div class="success-email">

            <h3>Senha recuperada com sucesso!</h3>

            <p id="email-success"></p>

        </div>





    </div>

</div>



<?php

if (preg_match('/selecionar-loja/', url()->previous())) {



    $url = url()->previous();

} else {



    $session = session()->all();

    $sess = $session['_old_input']['url_redirect'] ?? $url;

}



?>



<section class="login-cadastro">

    <div class="container">

        <form style="max-width: 450px; border-radius: 5px; padding: 10px;" action="/client/area-do-cliente/login" class="col-50" method="POST">

            <h2>Já sou cliente tubarão</h2>

            {{ csrf_field() }}

            <input type="hidden" value="{{ $sess ?? $url }}" name="url_redirect" />

            <label class="">

                E-mail<span>*</span>

                <input class="form-control" type="email" name="email" id="email" required />

            </label>

            <label class="">

                Senha<span>*</span>

                <input class="form-control" type="password" name="password" id="password" required>

            </label>

            <a href="#" id="recu-email-show">

                <p class="esquecer-senha"><small>Esqueci minha senha</small></p>

            </a>



            @if(Session::get('errors'))

            <div style="margin-top: 10px;">

                <p class="alert alert-danger">Email ou senha inválido</p>

            </div>

            @endif

            <input type="submit" class="btn-user-login" value="Entrar">

        </form>

        <div class="divider">



        </div>

        <form style="max-width: 450px; border-radius: 5px; padding: 10px;" action="/delivery/finalizar/quero-me-cadastrar" class="col-50" method="POST">

            <h2>Quero me cadastrar</h2>

            {{ csrf_field() }}

            <input type="hidden" value="{{ $session['_old_input']['url_redirect'] ?? $url }}" name="url_redirect" />

            <label class="">

                E-mail<span>*</span>

                <input class="form-control" type="email" name="email" id="email" required />

            </label>



            <input type="submit" class="btn-user-cadastro" value="Cadastrar">

            @if(Session::get('error-cadastro'))

            <div style="margin-top: 10px;">

                <p class="alert alert-danger">{{ Session::get('error-cadastro') }}</p>

            </div>

            @endif

        </form>



    </div>

</section>



<script>

    $('#recu-email-show').click(function() {

        $('.modal-recu-email').addClass('ativo');

    });



    if ($('.alert').length > 0) {

        var scroll = jQuery('.alert').offset();



        jQuery('html, body').animate({

            scrollTop: scroll.top - 140

        }, 100);

    }



    $('#btn-recup-email').click(function() {



        var email = $('#email-recu').val();



        $.ajax({

            url: '/client/area-do-cliente/recuperar-senha/' + email,

            type: 'GET',

            dataType: 'JSON',

            success: function(res) {

                console.log(res);

                if (res.status == 200) {

                    $('.recu-email').remove();

                    $('.success-email').show();

                    $('#email-success').append(res.msg);

                    return;

                } else if (res.status == 201) {

                    $('#email-error').html(res.msg);

                    $('#email-error').show();

                } else if (res.status == 403) {
                    document.location = res.redirect;
                }

                $('#email-error').show();

            },
            error: function(res)
            {
                res = res.responseJSON;
                if (res.status == 200) {

                    $('.recu-email').remove();

                    $('.success-email').show();

                    $('#email-success').append(res.msg);

                    return;

                } else if (res.status == 201) {

                    $('#email-error').html(res.msg);

                    $('#email-error').show();

                } else if (res.status == 403) {
                    document.location = res.redirect;
                }

                $('#email-error').show();
            }

        })

    });

</script>



@endsection