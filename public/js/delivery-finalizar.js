var items = [];



total = 0;



total_prod = 0;



function Base64Encode(str, encoding = 'utf-8') {

    var bytes = new (TextEncoder || TextEncoderLite)(encoding).encode(str);

    return base64js.fromByteArray(bytes);

}



function Base64Decode(str, encoding = 'utf-8') {

    var bytes = base64js.toByteArray(str);

    return new (TextDecoder || TextDecoderLite)(encoding).decode(bytes);

}



function validateDataCadForm(data) {

    if ($('#form-cadastrar-usuario input[name="nome"]').val().length === 0) {

        alert("Campo nome não preenchido");

        return false;

    } else if (!validateEmail($('#form-cadastrar-usuario input[name="email"]').val())) {

        alert("Campo email não preenchido ou email inválido");

        return false;

    } else if ($('#form-cadastrar-usuario input[name="nascimento"]').val().length === 0) {

        alert("Campo data de nascimento não preenchido");

        return false;

    } else if ($('#form-cadastrar-usuario input[name="whatsapp"]').val().length === 0) {

        alert("Campo whatsapp não preenchido");

        return false;

    } else if ($('#form-cadastrar-usuario input[name="cep"]').val().length === 0) {

        alert("Campo cep não preenchido");

        return false;

    } else if ($('#form-cadastrar-usuario input[name="sobrenome"]').val().length === 0) {

        alert("Campo sobrenome não preenchido");

        return false;

    } else if ($('#form-cadastrar-usuario input[name="estado"]').val().length === 0) {

        alert("Campo estado não preenchido");

        return false;

    } else if ($('#form-cadastrar-usuario input[name="cidade"]').val().length === 0) {

        alert("Campo cidade não preenchido");

        return false;

    } else if ($('input[name="logradouro"]').val().length === 0) {

        alert("Campo logradouro não preenchido");

        return false;

    } else if ($('input[name="numero"]').val().length === 0) {

        alert("Campo numero não preenchido");

        return false;

    } else if ($('input[name="bairro"]').val().length === 0) {

        alert("Campo bairro não preenchido");

        return false;

    } else if ($('select[name="sexo"] option:selected').val().length === 0) {

        alert("Campo sexo não preenchido");

        return false;

    } else if ($('input[name="password"]').val().length === 0) {

        alert("Campo senha não preenchido");

        return false;

    }



    return true;

}



// function getClient(email){

// $.ajax({



//     url: "/delivery/client/" + email, 



//     type: 'GET', 



//     dataType: 'JSON',



//     success: function(client){

//         $('#drop').effect('drop', 'slow');



//         setTimeout(function(){

//                 $("#scroll-forms").append(getEndForm(client));

//                 $("#scroll-forms").hide();

//                 $('#step__finalize').addClass('steps__item--active');

//                 $('#scroll-forms').effect('slide', 'slow');

//                 getCartProducts(JSON.parse(Base64Decode(localStorage.getItem("prods"))), JSON.parse(Base64Decode(localStorage.getItem("complementos"))));

//         }, 1000);



//     },

//     error: function(client)

//     {

//         var cliente = client.responseJSON;



//         if(cliente != undefined){

//             var obj = Object.keys(cliente);



//             if(obj[0] == 'id')

//             {

//                 html = getEndForm(cliente);



//             }

//         }

//         else

//         {

//             html = getCadForm(email);

//         }



//         $('#drop').effect('drop', 'slow');



//         $('#step__finalize').css('.steps__item--active');



//         setTimeout(function(){

//             $("#scroll-forms").append(html);

//             $("#scroll-forms").hide();

//             $('#step__finalize').addClass('steps__item--active');

//             $('#scroll-forms').effect('slide', 'slow');

//             getCartProducts(JSON.parse(Base64Decode(localStorage.getItem("prods"))), JSON.parse(Base64Decode(localStorage.getItem("complementos"))));

//         }, 1000);



//     }

//     })

// }



