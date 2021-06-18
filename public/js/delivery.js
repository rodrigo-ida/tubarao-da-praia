variations = [];

comboVariations = [];

verCombo = [];

function parseCEP(cep) {
  return cep.replace("-", "");
}

function setLocalStorageTime() {
  localStorage.setItem("time", Date.now());
}

function Base64Encode(str, encoding = "utf-8") {
  var bytes = new (TextEncoder || TextEncoderLite)(encoding).encode(str);
  return base64js.fromByteArray(bytes);
}
function Base64Decode(str, encoding = "utf-8") {
  var bytes = base64js.toByteArray(str);
  return new (TextDecoder || TextDecoderLite)(encoding).decode(bytes);
}

function removeDivs() {
  $(".lightbox").remove();
  $(".list-group").remove();
  $("div.inicio p").text("Selecione uma loja abaixo");
  $("div.inicio__form").remove();
  $("div.inicio span").remove();
  $("div.inicio .buscar").remove();
}

function verifyProds() {
  var i = 0;
  $(".itens").each(function () {
    i++;
  });

  return i;
}

function addLoadDiv() {
  $("#div-loading").addClass("loading");
  $("#div-loading").css("display", "");
}

function removeLoadDiv() {
  $("#div-loading").removeClass("loading");
  $("#div-loading").hide();
}

function addToCart() {
  var obj = JSON.parse(Base64Decode(localStorage.getItem("prods")));
  var complementos = JSON.parse(Base64Decode(localStorage.getItem("complementos")));
  var qtdAction = 0;
  var qtd = 0;

  $("div.prod").remove();

  if (Object.keys(obj).length !== 0) {
    for (let i of obj) {
      qtd += i.qtd;

      var cmp = "";
      var listaCmp = "";
      if (i.comp) {
        var el = $("div.prod[p='" + i.id + "']");
        if (el.attr("comp") == i.comp) {
          el.attr("comp", i.comp).remove();
        }

        cmp = `comp="${i.comp}"`;
        listaCmp = `<ul class="itens__comp">`;
        for (let c of complementos) {
          if (c.comp == i.comp) {
            listaCmp += `
						<li class="clearfix">
							<div>+ ${c.nome}</div>
							<div class="cmvl-${i.comp}-${c.id_complemento}">${numberToReal(c.preco)}</div>
						</li>
					`;
          }
        }
        listaCmp += `</ul>`;
      } else if (i.id_var) {
        if (typeof $("div.prod[p-var='" + i.id_var + "']") !== "undefined") {
          $("div.prod[p-var='" + i.id_var + "']").remove();
        }
      } else if (i.comboVars) {
        if (typeof $("div.prod[p-combo='" + i.id + "']") !== "undefined") {
          $("div.prod[p-combo='" + i.id + "']").remove();
        }
      } else if (i.tf == 0 && !i.comboVars) {
        if (typeof $("div.prod[p='" + i.id + "']") !== "undefined") {
          $("div.prod[p='" + i.id + "']").remove();
        }
      }

      if (i.id_var) {
        var html = `
			<div class="itens clearfix prod" p-var=${i.id_var} ${cmp}>
				<span p="${i.id}" name="${i.nome}" price="${i.preco}" class="clearfix">
				<div var="${
          i.id_var
        }" class="remItem"><svg style="margin-top: 6px;" fill="#800b58" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="isolation:isolate" viewBox="142 2560.343 73.17 8.484" width="12px" height="12px"><g><g><g><g><path fill="#800b58" d=" M 210.928 2560.343 L 182.827 2560.343 L 174.343 2560.343 L 146.242 2560.343 C 143.9 2560.343 142 2562.246 142 2564.585 C 142 2566.932 143.9 2568.827 146.242 2568.827 L 174.343 2568.827 L 182.827 2568.827 L 210.928 2568.827 C 213.272 2568.827 215.17 2566.931 215.17 2564.585 C 215.17 2562.246 213.271 2560.343 210.928 2560.343 Z "></path></g></g></g></g></svg></div>
				<input disabled class="qt" type='number' value='${i.qtd}'>
				<div var="${
          i.id_var
        }" class="addItem"><svg xmlns="http://www.w3.org/2000/svg" fill="#800b58" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="12px" height="12px" viewBox="0 0 73.17 73.17" style="margin-top: 6px;enable-background:new 0 0 73.17 73.17;" xml:space="preserve">
				<g>
				<g id="Plus">
				<g>
				<path d="M68.928,32.343H40.827V4.243C40.827,1.903,38.928,0,36.585,0s-4.242,1.903-4.242,4.242v28.101H4.242 C1.9,32.343,0,34.246,0,36.585c0,2.347,1.9,4.242,4.242,4.242h28.101v28.1c0,2.349,1.899,4.242,4.242,4.242 s4.242-1.896,4.242-4.242v-28.1h28.101c2.344,0,4.242-1.896,4.242-4.242C73.17,34.246,71.271,32.343,68.928,32.343z"></path>
				</g>
				</g>
				</g>
				
				</svg></div>
				</span>
				<span>${i.nome}</span>
				<span p=${i.id} id='total'>
					${numberToReal(i.qtd * i.preco)}
				</span>
				${listaCmp}
			</div>
		`;
      } else if (i.comboVars) {
        var html = `
			<div class="itens clearfix prod" p-combo=${i.id}">
				<span p="${i.id}" name="${i.nome}" price="${i.preco}" class="clearfix">
				<div class="remItem" comboVar='${JSON.stringify(
          i.comboVars
        )}'><svg fill="#800b58" style="margin-top: 6px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="isolation:isolate" viewBox="142 2560.343 73.17 8.484" width="12px" height="12px"><g><g><g><g><path fill="#800b58" d=" M 210.928 2560.343 L 182.827 2560.343 L 174.343 2560.343 L 146.242 2560.343 C 143.9 2560.343 142 2562.246 142 2564.585 C 142 2566.932 143.9 2568.827 146.242 2568.827 L 174.343 2568.827 L 182.827 2568.827 L 210.928 2568.827 C 213.272 2568.827 215.17 2566.931 215.17 2564.585 C 215.17 2562.246 213.271 2560.343 210.928 2560.343 Z "></path></g></g></g></g></svg></div>
				<input disabled class="qt" type='number' value='${i.qtd}'>
				<div class="addItem" comboVar='${JSON.stringify(
          i.comboVars
        )}'><svg xmlns="http://www.w3.org/2000/svg" fill="#800b58" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="12px" height="12px" viewBox="0 0 73.17 73.17" style="margin-top: 6px;enable-background:new 0 0 73.17 73.17;" xml:space="preserve">
				<g>
				<g id="Plus">
				<g>
				<path d="M68.928,32.343H40.827V4.243C40.827,1.903,38.928,0,36.585,0s-4.242,1.903-4.242,4.242v28.101H4.242 C1.9,32.343,0,34.246,0,36.585c0,2.347,1.9,4.242,4.242,4.242h28.101v28.1c0,2.349,1.899,4.242,4.242,4.242 s4.242-1.896,4.242-4.242v-28.1h28.101c2.344,0,4.242-1.896,4.242-4.242C73.17,34.246,71.271,32.343,68.928,32.343z"></path>
				</g>
				</g>
				</g>
				
				</svg></div>
				</span>
				<span>${i.nome}</span>
				<span p=${i.id} id='total'>
					${numberToReal(parseFloat(i.qtd * i.preco))}
				</span>
			</div>
			`;
      } else if (i.tf == 0 && !i.comboVars) {
        var html = `
			<div class="itens clearfix prod" p=${i.id} ${cmp}>
				<span p="${i.id}" name="${i.nome}" price="${i.preco}" class="clearfix">
				<div class="remItem"><svg fill="#800b58" xmlns="http://www.w3.org/2000/svg" style="margin-top: 6px;" xmlns:xlink="http://www.w3.org/1999/xlink" style="isolation:isolate" viewBox="142 2560.343 73.17 8.484" width="12px" height="12px"><g><g><g><g><path fill="#800b58" d=" M 210.928 2560.343 L 182.827 2560.343 L 174.343 2560.343 L 146.242 2560.343 C 143.9 2560.343 142 2562.246 142 2564.585 C 142 2566.932 143.9 2568.827 146.242 2568.827 L 174.343 2568.827 L 182.827 2568.827 L 210.928 2568.827 C 213.272 2568.827 215.17 2566.931 215.17 2564.585 C 215.17 2562.246 213.271 2560.343 210.928 2560.343 Z "></path></g></g></g></g></svg></div>
				<input disabled class="qt" type='number' value='${i.qtd}'>
				<div class="addItem"><svg xmlns="http://www.w3.org/2000/svg" fill="#800b58" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="12px" height="12px" viewBox="0 0 73.17 73.17" style="margin-top: 6px;enable-background:new 0 0 73.17 73.17;" xml:space="preserve">
				<g>
				<g id="Plus">
				<g>
				<path d="M68.928,32.343H40.827V4.243C40.827,1.903,38.928,0,36.585,0s-4.242,1.903-4.242,4.242v28.101H4.242 C1.9,32.343,0,34.246,0,36.585c0,2.347,1.9,4.242,4.242,4.242h28.101v28.1c0,2.349,1.899,4.242,4.242,4.242 s4.242-1.896,4.242-4.242v-28.1h28.101c2.344,0,4.242-1.896,4.242-4.242C73.17,34.246,71.271,32.343,68.928,32.343z"></path>
				</g>
				</g>
				</g>
				
				</svg></div>
				</span>
				<span>${i.nome}</span>
				<span p=${i.id} id='total'>
					${numberToReal(i.qtd * i.preco)}
				</span>
				${listaCmp}
			</div>
		`;
      } else if (i.comp) {
        var el = $("div.prod[p='" + i.id + "']");
        if (el.attr("comp") == i.comp) {
          el.attr("comp", i.comp).remove();
        }

        cmp = `comp="${i.comp}"`;
        listaCmp = `<ul class="itens__comp">`;
        for (let c of complementos) {
          if (c.comp == i.comp) {
            listaCmp += `
						<li class="clearfix">
							<div>+ ${c.nome}</div>
							<div class="cmvl-${i.comp}-${c.id_complemento}">${numberToReal(c.preco)}</div>
						</li>
					`;
          }
        }
        listaCmp += `</ul>`;

        var html = `
			<div class="itens clearfix prod" p=${i.id} ${cmp}>
				<span p="${i.id}" name="${i.nome}" price="${i.preco}" class="clearfix">
				<div class="remItem"><svg fill="#800b58" xmlns="http://www.w3.org/2000/svg" style="margin-top: 6px;" xmlns:xlink="http://www.w3.org/1999/xlink" style="isolation:isolate" viewBox="142 2560.343 73.17 8.484" width="12px" height="12px"><g><g><g><g><path fill="#800b58" d=" M 210.928 2560.343 L 182.827 2560.343 L 174.343 2560.343 L 146.242 2560.343 C 143.9 2560.343 142 2562.246 142 2564.585 C 142 2566.932 143.9 2568.827 146.242 2568.827 L 174.343 2568.827 L 182.827 2568.827 L 210.928 2568.827 C 213.272 2568.827 215.17 2566.931 215.17 2564.585 C 215.17 2562.246 213.271 2560.343 210.928 2560.343 Z "></path></g></g></g></g></svg></div>
				<input disabled class="qt" type='number' value='${i.qtd}'>
				<div class="addItem"><svg xmlns="http://www.w3.org/2000/svg" fill="#800b58" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="12px" height="12px" viewBox="0 0 73.17 73.17" style="margin-top: 6px;enable-background:new 0 0 73.17 73.17;" xml:space="preserve">
				<g>
				<g id="Plus">
				<g>
				<path d="M68.928,32.343H40.827V4.243C40.827,1.903,38.928,0,36.585,0s-4.242,1.903-4.242,4.242v28.101H4.242 C1.9,32.343,0,34.246,0,36.585c0,2.347,1.9,4.242,4.242,4.242h28.101v28.1c0,2.349,1.899,4.242,4.242,4.242 s4.242-1.896,4.242-4.242v-28.1h28.101c2.344,0,4.242-1.896,4.242-4.242C73.17,34.246,71.271,32.343,68.928,32.343z"></path>
				</g>
				</g>
				</g>
				
				</svg></div>
				</span>
				<span>${i.nome}</span>
				<span p=${i.id} id='total'>
					${numberToReal(i.qtd * i.preco)}
				</span>
				${listaCmp}
			</div>
		`;
      }
      $(".list-products").append(html);

      qtdAction = qtdAction + i.qtd;
    }

    if (verifyProds() > 0) {
      $(".carrinho-vazio").hide();
    }

    jQuery(".produtos__action span").text(qtdAction);
  }
}

function addProdAlert() {
  jQuery(".adicionarCarrinho").html("");
  jQuery(".adicionarCarrinho").html("<div>Produto adicionado ao carrinho</div>");
  jQuery(".adicionarCarrinho div").fadeIn(250).delay(1000).fadeOut(250);
}

function numberToReal(numero) {
  numero = parseFloat(numero);
  var numero = numero.toFixed(2).split(".");
  numero[0] = numero[0].split(/(?=(?:...)*$)/).join(".");

  return numero.join(",");
}

function getTotal() {
  if (localStorage.getItem("prods") != undefined && Object.keys(localStorage.getItem("prods")).length !== 0) {
    var obj = JSON.parse(Base64Decode(localStorage.getItem("prods")));
  }
  if (localStorage.getItem("complementos") != undefined && Object.keys(localStorage.getItem("complementos")).length !== 0) {
    var comp = JSON.parse(Base64Decode(localStorage.getItem("complementos")));
  }

  total = 0;
  if (obj) {
    for (let t of obj) {
      total += t.qtd * t.preco;
      for (let c of comp) {
        if (t.comp == c.comp) {
          total += t.qtd * parseFloat(c.preco);
          jQuery(".cmvl-" + c.comp + "-" + c.id_complemento).html(numberToReal(parseFloat(t.qtd * c.preco)));
        }
      }
    }
  }

  $("td#total").text("");
  return total;
}

function getProdTotal() {
  var obj = JSON.parse(Base64Decode(localStorage.getItem("prods")));

  total = 0;
  for (let t of obj) {
    total_prod += t.qtd;
  }

  return total_prod;
}

