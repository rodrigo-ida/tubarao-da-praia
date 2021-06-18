
<script type="text/javascript">

    var obj   = JSON.parse(localStorage.getItem("prods"));

    var ljObj = JSON.parse(localStorage.getItem("loja_id"));

    if(ljObj !== null && Object.keys(ljObj).length !== 0 || ljObj !== "undefined")
    {

        if(obj === null || Object.keys(obj).length == 0)
        {

            alert("Não há produtos no carrinho");

            localStorage.removeItem("prods");

            window.location = '/delivery/' + ljObj.loja_id;

        }

    }

    else
    {

        localStorage.removeItem("prods");

        localStorage.removeItem("loja_id");

        window.location = '/delivery';

    }

</script>

@extends('layouts.tubarao-delivery')

@section('content')

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
    <div id="scroll-forms">
        <div id="drop">
            <div class="login__info">
                <h2>Quase lá...</h2>
                <p>Digite seu e-mail:</p>
            </div>
            <div class="login__form clearfix">
                <input class="login__email" id="email-client" placeholder="E-mail" type="email">
                <input class="login__enviar" type="button" value="Pesquisar">
            </div>
        </div>
    </div>
</div>

    <script type="text/javascript">
        function parseCEP(cep)
        {
            return cep.replace('-', '');
        }
    </script>

    <script type="text/javascript">
	$(document.body).on('click', '#enviarCadForm',function(){

		var nome        = $('input[name="nome"]').val();
		var email       = $('input[name="email"]').val();
		var whatsapp    = $('input[name="whatsapp"]').val();
		var cep         = $('input[name="cep"]').val();
		var estado      = $('input[name="estado"]').val();
		var cidade      = $('input[name="cidade"]').val();
		var logradouro  = $('input[name="logradouro"]').val();
		var bairro      = $('input[name="bairro"]').val();
		var numero      = $('input[name="numero"]').val();
		var complemento = $('input[name="complemento"]').val();
		var data_nasc   = $('input[name="data_nasc"]').val();
		var sexo        = $('select[name="sexo"] option:selected').val();
        var origem      = 'Delivery';
        var loja        = JSON.parse(localStorage.getItem("loja_id")) 

		var data = {
			'nome': nome,
			'email': email,
			'whatsapp': whatsapp,
			'cep': cep,
			'estado': estado,
			'cidade': cidade,
			'logradouro': logradouro,
			'bairro': bairro,
			'numero': numero,
			'complemento': complemento,
			'data_nasc': data_nasc,
			'sexo': sexo,
			'origem': origem
		}

		if(data){

            addLoadDiv();

			$.ajax({

                url: "/delivery/finalizar/cadclient/",
                
                method: 'POST',

                data: data,
                
				success: function(response){
                    
                    if(response != false)
                    {
                        
                        $('#form-finalizar-pedido').remove();
                        $(getEndForm(response)).insertBefore('#form-pagamento');

                    }

                },
                error: function(response){
                    console.log(JSON.stringify(response));
                }

            })
            
            setTimeout(function(){
                
                removeLoadDiv();

            }, 3000);
		}

	});
