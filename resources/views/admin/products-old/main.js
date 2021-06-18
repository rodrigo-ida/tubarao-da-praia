window.getParameterByName = function (name) {
	name = name.replace(/[[]/, "\[").replace(/[]]/, "\]");
	var regexS = "[\?&]" + name + "=([^&#]*)";
	var regex = new RegExp(regexS);
	var results = regex.exec(window.location.href);
	if (results == null) return "";
	else return decodeURIComponent(results[1].replace(/\+/g, " "));
}

function sharers(em) {
	var shareurl=em.href;
	var top = (screen.availHeight - 500) / 2;
	var left = (screen.availWidth - 500) / 2;
	var popup = window.open(
		shareurl, 
		'social sharing',
		'width=550,height=420,left='+ left +',top='+ top +',location=0,menubar=0,toolbar=0,status=0,scrollbars=1,resizable=1'
	);
	return false;
}

jQuery('.carouselhalf').slick({
	slidesToShow: 1,
	dots: true,
	arrows: false
});

$('.phone').click(function() {
	$('.lightbox').addClass('ativo');
	$('.caixa').addClass('ativo');
});
$('.online').click(function() {
	$('.lightbox').addClass('ativo');
	$('.iframe').addClass('ativo');
});
$('.online').one('click', function() {

	var utm = window.getParameterByName('utm_source');
	$('#spoton iframe').remove();
	//$('#spoton').append('<iframe class="avaliacao" src="https://avaliacoesodontologi.websiteseguro.com/avalia?or='+utm+'" frameborder="0" scrolling="no" seamless="seamless"></iframe>');
});
$('.fundo').click(function() {
	$('.lightbox').removeClass('ativo');
	$('.caixa').removeClass('ativo');
	$('.iframe').removeClass('ativo');
});
$('.fechar').click(function() {
	$('.lightbox').removeClass('ativo');
	$('.caixa').removeClass('ativo');
	$('.iframe').removeClass('ativo');
});
$('.btn-default').click(function(){
		parent.history.back();
		return false;
	});
/*var testCidades = $('.cidades').length;
var testTrabalhe = $('.page-trabalhe-conosco').length;
if ( testCidades > 0 ) {
	new dgCidadesEstados({
		cidade: document.getElementById('cidade'),
		estado: document.getElementById('estado')
	});
} else if ( testTrabalhe > 0 ) {
	new dgCidadesEstados({
		cidade: document.getElementById('cidade'),
		estado: document.getElementById('estado')
	});
}*/
var testTrabalhe = $('.page-trabalhe-conosco').length;

if ( testTrabalhe > 0 ) {
	new dgCidadesEstados({
		cidade: document.getElementById('cidadeTrabalhe'),
		estado: document.getElementById('estadoTrabalhe')
	});
}

var testCidades2 = $('.lightbox').length;
if ( testCidades2 > 0 ) {
	new dgCidadesEstados({
		cidade: document.getElementById('cidadelightbox'),
		estado: document.getElementById('estadolightbox')
	});
} else {}

var testContato = $('#estadoContato').length;

if ( testContato > 0 ) {
	new dgCidadesEstados({
		cidade: document.getElementById('cidadeContato'),
		estado: document.getElementById('estadoContato')
	});
}


$('textarea, input').click(function() {
	$('.wpcf7-response-output').hide();
	$('.wpcf7-not-valid-tip').hide();
});