function getCadForm(client) {
  return (html = `
	<form id="form-finalizar-pedido" action="#" method="POST" class="finalizar__form clearfix">
		<h2 style="background-color: #800b58;color: #ffffff;font-size: 24px;padding: 6px 18px;" class="form-h2">CADASTRO</h2>
		<label class="form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 100%;">
			Nome<span>*</span>
			<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="nome" class="form" type="text" required />
		</label>
		<label class="form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 100%;">
			Sobrenome<span>*</span>
			<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="sobrenome" class="form" type="text" required />
		</label>
		<label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
			Whatsapp<span>*</span>
			<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="whatsapp" class="form" type="text"/>
		</label>
		<label class="form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 100%;">
			Email<span>*</span>
			<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="email" value="${client}" class="form" type="email"/>
		</label>
		<label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
			Data de nascimento<span>*</span>
			<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="nascimento" class="form" type="date"/>
		</label>
		<label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
			Sexo<span>*</span>
			<select style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="sexo">
				<option value="Masculino">Masculino</option>
				<option value="Feminino">Femininino</option>
			</select>
		</label>
		<label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
			CEP<span>*</span>
			<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="cep" max="9" class="form" type="text"/>
		</label>
		<label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
			Logradouro<span>*</span>
			<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="logradouro" class="form" value="" type="text"/>
		</label>
		<label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
			Bairro<span>*</span>
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
		<label>
			<input class="form-btn" id="enviarCadForm" type="button" value="CADASTRAR"/>
		</label>
	</form>
`);
}

function getEndForm(data, csrf, form = null, parameters = null) {
  var end = JSON.parse(localStorage.getItem("entrega"));

  var loja = JSON.parse(localStorage.getItem("loja_id"));

  var dtv = "";

  if (form == "pagamento" || form == "finalizar") {
    dtv = "desativado";
  }
  

  return (html =
    `
	<form class="box__form clearfix" id="form-endereco" action="/delivery/identificacao/pagamento" method="POST">
		<form  id="form-enviar-endereco" action="/delivery/identificacao/pagamento" method="POST">
			<div class="finalizar__form ` +
    dtv +
    ` ">
				<h2>ENDEREÇO DE ENTREGA</h2>
				<input type="hidden" name="id" id="user-entrega" value="${data.id}" />
				<div class="finalizar__dados">
					<h3 id="nome-entrega">${data.nome}</h3>
					<span>Endereço:</span>
					<p>${end.logradouro}</p>
					<p>${end.bairro} - ${end.cidade} - ${end.uf}</p>
					<input type="hidden" name="_token" value="${csrf}"/>
					<input type="hidden" name="cep" value="${parseCEP(end.cep)}"/>
					<input type="hidden" name="cidade" value="${end.cidade}"/>
					<input type="hidden" name="logradouro" value="${end.logradouro}"/>
					<input type="hidden" name="estado" value="${end.uf}"/>
					<input type="hidden" name="nome" value="${data.nome}"/>
					<input type="hidden" name="id_loja" value="${loja.loja_id}" />
					<input type="hidden" name="email" value="${data.email}" />
				</div>
				<label class="g2">
					Número<span>*</span>
					<input id="numero-entrega" name="numero" class="form style-input" type="number"/>
				</label>
				<label class="g2">
				Compl. - Ex: ap xx
				<input id="compl-entrega" name="complemento" class="form style-input" type="text"/>
				</label>
				<label>
					Referência
					<input id="ref-entrega" name="referencia" class="form style-input" type="text"/>
				</label>
				<label>
					<input type="button" class="form-btn" id="prosseguir-pagamento" value="CONTINUAR" />
				</label>
			</div>
		</form>
` +
    getForms(dtv, form, csrf, parameters));
}

function getPayments(methods) {
  html = '<label for="Forma de pagamento">Forma de Pagamento:<select class="style-input" name="pagamento" id="forma-pagamento"></label>';

  for (let i in methods) {
    html += `<option value="${methods[i].get_payment_methods.id}">${methods[i].get_payment_methods.name_method}</option>`;
  }

  $("#select-forma-pagamento").append(html);
  $("#form-finalizar-pedido").fadeIn();
  $("#form-finalizar-pedido").css("display", "table");
}

function getComplements() {
  jQuery.get({
    type: "GET",
    url: "/delivery/product/complements",
    success: function (data) {
      for (let i of data) {
        var item = {
          id: i.id,
          name_complement: i.name_complement,
          price_complement: i.price_complement,
          product_id: i.product_id,
        };
        listaComplemento.push(item);
      }
    },
  });
  return listaComplemento;
}

function parseURL(str) {
  return str
    .normalize("NFD")
    .replace(" ", "-")
    .replace(/[\u0300-\u036f]/g, "")
    .replace(" ", "-")
    .toLowerCase();
}

function pesquisaScroll(texto) {
  jQuery("#produtos").val(texto);

  var scroll = jQuery('.item-p[pesquisa="' + parseURL(texto) + '"]').offset();

  jQuery("html, body").animate(
    {
      scrollTop: scroll.top - 140,
    },
    100
  );

  jQuery(".pesquisa-resultado").hide(100);

  jQuery(".pesquisa-resultado-mobile").hide(100);
}

function pesquisaScrollBtn(texto) {
  //var scroll = jQuery('.item-p[pesquisa="' + parseURL(texto) + '"]').offset();

  if (scroll != undefined) {
    document.location = "http://pedidos.tubaraodapraia.com.br/delivery/search=" + parseURL(texto);
    // jQuery('html,body').animate({
    // 	scrollTop: scroll.top - 140
    // }, 100);

    // jQuery('.pesquisa-resultado').hide(100);

    // jQuery('.pesquisa-resultado-mobile').hide(100);
  } else {
    alert("Não há produtos com o nome informado");
  }
}

function inicializacao(ID, tx) {
  // var id_loja = ID;
  // var data = {
  // 	loja_id: id_loja
  // };
  if (localStorage.getItem("prods") != undefined && Object.keys(localStorage.getItem("prods")).length !== 0) {
    var products = JSON.parse(Base64Decode(localStorage.getItem("prods")));
  }
  // var idEntrega = JSON.parse(localStorage.getItem("entrega"));

  // idEntrega.taxa = tx;

  // localStorage.setItem("entrega", JSON.stringify(idEntrega));

  // idEntrega = JSON.parse(localStorage.getItem("entrega"));

  if (localStorage.getItem("complementos") != undefined && Object.keys(localStorage.getItem("complementos")).length !== 0) {
    var complementos = JSON.parse(Base64Decode(localStorage.getItem("complementos")));
  }

  getComboVariations();

  // localStorage.setItem("loja_id", JSON.stringify(data));

  // var idStorage = JSON.parse(localStorage.getItem("loja_id"));

  if (!complementos) {
    var complementos = [];
    localStorage.setItem("complementos", Base64Encode(JSON.stringify(complementos)));
  }
  if (products == undefined) {
    var products = [];
    localStorage.setItem("prods", Base64Encode(JSON.stringify(products)));
    console.log(products);
  }

  // if (products !== null) {

  // 	// if (id_loja != idStorage.loja_id) {

  // 	localStorage.removeItem("prods");

  // 	// }

  // }

  if (products != null) {
    // if (id_loja == idStorage.loja_id) {

    initItems(products);
    bugAux = true;

    // }
  }

  getVariations();

  total = 0;
  total_prod = 0;

  if (Object.keys(products).length !== 0) {
    for (let i of products) {
      var cmp = "";
      var listaCmp = "";
      if (i.comp) {
        cmp = `comp="${i.comp}"`;
        listaCmp = `<ul class="itens__comp">`;
        for (let c of complementos) {
          if (c.comp == i.comp) {
            listaCmp += `
						<li class="clearfix">
							<div>+ ${c.nome}</div>
							<div class="cmvl-${i.comp}-${c.id_complemento}">${numberToReal(c.preco)}</div>
						</li>
					`;
          }
        }
        listaCmp += `</ul>`;
        complTotal++;
      }

      if (i.id_var) {
        var html = `
				<div class="itens clearfix prod" p-var=${i.id_var} ${cmp}>
					<span p="${i.id}" name="${i.nome}" price="${i.preco}" class="clearfix">
					<div var="${
            i.id_var
          }" class="remItem"><svg fill="#800b58" style="margin-top: 6px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="isolation:isolate" viewBox="142 2560.343 73.17 8.484" width="12px" height="12px"><g><g><g><g><path fill="#800b58" d=" M 210.928 2560.343 L 182.827 2560.343 L 174.343 2560.343 L 146.242 2560.343 C 143.9 2560.343 142 2562.246 142 2564.585 C 142 2566.932 143.9 2568.827 146.242 2568.827 L 174.343 2568.827 L 182.827 2568.827 L 210.928 2568.827 C 213.272 2568.827 215.17 2566.931 215.17 2564.585 C 215.17 2562.246 213.271 2560.343 210.928 2560.343 Z "></path></g></g></g></g></svg></div>
					<input disabled class="qt" type='number' value='${i.qtd}'>
					<div var="${
            i.id_var
          }" class="addItem"><svg xmlns="http://www.w3.org/2000/svg" fill="#800b58" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="12px" height="12px" viewBox="0 0 73.17 73.17" style="margin-top: 6px;enable-background:new 0 0 73.17 73.17;" xml:space="preserve">
					<g>
					<g id="Plus">
					<g>
					<path d="M68.928,32.343H40.827V4.243C40.827,1.903,38.928,0,36.585,0s-4.242,1.903-4.242,4.242v28.101H4.242 C1.9,32.343,0,34.246,0,36.585c0,2.347,1.9,4.242,4.242,4.242h28.101v28.1c0,2.349,1.899,4.242,4.242,4.242 s4.242-1.896,4.242-4.242v-28.1h28.101c2.344,0,4.242-1.896,4.242-4.242C73.17,34.246,71.271,32.343,68.928,32.343z"></path>
					</g>
					</g>
					</g>
					
					</svg></div>
					</span>
					<span>${i.nome}</span>
					<span p=${i.id} id='total'>
						${numberToReal(i.qtd * i.preco)}
					</span>
					${listaCmp}
				</div>
				`;
      } else if (i.comboVars) {
        var html = `
			<div class="itens clearfix prod" p-combo=${i.id}">
			<span p="${i.id}" name="${i.nome}" price="${i.preco}" class="clearfix">
				<div class="remItem" comboVar="${JSON.stringify(
          i.comboVars
        )}"><svg fill="#800b58" style="margin-top: 6px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="isolation:isolate" viewBox="142 2560.343 73.17 8.484" width="12px" height="12px"><g><g><g><g><path fill="#800b58" d=" M 210.928 2560.343 L 182.827 2560.343 L 174.343 2560.343 L 146.242 2560.343 C 143.9 2560.343 142 2562.246 142 2564.585 C 142 2566.932 143.9 2568.827 146.242 2568.827 L 174.343 2568.827 L 182.827 2568.827 L 210.928 2568.827 C 213.272 2568.827 215.17 2566.931 215.17 2564.585 C 215.17 2562.246 213.271 2560.343 210.928 2560.343 Z "></path></g></g></g></g></svg></div>
					<input disabled class="qt" type='number' value='${i.qtd}'>
				<div class="addItem" comboVar="${JSON.stringify(
          i.comboVars
        )}"><svg xmlns="http://www.w3.org/2000/svg" fill="#800b58" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="12px" height="12px" viewBox="0 0 73.17 73.17" style="margin-top: 6px;enable-background:new 0 0 73.17 73.17;" xml:space="preserve">
				<g>
				<g id="Plus">
				<g>
				<path d="M68.928,32.343H40.827V4.243C40.827,1.903,38.928,0,36.585,0s-4.242,1.903-4.242,4.242v28.101H4.242 C1.9,32.343,0,34.246,0,36.585c0,2.347,1.9,4.242,4.242,4.242h28.101v28.1c0,2.349,1.899,4.242,4.242,4.242 s4.242-1.896,4.242-4.242v-28.1h28.101c2.344,0,4.242-1.896,4.242-4.242C73.17,34.246,71.271,32.343,68.928,32.343z"></path>
				</g>
				</g>
				</g>
				
				</svg></div>
				</span>
				<span>${i.nome}</span>
				<span p=${i.id} id='total'>
					${numberToReal(parseFloat(i.qtd * i.preco))}
				</span>
			</div>
			`;
      } else {
        var html = `
				<div class="itens clearfix prod" p=${i.id} ${cmp}>
					<span p="${i.id}" name="${i.nome}" price="${i.preco}" class="clearfix">
					<div class="remItem"><svg fill="#800b58" xmlns="http://www.w3.org/2000/svg" style="margin-top: 6px;" xmlns:xlink="http://www.w3.org/1999/xlink" style="isolation:isolate" viewBox="142 2560.343 73.17 8.484" width="12px" height="12px"><g><g><g><g><path fill="#800b58" d=" M 210.928 2560.343 L 182.827 2560.343 L 174.343 2560.343 L 146.242 2560.343 C 143.9 2560.343 142 2562.246 142 2564.585 C 142 2566.932 143.9 2568.827 146.242 2568.827 L 174.343 2568.827 L 182.827 2568.827 L 210.928 2568.827 C 213.272 2568.827 215.17 2566.931 215.17 2564.585 C 215.17 2562.246 213.271 2560.343 210.928 2560.343 Z "></path></g></g></g></g></svg></div>
						<input disabled class="qt" type='number' value='${i.qtd}'>
					<div class="addItem"><svg xmlns="http://www.w3.org/2000/svg" fill="#800b58" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="12px" height="12px" viewBox="0 0 73.17 73.17" style="margin-top: 6px;enable-background:new 0 0 73.17 73.17;" xml:space="preserve">
					<g>
					<g id="Plus">
					<g>
					<path d="M68.928,32.343H40.827V4.243C40.827,1.903,38.928,0,36.585,0s-4.242,1.903-4.242,4.242v28.101H4.242 C1.9,32.343,0,34.246,0,36.585c0,2.347,1.9,4.242,4.242,4.242h28.101v28.1c0,2.349,1.899,4.242,4.242,4.242 s4.242-1.896,4.242-4.242v-28.1h28.101c2.344,0,4.242-1.896,4.242-4.242C73.17,34.246,71.271,32.343,68.928,32.343z"></path>
					</g>
					</g>
					</g>
					
					</svg></div>
					</span>
					<span>${i.nome}</span>
					<span p=${i.id} id='total'>
						${numberToReal(i.qtd * i.preco)}
					</span>
					${listaCmp}
				</div>
				`;
      }
      $(".list-products").append(html);
    }
  }

  for (let t of products) {
    total += t.qtd * t.preco;
  }

  for (let t of products) {
    total_prod += t.qtd;
  }

  jQuery(".produtos__action span").text(total_prod);
  vlTotal = getTotal();
  $("span#subtotal-carrinho").text(numberToReal(vlTotal));

  // var taxa = parseFloat(idEntrega.taxa);
  $("#tx-entrega").text(numberToReal(0));

  $("span#total-carrinho").text(numberToReal(vlTotal));

  // jQuery('.end-prev').html(idEntrega.logradouro + " - " + idEntrega.bairro + "<br/>" + idEntrega.cidade + "/" + idEntrega.uf);

  jQuery(".item-p").each(function () {
    var produto = jQuery(this).attr("pesquisa");
    jQuery(".pesquisa-resultado").append("<li" + " onclick=" + "'onClickFunctionAlter()'" + ">" + replaceAll(produto, "-", " ") + "</li>");
    jQuery(".pesquisa-resultado-mobile").append("<li>" + replaceAll(produto, "-", " ") + "onclick=" + "'onClickFunctionAlter()'" + "</li>");
  });

  if (Object.keys(products).length != 0) {
    $(".carrinho-vazio").css("display", "none");
  }
}

