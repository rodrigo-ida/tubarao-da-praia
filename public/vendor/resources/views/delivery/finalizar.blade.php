
<script type="text/javascript">

    var qualquer = 0;

    var obj   = localStorage.getItem("prods");

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

<div class="container">
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
                <input class="login__email" id="emailclient" placeholder="E-mail" type="email">
                <input class="login__enviar" type="button" value="Pesquisar">
                <a href="#" id="recu-email-show"><span class="recuperar-email">Esqueceu seu e-mail?</span></a>
            </div>
            <div class="msg" style="    
                display: flex;
                justify-content: center;
                margin-top: 35px;">
            </div>
        </div>
    </div>
</div>
</div>
    <script type="text/javascript">
        function parseCEP(cep) {
            return cep.replace('-', '');
        }
    </script>

    <script type="text/javascript">

    $('#recu-email-show').click(function(){
        $('.modal-recu-email').addClass('ativo');
    });

    $(document.body).on('click', '#finalizar-pedido', function(){

        addLoadDiv();

        localStorage.removeItem("prods");
        localStorage.removeItem("complementos");
        localStorage.removeItem("entrega");
        localStorage.removeItem("loja_id");
        localStorage.removeItem("agendamento_pedido");
        localStorage.removeItem("obs");

    });

	$(document.body).on('click', '#enviarCadForm',function(){

        var nome        = $('input[name="nome"]').val();
        var sobre       = $('input[name="sobrenome"]').val();
		var email       = $('input[name="email"]').val();
		var whatsapp    = $('input[name="whatsapp"]').val();
		var cep         = $('input[name="cep"]').val();
		var estado      = $('input[name="estado"]').val();
		var cidade      = $('input[name="cidade"]').val();
		var logradouro  = $('input[name="logradouro"]').val();
		var bairro      = $('input[name="bairro"]').val();
		var numero      = $('input[name="numero"]').val();
		var complemento = $('input[name="complemento"]').val();
		var data_nasc   = $('input[name="nascimento"]').val();
		var sexo        = $('select[name="sexo"] option:selected').val();
        var origem      = 'Delivery';
        var loja        = JSON.parse(localStorage.getItem("loja_id")) 

		var data = {
            'nome'       : nome,
            'sobrenome'  : sobre,
			'email'      : email,
			'whatsapp'   : whatsapp,
			'cep'        : cep,
			'estado'     : estado,
			'cidade'     : cidade,
			'logradouro' : logradouro,
			'bairro'     : bairro,
			'numero'     : numero,
			'complemento': complemento,
			'data_nasc'  : data_nasc,
			'sexo'       : sexo,
			'origem'     : origem
        }
        
        if(!validateDataCadForm(data)) {
            return;
        }

		if(data){

            addLoadDiv();

			$.ajax({

                url: "{{ route('clientdelivery.cadclient') }}",
                
                method: 'POST',

                data: data,
                
				success: function(response){
                    
                    if(response.msg)
                    {
                    
                        alert(response.msg);
                        return;
                        
                    }
                    
                    $('#form-finalizar-pedido').remove();

                    $('#scroll-forms').append(getEndForm(response));

                    getCartProducts(JSON.parse(Base64Decode(localStorage.getItem("prods"))), JSON.parse(Base64Decode(localStorage.getItem("complementos"))));

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

        function getCartProducts(products, complementos){

            // var obj  = JSON.parse(localStorage.getItem("prods"));

            var taxa = JSON.parse(localStorage.getItem("entrega"));

            var complTotal = 0;
            var subTotal   = 0;

	if(Object.keys(products).length !== 0){

		for(let i of products){

			var cmp = "";
			var listaCmp = "";
			if (i.comp){

				cmp = `comp="${i.comp}"`;
				listaCmp =  `<ul class="itens__comp">`;
				for(let c of complementos){
					if(c.comp == i.comp){
						listaCmp += `
							<li class="clearfix">
								<div>+ ${c.nome}</div>
								<div class="cmvl-${i.comp}-${c.id_complemento}">${numberToReal(c.preco)}</div>
							</li>
						`;
                        subTotal += i.qtd * c.preco;
                    }
				}
				listaCmp += `</ul>`;
                complTotal++;
            }
            subTotal += i.qtd * i.preco;
			var html = `
				<div class="itens clearfix prod" p=${i.id} ${cmp}>
					<span p="${i.id}" name="${i.nome}" price="${i.preco}" class="clearfix">
						${i.qtd}
					</span>
					<span>${i.nome}</span>
					<span p=${i.id} id='total'>
						${numberToReal(i.qtd * i.preco)}
					</span>
					${listaCmp}
				</div>
            `;
            $('#items-pedido').append(html); 
            total_prod += i.qtd;
		}
    }
        $('#sub-total').text("R$" + numberToReal(getTotal()));
        $('input[name="total"]').val(getTotal());
        $('input[name="total_prod"]').val(total_prod);
        $('#total-pedido').text(numberToReal(getTotal() + parseFloat(taxa.taxa)));

        };

    </script>
    <script>

        $(document.body).on('click', '#btn-recu-email', function() {


           if($('#email-error').css('display') == 'block'){
               $('#email-success').hide();
               $('#email-error').hide();
           }
           
           var num = $('#cel-recu').val();

           if($('#cel-recu').val().length >= 12){
               
                recuEmail(num);

           }

        });

    // Função de Pesquisar cliente e mostrar formulário de finalização

        $(document).ready(function(){

            $('.login__enviar').on('click', function(){

                if(!validateEmail($('.login__email').val())){
                    return;
                }
                
                $('.msg').text('');
                $('.alert-warning').remove();

                if($("body").find(".form-group").length != 0)
                {

                    $(".form-group[p='remover']").remove();

                }

                if($('body').find('#form-pagamento').length != 0){
                    
                    $('#form-pagamento').remove();
                    
                    if($('body').find('#form-finalizar-pedido').length != 0){
                        
                        $('#form-finalizar-pedido').remove();
                    
                    }
                }

                var html  = "";

                var email = $('#emailclient').val();

                var csrf  = "<?php echo csrf_token(); ?>";

                var loja  = JSON.parse(localStorage.getItem("loja_id"));

                if(email)
                {
                    addLoadDiv();

                    getClient(email);

                    setTimeout(function(){
            
                        removeLoadDiv();

                    }, 3000);
                    
                }
            })
        });

    </script>

    <!-- <script type="text/javascript">

    $(document.body).on('click', '#finalizar-pedido', function(){

        var email       = $('#emailclient').val();

        var entrega     = JSON.parse(localStorage.getItem("entrega"));

        var id          = $('input#user-entrega').attr('data-id');

        var nome        = $('h3#nome-entrega').text();

        var numero      = $('input#numero-entrega').val();

        var pagamento   = $('select#forma-pagamento option:selected').val();

        var loja        = JSON.parse(localStorage.getItem("loja_id"));

        var complemento = $('input#compl-entrega').val();

        var observacao  = $('#order-obs').val();

        var referencia  = $('input#ref-entrega').val();

        var total       = getTotal();

        var taxa        = entrega.taxa;

        var status      = "Pdt";

        var obs_p       = $('input[name="observacao"]').val();

        var time        = null;

        var date        = null;
        
        if(localStorage.getItem('agendamento_pedido')) {
            var ls      = JSON.parse(localStorage.getItem('agendamento_pedido'));
            
            status      = "Agd";

            time        = ls.time;

            date        = ls.data;
        }
        
        var data = {

            "email": email,

            "nome": nome,

            "id": id,

            "cep": parseCEP(entrega.cep),

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

            "time": time,

            "loja": loja.loja_id,

            "status": status,

            "date": date,

            "products": [JSON.parse(Base64Decode(localStorage.getItem("prods")))],

            "complements": [JSON.parse(Base64Decode(localStorage.getItem("complementos")))]

        };

        if(data){

            addLoadDiv();

            finalizeOrder(data);
            
        }
        
        setTimeout(function(){
            
            removeLoadDiv();

        }, 3000);
        
    }); 

    </script>-->
    <script type="text/javascript">
    
        $(document.body).on('click', '#prosseguir-pagamento', function(){
            var loja  = JSON.parse(localStorage.getItem("loja_id"));

            if($('#numero-entrega').val().length != 0){
                $('#numero-entrega').css('border', '1px solid rgb(238, 238, 238)');
                $('#prosseguir-pagamento').remove();
                getPayments(loja.loja_id);
                $('#form-pagamento').removeClass('desativado');
                $('#prosseguir-finalizacao').prop('disabled', false);
                $('input[name="obs_payment"]').prop('disabled', false);
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
    
@endsection

