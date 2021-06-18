<script type="text/javascript">
    // var qualquer = 0;

    // var obj   = localStorage.getItem("prods");

    // var ljObj = JSON.parse(localStorage.getItem("loja_id"));

    // if(ljObj !== null && Object.keys(ljObj).length !== 0 || ljObj !== "undefined")
    // {

    //     localStorage.removeItem("prods");

    //     localStorage.removeItem("loja_id");

    //     window.location = '/delivery';

    // }
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

            <li class="steps__item steps__item--active" id="step__finalize">
                <span class="steps__label">Pagamento e Endereço</span>
            </li>

            <li class="steps__item steps__item--active" id="step__confirm">
                <span class="steps__label">Confirmação</span>
            </li>
        </ul>
    </div>
    <div id="scroll-forms">

    </div>
</div>

<script type="text/javascript">
    function parseCEP(cep) {
        return cep.replace('-', '');
    }
</script>

<script>
    $(document).ready(function() {

        $('#scroll-forms').append(getEndForm(
            <?php
            echo json_encode($data);
            ?>,
            '{{ csrf_token() }}', 'finalizar',
            <?php
            echo json_encode($data);
            ?>));

        getCartProducts(JSON.parse(Base64Decode(localStorage.getItem("prods"))), JSON.parse(Base64Decode(localStorage.getItem("complementos"))));

        var scroll = jQuery('.resumo__lista').offset();

        jQuery('html, body').animate({
            scrollTop: scroll.top - 140
        }, 100);
    });
    $(document.body).on('click', '#finalizar-pedido', function() {

        addLoadDiv();

        // localStorage.removeItem("prods");
        // localStorage.removeItem("complementos");
        // localStorage.removeItem("entrega");
        // localStorage.removeItem("loja_id");
        // localStorage.removeItem("agendamento_pedido");
        // localStorage.removeItem("obs");

    });
</script>
@endsection