function onClickFunctionAlter() {
  var btn = document.getElementById("botaoPesquisarIndex");
  btn.click();
}

function replaceAll(str, find, replace) {
  return str.replace(new RegExp(find, "g"), replace);
}

function initItems(data) {
  console.log(data);
  for (let i of data) {
    if (i.comp) {
      var item = {
        id: i.id,
        nome: i.nome,
        preco: parseFloat(i.preco),
        qtd: i.qtd,
        comp: i.comp,
        tf: 1,
      };
    } else if (i.comboVars) {
      var item = {
        id: i.id,
        comboVars: i.comboVars,
        nome: i.nome,
        preco: parseFloat(i.preco),
        qtd: i.qtd,
        tf: 0,
      };
    } else if (i.id_var) {
      var item = {
        id: i.id,
        nome: i.nome,
        id_var: i.id_var,
        preco: parseFloat(i.preco),
        qtd: i.qtd,
        tf: 0,
      };
    } else {
      var item = {
        id: i.id,
        nome: i.nome,
        preco: parseFloat(i.preco),
        qtd: i.qtd,
        tf: 0,
      };
    }
    items.push(item);
    // console.log(items);
  }
}

function pegarData() {
  var now = new Date();
  var day = ("0" + now.getDate()).slice(-2);
  var month = ("0" + (now.getMonth() + 1)).slice(-2);
  return now.getFullYear() + "-" + month + "-" + day;
}

function pegarHora() {
  var now = new Date();
  var hour = now.getHours();
  var mint = now.getMinutes();
  return hour + ":" + mint;
}

function definirHorarios(timeIni, timeFin) {
  var hour = jQuery("#agendar-hora");
  var date = jQuery("#agendar-data");
  hour.attr("min", timeIni);
  hour.attr("max", timeFin);

  var today = pegarData();
  date.val(today);
}

function agendamento() {
  var time = jQuery("#agendar-hora").val();
  jQuery("p.erromsg").remove();
  if (time) {
    var min = jQuery("#agendar-hora").attr("min");
    var max = jQuery("#agendar-hora").attr("max");
    var data = jQuery("#agendar-data").val();

    var timeSplit = time.split(":");
    var minSplit = min.split(":");
    var maxSplit = max.split(":");

    var abertura = new Date(2018, 01, 01, minSplit[0], minSplit[1]);
    var fechamento = new Date(2018, 01, 01, maxSplit[0], maxSplit[1]);
    var agendamento = new Date(2018, 01, 01, timeSplit[0], timeSplit[1]);

    if (abertura > fechamento) {
      fechamento.setDate(fechamento.getDate() + 1);
      if (agendamento < abertura) {
        agendamento.setDate(agendamento.getDate() + 1);
      }
    }

    if (agendamento >= abertura && agendamento <= fechamento) {
      var agendamento = {
        data: data,
        time: time,
        status: "agd",
      };

      var obs = jQuery("#obs").val();
      localStorage.setItem("obs", obs);

      localStorage.setItem("agendamento_pedido", JSON.stringify(agendamento));
      window.location = "/delivery/identificacao";
    } else {
      jQuery("#agendar-hora").after("<p class='erromsg'>Não realizamos entregas nesse horário</p>");
    }
  } else {
    jQuery("#agendar-hora").after("<p class='erromsg'>Você não preencheu o horário</p>");
  }
}

function removeItem(item) {
  for (i = 0; i < items.length; i++) {
    if (items[i].id == item) {
      var listAux = items.slice(0, i);
      var listAuxEnd = items.slice(i + 1);
      return (items = listAux.concat(listAuxEnd));
    }
  }
  return false;
}

function removeComp(complemento, localId) {
  for (i = 0; i < localId.length; i++) {
    if (localId[i].comp == complemento) {
      var listAux = localId.slice(0, i);
      var listAuxEnd = localId.slice(i + 1);
      return (items = listAux.concat(listAuxEnd));
    }
  }
  return false;
}

function removeCompList(comp, compLista) {
  complementos = removerPorIndex(compLista, comp);

  if (complementos) {
    return complementos;
  }

  return false;
}

function removerPorIndex(array, comp) {
  return array.filter(function (el) {
    return el.comp !== comp;
  });
}

function removerPorVar(array, id) {
  return array.filter(function (el) {
    return el.id_var !== id;
  });
}

function removeItem2(item) {
  for (i = 0; i < items.length; i++) {
    if (items[0][i] == item) {
      var listAux = items[0].slice(0, i);
      var listAuxEnd = items[0].slice(i + 1);
      return (items = listAux.concat(listAuxEnd));
    }
  }
  return false;
}

function removeVarItem(item) {
  for (i = 0; i < items.length; i++) {
    if (items[i].id_var == item) {
      var listAux = items.slice(0, i);
      var listAuxEnd = items.slice(i + 1);
      return (items = listAux.concat(listAuxEnd));
    }
  }
  return false;
}

function adicionarProdutoVariavel(id, idVar, idEntrega, qtd, name, price, prods) {
  qtd = parseInt(qtd);
  if (qtd != 0) {
    if (prods != null) {
      for (let i of prods) {
        if (i.id_var == idVar) {
          qtd += parseInt(i.qtd);
          items = removerPorVar(prods, idVar);
          //removeVarItem(idVar);
        }
      }
    }

    var data = {
      id: id,
      id_var: idVar,
      nome: name,
      preco: parseFloat(price),
      qtd: qtd,
      tf: 0,
    };

    items.push(data);
    localStorage.setItem("prods", Base64Encode(JSON.stringify(items)));
    addToCart();

    vlTotal = getTotal();
    // var taxa = parseInt(idEntrega.taxa);
    $("span#subtotal-carrinho").text(numberToReal(vlTotal));
    $("span#total-carrinho").text(numberToReal(vlTotal));
  }
}

function adicionarProduto(id, qtd, nome, preco, localId, idEntrega) {
  if (qtd != 0) {
    if (localId != null) {
      for (let i of localId) {
        if (i.id == id) {
          qtd += parseInt(i.qtd);
          removeItem(id);
        }
      }
    }

    var data = {
      id: id,
      nome: nome,
      preco: parseFloat(preco),
      qtd: qtd,
      tf: 0,
    };

    items.push(data);

    localStorage.setItem("prods", Base64Encode(JSON.stringify(items)));

    addToCart();

    vlTotal = getTotal();

    // var taxa = parseInt(idEntrega.taxa);

    $("span#subtotal-carrinho").text(numberToReal(vlTotal));

    $("span#total-carrinho").text(numberToReal(vlTotal));
  }
}

function adicionarQtProdVar(idVar, idEntrega, el, form, localId) {
  var name = "";
  var id = "";
  var price = 0;
  var qtd = 0;

  for (let i of localId) {
    if (items != null) {
      if (i.id_var == idVar) {
        id = i.id;
        name = i.nome;
        price = i.preco;

        qtd = parseInt(i.qtd + 1);
      }
    }
  }

  items = removerPorVar(localId, idVar);

  var data = {
    id: id,
    id_var: idVar,
    nome: name,
    preco: parseFloat(price),
    qtd: qtd,
    tf: 0,
  };

  var qtdAction = 0;

  for (let i of localId) {
    qtdAction += i.qtd;
  }

  jQuery(".produtos__action span").text(qtdAction - 1);

  if (qtd == 0) {
    el.parent().html("");
    localStorage.setItem("prods", Base64Encode(JSON.stringify(items)));

    vlTotal = getTotal();
    // var taxa = parseInt(idEntrega.taxa);

    $("span#subtotal-carrinho").text(numberToReal(vlTotal));
    $("span#total-carrinho").text(numberToReal(vlTotal));

    return;
  } else {
    form.val(qtd);
    vl = parseFloat(price) * qtd;
    el.next().next().text(numberToReal(vl));
  }

  items.push(data);

  localStorage.setItem("prods", Base64Encode(JSON.stringify(items)));

  vlTotal = getTotal();

  $('.remItem[var="' + idVar + '"]')
    .next()
    .val(qtd);
  // var taxa = parseInt(idEntrega.taxa);

  $("span#subtotal-carrinho").text(numberToReal(vlTotal));
  $("span#total-carrinho").text(numberToReal(vlTotal));
}

function removerQtProdVar(idVar, idEntrega, el, form, localId) {
  var name = "";
  var id = "";
  var price = 0;
  var qtdMob = jQuery(".produtos__action span").text();
  var qtd = 0;
  for (let i of localId) {
    if (items != null) {
      if (i.id_var == idVar) {
        id = i.id;
        name = i.nome;
        price = i.preco;
        qtd = parseInt(i.qtd - 1);
      }
    }
  }
  items = removerPorVar(localId, idVar);

  var data = {
    id: id,
    id_var: idVar,
    nome: name,
    preco: parseFloat(price),
    qtd: qtd,
    tf: 0,
  };

  var qtdAction = 0;

  for (let i of localId) {
    qtdAction += i.qtd;
  }

  jQuery(".produtos__action span").text(qtdAction - 1);

  if (qtd == 0) {
    el.parent().html("");
    localStorage.setItem("prods", Base64Encode(JSON.stringify(items)));

    vlTotal = getTotal();
    // var taxa = parseInt(idEntrega.taxa);

    // items.push(data);

    $("span#subtotal-carrinho").text(numberToReal(vlTotal));
    $("span#total-carrinho").text(numberToReal(vlTotal));

    if ($(".itens").length == 0) {
      $(".carrinho-vazio").show();
    }

    $('.prod[p-var="' + idVar + '"]').remove();

    return;
  } else {
    form.val(qtd);
    vl = parseFloat(price) * qtd;
    el.next().next().text(numberToReal(vl));
  }

  items.push(data);

  localStorage.setItem("prods", Base64Encode(JSON.stringify(items)));

  vlTotal = getTotal();
  // var taxa = parseInt(idEntrega.taxa);

  if ($(".itens").length == 0) {
    $(".carrinho-vazio").show();
  }

  $('.remItem[var="' + idVar + '"]')
    .next()
    .val(qtd);

  $("span#subtotal-carrinho").text(numberToReal(vlTotal));
  $("span#total-carrinho").text(numberToReal(vlTotal));
  jQuery(".produtos__action span").text(qtdMob - qtd);
}

function removerQt(el, form, localId, idEntrega, id, compId, complementosList, comboVars = null) {
  var comp = false;
  var qtdMob = $(".produtos__action span").text();

  for (let i of localId) {
    if (i.qtd != 0) {
      if (localId != null) {
        if (i.id == id) {
          nome = i.nome;
          preco = i.preco;
          if (compId) {
            if (i.comp == compId) {
              comp = i.comp;

              qtd = parseInt(i.qtd - 1);
            }
          } else {
            qtd = parseInt(i.qtd - 1);
          }
        }
      }
    }
  }

  if (comp) {
    removeComp(comp, localId);
    var data = {
      id: id,
      nome: nome,
      preco: parseFloat(preco),
      qtd: qtd,
      comp: comp,
      tf: 1,
    };
  } else if (comboVars != null) {
    removeItem(id);

    var data = {
      id: id,
      comboVars: comboVars,
      nome: nome,
      preco: parseFloat(preco),
      qtd: qtd,
      tf: 0,
    };
  } else {
    removeItem(id);
    var data = {
      id: id,
      nome: nome,
      preco: parseFloat(preco),
      qtd: qtd,
      tf: 0,
    };
  }

  if (qtd == 0) {
    el.parent().html("");

    localStorage.setItem("prods", Base64Encode(JSON.stringify(items)));

    vlTotal = getTotal();

    // var taxa = parseInt(idEntrega.taxa);

    $("span#subtotal-carrinho").text(numberToReal(vlTotal));

    $("span#total-carrinho").text(numberToReal(vlTotal));

    if ($(".itens").length == 1) {
      $(".carrinho-vazio").show();
    }

    if (comp) {
      $('.prod[comp="' + comp + '"]').remove();
    } else if (comboVars != null) {
      $('.prod[p-combo="' + id + '"]').remove();
    } else {
      $('.prod[p="' + id + '"]').remove();
    }

    jQuery(".produtos__action span").text(qtdMob - 1);
    return;
  } else {
    form.val(qtd);
    vl = parseFloat(preco) * qtd;
    el.next().next().text(numberToReal(vl));
  }

  var qtdAction = 0;

  for (let i of localId) {
    qtdAction += i.qtd;
  }

  jQuery(".produtos__action span").text(qtdAction + 1);

  vl = parseFloat(preco) * qtd;

  el.next().next().text(numberToReal(vl));

  items.push(data);

  localStorage.setItem("prods", Base64Encode(JSON.stringify(items)));

  vlTotal = getTotal();

  $('span[p="' + id + '"] .qt').val(qtd);

  // var taxa = parseInt(idEntrega.taxa);

  $("span#subtotal-carrinho").text(numberToReal(vlTotal));

  $("span#total-carrinho").text(numberToReal(vlTotal));

  jQuery(".produtos__action span").text(qtdMob - 1);
}

