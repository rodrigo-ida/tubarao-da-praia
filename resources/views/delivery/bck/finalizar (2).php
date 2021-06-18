<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<?php include "header.php";?>

<div class="steps">
	<ul class="clearfix">
		<li class="steps__item" id="step__login">
			<span class="steps__label">Identificação</span>
		</li>
		<li class="steps__item steps__item--active" id="step__finalize">
			<span class="steps__label">Pagamento e Endereço</span>
		</li>
		<li class="steps__item" id="step__confirm">
			<span class="steps__label">Confirmação</span>
		</li>
	</ul>
</div>
		
		<form class="finalizar__form clearfix">
			<h2>FORMA DE PAGAMENTO</h2>
			<div id="select-forma-pagamento">

			</div>
			<label>
				Observação:
				<input name="observacao" class="form" value="" type="text" placeholder="Se DINHEIRO, colocar o valor para troco." />
			</label>
		</form>
	
		<form class="finalizar__form clearfix">
  
			<h2>RESUMO DO PEDIDO</h2>
			<div class="resumo ">
			<div class="resumo__lista">
			<div class="titulo clearfix">
				<span>Qtd.</span>
				<span>Produto</span>
				<span>Total R$</span>
			</div>
			<form>
				<div class="item clearfix">
					<div class="itens clearfix">
						<span>2</span>
						<span>Barca casadinho</span>
						<span>66,49</span>
					</div>
					<div class="itens clearfix">
						<span>2</span>
						<span>Barca casadinho</span>
						<span>66,49</span>
					</div>
					<div class="itens clearfix">
						<span>2</span>
						<span>Barca casadinho</span>
						<span>66,49</span>
					</div>
					<div class="itens clearfix">
						<span>2</span>
						<span>Barca casadinho</span>
						<span>66,49</span>
					</div>
					<div class="itens clearfix">
						<span>2</span>
						<span>Barca casadinho</span>
						<span>66,49</span>
					</div>

				</div>
				<div class="valores" style="background-color: #f1f1f1;">
					<div class="clearfix">
						<span>Sub-Total:</span> 
						<span>R$ 94,80</span>
					</div>
					<div class="clearfix">
						<span>Taxa de entrega:</span>
						<span>R$ 10,20</span>
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
						<span>
							94,80
						</span>
					</div>
					<input type="submit" value="Finalizar pedido">
				</div>
			</form>
		</div>
		</div>
		</form>

<script type="text/javascript">
	$(document.body).on('click',' ',function(){

		var nome = $('form[name="nome"]').val();
		var email = $('form[name="email"]').val();
		var whatsapp = $('form[name="whatsapp"]').val();
		var cep = $('form[name="cep"]').val();
		var estado = $('form[name="estado"]').val();
		var cidade = $('form[name="cidade"]').val();
		var logradouro = $('form[name="logradouro"]').val();
		var bairro = $('form[name="bairro"]').val();
		var numero = $('form[name="numero"]').val();
		var complemento = $('form[name="complemento"]').val();
		var data_nasc = $('form[name="data_nasc"]').val();
		var sexo = $('form[name="sexo"]').val();
		var origem = $('form[name="origem"]').val();

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
			$.ajax({

				url: "/delivery/finalizar/cadclient",
				type: 'POST',
				data: data,

				success: function(response){

					console.log(response);

				}

			})
		}

	});
</script>
<?php include "footer.php";?>