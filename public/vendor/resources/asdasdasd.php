<style>
	.caption{
		position: absolute;
		z-index: 9999;
		margin: 0 auto;
		margin-top: 20%;
		width: 100%;
		text-align: center;
	}
        .caption h2 {
          color: #149a9c;
          font-family: 'Open Sans', sans-serif;
          font-size: 48px;
          font-weight: 600;
        }
        .caption h3 {
          color: #149a9c;
          font-family: 'Open Sans', sans-serif;
        }
        @media(max-width: 768px){
                .caption {
                  margin-top: 30%;
          }
        }
	.banner {
		max-width: 1800px;
		margin: 0 auto;
		text-transform: uppercase; 
	}
  @media (max-width: 998px) {
    .banner {
      min-height: 450px;
	  	background-position: left; 
		} 
	}
  	.banner-slider {
			overflow: hidden;
			position: relative; 
	}
    .banner-slider .slick-slide {
      float: left;
      text-align: center;
	  	position: relative; 
	}
    .banner-slider img {
      -o-object-fit: cover;
         object-fit: cover;
      width: 100%;
	  	height: 630px; 
	}
	@media (max-width: 484px) {
	.banner-slider img {
		height: 540px;
		-o-object-position: 3%;
		   object-position: 3%; } 
	}
    .banner-slider .slick-dots {
      padding: 25px 10px;
	  	text-align: center; 
	}
    .banner-slider .slick-dots li {
      display: inline-block;
      width: 15px;
      height: 15px;
      border-radius: 13px;
      background-color: #dadada;
      margin: 0 5px;
      margin-top: 30px;
      cursor: pointer;
	  	outline: none; 
	}
    .banner-slider .slick-dots .slick-active {
      background: #272727;
	  	outline: none; 
	}
    .banner-slider .slick-dots button {
      text-indent: -99999px;
      background-color: transparent;
      border: none;
      width: 100%;
      height: 100%;
	 }
	 .section {
			font-family: 'Open Sans', sans-serif;
			font-weight: 300;
	 }
	 .col-auto {
		 max-width: 277px;
	 }
	 .col-auto a img{
		 vertical-align: 20px;
	 }
	 .title-item {
		 color: #008080;
	 }
	 .site-info, .site-content, #colophon_TesseractTheme > .menu, #footer-banner {
     max-width: 100% !important;
	}
	.social-icons {
		 padding: 30px;
	}
	.social-icons a {
		padding-left: 5px;
	}
	.nav-menu-footer {
		 display: -webkit-box;
		 display: -ms-flexbox;
		 display: flex;
		 -ms-flex-wrap: wrap;
		     flex-wrap: wrap;
		 margin: 0 auto;
		 padding: 10px;
		 list-style: none;
		 -webkit-box-pack: center;
		     -ms-flex-pack: center;
		         justify-content: center;
	}
	.nav-menu-footer li {
		 display: inline-block;
		 padding: 5px;
	}
	.nav-menu-footer li a {
		 color: #fff;
	}
	footer {
		 background-color: rgba(16, 89, 91, 1);
	}
	.site-header a, .main-navigation ul ul a, #header-right-menu ul li a, .menu-open, .dashicons.menu-open, .menu-close, .dashicons.menu-close {
		color: #10595b;
	}
	@media(max-width: 768px){
		.col-md-4 {
			padding-bottom: 20px;
		}
	}
	@media(max-width: 768px) {
		.site-footer {
			margin-right: -20px !important;
    		margin-left: -20px !important;
		}
		#sidebar-footer, #content_TesseractTheme {
			padding: 0 !important;
		}
	}