function adicionarQt(el, form, id, localId, idEntrega, compId, comboVars = null) {
  var comp = false;
  for (let i of localId) {
    if (i.qtd != 0) {
      if (localId != null) {
        //for(let lId of localId){
        if (i.id == id) {
          nome = i.nome;
          preco = i.preco;
          if (compId) {
            if (i.comp == compId) {
              comp = i.comp;
              qtd = parseInt(i.qtd + 1);
            }
          } else {
            qtd = parseInt(i.qtd + 1);
          }
        }
        //}
      }
    }
  }
  if (comp) {
    removeComp(comp, localId);
    var data = {
      id: id,
      nome: nome,
      preco: parseFloat(preco),
      qtd: qtd,
      comp: comp,
      tf: 1,
    };
  } else if (comboVars != null) {
    removeItem(id);
    var data = {
      id: id,
      nome: nome,
      preco: parseFloat(preco),
      qtd: qtd,
      comboVars: comboVars,
      tf: 0,
    };
  } else {
    removeItem(id);
    var data = {
      id: id,
      nome: nome,
      preco: parseFloat(preco),
      qtd: qtd,
      tf: 0,
    };
  }

  form.prev().val(qtd);

  vl = parseFloat(preco) * qtd;

  el.next().next().text(numberToReal(vl));

  items.push(data);

  $('span[p="' + id + '"] .qt').val(qtd);

  localStorage.setItem("prods", Base64Encode(JSON.stringify(items)));

  vlTotal = getTotal();
  // var taxa = parseInt(idEntrega.taxa);

  $("span#subtotal-carrinho").text(numberToReal(vlTotal));
  $("span#total-carrinho").text(numberToReal(vlTotal));

  var qtdAction = 0;
  for (let i of localId) {
    qtdAction += i.qtd;
  }

  jQuery(".produtos__action span").text(qtdAction + 1);
}

function complementosModal(id, qtd, nome, preco, checkbox, obj, comps) {
  if (comps != null) {
    for (let c of comps) {
      for (let t of obj) {
        if (c == t.id) {
          checkbox += `
    			<label class="checkbox-style" price="${t.price_complement}" name="${t.name_complement}" id="${t.id}" product="${id}">
        			<input class="checkbox-item" type="checkbox"/>
					<span class="name">${t.name_complement}</span>
					<span price="${t.price_complement}" class="price">${numberToReal(t.price_complement)}</span>
				</label>
			`;
        }
      }
    }

    var conteudo = `
	<p class="nm-produto clearfix">
	${nome}
		<span class="compl-price-prod" price="${preco}" style="float: right;">${numberToReal(preco)}</span>
		</p>
	<div class="escolher__conteudo" id="${id}" name="${nome}" price="${preco}">
	${checkbox}
	</div>
`;

    $(".op").html("");

    if ($(".add-comp").length < 1) {
      $(".escolher .conteudo").append('<input style="background-image: url(img/continuar.png);" class="add-comp" value="Continuar" type="button"></input>');
    }
    jQuery(".escolher .conteudo .op").append(conteudo);
  }
}

function adicionarComplemento(produtosLista, complementosLista) {
  var nomeProduto = jQuery(".escolher__conteudo").attr("name");
  var idProduto = jQuery(".escolher__conteudo").attr("id");
  var preco = jQuery(".escolher__conteudo").attr("price");

  for (let c of complementosLista) {
    if (c.comp >= complTotal) {
      complTotal = c.comp;
    }
  }
  complTotal++;

  var listaCmp = "";
  var tf = 0;
  jQuery(".checkbox-style").each(function () {
    if (jQuery(this).children("input[type=checkbox]").prop("checked")) {
      var produto = jQuery(this).attr("product");

      var id = jQuery(this).attr("id");

      var preco = jQuery(this).attr("price");

      var nome = jQuery(this).attr("name");

      tf = 1;

      var item = {
        id_produto: produto,
        id_complemento: id,
        preco: preco,
        nome: nome,
        comp: complTotal,
        tf: 1,
      };

      complementosLista.push(item);

      listaCmp += `
			<li class="clearfix">
				<div>+ ${nome}</div>
				<div class="cmvl-${complTotal}-${id}">${numberToReal(preco)}</div>
			</li>
		`;
    }
  });
  if (listaCmp !== "") {
    ulItens = `
		<ul class="itens__comp">
			${listaCmp}
		</ul>
	`;
  } else {
    ulItens = "";
  }

  localStorage.setItem("complementos", Base64Encode(JSON.stringify(complementosLista)));

  var html = `
	<div class="itens clearfix prod" p=${idProduto} comp="${complTotal}">
		<span p="${idProduto}" name="${nomeProduto}" price="${preco}" class="clearfix">
			<div class="addItem">+</div>
			<input disabled class="qt" type='number' value='1'>
			<div class="remItem">-</div>
		</span>
		<span>${nomeProduto}</span>
		<span p=${idProduto} id='total'>
			${numberToReal(parseFloat(preco))}
		</span>

		<ul class="itens__comp">
			${ulItens}
		</ul>
	</div>
`;

  var item = {
    id: idProduto,
    nome: nomeProduto,
    preco: parseFloat(preco),
    qtd: 1,
    comp: complTotal,
    tf: tf,
  };
  produtosLista.push(item);
  items.push(item);
  localStorage.setItem("prods", Base64Encode(JSON.stringify(produtosLista)));

  $(".list-products").append(html);

  vlTotal = getTotal();
  $("span#subtotal-carrinho").text(numberToReal(vlTotal));
  var idEntrega = JSON.parse(localStorage.getItem("entrega"));
  // var taxa = parseFloat(idEntrega.taxa);
  // $('#tx-entrega').text(numberToReal(taxa));

  $("span#total-carrinho").text(numberToReal(vlTotal));

  var qtdAction = 0;
  for (let i of produtosLista) {
    qtdAction += i.qtd;
  }

  if (verifyProds() >= 1) {
    $(".carrinho-vazio").hide();
  }

  jQuery(".produtos__action span").text(qtdAction);

  jQuery(".escolher").fadeOut(100);
}

function getVariationsModal(id) {
  var today = new Date();
  var dd = today.getDay();

  $("#var-modal").remove();

  console.log(variations);

  var html = `
<div id="var-modal" class="escolher ativo">

	<div class="bg"></div>

	<div class="conteudo">

		<div class="x">X</div>
			<p>
			Escolha o produto:
			</p>
			<form class="escolher-form-overflow">`;
  for (let i of variations[0]) {
    if (i.prod_id == id && i.prod_var_status == "1") {
      html += `<div class="produto-variavel">
						<div class="produto-variavel__item">
						<span>${i.prod_var_name}</span> `;
      if (i.prod_var_promo_day == dd) {
        html += `<span class="preco">${i.prod_var_promo_price}</span>`;
      } else {
        html += `<span class="preco">${i.prod_var_price}</span>`;
      }

      if (i.prod_var_promo_day == dd) {
        html += `</div>
						<div class="produto-variavel__qt">
						<div id-var="${i.id}" class="remVarItem">-</div>
						<input class="qt qt-variation" id="qt-variation" name="${i.prod_var_name}"
						id-var="${i.id}" price="${i.prod_var_promo_price}" id-prod="${i.prod_id}" type="number" value="0">
						<div id-var="${i.id}" class="addVarItem">+</div>
						</div>
					</div>`;
      } else {
        html += `</div>
    				<div class="produto-variavel__qt">
    				<div id-var="${i.id}" class="remVarItem">-</div>
    				<input class="qt qt-variation" id="qt-variation" name="${i.prod_var_name}"
    				id-var="${i.id}" price="${i.prod_var_price}" id-prod="${i.prod_id}" type="number" value="0">
    				<div id-var="${i.id}" class="addVarItem">+</div>
    				</div>
    			</div>`;
      }
    }
  }

  html += `
			</form>
				<input style="background-image: url({{ asset('/img/continuar.png') }}" class="btn" id="addVarProd" value="Adicionar" type="button"/>
	</div>
</div>
`;

  $("body").append(html);
}

function getVariations() {
  $.ajax({
    url: "/delivery/loja/produto/variacoes",
    method: "GET",
    success: function (response) {
      variations.push(response);
    },
    error: function (response) {},
  });
}

function getComboVariations() {
  $.ajax({
    url: "/delivery/loja/produto/comboVariacoes",
    method: "GET",
    success: function (response) {
      for (let r of response) {
        comboVariations.push(r);
      }
    },
    error: function (response) {
      console.log("Erro");
    },
  });
}

function getComboModal(id, nomeProduto, preco) {
  var lsCat = 0;
  var conteudo = "";
  var checkbox = "";
  var idsPassados = [];
  $(".escolher .conteudo .op").html("");
  c = [];
  conteudo += `
   
    <p class="nm-produto clearfix">
        <span class="compl-price-prod" price="${preco}" style="float: right;">${numberToReal(preco)}</span>
    `;
  for (let cv of comboVariations) {
    console.log(cv);
    checkbox = "";
    if (cv.cat_id != lsCat && cv.prod_id == id) {
      if (cv.get_category.name_category == "Pizzas Grandes" && cv.num_esc == "2")
        if (cv.get_category.name_category) {
          $(document.body).on("change", ".checkbox-combo-item", function () {
            var preco = parseInt(jQuery(".nm-produto span").attr("price"));
            let arrayPizza = [];
            jQuery(".escolher__conteudo label").each(function () {
              if (jQuery(this).children("input[type=checkbox]").prop("checked")) {
                preco += parseInt(jQuery(this).children(".price").attr("price"));
              }
            });
            jQuery(".nm-produto span").text(numberToReal(preco));
          });
        }

      conteudo += `
				${cv.get_category.name_category}
					<p>Selecione até <span class="quantidade-combo" name="${cv.variation_name}">${cv.num_esc}</span> ${cv.get_category.name_category} de sua preferência</p>
				`;
      lsCat = cv.cat_id;
      if (cv.get_category.name_category) {
      }
    }
    if (cv.cat_id == lsCat && idsPassados.indexOf(cv.id) == -1 && cv.prod_id == id) {
      checkbox += `
				<label class="checkbox-style" price="${cv.price_product}" name="${cv.variation_name}" id="${cv.variation_name + "-" + cv.cat_id}" product="${id}">
					<input onchange='checkLimit(${cv.num_esc}, "${cv.cat_id}");' price="${cv.price_product}" class="checkbox-combo-item ${cv.variation_name}" num_esc="${cv.num_esc}" name="${cv.variation_name}" cat_id="${
        cv.cat_id
      }" type="checkbox" value="${cv.id}"/>
					<span class="name">${cv.name_product}</span>
					<span price="${cv.price_product}" class="price">${numberToReal(cv.price_product)}</span>
				</label>
				`;
      if (verCombo[cv.cat_id] == undefined) {
        verCombo[cv.cat_id] = cv.num_esc;
      }

      idsPassados.push(cv.id);
      conteudo += `</p>
			<div class="escolher__conteudo" id="1" name="a" price="a">
			${checkbox}
			</div>
		`;
    }
  }
  console.log("${nomeProduto}");
  conteudo += `
	<button prod_id="${id}" prod_name="${nomeProduto}" class="btn" prod_price="${preco}" id="add-combo">adicionar</button>
	`;
  if (conteudo != "") {
    jQuery(".escolher .conteudo .op").append(conteudo);
  }

  if ($(".add-comp").length == 1) {
    $(".add-comp").remove();
  }

  $(".escolher").show();
  // $('.op').html('');

  // if ($('.add-comp').length < 1) {

  // 	$('.escolher .conteudo').append('<input style="background-image: url(img/continuar.png);" class="add-comp" value="Continuar" type="button"></input>');

  // }
}

function verifyCombo(combo) {
  var bool = true;
  for (let v in verCombo) {
    if (combo[v] == undefined || combo[v] > verCombo[v] || combo[v] == 0) {
      bool = false;
    }
  }
  return bool;
}

function addComboProduct(produtosLista, ids, idProduto, nomeProduto, preco) {
  var item = {
    id: idProduto,
    nome: nomeProduto,
    preco: parseFloat(preco),
    qtd: 1,
    comboVars: JSON.stringify(ids),
    tf: 0,
  };
  console.log(item);
  // var html = `
  // <div class="itens clearfix prod" p=${idProduto}">
  // 	<span p="${idProduto}" name="${nomeProduto}" price="${preco}" class="clearfix">
  // 		<div class="addItem" comboVar='${JSON.stringify(ids)}'>+</div>
  // 		<input disabled class="qt" type='number' value='1'>
  // 		<div class="remItem" comboVar='${JSON.stringify(ids)}'>-</div>
  // 	</span>
  // 	<span>${nomeProduto}</span>
  // 	<span p=${idProduto} id='total'>
  // 		${numberToReal(parseFloat(preco))}
  // 	</span>
  // </div>
  // `;

  produtosLista.push(item);

  items.push(item);

  localStorage.setItem("prods", Base64Encode(JSON.stringify(items)));
  addToCart();
  // $('.list-products').append(html);

  vlTotal = getTotal();

  $("span#subtotal-carrinho").text(numberToReal(vlTotal));

  var idEntrega = JSON.parse(localStorage.getItem("entrega"));

  // var taxa = parseFloat(idEntrega.taxa);

  // $('#tx-entrega').text(numberToReal(taxa));

  $("span#total-carrinho").text(numberToReal(vlTotal));

  var qtdAction = 0;

  for (let i of produtosLista) {
    qtdAction += i.qtd;
  }

  if (verifyProds() >= 1) {
    $(".carrinho-vazio").hide();
  }

  jQuery(".produtos__action span").text(qtdAction);

  $(".escolher .conteudo .op").html("");

  jQuery(".escolher").fadeOut(100);
}
variations = [];

