<script type="text/javascript">
    var qualquer = 0;

    var obj = localStorage.getItem("prods");

    var ljObj = JSON.parse(localStorage.getItem("loja_id"));

    if (ljObj !== null && Object.keys(ljObj).length !== 0 || ljObj !== "undefined") {

    } else {

        localStorage.removeItem("prods");

        localStorage.removeItem("loja_id");

        window.location = '/delivery';

    }
</script>

@extends('layouts.tubarao-delivery')

@section('content')
<script src="{{ asset('/js/delivery-finalizar.js') }}"></script>

<!-- Modal recuperar e-mail header -->

<!-- <div class="modal-recu-email">

<div class="bg"></div>

    <div class="conteudo">
        <div class="x">X</div>

    <div class="recu-email">
        <h3>Esqueceu seu e-mail?</h3>
        <label for="cel-recu">Digite o número do celular cadastrado:</label>
        <input type="text" id="cel-recu" required>
        <p class="alert alert-danger" id="email-error" style="display: none;">Nenhum e-mail cadastrado com esse número, tente outro.</p>
        <input style="background-image: url({{ asset('/img/continuar.png') }}" id="btn-recu-email" class="btn" value="Continuar" type="button"/>
    </div>

    <div class="success-email">	
        <h3>E-mail recuperado com sucesso!</h3>
        <p id="email-success"></p>
        <button class="btn" id="copy-email" onclick="copyToClipboard('#email-success')">Copiar</button>
    </div>


    </div>
</div> -->
<div class="login clearfix">
    <div class="steps">
        <ul class="clearfix">
            <li class="steps__item steps__item--active" id="step__login">
                <span class="steps__label">Identificação</span>
            </li>

            <li class="steps__item" id="step__finalize">
                <span class="steps__label">Pagamento e Endereço</span>
            </li>

            <li class="steps__item" id="step__confirm">
                <span class="steps__label">Confirmação</span>
            </li>
        </ul>
    </div>
    <?php
    if (Session::get('_old_input')) {
        $old = Session::get('_old_input');
    } else {
        $old = url()->previous();
    }
    ?>
    <div id="scroll-forms">
        @if(Session::get('msg'))
        <div style="max-width: 450px; margin: 0 auto; margin-bottom: 10px;" class="alert alert-warning" role="alert">
            {{ Session::get('msg') }}
        </div>
        @endif
        <form id="form-cadastrar-usuario" action="{{ route('clientdelivery.cadclient') }}" method="POST" class="finalizar__form clearfix">
            <h2 style="background-color: #800b58;color: #ffffff;font-size: 24px;padding: 6px 18px;" class="form-h2">CADASTRO</h2>
            <input type="hidden" value="{{ $old['url_redirect'] ?? $old }}" name="url_redirect" />
            <label class="form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 100%;">
                Nome<span>*</span>
                <input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" value="{{ $old['nome'] ?? '' }}" name="nome" class="form" type="text" required />
            </label>
            <label class="form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 100%;">
                Sobrenome<span>*</span>
                <input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" value="{{ $old['sobrenome'] ?? '' }}" name="sobrenome" class="form" type="text" required />
            </label>
            <label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
                Whatsapp<span>*</span>
                <input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" value="{{ $old['whatsapp'] ?? '' }}" name="whatsapp" class="form" type="text" />
            </label>
            <label class="form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 100%;">
                Email<span>*</span>
                <input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="email" value="@if(Session::get('email')) {{ Session::get('email') }} @else {{ $old['email'] ?? '' }} @endif" class="form" type="email" />
            </label>
            <label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
                Data de nascimento<span>*</span>
                <input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" value="{{ $old['nascimento'] ?? '' }}" name="nascimento" class="form" type="date" />
            </label>
            <label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
                Sexo<span>*</span>
                <select style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="sexo">
                    <option @if(isset($old['sexo']) && $old['sexo']=='Masculino' ) selected @endif value="Masculino">Masculino</option>
                    <option @if(isset($old['sexo']) && $old['sexo']=='Feminino' ) selected @endif value="Feminino">Femininino</option>
                </select>
            </label>
            <label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
                CEP<span>*</span>
                <input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="cep" max="9" class="form" type="text" />
            </label>
            <label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
                Logradouro<span>*</span>
                <input readonly style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="logradouro" class="form" type="text" />
            </label>
            <label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
                Bairro<span>*</span>
                <input readonly style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="bairro" class="form" type="text" />
            </label>
            <label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
                Cidade*
                <input readonly style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="cidade" class="form" type="text" />
            </label>
            <label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
                Estado*
                <input readonly style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="estado" class="form" type="text" />
            </label>
            <label class="form-g4 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 25%;">
                Número<span>*</span>
                <input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" value="{{ $old['numero'] ?? '' }}" class="form" name="numero" type="text" />
            </label>
            <label class="form-g4 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 25%;">
                Compl.
                <input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" value="{{ $old['complemento'] ?? '' }}" name="complemento" class="form" type="text" />
            </label>
            <label class="form-label" style="padding-left: 12px;margin-top: 28px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 100%;">
                Senha<span>*</span>
                <input class="password-icon" style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="password" class="form" type="password" required />
            </label>
            <label class="form-label" style="padding-left: 12px;margin-top: 28px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 100%;">
                Confirmar senha<span>*</span>
                <input class="password-icon" style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="confirm-password" class="form" type="password" required />
            </label>
            <label style="margin-top: 28px;">
                <input class="form-btn" id="enviarCadForm" type="button" value="CADASTRAR" />
            </label>
        </form>
    </div>