.figure-advant {
width: 100px;
margin-top: 16px;
}
.advant .col-md-4 { 
display: -webkit-box; 
display: -ms-flexbox; 
display: flex;
}
.advant .title-item{ 
padding-left: 20px;
}
.advant p{ 
padding-left: 20px
}
#footer-horizontal-menu {
display: flex;
justify-content: center;
}
.wpcf7 {
width: 50%;
margin: 0 auto;
}
@media(max-width: 768px){
width: 100%;
}
</style>
<script type="text/javascript" src="https://www.brazilisencoes.com.br/wp-includes/js/jquery/jquery.js?ver=1.12.4"></script>
<script type="text/javascript" src="https://www.brazilisencoes.com.br/wp-content/themes/TESSERACT/js/jquery.sidr.min.js?ver=1.0.0"></script>
<section class="banner">
	<div class="banner-slider">
		<div>
			<figure>
				<?php if(have_rows('slide')):?>
				<?php while(have_rows('slide')): the_row();?>
				<?php 
											$image =  get_sub_field('imagem_slide');
											if( !empty($image) ): ?>
				<div class="caption">
					<strong>
						<h2>RESPEITO AO SEU DIREITO</h2>
					</strong>
					<h3>compre seu veículo 0KM com isenção de impostos</h3>
				</div>
				<img src="
					<?php echo $image['url']; ?>" alt="
					<?php echo $image['alt']; ?>" title="
					<?php echo $image['title']; ?>" />
					<?php endif; ?>
					<?php endwhile;?>
					<?php endif;?>
				</figure>
				<div></div>
			</section>
			<section class="section">
				<div class="container">
					<div class="row">
						<div class="col-md-3">
							<h6>
								<img src="https://brazilisencoes.com.br/wp-content/uploads/2018/08/1195445181899094722molumen_phone_icon.svg_.hi_-300x300.png" alt="contato" width="20" height="20">
					(11) 4213-2137 / 95783-5067 / 
					
									<a href="mailto:contato@brazilisencoes.com.br" target="_blank" rel="noopener">
										<span style="color: #121212;">
						contato@brazilisencoes.com.br
					
										</a>
									</h6>
								</div>
								<div class="col-md-3">
									<h6>
										<img src="https://brazilisencoes.com.br/wp-content/uploads/2018/08/icon-2.png" alt="" width="20" height="20" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/icon-2.png 165w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/icon-2-150x150.png 150w" sizes="(max-width: 20px) 100vw, 20px">&nbsp;
					
											<a href="https://www.google.com/maps/place/Brazil+Isen%C3%A7%C3%B5es/@-23.583427,-46.6401947,17z/data=!3m1!4b1!4m5!3m4!1s0x0:0x26581fb4bee1e186!8m2!3d-23.583427!4d-46.638006?hl=pt-BR" target="_blank" rel="noopener">R. Domingos de Morais, 770 - sala 1 bloco 2, Vila Mariana, São Paulo - SP</a>
										</h6>
									</div>
									<div class="col-md-3">
										<h6>
											<img class="alignnone wp-image-796" src="https://brazilisencoes.com.br/wp-content/uploads/2018/08/time_icon-icons.com_73366-300x300.png" alt="" width="20" height="20" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/time_icon-icons.com_73366-300x300.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/time_icon-icons.com_73366-150x150.png 150w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/time_icon-icons.com_73366.png 512w" sizes="(max-width: 20px) 100vw, 20px">&nbsp;Segunda a Sexta Feira das 09h ás 18h.
											</h6>
										</div>
										<div class="col-md-3 social-icons">
											<a href="https://www.google.com/search?ludocid=2762993232548848006&amp;hl=pt-BR&amp;q=Brazil%20Isen%C3%A7%C3%B5es%20Rua%20Domingos%20de%20Moraes%2C%20770%2C%20Sala%201%20Bloco%202%20Vila%20Mariana%20S%C3%A3o%20Paulo%20-%20SP%2004010-100&amp;_ga=2.227054365.1031241641.1535339578-936043679.1535339578#fpstate=lie" target="_blank" rel="noopener">
												<img src="https://brazilisencoes.com.br/wp-content/uploads/2018/08/google-1015752_960_720-294x300.png" alt="" width="25" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/google-1015752_960_720-294x300.png 294w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/google-1015752_960_720-150x150.png 150w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/google-1015752_960_720-300x306.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/google-1015752_960_720.png 706w" sizes="(max-width: 25px) 100vw, 25px">
												</a>
												<a href="https://www.instagram.com/brazilisencoes/" target="_blank" rel="noopener">
													<img src="https://brazilisencoes.com.br/wp-content/uploads/2018/08/facebook-icone-icon-300x300.png" alt="" width="25" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/facebook-icone-icon-300x300.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/facebook-icone-icon-150x150.png 150w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/facebook-icone-icon-768x768.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/facebook-icone-icon-1024x1024.png 1024w" sizes="(max-width: 25px) 100vw, 25px">&nbsp;&nbsp;
													</a>
													<a href="https://www.instagram.com/brazilisencoes/" target="_blank" rel="noopener">
														<img src="https://brazilisencoes.com.br/wp-content/uploads/2018/08/instagram-icone-icon-1-300x300.png" alt="" width="25" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/instagram-icone-icon-1-300x300.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/instagram-icone-icon-1-150x150.png 150w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/instagram-icone-icon-1-768x768.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/instagram-icone-icon-1-1024x1024.png 1024w" sizes="(max-width: 25px) 100vw, 25px">
														</a>
													</div>
												</div>
											</div>
										</section>