comboVariations = [];

verCombo = [];

function parseCEP(cep) {
  return cep.replace("-", "");
}

function setLocalStorageTime() {
  localStorage.setItem("time", Date.now());
}

function Base64Encode(str, encoding = "utf-8") {
  var bytes = new (TextEncoder || TextEncoderLite)(encoding).encode(str);
  return base64js.fromByteArray(bytes);
}
function Base64Decode(str, encoding = "utf-8") {
  var bytes = base64js.toByteArray(str);
  return new (TextDecoder || TextDecoderLite)(encoding).decode(bytes);
}

function removeDivs() {
  $(".lightbox").remove();
  $(".list-group").remove();
  $("div.inicio p").text("Selecione uma loja abaixo");
  $("div.inicio__form").remove();
  $("div.inicio span").remove();
  $("div.inicio .buscar").remove();
}

function verifyProds() {
  var i = 0;
  $(".itens").each(function () {
    i++;
  });

  return i;
}

function addLoadDiv() {
  $("#div-loading").addClass("loading");
  $("#div-loading").css("display", "");
}

function removeLoadDiv() {
  $("#div-loading").removeClass("loading");
  $("#div-loading").hide();
}

function addToCart() {
  var obj = JSON.parse(Base64Decode(localStorage.getItem("prods")));
  var complementos = JSON.parse(Base64Decode(localStorage.getItem("complementos")));
  var qtdAction = 0;
  var qtd = 0;

  $("div.prod").remove();

  if (Object.keys(obj).length !== 0) {
    for (let i of obj) {
      qtd += i.qtd;

      var cmp = "";
      var listaCmp = "";
      if (i.comp) {
        var el = $("div.prod[p='" + i.id + "']");
        if (el.attr("comp") == i.comp) {
          el.attr("comp", i.comp).remove();
        }

        cmp = `comp="${i.comp}"`;
        listaCmp = `<ul class="itens__comp">`;
        for (let c of complementos) {
          if (c.comp == i.comp) {
            listaCmp += `
						<li class="clearfix">
							<div>+ ${c.nome}</div>
							<div class="cmvl-${i.comp}-${c.id_complemento}">${numberToReal(c.preco)}</div>
						</li>
					`;
          }
        }
        listaCmp += `</ul>`;
      } else if (i.id_var) {
        if (typeof $("div.prod[p-var='" + i.id_var + "']") !== "undefined") {
          $("div.prod[p-var='" + i.id_var + "']").remove();
        }
      } else if (i.comboVars) {
        if (typeof $("div.prod[p-combo='" + i.id + "']") !== "undefined") {
          $("div.prod[p-combo='" + i.id + "']").remove();
        }
      } else if (i.tf == 0 && !i.comboVars) {
        if (typeof $("div.prod[p='" + i.id + "']") !== "undefined") {
          $("div.prod[p='" + i.id + "']").remove();
        }
      }

      if (i.id_var) {
        var html = `
			<div class="itens clearfix prod" p-var=${i.id_var} ${cmp}>
				<span p="${i.id}" name="${i.nome}" price="${i.preco}" class="clearfix">
				<div var="${
          i.id_var
        }" class="remItem"><svg style="margin-top: 6px;" fill="#800b58" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="isolation:isolate" viewBox="142 2560.343 73.17 8.484" width="12px" height="12px"><g><g><g><g><path fill="#800b58" d=" M 210.928 2560.343 L 182.827 2560.343 L 174.343 2560.343 L 146.242 2560.343 C 143.9 2560.343 142 2562.246 142 2564.585 C 142 2566.932 143.9 2568.827 146.242 2568.827 L 174.343 2568.827 L 182.827 2568.827 L 210.928 2568.827 C 213.272 2568.827 215.17 2566.931 215.17 2564.585 C 215.17 2562.246 213.271 2560.343 210.928 2560.343 Z "></path></g></g></g></g></svg></div>
				<input disabled class="qt" type='number' value='${i.qtd}'>
				<div var="${
          i.id_var
        }" class="addItem"><svg xmlns="http://www.w3.org/2000/svg" fill="#800b58" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="12px" height="12px" viewBox="0 0 73.17 73.17" style="margin-top: 6px;enable-background:new 0 0 73.17 73.17;" xml:space="preserve">
				<g>
				<g id="Plus">
				<g>
				<path d="M68.928,32.343H40.827V4.243C40.827,1.903,38.928,0,36.585,0s-4.242,1.903-4.242,4.242v28.101H4.242 C1.9,32.343,0,34.246,0,36.585c0,2.347,1.9,4.242,4.242,4.242h28.101v28.1c0,2.349,1.899,4.242,4.242,4.242 s4.242-1.896,4.242-4.242v-28.1h28.101c2.344,0,4.242-1.896,4.242-4.242C73.17,34.246,71.271,32.343,68.928,32.343z"></path>
				</g>
				</g>
				</g>
				
				</svg></div>
				</span>
				<span>${i.nome}</span>
				<span p=${i.id} id='total'>
					${numberToReal(i.qtd * i.preco)}
				</span>
				${listaCmp}
			</div>
		`;
      } else if (i.comboVars) {
        var html = `
			<div class="itens clearfix prod" p-combo=${i.id}">
				<span p="${i.id}" name="${i.nome}" price="${i.preco}" class="clearfix">
				<div class="remItem" comboVar='${JSON.stringify(
          i.comboVars
        )}'><svg fill="#800b58" style="margin-top: 6px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="isolation:isolate" viewBox="142 2560.343 73.17 8.484" width="12px" height="12px"><g><g><g><g><path fill="#800b58" d=" M 210.928 2560.343 L 182.827 2560.343 L 174.343 2560.343 L 146.242 2560.343 C 143.9 2560.343 142 2562.246 142 2564.585 C 142 2566.932 143.9 2568.827 146.242 2568.827 L 174.343 2568.827 L 182.827 2568.827 L 210.928 2568.827 C 213.272 2568.827 215.17 2566.931 215.17 2564.585 C 215.17 2562.246 213.271 2560.343 210.928 2560.343 Z "></path></g></g></g></g></svg></div>
				<input disabled class="qt" type='number' value='${i.qtd}'>
				<div class="addItem" comboVar='${JSON.stringify(
          i.comboVars
        )}'><svg xmlns="http://www.w3.org/2000/svg" fill="#800b58" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="12px" height="12px" viewBox="0 0 73.17 73.17" style="margin-top: 6px;enable-background:new 0 0 73.17 73.17;" xml:space="preserve">
				<g>
				<g id="Plus">
				<g>
				<path d="M68.928,32.343H40.827V4.243C40.827,1.903,38.928,0,36.585,0s-4.242,1.903-4.242,4.242v28.101H4.242 C1.9,32.343,0,34.246,0,36.585c0,2.347,1.9,4.242,4.242,4.242h28.101v28.1c0,2.349,1.899,4.242,4.242,4.242 s4.242-1.896,4.242-4.242v-28.1h28.101c2.344,0,4.242-1.896,4.242-4.242C73.17,34.246,71.271,32.343,68.928,32.343z"></path>
				</g>
				</g>
				</g>
				
				</svg></div>
				</span>
				<span>${i.nome}</span>
				<span p=${i.id} id='total'>
					${numberToReal(parseFloat(i.qtd * i.preco))}
				</span>
			</div>
			`;
      } else if (i.tf == 0 && !i.comboVars) {
        var html = `
			<div class="itens clearfix prod" p=${i.id} ${cmp}>
				<span p="${i.id}" name="${i.nome}" price="${i.preco}" class="clearfix">
				<div class="remItem"><svg fill="#800b58" xmlns="http://www.w3.org/2000/svg" style="margin-top: 6px;" xmlns:xlink="http://www.w3.org/1999/xlink" style="isolation:isolate" viewBox="142 2560.343 73.17 8.484" width="12px" height="12px"><g><g><g><g><path fill="#800b58" d=" M 210.928 2560.343 L 182.827 2560.343 L 174.343 2560.343 L 146.242 2560.343 C 143.9 2560.343 142 2562.246 142 2564.585 C 142 2566.932 143.9 2568.827 146.242 2568.827 L 174.343 2568.827 L 182.827 2568.827 L 210.928 2568.827 C 213.272 2568.827 215.17 2566.931 215.17 2564.585 C 215.17 2562.246 213.271 2560.343 210.928 2560.343 Z "></path></g></g></g></g></svg></div>
				<input disabled class="qt" type='number' value='${i.qtd}'>
				<div class="addItem"><svg xmlns="http://www.w3.org/2000/svg" fill="#800b58" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="12px" height="12px" viewBox="0 0 73.17 73.17" style="margin-top: 6px;enable-background:new 0 0 73.17 73.17;" xml:space="preserve">
				<g>
				<g id="Plus">
				<g>
				<path d="M68.928,32.343H40.827V4.243C40.827,1.903,38.928,0,36.585,0s-4.242,1.903-4.242,4.242v28.101H4.242 C1.9,32.343,0,34.246,0,36.585c0,2.347,1.9,4.242,4.242,4.242h28.101v28.1c0,2.349,1.899,4.242,4.242,4.242 s4.242-1.896,4.242-4.242v-28.1h28.101c2.344,0,4.242-1.896,4.242-4.242C73.17,34.246,71.271,32.343,68.928,32.343z"></path>
				</g>
				</g>
				</g>
				
				</svg></div>
				</span>
				<span>${i.nome}</span>
				<span p=${i.id} id='total'>
					${numberToReal(i.qtd * i.preco)}
				</span>
				${listaCmp}
			</div>
		`;
      } else if (i.comp) {
        var el = $("div.prod[p='" + i.id + "']");
        if (el.attr("comp") == i.comp) {
          el.attr("comp", i.comp).remove();
        }

        cmp = `comp="${i.comp}"`;
        listaCmp = `<ul class="itens__comp">`;
        for (let c of complementos) {
          if (c.comp == i.comp) {
            listaCmp += `
						<li class="clearfix">
							<div>+ ${c.nome}</div>
							<div class="cmvl-${i.comp}-${c.id_complemento}">${numberToReal(c.preco)}</div>
						</li>
					`;
          }
        }
        listaCmp += `</ul>`;

        var html = `
			<div class="itens clearfix prod" p=${i.id} ${cmp}>
				<span p="${i.id}" name="${i.nome}" price="${i.preco}" class="clearfix">
				<div class="remItem"><svg fill="#800b58" xmlns="http://www.w3.org/2000/svg" style="margin-top: 6px;" xmlns:xlink="http://www.w3.org/1999/xlink" style="isolation:isolate" viewBox="142 2560.343 73.17 8.484" width="12px" height="12px"><g><g><g><g><path fill="#800b58" d=" M 210.928 2560.343 L 182.827 2560.343 L 174.343 2560.343 L 146.242 2560.343 C 143.9 2560.343 142 2562.246 142 2564.585 C 142 2566.932 143.9 2568.827 146.242 2568.827 L 174.343 2568.827 L 182.827 2568.827 L 210.928 2568.827 C 213.272 2568.827 215.17 2566.931 215.17 2564.585 C 215.17 2562.246 213.271 2560.343 210.928 2560.343 Z "></path></g></g></g></g></svg></div>
				<input disabled class="qt" type='number' value='${i.qtd}'>
				<div class="addItem"><svg xmlns="http://www.w3.org/2000/svg" fill="#800b58" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="12px" height="12px" viewBox="0 0 73.17 73.17" style="margin-top: 6px;enable-background:new 0 0 73.17 73.17;" xml:space="preserve">
				<g>
				<g id="Plus">
				<g>
				<path d="M68.928,32.343H40.827V4.243C40.827,1.903,38.928,0,36.585,0s-4.242,1.903-4.242,4.242v28.101H4.242 C1.9,32.343,0,34.246,0,36.585c0,2.347,1.9,4.242,4.242,4.242h28.101v28.1c0,2.349,1.899,4.242,4.242,4.242 s4.242-1.896,4.242-4.242v-28.1h28.101c2.344,0,4.242-1.896,4.242-4.242C73.17,34.246,71.271,32.343,68.928,32.343z"></path>
				</g>
				</g>
				</g>
				
				</svg></div>
				</span>
				<span>${i.nome}</span>
				<span p=${i.id} id='total'>
					${numberToReal(i.qtd * i.preco)}
				</span>
				${listaCmp}
			</div>
		`;
      }
      $(".list-products").append(html);

      qtdAction = qtdAction + i.qtd;
    }

    if (verifyProds() > 0) {
      $(".carrinho-vazio").hide();
    }

    jQuery(".produtos__action span").text(qtdAction);
  }
}

function addProdAlert() {
  jQuery(".adicionarCarrinho").html("");
  jQuery(".adicionarCarrinho").html("<div>Produto adicionado ao carrinho</div>");
  jQuery(".adicionarCarrinho div").fadeIn(250).delay(1000).fadeOut(250);
}

function numberToReal(numero) {
  numero = parseFloat(numero);
  var numero = numero.toFixed(2).split(".");
  numero[0] = numero[0].split(/(?=(?:...)*$)/).join(".");

  return numero.join(",");
}

function getTotal() {
  if (localStorage.getItem("prods") != undefined && Object.keys(localStorage.getItem("prods")).length !== 0) {
    var obj = JSON.parse(Base64Decode(localStorage.getItem("prods")));
  }
  if (localStorage.getItem("complementos") != undefined && Object.keys(localStorage.getItem("complementos")).length !== 0) {
    var comp = JSON.parse(Base64Decode(localStorage.getItem("complementos")));
  }

  total = 0;
  if (obj) {
    for (let t of obj) {
      total += t.qtd * t.preco;
      for (let c of comp) {
        if (t.comp == c.comp) {
          total += t.qtd * parseFloat(c.preco);
          jQuery(".cmvl-" + c.comp + "-" + c.id_complemento).html(numberToReal(parseFloat(t.qtd * c.preco)));
        }
      }
    }
  }

  $("td#total").text("");
  return total;
}

function getProdTotal() {
  var obj = JSON.parse(Base64Decode(localStorage.getItem("prods")));

  total = 0;
  for (let t of obj) {
    total_prod += t.qtd;
  }

  return total_prod;
}

