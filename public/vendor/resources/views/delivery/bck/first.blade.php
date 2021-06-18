@extends('layouts.tubarao-delivery')

@section('content')

<div id="div-inicio" class="inicio clearfix">

<div class="lightbox">
    <div class="lightbox__bg"></div>
    <div class="lightbox__semcep">
        <div class="x">X</div>
        <div id="pog">
            <div class="titulo">Preencha seu endereço abaixo</div>
            <label for="uf">Estado</label><br/>
            <select id="uf" required disabled>
                <!-- <option value="">UF</option>
                <option value="AC">AC</option>
                <option value="AL">AL</option>
                <option value="AP">AP</option>
                <option value="AM">AM</option>
                <option value="BA">BA</option>
                <option value="CE">CE</option>
                <option value="DF">DF</option>
                <option value="ES">ES</option>
                <option value="GO">GO</option>
                <option value="MA">MA</option>
                <option value="MS">MS</option>
                <option value="MT">MT</option>
                <option value="MG">MG</option>
                <option value="PA">PA</option>
                <option value="PB">PB</option>
                <option value="PR">PR</option>
                <option value="PE">PE</option>
                <option value="PI">PI</option>
                <option value="RJ">RJ</option>
                <option value="RN">RN</option>
                <option value="RS">RS</option>
                <option value="RO">RO</option>
                <option value="RR">RR</option>
                <option value="SC">SC</option> -->
                <option value="SP">SP</option>
                <!-- <option value="SE">SE</option>
                <option value="TO">TO</option> -->
            </select>

            <label for="cidade">Cidade</label><br/>
            <input type="text" name="cidade" id="cidade" value="Praia Grande" required disabled />

            <label for="endereco">Endereço</label><br/>
            <input type="text" name="endereco" id="endereco" required />

            <input type="button" id="enviar" value="PESQUISAR CEP"/>
        </div>
    </div>
</div>

<div class="inicio__novidade">NOVIDADE</div>
    <h2>Tubarão da Praia Delivery</h2>
        <p>Digite seu CEP abaixo para começar:</p>
            <div class="inicio__form clearfix">
                <input name="cep" class="inicio__cep" placeholder="Seu CEP" type="text">
                <input class="inicio__enviar" type="button" value="Pesquisar">
            </div>
    <span>ou</span>
<div class="buscar">Buscar CEP</div>
<div id="lojas-input">

</div>
</div>

@endsection

@section('footer-scripts')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
    function parseCEP(cep)
    {
        return cep.replace('-', '');
    }
</script>

<script type="text/javascript">
    var html = '';
        
    idsCorridos = [];
        
    idAux = false;

    $(document.body).on('click', '.inicio__enviar', function(){

        var cep  = parseCEP($('input[name="cep"]').val());

        var html = '';
        
        idsCorridos = [];
        
        idAux = false;

        if(cep.length == 8)
        {
            $('.list-group').remove();
                
                addLoadDiv();

            $.ajax({
			url: "http://viacep.com.br/ws/" + cep + "/json/", 
			type: 'GET',
			datatype: 'JSON',
			success: function(response){ 

                if(response.cep != null) {

                var data = {
                    taxa: 0.00,
                    cidade: response.localidade,
                    cep: response.cep,
                    logradouro: response.logradouro,
                    bairro: response.bairro,
                    uf: response.uf
                }

                localStorage.setItem('entrega', JSON.stringify(data));

                $.ajax({
                    url: "/delivery/cep/loja",

                    type: "GET",

                    success: function(response){

                        html  = "<ul style='display: inline-block; margin-bottom: 10px;' class='list-group'>";
                        count = 0;

                        for(i = 0; i < response.length; i++) {
                        
                            for(d = 0; d < idsCorridos.length; d++)
                            {
                                if(idsCorridos[d] == response[i].order_tax_loja_id)
                                {
                                    idAux = true;
                                }
                            }

                        if(!idAux)
                        {
                            if(cep >= parseCEP(response[i].order_tax_cep_inicial) && cep <= parseCEP(response[i].order_tax_cep_final)) {
                                
                                html += '<li style="display: inline-block; border: none; background-color:transparent;" class="list-group-item"><a href="/delivery/'+ response[i].get_lojas[0].id +'"><input style="display:inline-block;" class="btn btn-outline-info" type="button" id="btn-loja" tx="' + response[i].order_tax_price + '" data-id="' + response[i].get_lojas[0].id + '" value="' + response[i].get_lojas[0].nome_loja + '"></a></li>';
                                count++;
                                idsCorridos.push(response[i].order_tax_loja_id);

                            }
                        }
                        idAux = false;
                        }

                        if(count === 0)
                        {
                        html += `   
                                <div style="margin-top:10px;" class="alert alert-warning" role="alert">
                                Não há lojas próximas do cep informado, tente novamente com outro CEP.
                                </div>`;
                        }
                        else
                        {
                            removeDivs();
                        }

                    html += "</ul>";
                    
                    $('#lojas-input').append(html);
                        
                    setTimeout(function(){
                
                        removeLoadDiv();

                    }, 3000);

                    }
                    
                })
            }
            else
            {
                alert("Cep inválido.");
            }
			},
			error: function(response) {
                alert("esse cep não existe");
			}
            });
            
            setTimeout(function(){
                
                removeLoadDiv();

            }, 3000);

        }

    });