$(".abaduvida").click(function() {
	Cookies.set('aba', 'duvida');
});
jQuery(document).ready(function($) {
	$(function() { $( '.video-box' ).swipebox(); });
	// Flickity options, defaults
	var options = {
		cellAlign: 'center',
		groupCells: 1,
		pageDots: false
	};
	// enable prev/next buttons at 768px
	if ( matchMedia('screen and (min-width: 700px)').matches ) {
		// options.groupCells = 2;
	}
	// disable draggable at 1200px
	if ( matchMedia('screen and (min-width: 1070px)').matches ) {
		// options.groupCells = 3;
	}
	$('.blogslider').flickity( options );
	$('.blogslider').css('visibility', 'visible');

	primeiroTipo = jQuery('.tipos .tab-link').first();
	primeiroTipo.addClass('is-active');
	id = jQuery(primeiroTipo).attr('id');
	showTipo(id);
	primeiroAparelho = jQuery('.aparelho .tab-link').first();
	primeiroAparelho.addClass('is-active');
	id = jQuery(primeiroAparelho).attr('id');
	showAparelho(id);

	function hideTipo (id) {
		jQuery('.tab-tipo').fadeOut().promise().done(function() {
			jQuery('.tab-tipo').removeClass('is-active');
			showTipo(id);
		});
		jQuery('.tipos .tab-link').removeClass('is-active');
	}
	function showTipo (id) {
		jQuery('.tab-tipo.'+id).fadeIn().promise().done(function() {
			jQuery('.tab-tipo.'+id).addClass('is-active');
		});
	}
	function hideAparelho (id) {
		jQuery('.tab-porque').fadeOut().promise().done(function() {
			jQuery('.tab-porque').removeClass('is-active'); 
			showAparelho(id);
		});
		jQuery('.aparelho .tab-link').removeClass('is-active');
	}
	function showAparelho (id) {
		jQuery('.tab-porque.'+id).fadeIn().promise().done(function() {
			jQuery('.tab-porque.'+id).addClass('is-active');
		});
	}

	// Abas página Serviços
	jQuery('.tipos .tab-link').click(function () {
		id = $(this).attr('id');
		hideTipo(id);
		$(this).addClass('is-active');
	});
	jQuery('.aparelho .tab-link').click(function () {
		id = $(this).attr('id');
		hideAparelho(id);
		$(this).addClass('is-active');
	});
});


//Recaptcha -------------------------------------
var invisibleGadget;
var visibleGadget;

var sitekey = '6LePHB8UAAAAAHZbz0pRnzXtZB1icEnZJdLa9I0u';
var sitekeyInv = '6LdASSYUAAAAAMijvmd27pY0LI1lGO_yp6wvi2OW';

var onloadCallback = function() {
	var vg = document.getElementById('recaptcha-dsn');
	if (vg) {
		if (visibleGadget) {
			grecaptcha.reset(visibleGadget);
		}
		visiblegadget = grecaptcha.render(vg, {
			'sitekey': sitekey,
		});
	} 
}

function onSubmit(token) {
	var formContato = document.getElementById("page-contato-form")
	if ( formContato ) {
		formContato.submit();
	}
}
function onSubmitTrabalhe(token) {
	var formTrabalhe = document.getElementById("page-trabalhe-form")
	if ( formTrabalhe ) {
		formTrabalhe.submit();
	}
} 

jQuery(document).ready(function($) {
	$('#contato-recaptcha').on('click', function (e) {
		e.preventDefault();
		var ig = document.getElementById('contato-recaptcha');
		var pageContato = $('#page-contato-form');
		var pageTrabalhe = $('#page-trabalhe-form');
		if (invisibleGadget) {
			grecaptcha.reset(invisibleGadget);
		}
		if (pageContato) {
			invisibleGadget = grecaptcha.render(ig, {
				'sitekey': sitekeyInv,
				'callback': onSubmit,
				'size': "invisible"
			})
		}
		if (pageTrabalhe) {
			invisibleGadget = grecaptcha.render(ig, {
				'sitekey': sitekeyInv,
				'callback': onSubmitTrabalhe,
				'size': "invisible"
			})
		}
		grecaptcha.execute(invisibleGadget);
	});
});

jQuery(document).on('click','.fold-form .btagd',function(){
	var failp = false;

	var nn11 = jQuery('.fold-form .name').val();

	if (!nn11){
		jQuery('.fold-form .name').addClass('frmagerro');
		failp = true;
	}
	if (nn11.length < 5){
		jQuery('.fold-form .name').addClass('frmagerro');
		failp = true;
	}
	var nnce = jQuery('.fold-form .celular').val();
	if (!nnce){
		jQuery('.fold-form .celular').addClass('frmagerro');
		failp = true;
	}
	if (nnce.replace('_','').replace('_','').replace('(','').replace(')','').length < 10){
		jQuery('.fold-form .celular').addClass('frmagerro');
		failp = true;
	}
	var esce = jQuery('.fold-form .estado').val();
	if (!esce){
		jQuery('.fold-form .estado').addClass('frmagerro');
		failp = true;
	}
	var cirs = jQuery('.fold-form .cidade').val();
	if (!cirs){
		jQuery('.fold-form .cidade').addClass('frmagerro');
		failp = true;
	}
	var units = jQuery('.fold-form .unidade').val();
	if (!units){
		jQuery('.fold-form .unidade').addClass('frmagerro');
		failp = true;
	}
	var dtwa = jQuery('.fold-form .data').val();
	if (!dtwa){
		jQuery('.fold-form .data').addClass('frmagerro');
		failp = true;
	}
	if (dtwa == 'Mais Opções'){
		jQuery('.fold-form .data').addClass('frmagerro');
		failp = true;
	}
	if(!failp){
		g23bhxcih3();
	}
});