<section class="section"><h2 style="text-align: center; margin-top: 25px;"> Entre em contato conosco </h2><div class="container"><div class="row"><div class="col-md-12"><?php 
						echo do_shortcode('[contact-form-7 id="103" title="Formulário de contato 1"]');
					?></div></div></div>
																																																																																																				</section>
										<section class="auto-banner">
											<div class="container">
												<div class="row">
													<div class="col-md-12">
														<a href="http://www.brazilisencoes.com.br/contato/">
															<img style="display: flex; margin: 0 auto;" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/audi.jpg" alt="audi">
															</a>
														</div>
													</div>
												</div>
											</section>
											<br>
												<h2 style="font-size: 2em; text-align: center; color: #008080;">
													<strong>Você sabia que pode ter!</strong>
												</h2>
												<br>
													<section class="advant">
														<div class="container">
															<div class="row">
																<div class="col-md-4">
<figure class="figure-advant">																	<img src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/10/sports-car.png" alt="" width="40" height="40">
</figure>																	<div>
																			<h2 class="title-item">
																				<strong>RODÍZIO NUNCA MAIS!</strong>
																			</h2>
																			<p>
							 Autorização Especial para a liberação do rodízio Municipal, de veículos dirigidos 
							 por pessoas portadoras de deficiência ou por quem as transportem.
						</p>
																		</div>
																	</div>
																<div class="col-md-4">
																	<figure class="figure-advant">
																		<img src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/10/icon.png" alt="" width="40" height="40">
																		</figure>
																		<div>
																			<h2 class="title-item">
																				<strong>ISENÇÃO DE IPVA PARA SEMPRE!</strong>
																			</h2>
																			<p>
						 A isenção é válida para qualquer pessoa portadora de deficiência que tenha direito do benefício,  adquirindo veículos até 70 mil reais.
						</p>
																		</div>
																	</div>
																	<div class="col-md-4">
																		<figure class="figure-advant">
																			<img src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/10/thumbs-up-hand-symbol.png" alt="" width="40" height="40">
																			</figure>
																			<div>
																				<h2 class="title-item">
																					<strong>DESCONTO DE ATÉ 30% NA COMPRA DO SEU CARRO!</strong>
																				</h2>
																				<p>
						 Uma grande parcela da população tem direito à inseção. A Brazil Insenções pode te ajudar a conseguir comprar um carro OKm com até 30% de desconto.
						</p>
																			</div>
																		</div>
																	</div>
																</div>
															</section>
															<br>
																<br>
																	<br>
																		<div class="container">
																			<div class="row">
																				<div class="col-md-12">
																					<h2 style="font-size: 21px; text-align: center; color: #008080;">
					"Mais de 
																						<strong>80%</strong>  das pessoas que tem direito à isenção de impostos são portadores de mobilidade reduzida com perda total ou parcial de movimentos, apenas 
					
																						<strong>10%</strong> destas pessoas com mobilidade reduzida 
																						<strong>sabem o seu direito ao benefício de isenção </strong>".
				
																					</h2>
																				</div>
																			</div>
																		</div>
																		<br>
																			<br>
																				<br>
																					<h2 style="font-size: 21px; text-align: center; color: red;">
																						<strong>
			É LEI, VEJA NA TABELA ABAIXO SE ESTE DIREITO PODE SER SEU!	
		</strong>
																					</h2>
																					<br>
																						<br>
																							<br>
																								<section class="section">
																									<div class="container">
																										<div class="row">
																											<div class="col-md-4">
																												<a href="https://www.brazilisencoes.com.br/sequela-de-avc">
																													<img class="alignnone size-medium wp-image-468" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/1-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/1-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/1-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/1-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/1-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/1.png 1582w" sizes="(max-width: 300px) 100vw, 300px">
																													</a>
																													<br>
																														<a href="https://www.brazilisencoes.com.br/hernia-de-disco-na-coluna">
																															<img class="alignnone size-medium wp-image-469" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/2-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/2-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/2-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/2-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/2-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/2.png 1582w" sizes="(max-width: 300px) 100vw, 300px">
																															</a>
																															<br>
																																<a href="https://www.brazilisencoes.com.br/artrodese">
																																	<img class="alignnone size-medium wp-image-470" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/3-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/3-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/3-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/3-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/3-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/3.png 1582w" sizes="(max-width: 300px) 100vw, 300px">
																																	</a>
																																	<br>
																																		<a href="https://www.brazilisencoes.com.br/protese-de-femur">
																																			<img class="alignnone size-medium wp-image-471" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/4-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/4-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/4-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/4-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/4-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/4.png 1582w" sizes="(max-width: 300px) 100vw, 300px">
																																			</a>
																																			<br>
																																				<a href="https://www.brazilisencoes.com.br/cirurgia-de-joelho">
																																					<img class="alignnone size-medium wp-image-472" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/5-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/5-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/5-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/5-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/5-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/5.png 1582w" sizes="(max-width: 300px) 100vw, 300px">
																																					</a>
																																					<br>
																																						<a href="https://www.brazilisencoes.com.br/cancer-de-prostata-pos-cirurgico">
																																							<img class="alignnone size-medium wp-image-473" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/6-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/6-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/6-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/6-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/6-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/6.png 1582w" sizes="(max-width: 300px) 100vw, 300px">
																																							</a>
																																							<br>
																																								<a href="https://www.brazilisencoes.com.br/insulficiencia-renal-em-uso-fistula">
																																									<img class="alignnone size-medium wp-image-474" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/7-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/7-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/7-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/7-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/7-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/7.png 1582w" sizes="(max-width: 300px) 100vw, 300px">
																																									</a>
																																									<br>
																																										<a href="https://www.brazilisencoes.com.br/encurtamento-de-membro">
																																											<img class="alignnone size-medium wp-image-475" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/8-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/8-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/8-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/8-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/8-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/8.png 1582w" sizes="(max-width: 300px) 100vw, 300px">
																																											</a>
																																											<br>
																																												<a href="https://www.brazilisencoes.com.br/sindrome-do-tunel-do-carpo">
																																													<img class="alignnone size-medium wp-image-476" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/9-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/9-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/9-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/9-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/9-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/9.png 1582w" sizes="(max-width: 300px) 100vw, 300px">
																																													</a>
																																													<br>
																																														<a href="https://www.brazilisencoes.com.br/cirurgia-de-punho">
																																															<img class="alignnone size-medium wp-image-477" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/10-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/10-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/10-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/10-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/10-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/10.png 1582w" sizes="(max-width: 300px) 100vw, 300px">
																																															</a>
																																															<br>
																																																<a href="https://www.brazilisencoes.com.br/fisica">
																																																	<img class="alignnone size-medium wp-image-478" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/11-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/11-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/11-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/11-1024x86.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/11-1580x133.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/11.png 1582w" sizes="(max-width: 300px) 100vw, 300px">
																																																	</a>
																																																	<br>
																																																		<a href="https://www.brazilisencoes.com.br/cegueira">
																																																			<img class="alignnone size-medium wp-image-479" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/12-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/12-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/12-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/12-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/12-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/12.png 1582w" sizes="(max-width: 300px) 100vw, 300px">
																																																			</a>
																																																			<br>
																																																				<a href="https://www.brazilisencoes.com.br/ave-acidente-vascular-encefalico">
																																																					<img class="alignnone size-medium wp-image-480" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/13-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/13-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/13-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/13-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/13-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/13.png 1582w" sizes="(max-width: 300px) 100vw, 300px">
																																																					</a>
																																																				</div>
																																																				<div class="col-md-4">
																																																					<a href="https://www.brazilisencoes.com.br/esclerose-multipla">
																																																						<img class="alignnone size-medium wp-image-481" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/14-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/14-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/14-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/14-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/14-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/14.png 1583w" sizes="(max-width: 300px) 100vw, 300px">
																																																						</a>
																																																						<br>
																																																							<a href="https://www.brazilisencoes.com.br/monoplegia">
																																																								<img class="alignnone size-medium wp-image-482" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/15-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/15-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/15-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/15-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/15-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/15.png 1583w" sizes="(max-width: 300px) 100vw, 300px">
																																																								</a>
																																																								<br>
																																																									<a href="https://www.brazilisencoes.com.br/paralisia">
																																																										<img class="alignnone size-medium wp-image-483" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/16-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/16-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/16-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/16-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/16-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/16.png 1583w" sizes="(max-width: 300px) 100vw, 300px">
																																																										</a>
																																																										<br>
																																																											<a href="https://www.brazilisencoes.com.br/parkinson">
																																																												<img class="alignnone size-medium wp-image-484" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/17-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/17-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/17-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/17-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/17-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/17.png 1583w" sizes="(max-width: 300px) 100vw, 300px">
																																																												</a>
																																																												<br>
																																																													<a href="https://www.brazilisencoes.com.br/tendinite-cronica">
																																																														<img class="alignnone size-medium wp-image-485" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/18-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/18-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/18-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/18-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/18-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/18.png 1583w" sizes="(max-width: 300px) 100vw, 300px">
																																																														</a>
																																																														<br>
																																																															<a href="https://www.brazilisencoes.com.br/tetraparesia">
																																																																<img class="alignnone size-medium wp-image-486" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/19-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/19-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/19-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/19-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/19-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/19.png 1583w" sizes="(max-width: 300px) 100vw, 300px">
																																																																</a>
																																																																<br>
																																																																	<a href="https://www.brazilisencoes.com.br/manguito-rotador">
																																																																		<img class="alignnone size-medium wp-image-487" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/20-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/20-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/20-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/20-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/20-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/20.png 1583w" sizes="(max-width: 300px) 100vw, 300px">
																																																																		</a>
																																																																		<br>
																																																																			<a href="https://www.brazilisencoes.com.br/cancer-de-mama">
																																																																				<img class="alignnone size-medium wp-image-488" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/21-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/21-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/21-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/21-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/21-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/21.png 1583w" sizes="(max-width: 300px) 100vw, 300px">
																																																																				</a>
																																																																				<br>
																																																																					<a href="https://www.brazilisencoes.com.br/cirurgia-de-coluna">
																																																																						<img class="alignnone size-medium wp-image-489" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/22-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/22-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/22-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/22-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/22-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/22.png 1583w" sizes="(max-width: 300px) 100vw, 300px">
																																																																						</a>
																																																																						<br>
																																																																							<a href="https://www.brazilisencoes.com.br/espondilite-anquilosante">
																																																																								<img class="alignnone size-medium wp-image-490" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/23-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/23-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/23-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/23-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/23-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/23.png 1583w" sizes="(max-width: 300px) 100vw, 300px">
																																																																								</a>
																																																																								<br>
																																																																									<a href="https://www.brazilisencoes.com.br/artrose-de-quadril">
																																																																										<img class="alignnone size-medium wp-image-491" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/24-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/24-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/24-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/24-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/24-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/24.png 1583w" sizes="(max-width: 300px) 100vw, 300px">
																																																																										</a>
																																																																										<br>
																																																																											<a href="https://www.brazilisencoes.com.br/cirurgia-e-ou-lesao-de-ombro">
																																																																												<img class="alignnone size-medium wp-image-492" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/25-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/25-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/25-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/25-1024x86.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/25-1580x133.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/25.png 1583w" sizes="(max-width: 300px) 100vw, 300px">
																																																																												</a>
																																																																												<br>
																																																																													<a href="https://www.brazilisencoes.com.br/condromalacia-patelar-do-joelho">
																																																																														<img class="alignnone size-medium wp-image-493" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/26-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/26-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/26-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/26-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/26-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/26.png 1583w" sizes="(max-width: 300px) 100vw, 300px">
																																																																														</a>
																																																																													</div>
																																																																													<div class="col-md-4">
																																																																														<a href="https://www.brazilisencoes.com.br/amputacoes-ou-ausecia-de-membro">
																																																																															<img class="alignnone size-medium wp-image-494" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/27-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/27-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/27-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/27-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/27-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/27.png 1583w" sizes="(max-width: 300px) 100vw, 300px">
																																																																															</a>
																																																																															<br>
																																																																																<a href="https://www.brazilisencoes.com.br/doencas-renais-cronicas">
																																																																																	<img class="alignnone size-medium wp-image-495" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/28-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/28-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/28-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/28-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/28-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/28.png 1583w" sizes="(max-width: 300px) 100vw, 300px">
																																																																																	</a>
																																																																																	<br>
																																																																																		<a href="https://www.brazilisencoes.com.br/estomias">
																																																																																			<img class="alignnone size-medium wp-image-496" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/29-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/29-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/29-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/29-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/29-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/29.png 1583w" sizes="(max-width: 300px) 100vw, 300px">
																																																																																			</a>
																																																																																			<br>
																																																																																				<a href="https://www.brazilisencoes.com.br/artrite">
																																																																																					<img class="alignnone size-medium wp-image-497" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/30-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/30-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/30-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/30-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/30-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/30.png 1583w" sizes="(max-width: 300px) 100vw, 300px">
																																																																																					</a>
																																																																																					<br>
																																																																																						<a href="https://www.brazilisencoes.com.br/mental-severa-ou-profunda">
																																																																																							<img class="alignnone size-medium wp-image-498" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/31-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/31-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/31-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/31-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/31-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/31.png 1583w" sizes="(max-width: 300px) 100vw, 300px">
																																																																																							</a>
																																																																																							<br>
																																																																																								<a href="https://www.brazilisencoes.com.br/autistas">
																																																																																									<img class="alignnone size-medium wp-image-499" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/32-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/32-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/32-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/32-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/32-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/32.png 1583w" sizes="(max-width: 300px) 100vw, 300px">
																																																																																									</a>
																																																																																									<br>
																																																																																										<a href="https://www.brazilisencoes.com.br/doenca-degenerativa">
																																																																																											<img class="alignnone size-medium wp-image-500" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/33-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/33-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/33-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/33-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/33-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/33.png 1583w" sizes="(max-width: 300px) 100vw, 300px">
																																																																																											</a>
																																																																																											<br>
																																																																																												<a href="https://www.brazilisencoes.com.br/escoliose-acentuada">
																																																																																													<img class="alignnone size-medium wp-image-501" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/34-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/34-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/34-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/34-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/34-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/34.png 1583w" sizes="(max-width: 300px) 100vw, 300px">
																																																																																													</a>
																																																																																													<br>
																																																																																														<a href="https://www.brazilisencoes.com.br/nanismo">
																																																																																															<img class="alignnone size-medium wp-image-502" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/35-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/35-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/35-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/35-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/35-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/35.png 1583w" sizes="(max-width: 300px) 100vw, 300px">
																																																																																															</a>
																																																																																															<br>
																																																																																																<a href="https://www.brazilisencoes.com.br/paraplegia">
																																																																																																	<img class="alignnone size-medium wp-image-503" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/36-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/36-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/36-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/36-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/36-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/36.png 1583w" sizes="(max-width: 300px) 100vw, 300px">
																																																																																																	</a>
																																																																																																	<br>
																																																																																																		<a href="https://www.brazilisencoes.com.br/poliomielite">
																																																																																																			<img class="alignnone size-medium wp-image-504" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/37-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/37-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/37-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/37-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/37-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/37.png 1583w" sizes="(max-width: 300px) 100vw, 300px">
																																																																																																			</a>
																																																																																																			<br>
																																																																																																				<a href="https://www.brazilisencoes.com.br/proteses-internas-e-externas"><img class="alignnone size-medium wp-image-505" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/38-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/38-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/38-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/38-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/38-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/38.png 1583w" sizes="(max-width: 300px) 100vw, 300px"></a><br><a href="https://www.brazilisencoes.com.br/tetraplegia"><img class="alignnone size-medium wp-image-506" src="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/39-300x25.png" alt="" width="300" height="25" srcset="https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/39-300x25.png 300w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/39-768x65.png 768w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/39-1024x87.png 1024w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/39-1580x134.png 1580w, https://www.brazilisencoes.com.br/wp-content/uploads/2018/08/39.png 1583w" sizes="(max-width: 300px) 100vw, 300px"></a></div></div>
																																																																																																				</div>
																																																																																																			</section>
																																																																																																			<br>
																																																																																																				</section>


