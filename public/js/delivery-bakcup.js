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

function addToCart(){

	var obj = JSON.parse(localStorage.getItem("prods"));
	var qtd = 0;
	var qtdAction = 0;

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

			qtdAction = qtdAction + i.qtd;

		}
		jQuery('.produtos__action span').text(qtdAction);
	}

}

function removeItem2(item) {

	for(i = 0; i < items.length; i++) { 
		if(items[0][i] == item){

			var listAux    = items[0].slice(0, i);
			var listAuxEnd = items[0].slice(i + 1);
			return items = listAux.concat(listAuxEnd); 

		}
	}
	return false;
}

function numberToReal(numero){
	
	numero = parseFloat(numero);
	var numero = numero.toFixed(2).split('.');
	numero[0] = numero[0].split(/(?=(?:...)*$)/).join('.');

	return numero.join(',');

}

function getTotal(){

	var obj  = JSON.parse(localStorage.getItem("prods"));

	var comp = JSON.parse(localStorage.getItem("complementos"));

	total = 0;

	for(let t of obj) {   

		total += t.qtd * t.preco;

	}

	if(comp !== "undefined" || null && comp.length !== 0) {
		for(let c of comp){   

			total += c.preco;
	
		}	
	}

	$('td#total').text('');
	
	return total;

}

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

function initItems(data){
	for(let i of data){
		var item = {
			"id":i.id,
			"nome": i.nome,
			"preco": parseFloat(i.preco),
			"qtd":i.qtd
		};
		items.push(item);
	}
}

function removeItem(item) {
	for(i = 0; i < items.length; i++) { 
		if(items[i].id == item){

			var listAux    = items.slice(0, i);
			var listAuxEnd = items.slice(i + 1)
			return items = listAux.concat(listAuxEnd); 

		}
	}
	return false;
}

function pesquisaScroll(texto){
	jQuery('#produtos').val(texto);
	var scroll = jQuery('.item-p[produto="' + texto +'"]').offset();
	jQuery('html,body').animate({
		scrollTop: scroll.top - 140
	}, 100);
	jQuery('.pesquisa-resultado').hide(100);
	jQuery('.pesquisa-resultado-mobile').hide(100);
}

function pesquisaScrollBtn(texto){
	var scroll = jQuery('.item-p[produto="' + texto +'"]').offset();
	jQuery('html,body').animate({
		scrollTop: scroll.top - 140
	}, 100);
	jQuery('.pesquisa-resultado').hide(100);
	jQuery('.pesquisa-resultado-mobile').hide(100);
}

function inicializacao(){
	var id_loja   = 1;
	var idStorage = JSON.parse(localStorage.getItem("loja_id"));
	var data      = { loja_id: id_loja };
	var products  = JSON.parse(localStorage.getItem("prods"));
	var idEntrega = JSON.parse(localStorage.getItem("entrega"));

	localStorage.setItem("loja_id", JSON.stringify(data));

	if(products !== null){

		if(id_loja != idStorage.loja_id){

			localStorage.removeItem("prods");

		}

	}

	if(products != null){ 

		if(id_loja == idStorage.loja_id){

			initItems(products);
			bugAux = true;

		}
	}

	total = 0;
	total_prod = 0;
	if(products != null){
		if(Object.keys(products).length !== 0){

			for(let i of products){
				var html = `
					<div class="itens clearfix prod" p=${i.id}>
						<span p="${i.id}" name="${i.nome}" price="${i.preco}" class="clearfix">
							<div class="addItem">+</div>
							<input disabled class="qt" type='number' value='${i.qtd}'>
							<div class="remItem">-</div>
						</span>
						<span>${i.nome}</span>
						<span p=${i.id} id='total'>
							${numberToReal(i.qtd * i.preco)}
						</span>
					</div>
				`;
				$('.list-products').append(html); 
			}
		}
	}

	if(products != null){
		for(let t of products){   

			total += t.qtd * t.preco;

		}  

		for(let t of products){   

			total_prod += t.qtd;

		}  
		vlTotal = getTotal();
	}
	else {
		vlTotal = 0;
	}

	jQuery('.produtos__action span').text(total_prod);

	var idEntrega = JSON.parse(localStorage.getItem("entrega"));

	var taxa	  = parseFloat(idEntrega.taxa)

	if(vlTotal){

		$('span#subtotal-carrinho').text(numberToReal(vlTotal));

	}
	
	$('#tx-entrega').text(numberToReal(taxa));

	$('span#total-carrinho').text(numberToReal(vlTotal + taxa));

	jQuery('.end-prev').html(idEntrega.logradouro + " - " + idEntrega.bairro + "<br/>" + idEntrega.cidade + "/" + idEntrega.uf);

	jQuery('.item-p').each(function(){
		var produto = jQuery(this).attr('produto');
		jQuery('.pesquisa-resultado').append('<li>' + produto + '</li>');
		jQuery('.pesquisa-resultado-mobile').append('<li>' + produto + '</li>');
	})
}