jQuery(document).on('click','.lightbox-form .btagd',function(){
	var failp = false;

	var nn11 = jQuery('.lightbox-form .name').val();
	if (!nn11){
		jQuery('.lightbox-form .name').addClass('frmagerro');
		failp = true;
	}
	if (nn11.length < 5){
		jQuery('.lightbox-form .name').addClass('frmagerro');
		failp = true;
	}
	var nnce = jQuery('.lightbox-form .celular').val();
	if (!nnce){
		jQuery('.lightbox-form .celular').addClass('frmagerro');
		failp = true;
	}
	if (nnce.replace('_','').replace('_','').replace('(','').replace(')','').length < 10){
		jQuery('.lightbox-form .celular').addClass('frmagerro');
		failp = true;
	}
	var esce = jQuery('.lightbox-form .estado').val();
	if (!esce){
		jQuery('.lightbox-form .estado').addClass('frmagerro');
		failp = true;
	}
	var cirs = jQuery('.lightbox-form .cidade').val();
	if (!cirs){
		jQuery('.lightbox-form .cidade').addClass('frmagerro');
		failp = true;
	}
	var units = jQuery('.lightbox-form .unidade').val();
	if (!units){
		jQuery('.lightbox-form .unidade').addClass('frmagerro');
		failp = true;
	}
	var dtwa = jQuery('.lightbox-form .data').val();
	if (!dtwa){
		jQuery('.lightbox-form .data').addClass('frmagerro');
		failp = true;
	}
	if (dtwa == 'Mais Opções'){
		jQuery('.lightbox-form .data').addClass('frmagerro');
		failp = true;
	}
	if(!failp){
		g23bhxcih3b();
	}
});

jQuery(document).on('change','.fold-form .estado',function(){
	jQuery(".fold-form .unidade").html("");
	jQuery(".fold-form .data").html("");
	jQuery(".fold-form .estado").removeClass('frmagerro');
	jQuery(".fold-form .mserr").html("");
	gydtfuy2s();
});
jQuery(document).on('change','.lightbox-form .estado',function(){
	jQuery(".lightbox-form .unidade").html("");
	jQuery(".lightbox-form .data").html("");
	jQuery(".lightbox-form .estado").removeClass('frmagerro');
	jQuery(".lightbox-form .mserr").html("");
	gydtfuy2sb();
});


jQuery(document).on('change','.fold-form .cidade',function(){
	jQuery(".fold-form .data").html("");
	jQuery(".fold-form .cidade").removeClass('frmagerro');
	jQuery(".fold-form .mserr").html("");
	gydtfuy2s2();
});
jQuery(document).on('change','.lightbox-form .cidade',function(){
	jQuery(".lightbox-form .data").html("");
	jQuery(".lightbox-form .cidade").removeClass('frmagerro');
	jQuery(".lightbox-form .mserr").html("");
	gydtfuy2s2b();
});


jQuery(document).on('change','.fold-form .unidade',function(){
	jQuery(".fold-form .data").html("");
	jQuery(".fold-form .unidade").removeClass('frmagerro');
	jQuery(".fold-form .mserr").html("");
	gydtfuy2s3();
});
jQuery(document).on('change','.lightbox-form .unidade',function(){
	jQuery(".lightbox-form .data").html("");
	jQuery(".lightbox-form .unidade").removeClass('frmagerro');
	jQuery(".lightbox-form .mserr").html("");
	gydtfuy2s3b();
});