</script>

<script type="text/javascript">

    $(document).ready(function(){

        // if(localStorage.getItem('prods')) {
        //     localStorage.removeItem('prods');
        // }

        $(document.body).on('click', '#btn-loja', function(){
            
            var ent  = JSON.parse(localStorage.getItem('entrega'));

            var id   = $(this).attr('data-id');

            var tx   = $(this).attr('tx');

            var data = {loja_id: id};

            localStorage.setItem('loja_id', JSON.stringify(data));

            var data = {
                    taxa: tx,
                    cidade: ent.cidade,
                    cep: ent.cep,
                    logradouro: ent.logradouro,
                    bairro: ent.bairro,
                    uf: ent.uf
                }

            localStorage.removeItem('entrega');

            localStorage.setItem('entrega', JSON.stringify(data));
       
       })

       var pedido = `
            <div class="continuar-compra ativo">

            <div class="bg"></div>
            <div class="conteudo">
            <div class="x">X</div>
            <h3>
            Notamos que vc não
            finalizou sua compra...
            </h3>
            <p>
            Gostaria de continuar de onde você parou ou fazer um novo pedido?
            </p>
            <div>
            <input value="Novo Pedido" id="novopedido" type="button">
            <input style="background-image: url({{ asset('/img/continuar.png') }}" value="Continuar" id="continuarpedido" type="button">
            </div>
            </div>

            </div>
            `;

        var prods = localStorage.getItem('prods');
        var loja_id = JSON.parse(localStorage.getItem('loja_id'));
        var entrega = localStorage.getItem('entrega');

        if(prods && loja_id && entrega){
        jQuery('header').after(pedido);
        }

        jQuery(document.body).on('click','.continuar-compra .x',function(){
            localStorage.removeItem('prods');
            localStorage.removeItem('loja_id');
            localStorage.removeItem('entrega');
            localStorage.removeItem('obs');
        jQuery('.continuar-compra').remove();
        });
        jQuery(document.body).on('click','.continuar-compra .bg',function(){
            localStorage.removeItem('prods');
            localStorage.removeItem('loja_id');
            localStorage.removeItem('entrega');
            localStorage.removeItem('obs');
        jQuery('.continuar-compra').remove();
        });
        jQuery(document.body).on('click','#novopedido',function(){
            localStorage.removeItem('prods');
            localStorage.removeItem('loja_id');
            localStorage.removeItem('entrega');
            localStorage.removeItem('obs');
        jQuery('.continuar-compra').remove();
        });
        jQuery(document.body).on('click','#continuarpedido',function(){
            window.location = "/delivery/" + loja_id.loja_id;
        });

    });

</script>

