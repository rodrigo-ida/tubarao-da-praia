$('#recu-email-show').click(function () {
    $('.modal-recu-email').addClass('ativo');
});

function getDeliveryCeps(cep) {
    console.log('getdeliverrrr');
    idsCorridos = [];

    idAux = false;

    $.ajax({
        url: "https://viacep.com.br/ws/" + cep + "/json/",
        type: 'GET',
        datatype: 'JSON',
        success: function (response) {

            if (response.cep != null) {
 
                var data = {
                    taxa: 0.00,
                    cidade: response.localidade,
                    cep: response.cep,
                    logradouro: response.logradouro,
                    bairro: response.bairro,
                    uf: response.uf,
                    tempo: 0
                }


                localStorage.setItem('entrega', JSON.stringify(data));

                $.ajax({
                    url: "/delivery/cep/" + response.bairro,

                    type: "GET",

                    success: function (response) {
                        html = "<ul style='display: inline-block; margin-bottom: 10px;' class='list-group'>";
                        count = 0;

                        for (i = 0; i < response.length; i++) {

                            if (cep >= parseCEP(response[i].order_tax_cep_inicial) && cep <= parseCEP(response[i].order_tax_cep_final) && count < 1) {

                                html += '<li style="display: inline-block; border: none; background-color:transparent;" class="list-group-item"><form id="cep-encontrado" style="display: none;" action="/delivery/selecionar-loja" method="POST"><input type="hidden" name="bairro" value="' + response[i].order_tax_neighborhood + '"><input type="hidden" name="rua" value="' + data.logradouro + '"><input type="hidden" name="cep-id" value="' + response[i].id + '"><input type="hidden" name="cidade" value="' + data.cidade + '"><input type="hidden" name="id" value="' + response[i].get_lojas[0].id + '" /><input style="display:inline-block;" class="btn btn-loja" data-time="' + response[i].order_shipping_time + '" type="submit" id="btn-loja" tx="' + response[i].order_tax_price + '" data-id="' + response[i].get_lojas[0].id + '" value="Continuar"></form></li>';
                                count++;

                                var tax = response[i].order_tax_price;
                                var time = response[i].order_shipping_time;

                                idsCorridos.push(response[i].order_tax_loja_id);

                            }

                        }


                        if (count === 0) {
                            html += `   
                            <div style="margin-top:10px;" class="alert alert-warning" role="alert">
                            Não há lojas próximas do cep informado, tente novamente com outro CEP.
                            </div>`;

                            $.ajax({
                                type: "POST",
                                url: '/cep-sem-cadastro',
                                data: {
                                    "_token" : $('meta[name="csrf-token"]').attr('content'),
                                    'cep': cep,
                                    
                                   
                             },
                                success: function() {
                                  console.log("Value added");
                                }
                              });

                        }

                        html += "</ul>";

                        $('#lojas-input').append(html);

                        data = JSON.parse(localStorage.getItem('entrega'));

                        data.taxa = tax;
                        data.tempo = time;
                       

                        localStorage.setItem('entrega', JSON.stringify(data));
                        //alert(JSON.stringify(data));
                        
                        $('#cep-encontrado').submit();

                        removeLoadDiv();

                    }

                })
            } else {
                alert("Cep inválido.");
            }
        },
        error: function (response) {
            alert("esse cep não existe");
        }
    });
}

function getDeliveryCepsConsulta(cep) {
    idsCorridos = [];

    idAux = false;

    $.ajax({
        url: "https://viacep.com.br/ws/" + cep + "/json/",
        type: 'GET',
        datatype: 'JSON',
        success: function (response) {

            if (response.cep != null) {

                var data = {
                    taxa: 0.00,
                    cidade: response.localidade,
                    cep: response.cep,
                    logradouro: response.logradouro,
                    bairro: response.bairro,
                    uf: response.uf,
                    tempo: 0
                }

         
            

                localStorage.setItem('entrega', JSON.stringify(data));

                $.ajax({
                    url: "/delivery/cep/" + response.bairro ? response.bairro : 'tupi',

                    type: "GET",

                    success: function (response) {
                        html = "<ul style='display: inline-block; margin-bottom: 10px;' class='list-group'>";
                        count = 0;

                        for (i = 0; i < response.length; i++) {

                            if (cep >= parseCEP(response[i].order_tax_cep_inicial) && cep <= parseCEP(response[i].order_tax_cep_final) && count < 1) {
                                count++;
                                html += `   
                                <div style="margin-top:10px;" class="alert alert-warning" role="alert">
                                Sim fazemos entrega nessa localidade.
                                </div>`;

                            }

                        }


                        if (count === 0) {
                            html += `   
                            <div style="margin-top:10px;" class="alert alert-warning" role="alert">
                            Não há lojas próximas do cep informado, tente novamente com outro CEP.
                            </div>`;

                            $.ajax({
                                type: "POST",
                                url: '/cep-sem-cadastro',
                                data: {
                                    "_token" : $('meta[name="csrf-token"]').attr('content'),
                                    'cep': cep,
                                    
                                   
                             },
                                success: function() {
                                  console.log("Value added");
                                }
                              });

                        }

                        html += "</ul>";

                        $('#lojas-input').append(html);

                        data = JSON.parse(localStorage.getItem('entrega'));

                        data.taxa = tax;
                        data.tempo = time;
                       

                        localStorage.setItem('entrega', JSON.stringify(data));
                        //alert(JSON.stringify(data));
                        
                        $('#cep-encontrado').submit();

                        removeLoadDiv();

                    }

                })
            } else {
                alert("Cep inválido.");
            }
        },
        error: function (response) {
            alert("esse cep não existe");
        }
    });
}




function getCepsBySearch(uf, cidade, log) {
    $.ajax({

        url: "https://viacep.com.br/ws/" + uf + "/" + cidade + "/" + log + "/json/",
        type: 'GET',
        datatype: 'JSON',
        success: function (response) {
            if ($('#ceps-pesquisados').length != 0) {

                $('#ceps-pesquisados').remove();

            }

            var html = "<ul id='ceps-pesquisados'>";

            if (response.length == 0) {
                html +=
                    `
             
                    <li><div class="alert alert-danger">Não foi possível encontrar a rua.</div></li>
                
                `;
                html += "</ul>";

                $(html).insertAfter('#pog');

                return;
            }
            for (i = 0; i < response.length; i++) {
                html +=
                    `
             
                    <li>
                        <form id="cep-encontrado" action="/delivery/selecionar-loja" method="POST">
                            <input type="hidden" name="cep-id" value="${response[0].id}">
                            <input type="hidden" name="bairro" value="${response[0].bairro}">
                            <input type="hidden" name="cidade" value="${response[0].cidade}">
                            <input id="log-cep" type="button" name="id" style="background-color: #800b58; color: #fdec01;" class="btn" name="cep-atlz" data-cep="${response[0].cep}" value="${response[0].logradouro} - ${response[0].localidade} - ${response[0].complemento}"/>
                        </form>
                    </li>
                
                `;

            }
            html += "</ul>";

            $(html).insertAfter('#pog');
            $('#pog').hide();

        },
        error: function (response) {
            var html = "<ul id='ceps-pesquisados'>";

            html +=
                `
             
                    <li><div class="alert alert-danger">Não foi possível encontrar essa rua.</div></li>
                
                `;

            html += "</ul>";

            $(html).insertAfter('#pog');
            $('#endereco').css('border', 'solid 1px red');

        }
    });

}