function getCadForm(client) {
  return (html = `
	<form id="form-finalizar-pedido" action="#" method="POST" class="finalizar__form clearfix">
		<h2 style="background-color: #800b58;color: #ffffff;font-size: 24px;padding: 6px 18px;" class="form-h2">CADASTRO</h2>
		<label class="form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 100%;">
			Nome<span>*</span>
			<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="nome" class="form" type="text" required />
		</label>
		<label class="form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 100%;">
			Sobrenome<span>*</span>
			<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="sobrenome" class="form" type="text" required />
		</label>
		<label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
			Whatsapp<span>*</span>
			<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="whatsapp" class="form" type="text"/>
		</label>
		<label class="form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 100%;">
			Email<span>*</span>
			<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="email" value="${client}" class="form" type="email"/>
		</label>
		<label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
			Data de nascimento<span>*</span>
			<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="nascimento" class="form" type="date"/>
		</label>
		<label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
			Sexo<span>*</span>
			<select style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="sexo">
				<option value="Masculino">Masculino</option>
				<option value="Feminino">Femininino</option>
			</select>
		</label>
		<label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
			CEP<span>*</span>
			<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="cep" max="9" class="form" type="text"/>
		</label>
		<label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
			Logradouro<span>*</span>
			<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="logradouro" class="form" value="" type="text"/>
		</label>
		<label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
			Bairro<span>*</span>
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
		<label>
			<input class="form-btn" id="enviarCadForm" type="button" value="CADASTRAR"/>
		</label>
	</form>
`);
}

function getEndForm(data, csrf, form = null, parameters = null) {
  var end = JSON.parse(localStorage.getItem("entrega"));

  var loja = JSON.parse(localStorage.getItem("loja_id"));

  var dtv = "";

  if (form == "pagamento" || form == "finalizar") {
    dtv = "desativado";
  }
  
  //else {
  return (html =
    `
	<form class="box__form clearfix" id="form-endereco" action="/delivery/identificacao/pagamento" method="POST">
		<form  id="form-enviar-endereco" action="/delivery/identificacao/pagamento" method="POST">
			<div class="finalizar__form ` +
    dtv +
    ` ">
				<h2>ENDEREÇO DE ENTREGA</h2>
				<input type="hidden" name="id" id="user-entrega" value="${data.id}" />
				<div class="finalizar__dados">
					<h3 id="nome-entrega">${data.nome}</h3>
					<span>Endereço:</span>
					<p>${end.logradouro}</p>
					<p>${end.bairro} - ${end.cidade} - ${end.uf}</p>
					<input type="hidden" name="_token" value="${csrf}"/>
					<input type="hidden" name="cep" value="${parseCEP(end.cep)}"/>
					<input type="hidden" name="cidade" value="${end.cidade}"/>
					<input type="hidden" name="logradouro" value="${end.logradouro}"/>
					<input type="hidden" name="estado" value="${end.uf}"/>
					<input type="hidden" name="nome" value="${data.nome}"/>
					<input type="hidden" name="id_loja" value="${loja.loja_id}" />
					<input type="hidden" name="email" value="${data.email}" />
				</div>
				<label class="g2">
					Número<span>*</span>
					<input id="numero-entrega" name="numero" class="form style-input" type="number"/>
				</label>
				<label class="g2">
				Compl. - Ex: ap xx
				<input id="compl-entrega" name="complemento" class="form style-input" type="text"/>
				</label>
				<label>
					Referência
					<input id="ref-entrega" name="referencia" class="form style-input" type="text"/>
				</label>
				<label>
					<input type="button" class="form-btn" id="prosseguir-pagamento" value="CONTINUAR" />
				</label>
			</div>
		</form>
` +
    getForms(dtv, form, csrf, parameters));
}

function getPayments(methods) {
  html = '<label for="Forma de pagamento">Forma de Pagamento:<select class="style-input" name="pagamento" id="forma-pagamento"></label>';

  for (let i in methods) {
    html += `<option value="${methods[i].get_payment_methods.id}">${methods[i].get_payment_methods.name_method}</option>`;
  }

  $("#select-forma-pagamento").append(html);
  $("#form-finalizar-pedido").fadeIn();
  $("#form-finalizar-pedido").css("display", "table");
}

function getComplements() {
  jQuery.get({
    type: "GET",
    url: "/delivery/product/complements",
    success: function (data) {
      for (let i of data) {
        var item = {
          id: i.id,
          name_complement: i.name_complement,
          price_complement: i.price_complement,
          product_id: i.product_id,
        };
        listaComplemento.push(item);
      }
    },
  });
  return listaComplemento;
}

function parseURL(str) {
  return str
    .normalize("NFD")
    .replace(" ", "-")
    .replace(/[\u0300-\u036f]/g, "")
    .replace(" ", "-")
    .toLowerCase();
}

function pesquisaScroll(texto) {
  jQuery("#produtos").val(texto);

  var scroll = jQuery('.item-p[pesquisa="' + parseURL(texto) + '"]').offset();

  jQuery("html, body").animate(
    {
      scrollTop: scroll.top - 140,
    },
    100
  );

  jQuery(".pesquisa-resultado").hide(100);

  jQuery(".pesquisa-resultado-mobile").hide(100);
}

function pesquisaScrollBtn(texto) {
  //var scroll = jQuery('.item-p[pesquisa="' + parseURL(texto) + '"]').offset();

  if (scroll != undefined) {
    document.location = "http://pedidos.tubaraodapraia.com.br/delivery/search=" + parseURL(texto);
    // jQuery('html,body').animate({
    // 	scrollTop: scroll.top - 140
    // }, 100);

    // jQuery('.pesquisa-resultado').hide(100);

    // jQuery('.pesquisa-resultado-mobile').hide(100);
  } else {
    alert("Não há produtos com o nome informado");
  }
}

function inicializacao(ID, tx) {
  // var id_loja = ID;
  // var data = {
  // 	loja_id: id_loja
  // };
  if (localStorage.getItem("prods") != undefined && Object.keys(localStorage.getItem("prods")).length !== 0) {
    var products = JSON.parse(Base64Decode(localStorage.getItem("prods")));
  }
  // var idEntrega = JSON.parse(localStorage.getItem("entrega"));

  // idEntrega.taxa = tx;

  // localStorage.setItem("entrega", JSON.stringify(idEntrega));

  // idEntrega = JSON.parse(localStorage.getItem("entrega"));

  if (localStorage.getItem("complementos") != undefined && Object.keys(localStorage.getItem("complementos")).length !== 0) {
    var complementos = JSON.parse(Base64Decode(localStorage.getItem("complementos")));
  }

  getComboVariations();

  // localStorage.setItem("loja_id", JSON.stringify(data));

  // var idStorage = JSON.parse(localStorage.getItem("loja_id"));

  if (!complementos) {
    var complementos = [];
    localStorage.setItem("complementos", Base64Encode(JSON.stringify(complementos)));
  }
  if (products == undefined) {
    var products = [];
    localStorage.setItem("prods", Base64Encode(JSON.stringify(products)));
    console.log(products);
  }

  // if (products !== null) {

  // 	// if (id_loja != idStorage.loja_id) {

  // 	localStorage.removeItem("prods");

  // 	// }

  // }

  if (products != null) {
    // if (id_loja == idStorage.loja_id) {

    initItems(products);
    bugAux = true;

    // }
  }

  getVariations();

  total = 0;
  total_prod = 0;

  if (Object.keys(products).length !== 0) {
    for (let i of products) {
      var cmp = "";
      var listaCmp = "";
      if (i.comp) {
        cmp = `comp="${i.comp}"`;
        listaCmp = `<ul class="itens__comp">`;
        for (let c of complementos) {
          if (c.comp == i.comp) {
            listaCmp += `
						<li class="clearfix">
							<div>+ ${c.nome}</div>
							<div class="cmvl-${i.comp}-${c.id_complemento}">${numberToReal(c.preco)}</div>
						</li>
					`;
          }
        }
        listaCmp += `</ul>`;
        complTotal++;
      }

      if (i.id_var) {
        var html = `
				<div class="itens clearfix prod" p-var=${i.id_var} ${cmp}>
					<span p="${i.id}" name="${i.nome}" price="${i.preco}" class="clearfix">
					<div var="${
            i.id_var
          }" class="remItem"><svg fill="#800b58" style="margin-top: 6px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="isolation:isolate" viewBox="142 2560.343 73.17 8.484" width="12px" height="12px"><g><g><g><g><path fill="#800b58" d=" M 210.928 2560.343 L 182.827 2560.343 L 174.343 2560.343 L 146.242 2560.343 C 143.9 2560.343 142 2562.246 142 2564.585 C 142 2566.932 143.9 2568.827 146.242 2568.827 L 174.343 2568.827 L 182.827 2568.827 L 210.928 2568.827 C 213.272 2568.827 215.17 2566.931 215.17 2564.585 C 215.17 2562.246 213.271 2560.343 210.928 2560.343 Z "></path></g></g></g></g></svg></div>
					<input disabled class="qt" type='number' value='${i.qtd}'>
					<div var="${
            i.id_var
          }" class="addItem"><svg xmlns="http://www.w3.org/2000/svg" fill="#800b58" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="12px" height="12px" viewBox="0 0 73.17 73.17" style="margin-top: 6px;enable-background:new 0 0 73.17 73.17;" xml:space="preserve">
					<g>
					<g id="Plus">
					<g>
					<path d="M68.928,32.343H40.827V4.243C40.827,1.903,38.928,0,36.585,0s-4.242,1.903-4.242,4.242v28.101H4.242 C1.9,32.343,0,34.246,0,36.585c0,2.347,1.9,4.242,4.242,4.242h28.101v28.1c0,2.349,1.899,4.242,4.242,4.242 s4.242-1.896,4.242-4.242v-28.1h28.101c2.344,0,4.242-1.896,4.242-4.242C73.17,34.246,71.271,32.343,68.928,32.343z"></path>
					</g>
					</g>
					</g>
					
					</svg></div>
					</span>
					<span>${i.nome}</span>
					<span p=${i.id} id='total'>
						${numberToReal(i.qtd * i.preco)}
					</span>
					${listaCmp}
				</div>
				`;
      } else if (i.comboVars) {
        var html = `
			<div class="itens clearfix prod" p-combo=${i.id}">
			<span p="${i.id}" name="${i.nome}" price="${i.preco}" class="clearfix">
				<div class="remItem" comboVar="${JSON.stringify(
          i.comboVars
        )}"><svg fill="#800b58" style="margin-top: 6px;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="isolation:isolate" viewBox="142 2560.343 73.17 8.484" width="12px" height="12px"><g><g><g><g><path fill="#800b58" d=" M 210.928 2560.343 L 182.827 2560.343 L 174.343 2560.343 L 146.242 2560.343 C 143.9 2560.343 142 2562.246 142 2564.585 C 142 2566.932 143.9 2568.827 146.242 2568.827 L 174.343 2568.827 L 182.827 2568.827 L 210.928 2568.827 C 213.272 2568.827 215.17 2566.931 215.17 2564.585 C 215.17 2562.246 213.271 2560.343 210.928 2560.343 Z "></path></g></g></g></g></svg></div>
					<input disabled class="qt" type='number' value='${i.qtd}'>
				<div class="addItem" comboVar="${JSON.stringify(
          i.comboVars
        )}"><svg xmlns="http://www.w3.org/2000/svg" fill="#800b58" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="12px" height="12px" viewBox="0 0 73.17 73.17" style="margin-top: 6px;enable-background:new 0 0 73.17 73.17;" xml:space="preserve">
				<g>
				<g id="Plus">
				<g>
				<path d="M68.928,32.343H40.827V4.243C40.827,1.903,38.928,0,36.585,0s-4.242,1.903-4.242,4.242v28.101H4.242 C1.9,32.343,0,34.246,0,36.585c0,2.347,1.9,4.242,4.242,4.242h28.101v28.1c0,2.349,1.899,4.242,4.242,4.242 s4.242-1.896,4.242-4.242v-28.1h28.101c2.344,0,4.242-1.896,4.242-4.242C73.17,34.246,71.271,32.343,68.928,32.343z"></path>
				</g>
				</g>
				</g>
				
				</svg></div>
				</span>
				<span>${i.nome}</span>
				<span p=${i.id} id='total'>
					${numberToReal(parseFloat(i.qtd * i.preco))}
				</span>
			</div>
			`;
      } else {
        var html = `
				<div class="itens clearfix prod" p=${i.id} ${cmp}>
					<span p="${i.id}" name="${i.nome}" price="${i.preco}" class="clearfix">
					<div class="remItem"><svg fill="#800b58" xmlns="http://www.w3.org/2000/svg" style="margin-top: 6px;" xmlns:xlink="http://www.w3.org/1999/xlink" style="isolation:isolate" viewBox="142 2560.343 73.17 8.484" width="12px" height="12px"><g><g><g><g><path fill="#800b58" d=" M 210.928 2560.343 L 182.827 2560.343 L 174.343 2560.343 L 146.242 2560.343 C 143.9 2560.343 142 2562.246 142 2564.585 C 142 2566.932 143.9 2568.827 146.242 2568.827 L 174.343 2568.827 L 182.827 2568.827 L 210.928 2568.827 C 213.272 2568.827 215.17 2566.931 215.17 2564.585 C 215.17 2562.246 213.271 2560.343 210.928 2560.343 Z "></path></g></g></g></g></svg></div>
						<input disabled class="qt" type='number' value='${i.qtd}'>
					<div class="addItem"><svg xmlns="http://www.w3.org/2000/svg" fill="#800b58" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="12px" height="12px" viewBox="0 0 73.17 73.17" style="margin-top: 6px;enable-background:new 0 0 73.17 73.17;" xml:space="preserve">
					<g>
					<g id="Plus">
					<g>
					<path d="M68.928,32.343H40.827V4.243C40.827,1.903,38.928,0,36.585,0s-4.242,1.903-4.242,4.242v28.101H4.242 C1.9,32.343,0,34.246,0,36.585c0,2.347,1.9,4.242,4.242,4.242h28.101v28.1c0,2.349,1.899,4.242,4.242,4.242 s4.242-1.896,4.242-4.242v-28.1h28.101c2.344,0,4.242-1.896,4.242-4.242C73.17,34.246,71.271,32.343,68.928,32.343z"></path>
					</g>
					</g>
					</g>
					
					</svg></div>
					</span>
					<span>${i.nome}</span>
					<span p=${i.id} id='total'>
						${numberToReal(i.qtd * i.preco)}
					</span>
					${listaCmp}
				</div>
				`;
      }
      $(".list-products").append(html);
    }
  }

  for (let t of products) {
    total += t.qtd * t.preco;
  }

  for (let t of products) {
    total_prod += t.qtd;
  }

  jQuery(".produtos__action span").text(total_prod);
  vlTotal = getTotal();
  $("span#subtotal-carrinho").text(numberToReal(vlTotal));

  // var taxa = parseFloat(idEntrega.taxa);
  $("#tx-entrega").text(numberToReal(0));

  $("span#total-carrinho").text(numberToReal(vlTotal));

  // jQuery('.end-prev').html(idEntrega.logradouro + " - " + idEntrega.bairro + "<br/>" + idEntrega.cidade + "/" + idEntrega.uf);

  jQuery(".item-p").each(function () {
    var produto = jQuery(this).attr("pesquisa");
    jQuery(".pesquisa-resultado").append("<li" + " onclick=" + "'onClickFunctionAlter()'" + ">" + replaceAll(produto, "-", " ") + "</li>");
    jQuery(".pesquisa-resultado-mobile").append("<li>" + replaceAll(produto, "-", " ") + "onclick=" + "'onClickFunctionAlter()'" + "</li>");
  });

  if (Object.keys(products).length != 0) {
    $(".carrinho-vazio").css("display", "none");
  }
}

