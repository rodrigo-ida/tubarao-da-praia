function removeDivs(){
	$('.lightbox').remove();
        
	$('.list-group').remove();

	$('div.inicio p').text('Selecione uma loja abaixo');

	$('div.inicio__form').remove();

	$('div.inicio span').remove();

	$('div.inicio .buscar').remove();
}

function addLoadDiv() {
	
	$('#div-loading').addClass('loading');
	$('#div-loading').css('display', '');
}

function removeLoadDiv() {

	$('#div-loading').removeClass('loading');
	$('#div-loading').hide();

}

function removeItem(item) {

	for(i = 0; i < items.length; i++) { 

		if(items[i].id == item) 

		{

			var listAux    = items.slice(0, i);

			var listAuxEnd = items.slice(i + 1)



			return items = listAux.concat(listAuxEnd); 

		}

	}

	return false;
}

function addToCart(){

	var obj = JSON.parse(localStorage.getItem("prods"));
	var qtd = 0;

	if(Object.keys(obj).length !== 0){
		for(let i of obj){   

			qtd += i.qtd;

			if(typeof($("div.prod[p='"+ i.id +"']")) !== "undefined"){

				$("div.prod[p='"+ i.id +"']").remove();

			}       

			var html = `
				<div class='itens clearfix prod' p=${i.id}>
					<span p="${i.id}" name="${i.nome}" price="${i.preco}" class="clearfix">
						<div class="addItem">+</div>
						<input disabled class="qt" type='number' value='${i.qtd}'>
						<div class="remItem">-</div>
					</span>
					<span>${i.nome}</span>
					<span p=${i.id} id='total'>
						${numberToReal(i.qtd * i.preco)}
					</span>
				</div>`;

			$('.list-products').append(html); 

		}               
	}

}

// function removeItem2(item) {

// 	for(i = 0; i < items.length; i++) { 

// 		if(items[0][i].id == item) 
// 		{

// 			var listAux    = items[0].slice(0, i);

// 			var listAuxEnd = items[0].slice(i + 1)

// 			return items = listAux.concat(listAuxEnd); 

// 		}

// 	}
// }

function getTotal(){

var obj = JSON.parse(localStorage.getItem("prods"));

total = 0;

for(let t of obj)

{   

	total += t.qtd * t.preco;

}  

return total;

}


function numberToReal(numero) {

numero = parseFloat(numero);

var numero = numero.toFixed(2).split('.');

numero[0] = numero[0].split(/(?=(?:...)*$)/).join('.');

return numero.join(',');

}

// function getTotal(){

// 	var obj = JSON.parse(localStorage.getItem("prods"));

// 	total = 0;

// 	for(let t of obj)
// 	{   

// 		total += t.qtd * t.preco;

// 	}  

// 	$('td#total').text('');

// 	return total;

// }

function getProdTotal(){

	var obj = JSON.parse(localStorage.getItem("prods"));

	total = 0;

	for(let t of obj)
	{   

		total_prod += t.qtd;

	}  

	return total_prod;

}

