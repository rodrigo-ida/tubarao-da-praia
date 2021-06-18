@extends('layouts.tubarao-delivery')

@section('content')
<script src="{{ asset('/js/sticky.min.js')}}"></script>

<div class="escolher">



	<div class="bg"></div>

	<div class="conteudo">

		<div class="x">X</div>

		<div class="op"></div>

	</div>

</div>




<script>
	if (localStorage.getItem('entrega') == null || localStorage.getItem('entrega').length == 0) {

		alert("Não foi selecionado o CEP, por favor, retorne e digite seu CEP.");

		window.location = '/delivery';

	}
</script>



<?php



$day            = date('w');

$hora 			= new DateTime("now");

$bool           = false;

$desativado     = false;

$horaFechamento = "";

$horaAbertura   = "";



?>



@foreach($configs as $config)

@if($day == 0 && $config->config_date == 'domingo')

@if($hora > new DateTime($config->config_time) && $hora < new DateTime($config->config_time_end) && $config->config_status != 0)

	<?php

	$bool   = true;

	$status = true;

	?>

	@endif

	<?php

	if ($config->config_status == 0) {

		$desativado = true;
	}

	$horaFechamento = new DateTime($config->config_time_end);

	$horaAbertura   = new DateTime($config->config_time);

	?>

	@elseif($day == 1 && $config->config_date == 'segunda-feira')

	@if($hora > new DateTime($config->config_time) && $hora < new DateTime($config->config_time_end) && $config->config_status != 0)

		<?php

		$bool   = true;

		$status = true;



		?>

		@endif

		<?php

		if ($config->config_status == 0) {

			$desativado = true;
		}

		$horaFechamento = new DateTime($config->config_time_end);

		$horaAbertura   = new DateTime($config->config_time);

		?>

		@elseif($day == 2 && $config->config_date == 'terca-feira')

		@if($hora > new DateTime($config->config_time) && $hora < new DateTime($config->config_time_end) && $config->config_status != 0)

			<?php

			$bool   = true;

			$status = true;

			?>

			@endif

			<?php

			if ($config->config_status == 0) {

				$desativado = true;
			}

			$horaFechamento = new DateTime($config->config_time_end);

			$horaAbertura   = new DateTime($config->config_time);

			?>

			@elseif($day == 3 && $config->config_date == 'quarta-feira')

			@if($hora > new DateTime($config->config_time) && $hora < new DateTime($config->config_time_end) && $config->config_status != 0)

				<?php

				$bool   = true;

				$status = true;

				?>

				@endif

				<?php

				if ($config->config_status == 0) {

					$desativado = true;
				}

				$horaFechamento = new DateTime($config->config_time_end);

				$horaAbertura   = new DateTime($config->config_time);

				?>

				@elseif($day == 4 && $config->config_date == 'quinta-feira')

				@if($hora > new DateTime($config->config_time) && $hora < new DateTime($config->config_time_end) && $config->config_status != 0)

					<?php

					$bool   = true;

					$status = true;

					?>

					@endif

					<?php

					if ($config->config_status == 0) {

						$desativado = true;
					}

					$horaFechamento = new DateTime($config->config_time_end);

					$horaAbertura   = new DateTime($config->config_time);

					?>

					@elseif($day == 5 && $config->config_date == 'sexta-feira')

					@if($hora > new DateTime($config->config_time) && $hora < new DateTime($config->config_time_end) && $config->config_status != 0)

						<?php

						$bool   = true;

						$status = true;

						?>

						@endif

						<?php

						if ($config->config_status == 0) {

							$desativado = true;
						}

						$horaFechamento = new DateTime($config->config_time_end);

						$horaAbertura   = new DateTime($config->config_time);

						?>

						@elseif($day == 6 && $config->config_date == 'sabado')

						@if($hora > new DateTime($config->config_time) && $hora < new DateTime($config->config_time_end) && $config->config_status != 0)

							<?php

							$bool   = true;

							$status = true;

							?>

							@endif

							<?php

							if ($config->config_status == 0) {

								$desativado = true;
							}

							$horaFechamento = new DateTime($config->config_time_end);

							$horaAbertura   = new DateTime($config->config_time);

							?>

							@endif

							@endforeach



							<div class="agendar-hora">



								<div class="bg"></div>



								<div class="conteudo">

									<div class="x">X</div>

									<p>Nosso horário de atendimento acabou :(</p>

									<h3>Gostaria de continuar e agendar seu pedido?</h3>

									<label for="agendar-data">Pedido agendado para:</label>

									<input type="date" name="agendar-data" id="agendar-data" Disabled>

									<label for="agendar-hora">Digite a hora de entrega:</label>

									<input type="time" name="agendar-hora" id="agendar-hora">

									<input style="background-image: url({{ asset('/img/continuar.png') }}" class="btn" value="Continuar" id="continuar-agendamento" type="button" />

								</div>



								<script>
									var dateControl = document.querySelector('#agendar-data');

									dateControl.value = '2018-06-01';
								</script>



							</div>

							<div class="adicionarCarrinho"></div>

							@if($bool == true && $desativado == false || $bool == false && $desativado == false)

							<div class="produtos container clearfix">



								<div class="produtos__banner" style="background-image: url({{ asset('/img/banner.jpg') }});"></div>

								<div class="produtos__pesquisa clearfix">

									<input placeholder="Pesquisar..." type="text" id="produtos" />

									<input class="enviar" type="button" value="Pesquisar" style="background-image: url({{ asset('/img/search.png') }});">

									<ul class="pesquisa-resultado-mobile" style="display:none;"></ul>

								</div>

								<!-- <div class="produtos__nav">

		<a href="#"><img src="{{ asset('img/icone-bebida.png')}}"/>Japa</a>

		<a href="#"><img src="{{ asset('img/icone-bebida.png')}}"/>Pratos</a>

		<a href="#"><img src="{{ asset('img/icone-bebida.png')}}"/>Sobremesas</a>

		<a href="#"><img src="{{ asset('img/icone-bebida.png')}}"/>Bebidas</a>

		<a href="#"><img src="{{ asset('img/icone-bebida.png')}}"/>Combos e Promoções</a>

	</div> -->

								<div class="clearfix">

									<div class="produtos__conteudo">

										@if($desativado == false && $bool == false)

										<h3 class="alert">Atendimento das <span>{{ date_format($horaAbertura, "H:i") }}</span> às <span>{{ date_format($horaFechamento, "H:i") }}</span>, agende seu pedido!</h3>

										@else

										<h3 class="success">Atendimento das <span>{{ date_format($horaAbertura, "H:i") }}</span> às <span>{{ date_format($horaFechamento, "H:i") }}</span>, faça seu pedido!</h3>

										@endif



										@foreach($categories as $category)

										<?php $var = $category->product()->count(); ?>



										@if($category->product()->count() > 0)

										<h2>{{ $category->name_category }}</h2>

										@endif

										<div class="clearfix">



											@foreach($products as $product)



											@if($category->id == $product->category_id)



											@if($product->product_type == '0')

											<div class="item-p" produto="{{ $product->name_product }}">

												<div class="item-p__img">

													<img src="{{ asset('/storage/media/product/'.$product->product_pic_src)}}" alt="{{ $product->name_product }}" title="{{ $product->name_product }}">

												</div>



												<div class="item-p__info">

													<div class="info">

														<div>

															{{ $product->name_product }}

														</div>

														<div class="info__price">

															@if($product->promotion_active == 1 && $product->promotion_id != 0)

															<small>{{ number_format($product->price_product, 2, ",", ".") }}</small>

															@endif

															<span p="{{ $product->id }}" id="preco-produto">

																@if($product->promotion_active == 1 && $product->promotion_id != 0)

																{{ number_format($product->getPromotionPrice()->First()->price_promotion_after, 2, ",", ".") }}

																@else

																{{ number_format($product->price_product, 2, ",", ".") }}

																@endif

															</span>

														</div>

													</div>

													<p p="{{ $product->id }}" id="nome-produto">

														{{ $product->description_product }}

													</p>

													<div class="btn">

														<input class="btn-item-product add-prod" type="button" id="{{ $product->id }}" name="{{$product->name_product}}" price="@if($product->promotion_active == 1 && $product->promotion_id != null || $product->promotion_id != 0)

												{{$product->getPromotionPrice()->First()->price_promotion_after}}

												@else

												{{$product->price_product}}

												@endif" value="Adicionar ao Carrinho" />

													</div>

												</div>

											</div>



											@elseif($product->product_type == '2')



											<div class="item-p" produto="{{ $product->id }}" complemento="">

												<div class="item-p__img">

													<img src="{{ asset('/storage/media/product/'.$product->product_pic_src)}}" alt="{{ $product->name_product }}" title="{{ $product->name_product }}">

												</div>



												<div class="item-p__info">

													<div class="info">

														<div>{{ $product->name_product }}</div>

														<div class="info__price">

															@if($product->promotion_active == 1 && $product->promotion_id != 0)

															<small>{{ number_format($product->price_product, 2, ",", ".") }}</small>

															@endif

															<span p="2" id="preco-produto">

																@if($product->promotion_active == 1 && $product->promotion_id != 0)

																{{ number_format($product->getPromotionPrice()->First()->price_promotion_after, 2, ",", ".") }}

																@else

																{{ number_format($product->price_product, 2, ",", ".") }}

																@endif

															</span>



														</div>

													</div>

													<p p="{{ $product->id }}" id="nome-produto">{{ $product->description_product }}</p>

													<div class="btn">

														<input class="btn-item-product comp-prod" type="button" id="{{ $product->id }}" name="{{$product->name_product}}" price="

												@if($product->promotion_active == 1 && $product->promotion_id > 0)

														{{$product->getPromotionPrice()->First()->price_promotion_after}}

														@else

														{{$product->price_product}}

														@endif" value="Ver Opções">

													</div>

												</div>

											</div>



											@else

											<div class="item-p" produto="{{ $product->name_product }}">

												<div class="item-p__img">

													<img src="{{ asset('/storage/media/product/'.$product->product_pic_src)}}" alt="{{ $product->name_product }}" title="{{ $product->name_product }}">

												</div>



												<div class="item-p__info">

													<div class="info">

														<div>

															{{ $product->name_product }}

														</div>

														<div class="info__price">

															@if($product->promotion_active == 1 && $product->promotion_id != 0)

															<small>{{ number_format($product->price_product, 2, ",", ".") }}</small>

															@endif

															<span>a partir de</span>

															<span p="{{ $product->id }}" id="preco-produto">

																@if($product->promotion_active == 1 && $product->promotion_id != 0)

																{{ number_format($product->getPromotionPrice()->First()->price_promotion_after, 2, ",", ".") }}

																@else

																{{ number_format($product->price_product, 2, ",", ".") }}

																@endif

															</span>

														</div>

													</div>

													<p p="{{ $product->id }}" id="nome-produto">

														{{ $product->description_product }}

													</p>

													<select class="option-item" id-produto="{{ $product->id }}">

														<option value="">Escolha um produto</option>

														@foreach($variations as $variation)

														@if($product->id == $variation->prod_id)

														@if($variation->prod_var_promo_id > 0 && $variation->prod_var_active == 1)

														<option name-variation="{{ $variation->prod_var_name }}" id-variation="{{ $variation->id }}" value="{{ $variation->getPromotion()->First()->price_promotion_after }}">{{ $variation->prod_var_name . " - de " . number_format($variation->prod_var_price, 2, ',', '.') . " por R$ " . number_format($variation->getPromotion()->First()->price_promotion_after, 2, ',', '.') }}</option>

														@else

														<option name-variation="{{ $variation->prod_var_name }}" id-variation="{{ $variation->id }}" value="{{ $variation->prod_var_price }}">{{ $variation->prod_var_name . " - R$ " . number_format($variation->prod_var_price, 2, ',', '.') }}</option>

														@endif

														@endif

														@endforeach

													</select>

													<div class="btn">

														<input class="btn-item-product add-var-prod" id="add-var-prod" type="button" id-produto="{{ $product->id }}" name="{{$product->name_product}}" price="@if($product->promotion_active == 1 && $product->promotion_id != null || $product->promotion_id != 0)

												{{$product->getPromotionPrice()->First()->price_promotion_after}}

												@else

												{{$product->price_product}}

												@endif" value="Adicionar ao Carrinho" />

													</div>

												</div>

											</div>



											@endif

											@endif



											@endforeach

										</div>

										@endforeach

									</div>

									<div class="produtos__bg"></div>

									<div style="background-image: url({{ asset('/img/carrinho-mobile.png')}})" class="produtos__action active"><span style="z-index: 1">0</span></div>

									<div class="produtos__lista">

										<div class="produtos__lista--sticky" data-margin-top="110">

											<div class="produtos-header">

												<img src="{{ asset('img/carrinho-header.svg') }}" alt="">

												<span>Seu carrinho</span>

											</div>

											<div class="titulo clearfix">

												<span>Qtd.</span>

												<span>Produto</span>

												<span>Total R$</span>

											</div>

											<form>

												<div class="item clearfix list-products">

													<div class="carrinho-vazio">

														<img src="{{asset('img/sad.svg')}}">

														<h3>Seu carrinho vazinho.</h3>

														<p>Que tal iniciar seu pedido?</p>

													</div>

												</div>

												<div class="valores" style="background-color: #f1f1f1;">

													<div class="clearfix">

														<span>Sub-Total:</span>

														<span id="subtotal-carrinho">0,00</span>

													</div>

													<div class="clearfix">

														<span>Taxa de entrega:</span>

														<span id="tx-entrega"></span>

													</div>

												</div>

												<div class="valores clearfix">

													<span>Tempo de entrega estimado</span>

													<span>60min</span>

												</div>

												<div class="comprar">

													<label for="obs">Obs:</label>

													<textarea id="obs"></textarea>

													<div class="clearfix">

														<span>

															TOTAL

														</span>

														<span id="total-carrinho">0,00</span>

													</div>

													<a href="#"><input type="button" value="Finalizar pedido" id="Finalizar-pedido"></a>

												</div>

											</form>

										</div>

									</div>

								</div>

							</div>

							</div>

							@elseif($desativado == true)



							<div class="alert alert-danger">

								Hoje não trabalhamos com entregas, agradeçemos a preferência!

							</div>



							@endif

							<script>
								jQuery('.produtos__action').click(function() {

									jQuery('.produtos__lista').toggleClass('ativo');

									jQuery('.produtos__bg').toggleClass('ativo');

									if (jQuery(this).hasClass('active')) {

										jQuery(this).removeClass('active');

									} else {

										jQuery(this).addClass('active');

									}



								});

								jQuery('.produtos__bg').click(function() {

									jQuery('.produtos__lista').toggleClass('ativo');

									jQuery('.produtos__bg').toggleClass('ativo');

									if (jQuery('.produtos__action').hasClass('active')) {

										jQuery('.produtos__action').removeClass('active');

									} else {

										jQuery('.produtos__action').addClass('active');

									}

								});



								jQuery('.continuar-compra .x').click(function() {

									jQuery('.continuar-compra').toggleClass('ativo');

								});

								jQuery('.continuar-compra .bg').click(function() {

									jQuery('.continuar-compra').toggleClass('ativo');

								});



								jQuery('.escolher .x').click(function() {

									jQuery('.escolher').fadeOut(100);

								});

								jQuery('.escolher .bg').click(function() {

									jQuery('.escolher').fadeOut(100);

								});



								var bugAux = false;



								var listaComplemento = [];

								var complTotal = 0;



								$(document).ready(function() {

									inicializacao(<?php echo $loja; ?>);



									if ($(window).width() > 1120) {



										var sticky = new Sticky('.produtos__lista--sticky');



									}



									var listaComplemento = getComplements(listaComplemento);





									//desktop

									jQuery('.pesquisa-produtos #produtos').keyup(function() {

										input = jQuery(this);

										valor = input.val();

										filtro = valor.toUpperCase();

										jQuery('.pesquisa-resultado li').each(function() {

											item = jQuery(this).text().toUpperCase();

											if (item.indexOf(filtro) > -1) {

												jQuery(this).css('display', 'block');

												jQuery(this).addClass('on');

											} else {

												jQuery(this).css('display', 'none');

												jQuery(this).removeClass('on');

											}

										});

									});



									jQuery('.pesquisa-produtos #produtos').focus(function() {

										jQuery('.pesquisa-resultado').css('display', 'block');

									})

									jQuery('.produtos__pesquisa #produtos').focus(function() {

										jQuery('.pesquisa-resultado-mobile').css('display', 'block');

									})



									//mobile

									jQuery('.produtos__pesquisa #produtos').keyup(function() {

										input = jQuery(this);

										valor = input.val();

										filtro = valor.toUpperCase();

										jQuery('.pesquisa-resultado-mobile li').each(function() {

											item = jQuery(this).text().toUpperCase();

											if (item.indexOf(filtro) > -1) {

												jQuery(this).css('display', 'block');

												jQuery(this).addClass('on');

											} else {

												jQuery(this).css('display', 'none');

												jQuery(this).removeClass('on');

											}

										});

									});



									jQuery(document.body).on('click', '.pesquisa-resultado li, .pesquisa-resultado-mobile li', function() {

										var texto = jQuery(this).text();

										pesquisaScroll(texto);

									});



									//desktop

									jQuery(document.body).on('click', '.pesquisa-produtos .enviar', function() {

										var texto = jQuery('.pesquisa-resultado li.on').first().text();

										pesquisaScrollBtn(texto);

									});

									//mobile

									jQuery(document.body).on('click', '.produtos__pesquisa .enviar', function() {

										var texto = jQuery('.pesquisa-resultado-mobile li.on').first().text();

										pesquisaScrollBtn(texto);

									});



									var timeIni = '<?php echo date_format($horaAbertura, "H:i"); ?>';

									var timeFin = '<?php echo date_format($horaFechamento, "H:i"); ?>';

									definirHorarios(timeIni, timeFin);



									jQuery(document.body).on('click', '.agendar-hora .x', function() {

										jQuery('.agendar-hora').css('display', 'none');

									});

									jQuery(document.body).on('click', '.agendar-hora .bg', function() {

										jQuery('.agendar-hora').css('display', 'none');

									});



									jQuery(document.body).on('click', '#continuar-agendamento', function() {

										agendamento();

									});



								});



								$(document.body).on('click', '.add-var-prod', function() {



									var id = $(this).attr('id-produto');



									var price = parseFloat($('select[id-produto="' + id + '"] option:selected').val());



									var id_var = $('select[id-produto="' + id + '"] option:selected').attr('id-variation');



									var name = $('select[id-produto="' + id + '"] option:selected').attr('name-variation');



									var qtd = 1;



									var prods = JSON.parse(localStorage.getItem('prods'));



									var idEntrega = JSON.parse(localStorage.getItem('entrega'));



									if (id_var !== undefined) {



										$('select[id-produto="' + id + '"]').css('border-color', '');



										adicionarProdutoVariavel(id, id_var, idEntrega, qtd, name, price, prods);



										addProdAlert();



									} else {

										$('select[id-produto="' + id + '"]').css('border-color', 'red');

									}



								});



								$(document.body).on('click', '.add-prod', function() {

									var id = $(this).attr('id');

									var qtd = 1;

									var nome = $(this).attr('name');

									var preco = $(this).attr('price');

									var localId = JSON.parse(

										localStorage.getItem("prods")

									);

									var idEntrega = JSON.parse(localStorage.getItem("entrega"));

									qtd = parseInt(qtd);

									adicionarProduto(id, qtd, nome, preco, localId, idEntrega);

									addProdAlert();

								});

								$(document.body).on('click', '.comp-prod', function() {

									var id = $(this).attr('id');

									var qtd = 1;

									var nome = $(this).attr('name');

									var preco = $(this).attr('price');

									var checkbox = '';



									jQuery('.escolher').fadeIn(100);



									var obj = JSON.stringify(listaComplemento);

									var obj = JSON.parse(obj);



									complementosModal(id, qtd, nome, preco, checkbox, obj);



								});

								$(document.body).on('click', '.add-comp', function() {

									var produtosLista = JSON.parse(localStorage.getItem("prods"));

									var complementosLista = JSON.parse(localStorage.getItem("complementos"));



									adicionarComplemento(produtosLista, complementosLista);

									addProdAlert();

								});



								$(document.body).on('click', '.checkbox-item', function() {

									var preco = parseInt(jQuery('.nm-produto span').attr('price'));

									jQuery('.escolher__conteudo label').each(function() {

										if (jQuery(this).children('input[type=checkbox]').prop('checked')) {

											preco += parseInt(jQuery(this).children('.price').attr('price'));

										};

									});

									jQuery('.nm-produto span').text(numberToReal(preco));

								})



								var items = [];



								jQuery(document.body).on('click', '.remItem', function() {

									var el = jQuery(this).parent();

									var form = jQuery(this).prev();

									var localId = JSON.parse(

										localStorage.getItem("prods")

									);

									var idEntrega = JSON.parse(

										localStorage.getItem("entrega")

									);

									if (el.parent().attr('comp')) {

										var compId = el.parent().attr('comp');

									} else {

										var compId = false;

									}

									var id = el.attr('p');

									var complementosLista = JSON.parse(

										localStorage.getItem("complementos")

									);



									if ($(this).attr('var') !== null && $(this).attr('var') !== undefined) {



										removerQtProdVar($(this).attr('var'), idEntrega, el, form, localId);



									} else {



										removerQt(el, form, localId, idEntrega, id, compId, complementosLista);



									}

								});



								$(document.body).on('click', '.addItem', function() {

									var el = jQuery(this).parent();

									var form = jQuery(this).next();

									var id = el.attr('p');

									if (el.parent().attr('comp')) {

										var compId = el.parent().attr('comp');

									} else {

										var compId = false;

									}

									var localId = JSON.parse(

										localStorage.getItem("prods")

									);

									var idEntrega = JSON.parse(

										localStorage.getItem("entrega")

									);



									if ($(this).attr('var') !== null && $(this).attr('var') !== undefined) {



										adicionarQtProdVar($(this).attr('var'), idEntrega, el, form, localId);



									} else {



										adicionarQt(el, form, id, localId, idEntrega, compId);



									}

								});



								var agendamentoBool = false;



								$(document.body).on('click', '#Finalizar-pedido', function() {



									if (verifyProds() > 0) {

										var time = pegarHora();

										var min = jQuery('#agendar-hora').attr('min');

										var max = jQuery('#agendar-hora').attr('max');





										var timeSplit = time.split(":");

										var minSplit = min.split(":");

										var maxSplit = max.split(":");



										var abertura = new Date(2018, 01, 01, minSplit[0], minSplit[1]);

										var fechamento = new Date(2018, 01, 01, maxSplit[0], maxSplit[1]);

										var horaAtual = new Date(2018, 01, 01, timeSplit[0], timeSplit[1]);



										if (abertura > fechamento) {

											fechamento.setDate(fechamento.getDate() + 1);

											if (horaAtual < abertura) {

												horaAtual.setDate(horaAtual.getDate() + 1);

											}

										}



										if (horaAtual >= abertura && horaAtual <= fechamento) {

											<?php

											if (!$banner->isEmpty()) {

												?>

												getPromoBanner();

											<?php

										} else {

											?>

												window.location = "/delivery/finalizar";

											<?php

										}

										?>

										} else {

											<?php



											if (!$banner->isEmpty()) {

												?>

												agendamentoBool = true;

												getPromoBanner();

											<?php

										} else {

											?>

												jQuery(".agendar-hora").fadeIn(100);

											<?php

										}

										?>

										}

									} else {

										alert("Adicione produtos ao carrinho para finalizar o pedido!");

									}



								});



								$(document).on('click', '#add-item-oferta', function() {

									var localId = JSON.parse(localStorage.getItem("prods"));



									var idEntrega = JSON.parse(localStorage.getItem("entrega"));



									var id = $(this).attr('produto-id');



									var nome = $(this).attr('produto-nome');



									var preco = $(this).attr('produto-preco');



									var qtd = parseInt($('.qtd-item-oferta').val());



									adicionarProduto(id, qtd, nome, preco, localId, idEntrega);



									var obs = jQuery('#obs').val();



									localStorage.setItem("obs", obs);



									window.location = "/delivery/finalizar";

								});



								$(document).on('click', '#mais-item-oferta', function() {

									var qtd = parseInt($('.qtd-item-oferta').val());



									$('.qtd-item-oferta').val(qtd + 1);



								});



								$(document).on('click', '#menos-item-oferta', function() {

									var qtd = parseInt($('.qtd-item-oferta').val());



									if (qtd != 1) {



										$('.qtd-item-oferta').val(qtd - 1);



									}



								});



								$(document).on('click', '.prosseguir-pedido', function() {

									if (agendamentoBool) {



										$('.oferta.ativo').fadeOut(100);

										$('.agendar-hora').fadeIn(100);



									} else {



										window.location = "/delivery/finalizar";



									}



								});



								function getPromoBanner() {

									<?php

									if (!$banner->isEmpty()) {

										?>

										var html = `

					<div class="oferta ativo">

						<div class="bg"></div>

							<div class="conteudo">

								<img src="<?php echo asset('/storage/media/banner/' . $banner->First()->promo_banner_pic_src) ?>" alt="">

								<div class="oferta-item">	

								<span class="clearfix qtd-itens">

									<p>Escolha a quantidade:</p>
									<div class="remItem" id="menos-item-oferta">-</div>


										<input class="qtd-item-oferta" type="number" value="1" disabled>
										<div class="addItem" id="mais-item-oferta">+</div>


								</span>

						<span>
						<input style="background-image: url({{ asset('/img/continuar.png') }}" class="btn prosseguir-pedido" value="Ignorar e prosseguir" type="button"/>

							<input class="btn add-item-oferta"

							id="add-item-oferta" 

							produto-id="{{ $banner->First()->getProduct()->First()->id }}" 

							produto-nome="{{ $banner->First()->getProduct()->First()->name_product }}"

							produto-preco="{{ $banner->First()->getProduct()->First()->price_product }}"

							value="Adicionar ao carrinho" type="button"/>


						</span>

							</div>

						</div>

					</div>`;



										$(html).insertAfter('body');

									<?php

								}

								?>

								}
							</script>



							@endsection