</div>

<script type="text/javascript">
    function parseCEP(cep) {
        return cep.replace('-', '');
    }
</script>

<script type="text/javascript">
    $('input[name="whatsapp"]').mask('(00) 00000-0000');

    $('input[name="cep"]').mask('00000-000');

    $('#cel-recu').mask('(00) 00000-0000');

    $(document).ready(function() {

        $('input[name="cep"]').keyup(function() {
            var cep = $(this).val().toString().replace(/-/, '');
            if (cep.length == 8) {

                $.ajax({
                    url: 'https://viacep.com.br/ws/' + cep + '/json/',
                    method: 'GET',
                    dataType: 'JSON',
                    success: function(obj) {
                        if (obj.hasOwnProperty('logradouro')) {
                            $('input[name="logradouro"]').val(obj.logradouro);
                            $('input[name="bairro"]').val(obj.bairro);
                            $('input[name="cidade"]').val(obj.localidade);
                            $('input[name="estado"]').val(obj.uf);
                            return;
                        }
                        alert('O CEP digitado não foi encontrado');
                    },
                    error: function(obj) {
                        alert('O CEP digitado não foi encontrado');
                    }
                });
            }

        });
    });

    $(document.body).on('click', '#enviarCadForm', function() {
        // var nome        = $('input[name="nome"]').val();
        // var sobre       = $('input[name="sobrenome"]').val();
        // var email       = $('input[name="email"]').val();
        // var whatsapp    = $('input[name="whatsapp"]').val();
        // var cep         = $('input[name="cep"]').val();
        // var estado      = $('input[name="estado"]').val();
        // var cidade      = $('input[name="cidade"]').val();
        // var logradouro  = $('input[name="logradouro"]').val();
        // var bairro      = $('input[name="bairro"]').val();
        // var numero      = $('input[name="numero"]').val();
        // var complemento = $('input[name="complemento"]').val();
        // var data_nasc   = $('input[name="nascimento"]').val();
        // var sexo        = $('select[name="sexo"] option:selected').val();
        // var origem      = 'Delivery';
        // var loja        = JSON.parse(localStorage.getItem("loja_id")) 

        // var data = {
        //     'nome'       : nome,
        //     'sobrenome'  : sobre,
        // 	'email'      : email,
        // 	'whatsapp'   : whatsapp,
        // 	'cep'        : cep,
        // 	'estado'     : estado,
        // 	'cidade'     : cidade,
        // 	'logradouro' : logradouro,
        // 	'bairro'     : bairro,
        // 	'numero'     : numero,
        // 	'complemento': complemento,
        // 	'data_nasc'  : data_nasc,
        // 	'sexo'       : sexo,
        // 	'origem'     : origem
        // }

        if (!validateDataCadForm('')) {

            return;

        }

        if ($('input[name="password"]').val() == $('input[name="confirm-password"]').val()) {
            $('#form-cadastrar-usuario').submit();
            return;
        } else {
            alert('As senhas digitadas não conferem, tente novamente.');
            return;
        }

    });
</script>



@endsection