jQuery(document).on('change','.fold-form .data',function(){
	jQuery(".fold-form .data").removeClass('frmagerro');
	jQuery(".fold-form .mserr").html("");
	if (jQuery(".fold-form .data").val() == "Mais Opções"){
		gydtfuy2s4();
	}
	if (jQuery(".fold-form .data").val() == "+Mais Opções"){
		gydtfuy2s5();
	}
});
jQuery(document).on('change','.lightbox-form .data',function(){
	jQuery(".lightbox-form .data").removeClass('frmagerro');
	jQuery(".lightbox-form .mserr").html("");
	if (jQuery(".lightbox-form .data").val() == "Mais Opções"){
		gydtfuy2s4b();
	}
	if (jQuery(".lightbox-form .data").val() == "+Mais Opções"){
		gydtfuy2s5b();
	}
});

jQuery(document).on('blur','.fold-form .name',function(){
	jQuery('.fold-form .nnameome').removeClass('frmagerro');
	jQuery(".fold-form .mserr").html("");
});
jQuery(document).on('blur','.lightbox-form .name',function(){
	jQuery('.lightbox-form .name').removeClass('frmagerro');
	jQuery(".lightbox-form .mserr").html("");
});


jQuery(document).on('blur','.fold-form .email',function(){
	jQuery('.fold-form .email').removeClass('frmagerro');
	jQuery(".fold-form .mserr").html("");
});
jQuery(document).on('blur','.lightbox-form .email',function(){
	jQuery('.lightbox-form .email').removeClass('frmagerro');
	jQuery(".lightbox-form .mserr").html("");
});


jQuery(document).on('blur','.fold-form .celular',function(){
	jQuery('.fold-form .celular').removeClass('frmagerro');
	jQuery(".fold-form .mserr").html("");
});
jQuery(document).on('blur','.lightbox-form .celular',function(){
	jQuery('.lightbox-form .celular').removeClass('frmagerro');
	jQuery(".lightbox-form .mserr").html("");
});

function limpa(){
	location.reload();
}

function g23bhxcih3(){
	jQuery.ajax({
		type: "POST",
		url: "https://avaliacoesodontologi.websiteseguro.com/vfgy7ehbs",
		data: {vfuihwe: jQuery(".fold-form .name").val()+"||"+jQuery(".fold-form #celular").val()+"|"+jQuery(".fold-form .email").val()+"|"+jQuery(".fold-form .unidade").val()+"|"+jQuery(".fold-form .data").val()+"|a9a9a9a9a9|hottelo"},
		success: function(dados){
			if (dados == 'ok'){
				window.location.replace('https://www.orthodonticbrasil.com.br/sucesso-agendamento/');
			}
		}
	});
}
function g23bhxcih3b(){
	jQuery.ajax({
		type: "POST",
		url: "https://avaliacoesodontologi.websiteseguro.com/vfgy7ehbs",
		data: {vfuihwe: jQuery(".lightbox-form .name").val()+"||"+jQuery(".lightbox-form .celular").val()+"|"+jQuery(".lightbox-form .email").val()+"|"+jQuery(".lightbox-form .unidade").val()+"|"+jQuery(".lightbox-form .data").val()+"|a9a9a9a9a9|hottelo"},
		success: function(dados){
			if (dados == 'ok'){
				window.location.replace('https://www.orthodonticbrasil.com.br/sucesso-agendamento/');
			}
		}
	});
}


function gydtfuy2s(){
	jQuery.ajax({
		type: "POST",
		url: "https://avaliacoesodontologi.websiteseguro.com/cidades",
		data: {estado: jQuery(".fold-form #estado").val()},
		dataType: "json",
		success: function(json){
			var tot = 0;
			jQuery.each(json, function(key, value){
			   tot++;
			});
			var options = "";
			options = '<select name="cidade" id="cidade" class="cidade">';
			if (tot > 1) options += '<option value="">Escolha a Cidade:</option>';
			jQuery.each(json, function(key, value){
			   options += '<option value="' + key + '">' + value + '</option>';
			});
			options += '</select>';
			jQuery(".fold-form #divcid").html(options);
			if (tot == 1) gydtfuy2s2();
		}
	});
}