function onClickFunctionAlter() {
  var btn = document.getElementById("botaoPesquisarIndex");
  btn.click();
}

function replaceAll(str, find, replace) {
  return str.replace(new RegExp(find, "g"), replace);
}

function initItems(data) {
  console.log(data);
  for (let i of data) {
    if (i.comp) {
      var item = {
        id: i.id,
        nome: i.nome,
        preco: parseFloat(i.preco),
        qtd: i.qtd,
        comp: i.comp,
        tf: 1,
      };
    } else if (i.comboVars) {
      var item = {
        id: i.id,
        comboVars: i.comboVars,
        nome: i.nome,
        preco: parseFloat(i.preco),
        qtd: i.qtd,
        tf: 0,
      };
    } else if (i.id_var) {
      var item = {
        id: i.id,
        nome: i.nome,
        id_var: i.id_var,
        preco: parseFloat(i.preco),
        qtd: i.qtd,
        tf: 0,
      };
    } else {
      var item = {
        id: i.id,
        nome: i.nome,
        preco: parseFloat(i.preco),
        qtd: i.qtd,
        tf: 0,
      };
    }
    items.push(item);
    // console.log(items);
  }
}

function pegarData() {
  var now = new Date();
  var day = ("0" + now.getDate()).slice(-2);
  var month = ("0" + (now.getMonth() + 1)).slice(-2);
  return now.getFullYear() + "-" + month + "-" + day;
}

function pegarHora() {
  var now = new Date();
  var hour = now.getHours();
  var mint = now.getMinutes();
  return hour + ":" + mint;
}

function definirHorarios(timeIni, timeFin) {
  var hour = jQuery("#agendar-hora");
  var date = jQuery("#agendar-data");
  hour.attr("min", timeIni);
  hour.attr("max", timeFin);

  var today = pegarData();
  date.val(today);
}

function agendamento() {
  var time = jQuery("#agendar-hora").val();
  jQuery("p.erromsg").remove();
  if (time) {
    var min = jQuery("#agendar-hora").attr("min");
    var max = jQuery("#agendar-hora").attr("max");
    var data = jQuery("#agendar-data").val();

    var timeSplit = time.split(":");
    var minSplit = min.split(":");
    var maxSplit = max.split(":");

    var abertura = new Date(2018, 01, 01, minSplit[0], minSplit[1]);
    var fechamento = new Date(2018, 01, 01, maxSplit[0], maxSplit[1]);
    var agendamento = new Date(2018, 01, 01, timeSplit[0], timeSplit[1]);

    if (abertura > fechamento) {
      fechamento.setDate(fechamento.getDate() + 1);
      if (agendamento < abertura) {
        agendamento.setDate(agendamento.getDate() + 1);
      }
    }

    if (agendamento >= abertura && agendamento <= fechamento) {
      var agendamento = {
        data: data,
        time: time,
        status: "agd",
      };

      var obs = jQuery("#obs").val();
      localStorage.setItem("obs", obs);

      localStorage.setItem("agendamento_pedido", JSON.stringify(agendamento));
      window.location = "/delivery/identificacao";
    } else {
      jQuery("#agendar-hora").after("<p class='erromsg'>Não realizamos entregas nesse horário</p>");
    }
  } else {
    jQuery("#agendar-hora").after("<p class='erromsg'>Você não preencheu o horário</p>");
  }
}

function removeItem(item) {
  for (i = 0; i < items.length; i++) {
    if (items[i].id == item) {
      var listAux = items.slice(0, i);
      var listAuxEnd = items.slice(i + 1);
      return (items = listAux.concat(listAuxEnd));
    }
  }
  return false;
}

function removeComp(complemento, localId) {
  for (i = 0; i < localId.length; i++) {
    if (localId[i].comp == complemento) {
      var listAux = localId.slice(0, i);
      var listAuxEnd = localId.slice(i + 1);
      return (items = listAux.concat(listAuxEnd));
    }
  }
  return false;
}

function removeCompList(comp, compLista) {
  complementos = removerPorIndex(compLista, comp);

  if (complementos) {
    return complementos;
  }

  return false;
}

function removerPorIndex(array, comp) {
  return array.filter(function (el) {
    return el.comp !== comp;
  });
}

function removerPorVar(array, id) {
  return array.filter(function (el) {
    return el.id_var !== id;
  });
}

function removeItem2(item) {
  for (i = 0; i < items.length; i++) {
    if (items[0][i] == item) {
      var listAux = items[0].slice(0, i);
      var listAuxEnd = items[0].slice(i + 1);
      return (items = listAux.concat(listAuxEnd));
    }
  }
  return false;
}

function removeVarItem(item) {
  for (i = 0; i < items.length; i++) {
    if (items[i].id_var == item) {
      var listAux = items.slice(0, i);
      var listAuxEnd = items.slice(i + 1);
      return (items = listAux.concat(listAuxEnd));
    }
  }
  return false;
}

function adicionarProdutoVariavel(id, idVar, idEntrega, qtd, name, price, prods) {
  qtd = parseInt(qtd);
  if (qtd != 0) {
    if (prods != null) {
      for (let i of prods) {
        if (i.id_var == idVar) {
          qtd += parseInt(i.qtd);
          items = removerPorVar(prods, idVar);
          //removeVarItem(idVar);
        }
      }
    }

    var data = {
      id: id,
      id_var: idVar,
      nome: name,
      preco: parseFloat(price),
      qtd: qtd,
      tf: 0,
    };

    items.push(data);
    localStorage.setItem("prods", Base64Encode(JSON.stringify(items)));
    addToCart();

    vlTotal = getTotal();
    // var taxa = parseInt(idEntrega.taxa);
    $("span#subtotal-carrinho").text(numberToReal(vlTotal));
    $("span#total-carrinho").text(numberToReal(vlTotal));
  }
}

function adicionarProduto(id, qtd, nome, preco, localId, idEntrega) {
  if (qtd != 0) {
    if (localId != null) {
      for (let i of localId) {
        if (i.id == id) {
          qtd += parseInt(i.qtd);
          removeItem(id);
        }
      }
    }

    var data = {
      id: id,
      nome: nome,
      preco: parseFloat(preco),
      qtd: qtd,
      tf: 0,
    };

    items.push(data);

    localStorage.setItem("prods", Base64Encode(JSON.stringify(items)));

    addToCart();

    vlTotal = getTotal();

    // var taxa = parseInt(idEntrega.taxa);

    $("span#subtotal-carrinho").text(numberToReal(vlTotal));

    $("span#total-carrinho").text(numberToReal(vlTotal));
  }
}

function adicionarQtProdVar(idVar, idEntrega, el, form, localId) {
  var name = "";
  var id = "";
  var price = 0;
  var qtd = 0;

  for (let i of localId) {
    if (items != null) {
      if (i.id_var == idVar) {
        id = i.id;
        name = i.nome;
        price = i.preco;

        qtd = parseInt(i.qtd + 1);
      }
    }
  }

  items = removerPorVar(localId, idVar);

  var data = {
    id: id,
    id_var: idVar,
    nome: name,
    preco: parseFloat(price),
    qtd: qtd,
    tf: 0,
  };

  var qtdAction = 0;

  for (let i of localId) {
    qtdAction += i.qtd;
  }

  jQuery(".produtos__action span").text(qtdAction - 1);

  if (qtd == 0) {
    el.parent().html("");
    localStorage.setItem("prods", Base64Encode(JSON.stringify(items)));

    vlTotal = getTotal();
    // var taxa = parseInt(idEntrega.taxa);

    $("span#subtotal-carrinho").text(numberToReal(vlTotal));
    $("span#total-carrinho").text(numberToReal(vlTotal));

    return;
  } else {
    form.val(qtd);
    vl = parseFloat(price) * qtd;
    el.next().next().text(numberToReal(vl));
  }

  items.push(data);

  localStorage.setItem("prods", Base64Encode(JSON.stringify(items)));

  vlTotal = getTotal();

  $('.remItem[var="' + idVar + '"]')
    .next()
    .val(qtd);
  // var taxa = parseInt(idEntrega.taxa);

  $("span#subtotal-carrinho").text(numberToReal(vlTotal));
  $("span#total-carrinho").text(numberToReal(vlTotal));
}

function removerQtProdVar(idVar, idEntrega, el, form, localId) {
  var name = "";
  var id = "";
  var price = 0;
  var qtdMob = jQuery(".produtos__action span").text();
  var qtd = 0;
  for (let i of localId) {
    if (items != null) {
      if (i.id_var == idVar) {
        id = i.id;
        name = i.nome;
        price = i.preco;
        qtd = parseInt(i.qtd - 1);
      }
    }
  }
  items = removerPorVar(localId, idVar);

  var data = {
    id: id,
    id_var: idVar,
    nome: name,
    preco: parseFloat(price),
    qtd: qtd,
    tf: 0,
  };

  var qtdAction = 0;

  for (let i of localId) {
    qtdAction += i.qtd;
  }

  jQuery(".produtos__action span").text(qtdAction - 1);

  if (qtd == 0) {
    el.parent().html("");
    localStorage.setItem("prods", Base64Encode(JSON.stringify(items)));

    vlTotal = getTotal();
    // var taxa = parseInt(idEntrega.taxa);

    // items.push(data);

    $("span#subtotal-carrinho").text(numberToReal(vlTotal));
    $("span#total-carrinho").text(numberToReal(vlTotal));

    if ($(".itens").length == 0) {
      $(".carrinho-vazio").show();
    }

    $('.prod[p-var="' + idVar + '"]').remove();

    return;
  } else {
    form.val(qtd);
    vl = parseFloat(price) * qtd;
    el.next().next().text(numberToReal(vl));
  }

  items.push(data);

  localStorage.setItem("prods", Base64Encode(JSON.stringify(items)));

  vlTotal = getTotal();
  // var taxa = parseInt(idEntrega.taxa);

  if ($(".itens").length == 0) {
    $(".carrinho-vazio").show();
  }

  $('.remItem[var="' + idVar + '"]')
    .next()
    .val(qtd);

  $("span#subtotal-carrinho").text(numberToReal(vlTotal));
  $("span#total-carrinho").text(numberToReal(vlTotal));
  jQuery(".produtos__action span").text(qtdMob - qtd);
}

function removerQt(el, form, localId, idEntrega, id, compId, complementosList, comboVars = null) {
  var comp = false;
  var qtdMob = $(".produtos__action span").text();

  for (let i of localId) {
    if (i.qtd != 0) {
      if (localId != null) {
        if (i.id == id) {
          nome = i.nome;
          preco = i.preco;
          if (compId) {
            if (i.comp == compId) {
              comp = i.comp;

              qtd = parseInt(i.qtd - 1);
            }
          } else {
            qtd = parseInt(i.qtd - 1);
          }
        }
      }
    }
  }

  if (comp) {
    removeComp(comp, localId);
    var data = {
      id: id,
      nome: nome,
      preco: parseFloat(preco),
      qtd: qtd,
      comp: comp,
      tf: 1,
    };
  } else if (comboVars != null) {
    removeItem(id);

    var data = {
      id: id,
      comboVars: comboVars,
      nome: nome,
      preco: parseFloat(preco),
      qtd: qtd,
      tf: 0,
    };
  } else {
    removeItem(id);
    var data = {
      id: id,
      nome: nome,
      preco: parseFloat(preco),
      qtd: qtd,
      tf: 0,
    };
  }

  if (qtd == 0) {
    el.parent().html("");

    localStorage.setItem("prods", Base64Encode(JSON.stringify(items)));

    vlTotal = getTotal();

    // var taxa = parseInt(idEntrega.taxa);

    $("span#subtotal-carrinho").text(numberToReal(vlTotal));

    $("span#total-carrinho").text(numberToReal(vlTotal));

    if ($(".itens").length == 1) {
      $(".carrinho-vazio").show();
    }

    if (comp) {
      $('.prod[comp="' + comp + '"]').remove();
    } else if (comboVars != null) {
      $('.prod[p-combo="' + id + '"]').remove();
    } else {
      $('.prod[p="' + id + '"]').remove();
    }

    jQuery(".produtos__action span").text(qtdMob - 1);
    return;
  } else {
    form.val(qtd);
    vl = parseFloat(preco) * qtd;
    el.next().next().text(numberToReal(vl));
  }

  var qtdAction = 0;

  for (let i of localId) {
    qtdAction += i.qtd;
  }

  jQuery(".produtos__action span").text(qtdAction + 1);

  vl = parseFloat(preco) * qtd;

  el.next().next().text(numberToReal(vl));

  items.push(data);

  localStorage.setItem("prods", Base64Encode(JSON.stringify(items)));

  vlTotal = getTotal();

  $('span[p="' + id + '"] .qt').val(qtd);

  // var taxa = parseInt(idEntrega.taxa);

  $("span#subtotal-carrinho").text(numberToReal(vlTotal));

  $("span#total-carrinho").text(numberToReal(vlTotal));

  jQuery(".produtos__action span").text(qtdMob - 1);
}