function getCadForm(client)
		{

			return html = 
				`
				 <form id="form-finalizar-pedido" action="#" method="post" class="finalizar__form clearfix">
					<h2 style="background-color: #800b58;color: #ffffff;font-size: 24px;padding: 6px 18px;" class="form-h2">CADASTRO</h2>
					<label class="form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 100%;">
						Seu nome<span>*</span>
						<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="nome" class="form" type="text" required />
					</label>
					<label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
						Whatsapp<span>*</span>
						<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="whatsapp" class="form" type="text"/>
					</label>
					<label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
						Telefone
						<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="telefone" class="form" type="text"/>
					</label>
					<label class="form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 100%;">
						Email
						<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="email" value="${client}" class="form" type="email"/>
					</label>
					<label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
						Data de nascimento<span>*</span>
						<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="nascimento" class="form" type="date"/>
					</label>
					<label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
						Sexo<span>*</span>
						<select style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="sexo">
							<option hidden value=""></option>
							<option value="m">Masculino</option>
							<option value="f">Femininino</option>
						</select>
					</label>
					<label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
						CEP<span>*</span>
						<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="cep" max="9" class="form" type="text"/>
					</label>
					<label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
						Logradouro
						<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="logradouro" class="form" value="" type="text"/>
					</label>
					<label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
						Bairro
						<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="bairro" value="" class="form" type="text"/>
					</label>
					<label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
						Cidade
						<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="cidade" value="" class="form" type="text"/>
					</label>
					<label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
						Estado
						<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="estado" value="" class="form" type="text"/>
					</label>
					<label class="form-g4 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 25%;">
						Número<span>*</span>
						<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" class="form" name="numero" value="" type="text"/>
					</label>
					<label class="form-g4 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 25%;">
						Compl.
						<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="complemento" value="" class="form" type="text"/>
					</label>
					<label class="form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 100%;">
						Referência - EX: Fundos
						<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="referencia" value="" class="form" type="text"/>
					</label>
					<label>
						<input id="enviarCadForm" type="button" value="CADASTRAR"/>
					</label>
				</form>           
				`;

		}
		function getEndForm(data){

			var end = JSON.parse(localStorage.getItem('entrega'));

			return html = `

				<form id="form-endereco" class="finalizar__form clearfix">
					<h2>ENDEREÇO DE ENTREGA</h2>
					<input type="hidden" id="user-entrega" data-id="${data.id}" />
					<div class="finalizar__dados">
						<h3 id="nome-entrega">${data.nome}</h3>
						<span>Endereço:</span>
						<p>${end.logradouro}</p>
						<p> - ${end.uf}</p>
						<input type="hidden" value="${end.cep}"/>
					</div>
					<label>
						Referência - EX: Fundos
						<input id="ref-entrega" class="form style-input" type="text"/>
					</label>
					<label class="g2">
						Número<span>*</span>
						<input id="numero-entrega" class="form style-input" type="number"/>
					</label>
					<label class="g2">
						Compl.
						<input id="compl-entrega" class="form style-input" type="text"/>
					</label>
					<label>
						<input type="button" class="form-btn" id="prosseguir-pagamento" value="CONTINUAR" />
					</label>		
				</form>

			`;
		}
		function getPayments(id)
		{

			$.get("/delivery/payment/" + id, function(methods){

			html = '<label for="Forma de pagamento">Forma de Pagamento:</label><select class="style-input" name="payment_method_id" id="forma-pagamento">';

			for(let i in methods)
			{

				html += `<option value="${methods[i].get_payment_methods.id}">${methods[i].get_payment_methods.name_method}</option>`;

			}

			$('#select-forma-pagamento').append(html);

			$('#form-finalizar-pedido').fadeIn();

			$('#form-finalizar-pedido').css("display", "table");

			})
		}

	//     function taxaEntrega(cep) {

	//         loja = localStorage.getItem('loja_id');
	//         console.log("1 = " + loja.loja_id);
	//         if(cep)
	//         {        
	
	//             if($('body').find('#inputs-form-footer').length != 0)
	//             {
	//                 $('#inputs-form-footer').remove();
	//             }
	
	//             $.ajax({
	
	//                 url: "/delivery/cep/" + 1, 
	
	//                 type: 'GET',
	
	//             success: function(response){
	//                 if($('body').find('.alert-warning').length != 0)
	//                 {
	//                     $('.alert-warning').remove();
	//                 }
	
	//                 for(i = 0; i < response.length; i++) {
	//                     console.log(loja.loja_id);
	
	//                     if(cep >= response[i].order_tax_cep_inicial && cep <= response[i].order_tax_cep_final) {
	//                         if(response[i].order_tax_loja_id == loja.loja_id)
	//                         {

	//                             var html = "<div id='inputs-form-footer'><span id='taxa-de-entrega' v='" + response[i].order_tax_price + "'><strong>Taxa de entrega: " + numberToReal(response[i].order_tax_price) + "</strong></span></br>";
		
	//                             html += '<span id="total-pedido" t="' + (total + response[i].order_tax_price) + '"><strong>Total do pedido: ' + numberToReal(total + response[i].order_tax_price) + '</strong></span></br>'
		
	//                             html += '<input type="button" style="margin: 15px;" id="btn-finalizar-pedido" class="btn btn-success" value="Finalizar Pedido" disabled /></div>';
		
	//                             $(html).insertAfter('#form-finalizar-pedido');
		
	//                             if($('input[name="numero"]').val().length != 0)
	//                             {
		
	//                                 $('#btn-finalizar-pedido').prop('disabled', false);
		
	//                             }
	//                         }
	//                     }
	//                 }
					
	//                     if($('body').find('#inputs-form-footer').length == 0)
	//                     {
	
	//                         html = `<div style="margin-top: 10px;" class="alert alert-warning" role="alert">
							
	//                         O CEP digitado não está entre nossos endereços de entrega, digite outro CEP e tente novamente!
							
	//                         </div>`;
							
	//                         $(html).insertAfter('#buscar-cliente');
							
	//                     }
	
	//             }
	
	//         })                   
	
	//     }
	
	// }