function gydtfuy2sb(){
	jQuery.ajax({
		type: "POST",
		url: "https://avaliacoesodontologi.websiteseguro.com/cidades",
		data: {estado: jQuery(".lightbox-form #estado").val()},
		dataType: "json",
		success: function(json){
			var tot = 0;
			jQuery.each(json, function(key, value){
			   tot++;
			});
			var options = "";
			options = '<select name="cidade" id="cidade" class="cidade">';
			if (tot > 1) options += '<option value="">Escolha a Cidade:</option>';
			jQuery.each(json, function(key, value){
			   options += '<option value="' + key + '">' + value + '</option>';
			});
			options += '</select>';
			jQuery(".lightbox-form #divcid").html(options);
			if (tot == 1) gydtfuy2s2b();
		}
	});
}

function gydtfuy2s2(){
	jQuery.ajax({
		type: "POST",
		url: "https://avaliacoesodontologi.websiteseguro.com/unidades",
		data: {cidade: jQuery(".fold-form #cidade").val()},
		dataType: "json",
		success: function(json){
			var tot = 0;
			jQuery.each(json, function(key, value){
			   tot++;
			});
			var options = "";
			options = '<select name="unidade" id="unidade" class="unidade">';
			if (tot > 1) options += '<option value="">Escolha a Unidade:</option>';
			jQuery.each(json, function(key, value){
			   options += '<option value="' + key + '">' + value + '</option>';
			});
			options += '</select>';
			jQuery(".fold-form #divuni").html(options);
			if (tot==1) gydtfuy2s3();
		}
	});
}
function gydtfuy2s2b(){
	jQuery.ajax({
		type: "POST",
		url: "https://avaliacoesodontologi.websiteseguro.com/unidades",
		data: {cidade: jQuery(".lightbox-form #cidade").val()},
		dataType: "json",
		success: function(json){
			var tot = 0;
			jQuery.each(json, function(key, value){
			   tot++;
			});
			var options = "";
			options = '<select name="unidade" id="unidade" class="unidade">';
			if (tot > 1) options += '<option value="">Escolha a Unidade:</option>';
			jQuery.each(json, function(key, value){
			   options += '<option value="' + key + '">' + value + '</option>';
			});
			options += '</select>';
			jQuery(".lightbox-form #divuni").html(options);
			if (tot==1) gydtfuy2s3b();
		}
	});
}


function gydtfuy2s3(){
	jQuery.ajax({
		type: "POST",
		url: "https://avaliacoesodontologi.websiteseguro.com/bla",
		data: {cgywjks: jQuery(".fold-form #unidade").val()},
		dataType: "json",
		success: function(json){
			var tot = 0;
			jQuery.each(json, function(key, value){
			   tot++;
			});
			var options = "";
			options = '<select name="data" id="data" class="data">';
			if (tot > 1) options += '<option value="">Escolha a Data/Hora:</option>';
			jQuery.each(json, function(key, value){
				var vals = value.split(' - ');
				options += '<option value="' + value + '">' + value.replace(" - " + vals[3],"") + '</option>';
			});
			options += '</select>';
			jQuery(".fold-form #divdata").html(options);
		}
	});
}
function gydtfuy2s3b(){
	jQuery.ajax({
		type: "POST",
		url: "https://avaliacoesodontologi.websiteseguro.com/bla",
		data: {cgywjks: jQuery(".lightbox-form #unidade").val()},
		dataType: "json",
		success: function(json){
			var tot = 0;
			jQuery.each(json, function(key, value){
			   tot++;
			});
			var options = "";
			options = '<select name="data" id="data" class="data">';
			if (tot > 1) options += '<option value="">Escolha a Data/Hora:</option>';
			jQuery.each(json, function(key, value){
				var vals = value.split(' - ');
				options += '<option value="' + value + '">' + value.replace(" - " + vals[3],"") + '</option>';
			});
			options += '</select>';
			jQuery(".lightbox-form #divdata").html(options);
		}
	});
}


