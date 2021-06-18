
//Obtem todas as cidades
function getCity(position){
    jQuery('#busca-unidade').attr('placeholder', 'Localizando cidade, por favor aguarde...');
    jQuery('#busca-unidade').prop('disabled', true); 
    jQuery('#load-geo').show(); 
    console.log('https://maps.googleapis.com/maps/api/geocode/json?latlng='+ position.coords.latitude +','+ position.coords.longitude +'');
    var cidade = [];
     jQuery.ajax({
         url: 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+ position.coords.latitude +','+ position.coords.longitude +'',
         method: 'GET',
         dataType: 'JSON',
         success: function(response){
             console.log(response)
             if(response.status = "OK"){
                 cidade.push(response);
                 jQuery('#load-geo').hide(); 
                 jQuery('#busca-unidade').attr('placeholder', 'Busque por Cidade...');
                 jQuery('#busca-unidade').prop('disabled', false); 
                 jQuery('#busca-unidade').val(cidade[0].results[0].address_components[3].long_name).focus();
                 initUnits();
                 searchUnit();
             }else{
                jQuery('#busca-unidade').attr('placeholder', 'Busque por Cidade...');
             }
         },
         error: function(response){
         }
     })
     return cidade;
 }
 
//Previne o click 
jQuery('#my-location').click(function(e){
    e.preventDefault();
});

//Aviso Geolocalização
var notice = jQuery('#aviso');

function getLocation(e) {

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else { 
        x.innerHTML = "Geolocalização não é suportada por este navegador.";
    }
}

function showPosition(position) {
    getCity(position);
}

function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            jQuery(notice).html('Usuário negou a solicitação de Geolocalização.').fadeIn(500).delay(5000).fadeOut(500);
            break;
        case error.POSITION_UNAVAILABLE:
            jQuery(notice).html('As informações de localização não estão disponíveis.').fadeIn(500).delay(5000).fadeOut(500);
            break;
        case error.TIMEOUT:
            jQuery(notice).html('O pedido para obter a localização do usuário expirou.').fadeIn(500).delay(5000).fadeOut(500);
            break;
        case error.UNKNOWN_ERROR:
            jQuery(notice).html('Ocorreu um erro desconhecido.').fadeIn(500).delay(5000).fadeOut(500);
            break;
    }
}

//Retira acentos
function parseCity(str){
return str.normalize('NFD').replace(/[\u0300-\u036f]/g, "").toLowerCase();
}

//Retira acentos e espaços
function parseURL(str){
    return str.normalize('NFD').replace(" ", "-").replace(/[\u0300-\u036f]/g, "").toLowerCase();
}

//Unidades Json
    var unidades = [];
    jQuery('#busca-unidade').val("");
    jQuery.ajax({
        url: 'https://ortodontic.otimaideia.com.br/api/locations',
        method: 'GET',
        dataType: 'JSON',
        success: function(response){
            unidades.push(response);
            initUnits();
            
            jQuery('#busca-unidade').attr('placeholder', 'Busque por Cidade');
            jQuery('#busca-unidade').prop('disabled', false);
            
            jQuery(window).load(function(){
            setTimeout(function(){
                jQuery('#my-location').show();
            }, 1000);
        });
        
        },
        error: function(response){
        }
    })

//Buscar cidades 
jQuery('input#busca-unidade').keyup(function(){
return searchUnit();
});

function searchUnit(){
    if(unidades.length != 0){
    var i = 0;
    var unidade_p = parseCity(jQuery('input#busca-unidade').val());

    jQuery('#retorno-unidades').show();

    jQuery('.resul-unidades li').each(function(){

        var unidade_json = parseCity(jQuery(this).text().toLowerCase());
        
        if(unidade_json.indexOf(unidade_p) > -1){

            jQuery(this).css('display', 'block');
            jQuery(this).addClass('on');
            // if(jQuery('#sem-unidades').length > 0){
            // jQuery('#sem-unidades').hide();
            // }

        }else if(unidade_json.indexOf(unidade_p) == -1){

        jQuery(this).css('display', 'none');

        jQuery(this).removeClass('on');
        
        jQuery('.resul-unidades li').each(function(){
            
            var vclass = jQuery(this).attr('class');
            
            if(vclass == 'on'){
                i++;
            }

        });
        if(i > 0){
            jQuery('#sem-unidades').remove();
        }
        else{
            jQuery('#sem-unidades').remove();
            var city = jQuery('#busca-unidade').val();
            if(jQuery('#sem-unidades').length == 0){
                jQuery('.resul-unidades').append('<li id="sem-unidades"><a href="https://www.orthodonticbrasil.com.br/inauguracao-de-unidade/?city=' + parseURL(city) + '">Não há unidades próximas em sua cidade. Clique aqui e seja avisado quando inaugurarmos.</a></li>');
            }
            }
        }
        });
    }
}
 
//Carrega a lista de cidades
function initUnits(){
    var html = "";
//  var city = jQuery('#busca-unidade').val();
//  html    += '<li id="sem-unidades"> <a href="https://www.orthodonticbrasil.com.br/inauguracao-de-unidade/?city='+ jQuery('#busca-unidade').val() +'">Não há unidades próximas em sua cidade. Clique aqui e seja avisado quando inaugurarmos.</a></li>';
    for (let i = 0; i < unidades[0].data.length; i++) {
        html += `<li> <a href="https://www.orthodonticbrasil.com.br/` + parseURL(`unidade-${unidades[0].data[i].city}-${ unidades[0].data[i].id}`) + `">${ unidades[0].data[i].name }</a></li>`;
    }
    jQuery('.resul-unidades').append(html);
}
 
//Fecha dropdown
jQuery(document).ready(function(){
    jQuery(document.body).click(function(){ 
        if(jQuery('#retorno-unidades').length != 0 && jQuery('body').data('clicked', true)){
            jQuery('#retorno-unidades').hide();
        }
    })
});
 
 