function definirHorarios(timeIni,timeFin){
	var hour = jQuery('#agendar-hora');
	var date = jQuery('#agendar-data');
	hour.attr('min',timeIni);
	hour.attr('max',timeFin);

	var now = new Date();
 
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);

	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
	date.val(today);
}

function agendamento(){
	var time = jQuery('#agendar-hora').val();
	jQuery('p.erromsg').remove();
	if(time){

		var min  = jQuery('#agendar-hora').attr('min');
		var max  = jQuery('#agendar-hora').attr('max');
		var data = jQuery('#agendar-data').val();				

		var timeSplit = time.split(":");
		var minSplit  = min.split(":");
		var maxSplit  = max.split(":");

		var abertura    = new Date(2018,01,01,minSplit[0],minSplit[1]);
		var fechamento  = new Date(2018,01,01,maxSplit[0],maxSplit[1]);
		var agendamento = new Date(2018,01,01,timeSplit[0],timeSplit[1]);
	
		if(abertura > fechamento){
			fechamento.setDate(fechamento.getDate() + 1);
			if(agendamento < abertura){
				agendamento.setDate(agendamento.getDate() + 1);
			}
		}

		if(agendamento >= abertura && agendamento <= fechamento){
			var agendamento = {
				'data'  : data,
				'time'  : time,
				'status': 'agd'
			}

			localStorage.setItem("agendamento_pedido", JSON.stringify(agendamento));
			window.location = "/delivery/finalizar";

		}else{
			jQuery('#agendar-hora').after("<p class='erromsg'>Não realizamos entregas nesse horário</p>");
		}
	}else{
		jQuery('#agendar-hora').after("<p class='erromsg'>Você não preencheu o horário</p>");
	}
}

function adicionarProduto(id,qtd,nome,preco,localId,idEntrega){
	if(qtd != 0){
		if(localId != null){
			for(let i of localId){
				if(i.id == id){
					qtd += parseInt(i.qtd);
					if(!removeItem2(id)){
						removeItem(id);
					}
				}
			}
		}

		var data = {
			"id":id,
			"nome": nome,
			"preco": parseFloat(preco),
			"qtd":qtd
		};
		
		items.push(data);
		localStorage.setItem("prods", JSON.stringify(items));
		addToCart();

		vlTotal = getTotal();
		var taxa = parseInt(idEntrega.taxa);
		$('span#subtotal-carrinho').text(numberToReal(vlTotal));
		$('span#total-carrinho').text(numberToReal(vlTotal + taxa));

	}
}

function removerQt(el,form,localId,idEntrega,id){
	for(var i of localId){
		if(i.qtd != 0){
			if(localId != null){
				for(let i of localId){
					if(i.id == id){
						qtd   = parseInt(i.qtd - 1);
						nome  = i.nome;
						preco = i.preco;
						if(!removeItem(id)){
							removeItem2(id);
						}
					}
				}
			}
		}
	}

	var qtdAction = 0;
	for(let i of localId){
		qtdAction += i.qtd;
	}
	jQuery('.produtos__action span').text(qtdAction - 1);

	if(qtd == 0){
		el.parent().html('');
		localStorage.setItem("prods", JSON.stringify(items));

		vlTotal = getTotal();
		var taxa = parseInt(idEntrega.taxa);

		$('span#subtotal-carrinho').text(numberToReal(vlTotal));
		$('span#total-carrinho').text(numberToReal(vlTotal + taxa));

		return;
	}else{
		form.val(qtd);
		vl = parseFloat(preco) * qtd;
		el.next().next().text(numberToReal(vl));
	}
	var data = {"id":id, "nome": nome, "preco": parseFloat(preco), "qtd":qtd};

	items.push(data);

	localStorage.setItem("prods", JSON.stringify(items));

	vlTotal = getTotal();
	var taxa = parseInt(idEntrega.taxa);

	$('span#subtotal-carrinho').text(numberToReal(vlTotal));
	$('span#total-carrinho').text(numberToReal(vlTotal + taxa));
}

function adicionarQt(el,form,id,localId,idEntrega){
	for(var i of localId){
		if(i.qtd != 0){
			if(localId != null){
				for(let i of localId){
					if(i.id == id){
						qtd   = parseInt(i.qtd + 1);
						nome  = i.nome;
						preco = i.preco;
						if(!removeItem(id)){
							removeItem2(id);
						}
					}
				}
			}
		}
	}
	form.val(qtd);
	vl = parseFloat(preco) * qtd;
	el.next().next().text(numberToReal(vl));
	var data = {"id":id, "nome": nome, "preco": parseFloat(preco), "qtd":qtd};

	items.push(data);

	localStorage.setItem("prods", JSON.stringify(items));

	vlTotal = getTotal();
	var taxa = parseInt(idEntrega.taxa);
		
	$('span#subtotal-carrinho').text(numberToReal(vlTotal));
	$('span#total-carrinho').text(numberToReal(vlTotal + taxa));

	var qtdAction = 0;
	for(let i of localId){
		qtdAction += i.qtd;
	}
		
	jQuery('.produtos__action span').text(qtdAction + 1);
}