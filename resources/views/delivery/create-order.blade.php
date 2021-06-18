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

<style>
    .pog-paula {
        border: solid 1px #cacaca;
        margin-top: 8px;
        padding: 8px;
        font-family: 'Oswald', sans-serif;
        display: block;
        width: 100%;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        border-radius: 10px;
        outline: none;
    }
</style>

<script src="{{ asset('js/delivery-finalizar.js') }}"></script>

<div class="login clearfix">
    <h2 style="font-size: 30px; text-align:center; margin: 30px">CRIAR PEDIDO</h2>

    <div id="scroll-forms">

        <form action="/delivery/identificacao/finalizar-pedido" method="POST">
            <div class="box__form clearfix" id="form-endereco">

                <div class="finalizar__form  ">
                    <h2>ENDEREÇO DE ENTREGA</h2>
                    <input type="hidden" name="id" id="user-entrega" value="{{ \Auth::user()->id }}">
                    <div class="finalizar__dados">
                        <input type="text" name="nome" value="" class="form style-input" placeholder="Nome do cliente" required>
                        <span>Endereço:</span>
                        <input type="text" name="cidade" value="" class="form style-input" placeholder="Cidade" required>
                        <input type="text" name="logradouro" value="" class="form style-input" placeholder="Logradouro" required>
                        <input type="text" name="bairro" class="form style-input" value="">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="cep" value="">
                        <input type="hidden" name="estado" value="SP">
                        <input type="hidden" name="email" value="{{ \Auth::user()->email }}">
                    </div>
                    <label class="g2">
                        Número<span>*</span>
                        <input id="numero-entrega" name="numero" class="form style-input" type="number" required>
                    </label>
                    <label class="g2">
                        Compl. - Ex: ap xx
                        <input id="compl-entrega" name="complemento" class="form style-input" type="text">
                    </label>
                    <label>
                        Referência
                        <input id="ref-entrega" name="referencia" class="form style-input" type="text">
                    </label>

                </div>
            </div>

            <div class="box__form clearfix" id="form-enviar-pagamento">
                <div id="form-pagamento" class="finalizar__form">
                    <h2>FORMA DE PAGAMENTO</h2>
                    <div id="select-forma-pagamento">
                        <select name="payment_method" id="select-forma-pagamento2" required>
                        </select>
                    </div>

                    <label>
                        Observação:
                        <input name="obs_payment" class="form style-input" value="" type="text" placeholder="Se DINHEIRO, digite o valor para troco.">
                    </label>
                    <label>
                        CPF na nota?<br>
                        <input type="radio" name="cpf-sim" id="cpf-sim" style="margin-right: 5px;">sim
                        <input type="radio" name="cpf-sim" id="cpf-nao" style="margin-right: 5px;">não
                    </label>
                    <label id="cpf" style="display: none;">
                        CPF:
                        <input name="cpf_nota" id="cpf_nota" class="form style-input" value="" type="text" placeholder="">

                        <p id="cpf-invalido" style="display: none;">CPF inválido, tente novamente.</p>
                    </label>
                    <label>

                    </label>
                </div>
            </div>
            <div class="box__form clearfix" id="form-finalizar-pedido">
                <div id="form-finalizar" class="finalizar__form">

                    <h2>RESUMO DO PEDIDO</h2>
                    <div class="resumo ">
                        <div class="resumo__lista">
                            <div class="titulo clearfix">
                                <span>Qtd.</span>
                                <span>Produto</span>
                                <span>Total</span>
                            </div>

                            <div id="items-pedido" class="item clearfix">

                            </div>
                            <div class="valores" style="background-color: #f1f1f1;">
                                <div class="clearfix">
                                    <span>Sub-Total:</span>
                                    <span id="sub-total">0</span>
                                </div>
                                <div class="clearfix">
                                    <span>Taxa de entrega:</span>
                                    <span id="taxa-entrega">0</span>
                                </div>
                            </div>
                            <div class="valores clearfix">
                                <span>Tempo de entrega estimado</span>
                                <span>--:--:--</span>
                            </div>
                            <div class="comprar">
                                <div class="obs">
                                    <span>Observação: </span>
                                    <textarea id="order-obs" name="obs" rows="3" maxlength="200" placeholder="Caso tenha selecionado o Combo 3, coloque os 2 sabores de temaki aqui."></textarea>
                                </div>
                                <div class="clearfix total">

                                    <input type="hidden" name="total" value="">
                                    <input type="hidden" name="taxa" value="">
                                    <input type="hidden" name="total_prod" value="">
                                    <input type="hidden" name="products" value="">
                                    <input type="hidden" name="complements" value="">
                                    <input type="hidden" name="status" value="">
                                    <input type="hidden" name="time" value="">
                                    <input type="hidden" name="date" value="">
                                    <input type="hidden" name="loja" value="">
                                    <span>
                                        TOTAL
                                    </span>
                                    <span id="total-pedido">0</span>
                                </div>
                                <input type="submit" id="finalizar-pedido" value="Finalizar pedido">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        var paymentsShop = <?= $paymentsShop ?>,
            payments = <?= $payments ?>,
            loja_id = JSON.parse(localStorage.getItem('loja_id')),
            entrega = JSON.parse(localStorage.getItem('entrega')),
            prods = JSON.parse(Base64Decode(localStorage.getItem("prods"))),
            comp = JSON.parse(Base64Decode(localStorage.getItem("complementos"))),
            html = '';
        getCartProducts(prods, comp);
        $('input[name="cep"]').val(entrega.cep);
        $('input[name="loja"]').val(loja_id.loja_id);
        $('input[name="total"]').val();
        $('input[name="taxa"]').val(entrega.taxa);
        $('input[name="status"]').val('Pdt');
        $('input[name="bairro"]').val(entrega.bairro);
        $('input[name="logradouro"]').val(entrega.logradouro);
        $('input[name="cidade"]').val(entrega.cidade);
        // $('input[name="total_prod"]').val(JSON.parse(Base64Decode(localStorage.getItem("prods"))).length);
        $('input[name="products"]').val([JSON.stringify(Base64Decode(localStorage.getItem("prods")))]);
        $('input[name="complements"]').val([JSON.stringify(Base64Decode(localStorage.getItem("complementos")))]);
        $('#taxa-entrega').html('R$' + numberToReal(entrega.taxa));
        for (ps of paymentsShop) {
            for (p in payments)
                if (ps.payment_method_ids == p && ps.payment_method_loja_id == loja_id.loja_id && !payments[p].match(/eRede/)) {

                    html += `<option value="${p}">${payments[p]}</option>`;

                }
        }

        $('#select-forma-pagamento2').append(html);

        $(document.body).on('click', '#finalizar-pedido', function() {

        });
    });

    function numberToReal(numero) {

        numero = parseFloat(numero);
        var numero = numero.toFixed(2).split('.');
        numero[0] = numero[0].split(/(?=(?:...)*$)/).join('.');

        return numero.join(',');

    }
</script>
@endsection