</script>

    <script type="text/javascript">

    // Função de pegar os produtos

        var items = [];

        total = 0;   

        total_prod = 0;   

        function getCartProducts(){

            var obj  = JSON.parse(localStorage.getItem("prods"));

            var taxa = JSON.parse(localStorage.getItem("entrega"));

            if(Object.keys(obj).length !== 0)
            {

                for(let i of obj)
                {   

                    var html = `
                    
                        
                        <div class="itens clearfix">
                            <span>${i.qtd}</span>
                            <span>${i.nome}</span>
                            <span>${numberToReal(i.preco)}</span>
                        </div>
                                        
                    `;

                    $('#items-pedido').append(html); 
                    total_prod += i.qtd;
                }               

            }

            $('#sub-total').text("R$" + numberToReal(getTotal()));
            $('#total-pedido').text(numberToReal(getTotal() + parseFloat(taxa.taxa)));

        };

    </script>
    <script>

    // Função de Pesquisar cliente e mostrar formulário de finalização

        $(document).ready(function(){

            $('.login__enviar').on('click', function(){

                $('.alert-warning').remove();

                if($("body").find(".form-group").length != 0)
                {

                    $(".form-group[p='remover']").remove();

                }

                var html  = "";

                var email = $('#email-client').val();

                var csrf  = "<?php echo csrf_token(); ?>";

                var loja  = JSON.parse(localStorage.getItem("loja_id"));

                if(email)
                {
                    addLoadDiv();

                    $.ajax({

                    url: "/delivery/client/" + email, 

                    type: 'GET', 

                    dataType: 'JSON',

                    success: function(client){
                        $('#drop').effect('drop', 'slow');

                        setTimeout(function(){
                            $("#scroll-forms").append(getEndForm(client));
                            $(getForms()).insertAfter('#form-endereco');
                            $("#scroll-forms").hide();
                            $('#step__finalize').addClass('steps__item--active');
                            $('#scroll-forms').effect('slide', 'slow');
                            getCartProducts();
                        }, 1000);

                    },
                    error: function(client)
                    {
                        console.log(client);
                        if(client.responseJSON != null)
                        {

                           html = getEndForm(client.responseJSON);

                        }
                            
                        $('#drop').effect('drop', 'slow');
                        
                        $('#step__finalize').css('.steps__item--active');

                        setTimeout(function(){
                            $("#scroll-forms").append(getCadForm(email));
                            $(getForms()).insertAfter('#form-finalizar-pedido');
                            $("#scroll-forms").hide();
                            $('#step__finalize').addClass('steps__item--active');
                            $('#scroll-forms').effect('slide', 'slow');
                            getCartProducts();
                        }, 1000);

                        // $('.login__form clearfix').remove().    

                        //getPayments(loja.loja_id);
                    }
                    });

                    setTimeout(function(){
                
                        removeLoadDiv();

                    }, 5000);
                    
                }
            })
        });

    </script>

    <script type="text/javascript">
            function getForms()
            {
                var ent  = JSON.parse(localStorage.getItem('entrega')); 

                var html = `
             
                <form id="form-pagamento" class="finalizar__form desativado clearfix">
                    <h2>FORMA DE PAGAMENTO</h2>
                    <div id="select-forma-pagamento">
                        
                    </div>
                    <label>
                        Observação:
                        <input name="observacao" class="form style-input" value="" type="text" placeholder="Se DINHEIRO, colocar o valor para troco." disabled />
                    </label>
                    <label>
                        <input type="button" class="form-btn" id="prosseguir-finalizacao" value="CONTINUAR" disabled />
                    </label>
                </form>
            
                <form id="form-finalizar" class="finalizar__form desativado clearfix">
        
                    <h2>RESUMO DO PEDIDO</h2>
                    <div class="resumo ">
                    <div class="resumo__lista">
                    <div class="titulo clearfix">
                        <span>Qtd.</span>
                        <span>Produto</span>
                        <span>Total</span>
                    </div>
                    <form>
                    <div id="items-pedido" class="item clearfix">

                    </div>
                        <div class="valores" style="background-color: #f1f1f1;">
                            <div class="clearfix">
                                <span>Sub-Total:</span> 
                                <span id="sub-total"></span>
                            </div>
                            <div class="clearfix">
                                <span>Taxa de entrega:</span>
                                <span>${ "R$" + numberToReal(ent.taxa)}</span>
                            </div>
                        </div>
                        <div class="valores clearfix">
                            <span>Tempo de entrega estimado</span>
                            <span>35min</span>
                        </div>
                        <div class="comprar">
                            <div class="obs">
                                <span>Obs:</span>
                                <span></span>
                            </div>
                            <div class="clearfix total">
                                <span>
                                    TOTAL
                                </span>
                                <span id="total-pedido">
                                    
                                </span>
                            </div>
                                <input type="button" id="finalizar-pedido" value="Finalizar pedido" disabled />
                            </div>
                    </form>
                </div>
                </div>
                </form>
            `;
                
                return html;
            }
            // $(document.body).on('click', '#remover-produto', function(){

            //     var id = $(this).attr('p');

            //     var local = localStorage.getItem("prods");

            //     if(items == "")
            //     {

            //         items.push(JSON.parse(local));

            //         removeItem2(id);

            //     }
            //     else
            //     {

            //         removeItem2(id);

            //     }

            //     localStorage.setItem("prods", JSON.stringify(items));

            //     getTotal();

            //     $('td#total').text(numberToReal(total));   

            //     $('tr[p="'+ id +'"]').fadeOut();

            //     setTimeout(function(){

            //     $('tr[p="'+ id +'"]').remove();

            //    }, 2000);

            //    if(Object.keys(JSON.parse(localStorage.getItem("prods"))).length === 0)
            //    {

            //         alert("Não há mais produtos no carrinho");

            //         window.location = '/delivery';

            //    }

            // })

    </script>

    <script type="text/javascript">

    $(document.body).on('click', '#finalizar-pedido', function(){

        var email       = $('#email-client').val();

        var entrega     = JSON.parse(localStorage.getItem("entrega"));

        var id          = $('input#user-entrega').attr('data-id');

        var nome        = $('h3#nome-entrega').text();

        var numero      = $('input#numero-entrega').val();

        var pagamento   = $('select#forma-pagamento option:selected').val();

        var loja        = JSON.parse(localStorage.getItem("loja_id"));

        var complemento = $('input#compl-entrega').val();

        var observacao  = localStorage.getItem('obs');

        var referencia  = $('input#ref-entrega').val();

        var total       = getTotal();

        var taxa        = entrega.taxa;

        var obs_p       = $('input[name="observacao"]').val();
        
        var data = {

            "email": email,

            "nome": nome,

            "id": id,

            "cep": entrega.cep,

            "logradouro": entrega.logradouro,

            "numero": numero,

            "bairro": entrega.bairro,

            "complemento": complemento,

            "referencia": referencia,

            "obs": observacao,

            "obs_payment": obs_p,

            "cidade": entrega.cidade,

            "estado": entrega.uf,

            "pagamento": pagamento,

            "taxa": taxa,

            "total": total,

            "total_prod": total_prod,

            "loja": loja.loja_id,

            "status": "Pdt",

            "products": [JSON.parse(localStorage.getItem("prods"))]

        };

        if(data){

            $.ajax({

            url: "/delivery/finalizar-pedido", 

            type: 'POST',

            data: data,

            success: function(response){
                 
                if(response.status != 401 || response.status != "undefined" || response.status != null){ 

                    localStorage.removeItem("prods");
    
                    window.location = response;

                }
                else{
                    alert(response.msg);                    
                }

                },
            error: function(response){
                console.log(response.responseText);
                alert('Erro. Não foi possível concluir o seu pedido.');
            }

            })
            
        }

    });

    </script>
    <script type="text/javascript">
    
        $(document.body).on('click', '#prosseguir-pagamento', function(){
            var loja  = JSON.parse(localStorage.getItem("loja_id"));

            if($('#numero-entrega').val().length != 0){
                $('#numero-entrega').css('border', '1px solid rgb(238, 238, 238)');
                $('#prosseguir-pagamento').remove();
                getPayments(loja.loja_id);
                $('#form-pagamento').removeClass('desativado');
                $('#prosseguir-finalizacao').prop('disabled', false);
                $('input[name="observacao"]').prop('disabled', false);
            }
            else
            {
                $('#numero-entrega').css('border-color', 'red');
            }
        });
    
    </script>

    <script type="text/javascript">
    
        $(document.body).on('click', '#prosseguir-finalizacao', function(){
            $('#prosseguir-finalizacao').remove();
            $('#form-finalizar').removeClass('desativado');
            $('#finalizar-pedido').prop('disabled', false);
        });
    
    </script>
    
    <!-- <script>
    function taxaEntrega(cep, bairro) {

    var loja = JSON.parse(localStorage.getItem('loja_id'));

    if(cep)
    {        
        add
        if($('body').find('#inputs-form-footer').length != 0)
        {
            $('#inputs-form-footer').remove();
        }

        $.ajax({

            url: "/delivery/cep/" + loja.loja_id + "/" + bairro, 

            type: 'GET',

        success: function(response){
            if($('body').find('.alert-warning').length != 0)
            {
                $('.alert-warning').remove();
            }

            for(i = 0; i < response.length; i++) {
                
                if(cep >= response[i].order_tax_cep_inicial && cep <= response[i].order_tax_cep_final) {
                    if(response[i].order_tax_loja_id == loja.loja_id)
                    {
                        
                        var html = "<div id='inputs-form-footer'><span id='taxa-de-entrega' v='" + response[i].order_tax_price + "'><strong>Taxa de entrega: " + numberToReal(response[i].order_tax_price) + "</strong></span></br>";

                        html += '<span id="total-pedido" t="' + (total + response[i].order_tax_price) + '"><strong>Total do pedido: ' + numberToReal(total + response[i].order_tax_price) + '</strong></span></br>'

                        html += '<input type="button" style="margin: 15px;" id="btn-finalizar-pedido" class="btn btn-success" value="Finalizar Pedido" disabled /></div>';

                        $(html).insertAfter('#form-finalizar-pedido');

                        if($('input[name="numero"]').val().length != 0)
                        {

                            $('#btn-finalizar-pedido').prop('disabled', false);

                        }
                    }
                }
            }
            
                if($('body').find('#inputs-form-footer').length == 0)
                {

                    html = `<div style="margin-top: 10px;" class="alert alert-warning" role="alert">
                    
                    O CEP digitado não está entre nossos endereços de entrega, digite outro CEP e tente novamente!
                    
                    </div>`;
                    
                    $(html).insertAfter('#buscar-cliente');
                    
                }
            }
        })                   
    }
}
    </script> -->

    <!-- <script type="text/javascript">

    $(document.body).on('click', '#pesquisar-cep-entrega', function(){

        $('input[name="logradouro"]').val('');

        $('input[name="cidade"]').val('');

        $('input[name="bairro"]').val('');

        $('input[name="estado"]').val('');

        $('#inputs-form-footer').remove();

        var cep = parseCEP($('input[name="cep"]').val());
        
        if(cep.length == 8)
        {
            $.ajax({

                url: "http://viacep.com.br/ws/" + cep + "/json/", 

                type: 'GET',

                success: function(response){

                    $('input[name="logradouro"]').val(response.logradouro);

                    $('input[name="cidade"]').val(response.localidade);

                    $('input[name="bairro"]').val(response.bairro);

                    $('input[name="estado"]').val(response.uf);

                    taxaEntrega(cep, response.bairro);
                }
            })
        }
    });

    </script>

    <script type="text/javascript">

    $(document.body).on('keyup', 'input[name="numero"]', function(){

        if($('input[name="numero"]').val().length != 0)
        {

            $('#btn-finalizar-pedido').prop('disabled', false);

        }

        return;

    });

    </script> -->

@endsection