function getForms(dtv = '', flt = '', csrf = '', parameters = '') {



    var ent = JSON.parse(localStorage.getItem('entrega'));



    var products = [JSON.stringify(Base64Decode(localStorage.getItem("prods")))];



    var compl = [JSON.stringify(Base64Decode(localStorage.getItem("complementos")))];



    var total_prod = JSON.parse(Base64Decode(localStorage.getItem("prods"))).length;



    var status = "Pdt";



    var time = null;



    var date = null;



    var loja = JSON.parse(localStorage.getItem("loja_id"));



    if (localStorage.getItem('agendamento_pedido')) {



        var ls = JSON.parse(localStorage.getItem('agendamento_pedido'));



        status = "Agd";



        time = ls.time;



        date = ls.data;



    }



    if (parameters != '') {

        parameters = JSON.parse(JSON.stringify(parameters));

        var inputs = '';



        for (let p in parameters) {

            inputs += `<input name="${p}" id="${p}" value="${parameters[p]}" type="hidden" placeholder="" />`;

        }

    }



    if (flt == 'entrega') {

        flt = 'desativado';

        dtv = 'desativado';

    } else if (flt == 'pagamento') {

        flt = 'desativado';

        dtv = '';

    } else if (flt == 'finalizar') {

        flt = '';

        dtv = 'desativado';

    } else {

        dtv = '';

    }



    var html = `   

    <form class="box__form clearfix" id="form-enviar-pagamento" action="/delivery/identificacao/finalizacao-pedido" method="POST">

        <div id="form-pagamento" class="finalizar__form ${dtv} ">

            <h2>FORMA DE PAGAMENTO</h2>

            <div id="select-forma-pagamento">

                <select name="payment_method" id="select-forma-pagamento2">

                </select>

            </div>

            <div id="erede-form" style="display: none;">

            <style>

            

#erede-form {

    

    padding-top: 12px;

  }

  

  #erede-form input {

      width:100%;

    height: 42px;

    margin-top: 8px;

    margin-bottom:15px;

    border-radius: 10px;

    padding: 8px;

    border: solid 1px #cacaca;

    

  }

  

            </style>

                <div style="    display: inline-block;

                background: #fbf9fb;

                margin: 15px;">

                <img src="https://www.pedidos.tubaraodapraia.com.br/img/cards2.png" style="padding: 12px;" />

                <label>Número do cartão

                    <input type="text" id="erede_card_number" name="erede_card_number" step="any" placeholder="**** **** **** ****" >

                    </label> <label>Nome impresso no cartão

                    <input type="text" name="erede_card_name"></label>

                    <label>Validade do cartão



                    <input type="text" id="erede_exp" name="erede_card_exp" step="any" placeholder="MM/AAAA"></label>

                    <label>Código de segurança



                    <input type="text" pattern="\\d*" name="erede_card_sec" maxlength="3" placeholder="CVC"></label>

                    <label style="margin: 10px;">* Nenhum dado do seu cartão ficará salvo.</label>

                </div>

            </div>

            <label>

                Observação:

                <input name="obs_payment" class="form style-input" value="" type="text" placeholder="Se DINHEIRO, digite o valor para troco." />

            </label>

            <label>

                CPF na nota?</br>

                <input type="radio" name="cpf-sim" id="cpf-sim" style="margin-right: 5px;">sim

                <input type="radio" name="cpf-sim" id="cpf-nao" style="margin-right: 5px;">não

            </label>

            <label id="cpf" style="display: none;">

                CPF:

                <input name="cpf_nota" id="cpf_nota" class="form style-input" value="" type="text" placeholder="" />

                

                <p id="cpf-invalido" style="display: none;">CPF inválido, tente novamente.</p>

            </label>

            <label>

                <input type="hidden" name="_token" value="${csrf}" />

                ${inputs}

                <input type="button" class="form-btn" id="prosseguir-finalizacao" value="CONTINUAR" />

            </label>

        </div>

    </form>

    <form class="box__form clearfix" id="form-finalizar-pedido" action="/delivery/identificacao/finalizar-pedido" method="POST">

        <div id="form-finalizar" class="finalizar__form ${flt} ">



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

                        <span id="sub-total"></span>

                    </div>

                    <div class="clearfix">

                        <span>Taxa de entrega:</span>

                        <span>${ "R$" + numberToReal(ent.taxa)}</span>

                    </div>

                </div>

                <div class="valores clearfix">

                    <span>Tempo de entrega estimado</span>

                    <span>${ent.tempo}</span>

                </div>

                <div class="comprar">

                    <div class="obs">

                        <span>Observação: </span>

                        <textarea id="order-obs" name="obs" rows="3" maxlength = "200" placeholder="Observação."></textarea>

                    </div>

                    <div class="clearfix total">

                    ${inputs}

                    <input type="hidden" name="total" value="" />

                    <input type="hidden" name="taxa" value="${ent.taxa}" />

                    <input type="hidden" name="total_prod" value="" />

                    <input type="hidden" name="products" value='${products}' />

                    <input type="hidden" name="complements" value='${compl}' />

                    <input type="hidden" name="status" value="${status}" />

                    <input type="hidden" name="time" value="${time}" />

                    <input type="hidden" name="date" value="${date}" />

                    <input type="hidden" name="loja" value="${loja.loja_id}" />

                    <input type="hidden" name="bairro" value="${ent.bairro}" />

                        <span>

                            TOTAL

                        </span>

                        <span id="total-pedido">

                            

                        </span>

                    </div>

                        <input type="submit" id="finalizar-pedido" value="Finalizar pedido" />

                    </div>

            </form>

        </div>

        </div>

    </div>

</form>

`;



    return html;

}



function validateEmail(email) {



    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (!filter.test(email)) {

        $(".msg").text('Por favor, informe um email válido.');

        return false;

    }



    return true;

}



function getCartProducts(products, complementos) {



    // var obj  = JSON.parse(localStorage.getItem("prods"));



    var taxa = JSON.parse(localStorage.getItem("entrega"));



    var complTotal = 0;

    var subTotal = 0;



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



$(document.body).on('click', '#cpf-sim', function () {

    $('#cpf').show();

});



$(document.body).on('click', '#cpf-nao', function () {

    $('#cpf').hide();

});



// $(document).on('click', '#prosseguir-finalizacao', function () {

//     $('#cpf_nota').cpfcnpj({

//         mask: true,

//         validate: 'cpf',

//         event: 'click',

//         handler: '#prosseguir-finalizacao',

//         ifValid: function (input) {

//             $('#cpf-invalido').hide();

//             $('#prosseguir-finalizacao').prop('disabled', false);

//             $('#cpf_nota').css('border-color', 'green');

//             if ($('#xxoa').length < 1) {



//                 $('#form-enviar-pagamento').append('<input type="hidden" id="xxoa" name="XXSSAA$IIE.OQP" value="1" />');



//             }



//         },

//         ifInvalid: function (input) {

//             $('#cpf-invalido').show();

//             $('#prosseguir-finalizacao').prop('disabled', true);

//             $('#cpf_nota').css('border-color', 'red');

//             $('#xxoa').remove();

//         }

//     });

// });