<script>
	jQuery('.buscar').click(function(){
        jQuery('.lightbox').toggleClass('ativo');
        $('#pog').css('display', '');
        $('#ceps-pesquisados').remove();
	});
	jQuery('.lightbox__bg').click(function(){
		jQuery('.lightbox').toggleClass('ativo');
	});
	jQuery('.lightbox__semcep .x').click(function(){
		jQuery('.lightbox').toggleClass('ativo');
    });
    
	jQuery('#enviar').click(function(){
		var uf = jQuery('#uf').val();
		var cidade = jQuery('#cidade').val();
		var log = jQuery('#endereco').val();

            addLoadDiv();

        if(log.length != 0){

		$.ajax({
                

			url: "http://viacep.com.br/ws/" + uf + "/" + cidade + "/" + log + "/json/", 
			type: 'GET',
			datatype: 'JSON',
			success: function(response){
                if($('#ceps-pesquisados').length != 0)
                {
                    
                    $('#ceps-pesquisados').remove();

                } 
                
                var html =  "<ul id='ceps-pesquisados'>";

                if(response.length == 0){
                    html += 
                    `
                 
                        <li><div class="alert alert-danger">Não foi possível encontrar a rua.</div></li>
                    
                    `;
                    html += "</ul>";

                    $(html).insertAfter('#pog');

                    return;
                }
                for(i = 0; i < response.length; i++) {
                    html += 
                    `
                 
                        <li><input id="log-cep" type="button" style="background-color: #800b58; color: #fdec01;" class="btn" name="cep-atlz" data-cep="${response[0].cep}" value="${response[0].logradouro} - ${response[0].localidade} - ${response[0].complemento}"/></li>
                    
                    `;

                }
                html += "</ul>";

                setTimeout(function(){
                    removeLoadDiv();
                }, 3000);

                $(html).insertAfter('#pog');
                $('#pog').hide();
			},
			error: function(response) {
                var html =  "<ul id='ceps-pesquisados'>";
              
                    html += 
                    `
                 
                        <li><div class="alert alert-danger">Não foi possível encontrar essa rua.</div></li>
                    
                    `;

                html += "</ul>";

                $(html).insertAfter('#pog');
                $('#endereco').css('border', 'solid 1px red ');
                
			}
        });
    }
    else
    {
        removeLoadDiv();

    }

    setTimeout(function(){
        removeLoadDiv();
    }, 5000);

	});

</script>

<script type="text/javascript">
    $(document.body).on('click', '#log-cep', function(){
        var cep = parseCEP($(this).attr('data-cep'));
        
        removeDivs();

        if(cep.length == 8)
        {

            addLoadDiv();

            $.ajax({
			url: "http://viacep.com.br/ws/" + cep + "/json/", 
			type: 'GET',
			datatype: 'JSON',
			success: function(response){ 
                if(response.cep != null) {

                var data = {
                    taxa: 0.00,
                    cidade: response.localidade,
                    cep: response.cep,
                    logradouro: response.logradouro,
                    bairro: response.bairro,
                    uf: response.uf
                }

                localStorage.setItem('entrega', JSON.stringify(data));

                $.ajax({
                    url: "/delivery/cep/loja",

                    type: "GET",

                    success: function(response){
                        html  = "<ul style='display: inline-block; margin-bottom: 10px; overflow-y: scroll;' class='list-group'>";
                        count = 0;

                        for(i = 0; i < response.length; i++) {
                        
                            for(d = 0; d < idsCorridos.length; d++)
                            {
                                if(idsCorridos[d] == response[i].order_tax_loja_id)
                                {
                                    idAux = true;
                                }
                            }

                        if(!idAux)
                        {
                            if(cep >= parseCEP(response[i].order_tax_cep_inicial) && cep <= parseCEP(response[i].order_tax_cep_final)) {
                                
                                html += '<li style="display: inline-block; border: none; background-color:transparent;" class="list-group-item"><a href="/delivery/'+ response[i].get_lojas[0].id +'"><input style="display:inline-block;" class="btn btn-outline-info" type="button" id="btn-loja" tx="' + response[i].order_tax_price + '" data-id="' + response[i].get_lojas[0].id + '" value="' + response[i].get_lojas[0].nome_loja + '"></a></li>';
                                count++;
                                idsCorridos.push(response[i].order_tax_loja_id);

                            }
                        }
                        idAux = false;
                        }

                        if(count === 0)
                        {
                        html += `   
                                <div style="margin-top:10px;" class="alert alert-warning" role="alert">
                                Não há lojas próximas do cep informado, tente novamente com outro CEP.
                                </div>`;
                        }

                    html += "</ul>";
                    
                    $('#lojas-input').append(html);
                    
                    setTimeout(function(){
                        removeLoadDiv();
                    }, 3000);

                    }
                    
                })
            }
        }
    })
    // setTimeout(function(){
                    
    //     removeLoadDiv();
    
    //     }, 3000);
}

});


</script>

@endsection