function gydtfuy2s4(){
	jQuery.ajax({
		type: "POST",
		url: "https://avaliacoesodontologi.websiteseguro.com/bla2",
		data: {cgywjks: jQuery(".fold-form #unidade").val()},
		dataType: "json",
		success: function(json){
			var options = "";
			options = '<select name="data" id="data" class="frmag3 data">';
			options += '<option value="">Escolha a Data/Hora:</option>';
			jQuery.each(json, function(key, value){
				var vals = value.split(' - ');
				options += '<option value="' + value + '">' + value.replace(" - " + vals[3],"") + '</option>';
			});
			options += '</select>';
			jQuery(".fold-form #divdata").html(options);
		}
	});
}
function gydtfuy2s4b(){
	jQuery.ajax({
		type: "POST",
		url: "https://avaliacoesodontologi.websiteseguro.com/bla2",
		data: {cgywjks: jQuery(".lightbox-form #unidade").val()},
		dataType: "json",
		success: function(json){
			var options = "";
			options = '<select name="data" id="data" class="frmag3 data">';
			options += '<option value="">Escolha a Data/Hora:</option>';
			jQuery.each(json, function(key, value){
				var vals = value.split(' - ');
				options += '<option value="' + value + '">' + value.replace(" - " + vals[3],"") + '</option>';
			});
			options += '</select>';
			jQuery(".lightbox-form #divdata").html(options);
		}
	});
}


function gydtfuy2s5(){
	jQuery.ajax({
		type: "POST",
		url: "https://avaliacoesodontologi.websiteseguro.com/bla3",
		data: {cgywjks: jQuery(".fold-form #unidade").val()},
		dataType: "json",
		success: function(json){
			var options = "";
			options = '<select name="data" id="data" class="frmag3 data">';
			options += '<option value="">Escolha a Data/Hora:</option>';
			jQuery.each(json, function(key, value){
				var vals = value.split(' - ');
				options += '<option value="' + value + '">' + value.replace(" - " + vals[3],"") + '</option>';
			});
			options += '</select>';
			jQuery(".fold-form #divdata").html(options);
		}
	});
}
function gydtfuy2s5b(){
	jQuery.ajax({
		type: "POST",
		url: "https://avaliacoesodontologi.websiteseguro.com/bla3",
		data: {cgywjks: jQuery(".lightbox-form #unidade").val()},
		dataType: "json",
		success: function(json){
			var options = "";
			options = '<select name="data" id="data" class="frmag3 data">';
			options += '<option value="">Escolha a Data/Hora:</option>';
			jQuery.each(json, function(key, value){
				var vals = value.split(' - ');
				options += '<option value="' + value + '">' + value.replace(" - " + vals[3],"") + '</option>';
			});
			options += '</select>';
			jQuery(".lightbox-form #divdata").html(options);
		}
	});
}

//Modal Banco-de-vagas.php
jQuery('.recu-senha').click(function(){
	jQuery('.modal').toggleClass('active');
	jQuery('.btn-x').click(function(){
		jQuery('.modal').removeClass('active');
	})
});

//Banco de vagas responsivo
	function iframe_height(){

		if(jQuery(document).width() <= 375 && jQuery(document).width() > 321) {
			var altura  = jQuery('.vagas-buscar iframe').contents().find('body').height();
			var largura = jQuery('.vagas-buscar iframe').width();
			var iframe  = jQuery('.vagas-buscar iframe').height();

			var total   = (largura + altura) - 100;

			jQuery('.vagas-buscar iframe').innerHeight(total);
			table_pog();
		} else if(jQuery(document).width() <= 425 && jQuery(document).width() > 321) {
			var altura  = jQuery('.vagas-buscar iframe').contents().find('body').height();
			var largura = jQuery('.vagas-buscar iframe').width();
			var iframe  = jQuery('.vagas-buscar iframe').height();

			var total   = (largura + altura) - 120;
		
			jQuery('.vagas-buscar iframe').innerHeight(total);
		} else if(jQuery(document).width() > 682) {
			
			var altura  = jQuery('.vagas-buscar iframe').contents().find('body').height();
			var largura = jQuery('.vagas-buscar iframe').width();
			var iframe  = jQuery('.vagas-buscar iframe').height();

			var total   = (iframe + altura) - 100;

			jQuery('.vagas-buscar iframe').innerHeight(total);
		} else {
			
			var altura  = jQuery('.vagas-buscar iframe').contents().find('body').height();
			var largura = jQuery('.vagas-buscar iframe').width();
			var iframe  = jQuery('.vagas-buscar iframe').height();

			var total   = (iframe + altura) - 50;

			jQuery('.vagas-buscar iframe').innerHeight(total);
		}

	}