function adicionarQt(el, form, id, localId, idEntrega, compId, comboVars = null) {
  var comp = false;
  for (let i of localId) {
    if (i.qtd != 0) {
      if (localId != null) {
        //for(let lId of localId){
        if (i.id == id) {
          nome = i.nome;
          preco = i.preco;
          if (compId) {
            if (i.comp == compId) {
              comp = i.comp;
              qtd = parseInt(i.qtd + 1);
            }
          } else {
            qtd = parseInt(i.qtd + 1);
          }
        }
        //}
      }
    }
  }
  if (comp) {
    removeComp(comp, localId);
    var data = {
      id: id,
      nome: nome,
      preco: parseFloat(preco),
      qtd: qtd,
      comp: comp,
      tf: 1,
    };
  } else if (comboVars != null) {
    removeItem(id);
    var data = {
      id: id,
      nome: nome,
      preco: parseFloat(preco),
      qtd: qtd,
      comboVars: comboVars,
      tf: 0,
    };
  } else {
    removeItem(id);
    var data = {
      id: id,
      nome: nome,
      preco: parseFloat(preco),
      qtd: qtd,
      tf: 0,
    };
  }

  form.prev().val(qtd);

  vl = parseFloat(preco) * qtd;

  el.next().next().text(numberToReal(vl));

  items.push(data);

  $('span[p="' + id + '"] .qt').val(qtd);

  localStorage.setItem("prods", Base64Encode(JSON.stringify(items)));

  vlTotal = getTotal();
  // var taxa = parseInt(idEntrega.taxa);

  $("span#subtotal-carrinho").text(numberToReal(vlTotal));
  $("span#total-carrinho").text(numberToReal(vlTotal));

  var qtdAction = 0;
  for (let i of localId) {
    qtdAction += i.qtd;
  }

  jQuery(".produtos__action span").text(qtdAction + 1);
}

function complementosModal(id, qtd, nome, preco, checkbox, obj, comps) {
  if (comps != null) {
    for (let c of comps) {
      for (let t of obj) {
        if (c == t.id) {
          checkbox += `
    			<label class="checkbox-style" price="${t.price_complement}" name="${t.name_complement}" id="${t.id}" product="${id}">
        			<input class="checkbox-item" type="checkbox"/>
					<span class="name">${t.name_complement}</span>
					<span price="${t.price_complement}" class="price">${numberToReal(t.price_complement)}</span>
				</label>
			`;
        }
      }
    }

    var conteudo = `
	<p class="nm-produto clearfix">
	${nome}
		<span class="compl-price-prod" price="${preco}" style="float: right;">${numberToReal(preco)}</span>
		</p>
	<div class="escolher__conteudo" id="${id}" name="${nome}" price="${preco}">
	${checkbox}
	</div>
`;

    $(".op").html("");

    if ($(".add-comp").length < 1) {
      $(".escolher .conteudo").append('<input style="background-image: url(img/continuar.png);" class="add-comp" value="Continuar" type="button"></input>');
    }
    jQuery(".escolher .conteudo .op").append(conteudo);
  }
}

function adicionarComplemento(produtosLista, complementosLista) {
  var nomeProduto = jQuery(".escolher__conteudo").attr("name");
  var idProduto = jQuery(".escolher__conteudo").attr("id");
  var preco = jQuery(".escolher__conteudo").attr("price");

  for (let c of complementosLista) {
    if (c.comp >= complTotal) {
      complTotal = c.comp;
    }
  }
  complTotal++;

  var listaCmp = "";
  var tf = 0;
  jQuery(".checkbox-style").each(function () {
    if (jQuery(this).children("input[type=checkbox]").prop("checked")) {
      var produto = jQuery(this).attr("product");

      var id = jQuery(this).attr("id");

      var preco = jQuery(this).attr("price");

      var nome = jQuery(this).attr("name");

      tf = 1;

      var item = {
        id_produto: produto,
        id_complemento: id,
        preco: preco,
        nome: nome,
        comp: complTotal,
        tf: 1,
      };

      complementosLista.push(item);

      listaCmp += `
			<li class="clearfix">
				<div>+ ${nome}</div>
				<div class="cmvl-${complTotal}-${id}">${numberToReal(preco)}</div>
			</li>
		`;
    }
  });
  if (listaCmp !== "") {
    ulItens = `
		<ul class="itens__comp">
			${listaCmp}
		</ul>
	`;
  } else {
    ulItens = "";
  }

  localStorage.setItem("complementos", Base64Encode(JSON.stringify(complementosLista)));

  var html = `
	<div class="itens clearfix prod" p=${idProduto} comp="${complTotal}">
		<span p="${idProduto}" name="${nomeProduto}" price="${preco}" class="clearfix">
			<div class="addItem">+</div>
			<input disabled class="qt" type='number' value='1'>
			<div class="remItem">-</div>
		</span>
		<span>${nomeProduto}</span>
		<span p=${idProduto} id='total'>
			${numberToReal(parseFloat(preco))}
		</span>

		<ul class="itens__comp">
			${ulItens}
		</ul>
	</div>
`;

  var item = {
    id: idProduto,
    nome: nomeProduto,
    preco: parseFloat(preco),
    qtd: 1,
    comp: complTotal,
    tf: tf,
  };
  produtosLista.push(item);
  items.push(item);
  localStorage.setItem("prods", Base64Encode(JSON.stringify(produtosLista)));

  $(".list-products").append(html);

  vlTotal = getTotal();
  $("span#subtotal-carrinho").text(numberToReal(vlTotal));
  var idEntrega = JSON.parse(localStorage.getItem("entrega"));
  // var taxa = parseFloat(idEntrega.taxa);
  // $('#tx-entrega').text(numberToReal(taxa));

  $("span#total-carrinho").text(numberToReal(vlTotal));

  var qtdAction = 0;
  for (let i of produtosLista) {
    qtdAction += i.qtd;
  }

  if (verifyProds() >= 1) {
    $(".carrinho-vazio").hide();
  }

  jQuery(".produtos__action span").text(qtdAction);

  jQuery(".escolher").fadeOut(100);
}

function getVariationsModal(id) {
  var today = new Date();
  var dd = today.getDay();

  $("#var-modal").remove();

  console.log(variations);

  var html = `
<div id="var-modal" class="escolher ativo">

	<div class="bg"></div>

	<div class="conteudo">

		<div class="x">X</div>
			<p>
			Escolha o produto:
			</p>
			<form class="escolher-form-overflow">`;
  for (let i of variations[0]) {
    if (i.prod_id == id && i.prod_var_status == "1") {
      html += `<div class="produto-variavel">
						<div class="produto-variavel__item">
						<span>${i.prod_var_name}</span> `;
      if (i.prod_var_promo_day == dd) {
        html += `<span class="preco">${i.prod_var_promo_price}</span>`;
      } else {
        html += `<span class="preco">${i.prod_var_price}</span>`;
      }

      if (i.prod_var_promo_day == dd) {
        html += `</div>
						<div class="produto-variavel__qt">
						<div id-var="${i.id}" class="remVarItem">-</div>
						<input class="qt qt-variation" id="qt-variation" name="${i.prod_var_name}"
						id-var="${i.id}" price="${i.prod_var_promo_price}" id-prod="${i.prod_id}" type="number" value="0">
						<div id-var="${i.id}" class="addVarItem">+</div>
						</div>
					</div>`;
      } else {
        html += `</div>
						<div class="produto-variavel__qt">
						<div id-var="${i.id}" class="remVarItem">-</div>
						<input class="qt qt-variation" id="qt-variation" name="${i.prod_var_name}"
						id-var="${i.id}" price="${i.prod_var_price}" id-prod="${i.prod_id}" type="number" value="0">
						<div id-var="${i.id}" class="addVarItem">+</div>
						</div>
					</div>`;
      }
    }
  }

  html += `
			</form>
				<input style="background-image: url({{ asset('/img/continuar.png') }}" class="btn" id="addVarProd" value="Adicionar" type="button"/>
	</div>
</div>
`;

  $("body").append(html);
}

function getVariations() {
  $.ajax({
    url: "/delivery/loja/produto/variacoes",
    method: "GET",
    success: function (response) {
      variations.push(response);
    },
    error: function (response) {},
  });
}

function getComboVariations() {
  $.ajax({
    url: "/delivery/loja/produto/comboVariacoes",
    method: "GET",
    success: function (response) {
      for (let r of response) {
        comboVariations.push(r);
      }
    },
    error: function (response) {
      console.log("Erro");
    },
  });
}

function getComboModal(id, nomeProduto, preco) {
  var lsCat = 0;
  var conteudo = "";
  var checkbox = "";
  var idsPassados = [];
  $(".escolher .conteudo .op").html("");
  c = [];
  conteudo += `
   
    <p class="nm-produto clearfix">
        <span class="compl-price-prod" price="${preco}" style="float: right;">${numberToReal(preco)}</span>
    `;
  for (let cv of comboVariations) {
    console.log(cv);
    checkbox = "";
    if (cv.cat_id != lsCat && cv.prod_id == id) {
      if (cv.get_category.name_category == "Pizzas Grandes" && cv.num_esc == "2")
        if (cv.get_category.name_category) {
          $(document.body).on("change", ".checkbox-combo-item", function () {
            var preco = parseInt(jQuery(".nm-produto span").attr("price"));
            let arrayPizza = [];
            jQuery(".escolher__conteudo label").each(function () {
              if (jQuery(this).children("input[type=checkbox]").prop("checked")) {
                preco += parseInt(jQuery(this).children(".price").attr("price"));
              }
            });
            jQuery(".nm-produto span").text(numberToReal(preco));
          });
        }

      conteudo += `
				${cv.get_category.name_category}
					<p>Selecione até <span class="quantidade-combo" name="${cv.variation_name}">${cv.num_esc}</span> ${cv.get_category.name_category} de sua preferência</p>
				`;
      lsCat = cv.cat_id;
      if (cv.get_category.name_category) {
      }
    }
    if (cv.cat_id == lsCat && idsPassados.indexOf(cv.id) == -1 && cv.prod_id == id) {
      checkbox += `
				<label class="checkbox-style" price="${cv.price_product}" name="${cv.variation_name}" id="${cv.variation_name + "-" + cv.cat_id}" product="${id}">
					<input onchange='checkLimit(${cv.num_esc}, "${cv.cat_id}");' price="${cv.price_product}" class="checkbox-combo-item ${cv.variation_name}" num_esc="${cv.num_esc}" name="${cv.variation_name}" cat_id="${
        cv.cat_id
      }" type="checkbox" value="${cv.id}"/>
					<span class="name">${cv.name_product}</span>
					<span price="${cv.price_product}" class="price">${numberToReal(cv.price_product)}</span>
				</label>
				`;
      if (verCombo[cv.cat_id] == undefined) {
        verCombo[cv.cat_id] = cv.num_esc;
      }

      idsPassados.push(cv.id);
      conteudo += `</p>
			<div class="escolher__conteudo" id="1" name="a" price="a">
			${checkbox}
			</div>
		`;
    }
  }
  console.log("${nomeProduto}");
  conteudo += `
	<button prod_id="${id}" prod_name="${nomeProduto}" class="btn" prod_price="${preco}" id="add-combo">adicionar</button>
	`;
  if (conteudo != "") {
    jQuery(".escolher .conteudo .op").append(conteudo);
  }

  if ($(".add-comp").length == 1) {
    $(".add-comp").remove();
  }

  $(".escolher").show();
  // $('.op').html('');

  // if ($('.add-comp').length < 1) {

  // 	$('.escolher .conteudo').append('<input style="background-image: url(img/continuar.png);" class="add-comp" value="Continuar" type="button"></input>');

  // }
}

function verifyCombo(combo) {
  var bool = true;
  for (let v in verCombo) {
    if (combo[v] == undefined || combo[v] > verCombo[v] || combo[v] == 0) {
      bool = false;
    }
  }
  return bool;
}

function addComboProduct(produtosLista, ids, idProduto, nomeProduto, preco) {
  var item = {
    id: idProduto,
    nome: nomeProduto,
    preco: parseFloat(preco),
    qtd: 1,
    comboVars: JSON.stringify(ids),
    tf: 0,
  };
  console.log(item);
  // var html = `
  // <div class="itens clearfix prod" p=${idProduto}">
  // 	<span p="${idProduto}" name="${nomeProduto}" price="${preco}" class="clearfix">
  // 		<div class="addItem" comboVar='${JSON.stringify(ids)}'>+</div>
  // 		<input disabled class="qt" type='number' value='1'>
  // 		<div class="remItem" comboVar='${JSON.stringify(ids)}'>-</div>
  // 	</span>
  // 	<span>${nomeProduto}</span>
  // 	<span p=${idProduto} id='total'>
  // 		${numberToReal(parseFloat(preco))}
  // 	</span>
  // </div>
  // `;

  produtosLista.push(item);

  items.push(item);

  localStorage.setItem("prods", Base64Encode(JSON.stringify(items)));
  addToCart();
  // $('.list-products').append(html);

  vlTotal = getTotal();

  $("span#subtotal-carrinho").text(numberToReal(vlTotal));

  var idEntrega = JSON.parse(localStorage.getItem("entrega"));

  // var taxa = parseFloat(idEntrega.taxa);

  // $('#tx-entrega').text(numberToReal(taxa));

  $("span#total-carrinho").text(numberToReal(vlTotal));

  var qtdAction = 0;

  for (let i of produtosLista) {
    qtdAction += i.qtd;
  }

  if (verifyProds() >= 1) {
    $(".carrinho-vazio").hide();
  }

  jQuery(".produtos__action span").text(qtdAction);

  $(".escolher .conteudo .op").html("");

  jQuery(".escolher").fadeOut(100);
}
