@extends('layouts.tubarao-delivery')

<!-- <script src="{{ asset('/js/sticky.min.js')}}"></script> -->

<div class="escolher" style="display: none;">



    <div class="bg"></div>

    <div class="conteudo">

        <div class="x">X</div>

        <div class="op"></div>

    </div>

</div>

@section('content')



<script>
    addLoadDiv();
</script>



@include('admin.helpers._messages')



<script>
    // if (localStorage.getItem('entrega') == null || localStorage.getItem('entrega').length == 0) {

    //     alert("Não foi selecionado o CEP, por favor, retorne e digite seu CEP.");

    //     window.location = '/delivery';

    // }



    if (localStorage.getItem('time') == null || localStorage.getItem('time').length == 0) {

        setLocalStorageTime();

    }
</script>



<?php



$day = date('w');

$hora = new DateTime("now");

$bool = false;

$desativado = false;

$horaFechamento = "";

$horaAbertura = "";

$dias = array(

    '0' => 'Domingo',

    '1' => 'Segunda-Feira',

    '2' => 'Terça-Feira',

    '3' => 'Quarta-Feira',

    '4' => 'Quinta-Feira',

    '5' => 'Sexta-Feira',

    '6' => 'Sábado'

);



function gerarSlug($str)

{

    $str = strtolower(utf8_decode($str));

    $i = 1;

    $str = strtr($str, utf8_decode('àáâãäåæçèéêëìíîïñòóôõöøùúûüýýÿÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÑÒÓÔÕÖØÙÚÛÜÝÝŸ'), 'aaaaaaaceeeeiiiinoooooouuuuyyyaaaaaaaceeeeiiiinoooooouuuuyyy');

    $str = preg_replace("/([^a-z0-9])/", '-', utf8_encode($str));

    while ($i > 0)

        $str = str_replace('--', '-', $str, $i);

    if (substr($str, -1) == '-')

        $str = substr($str, 0, -1);

    return $str;
}



?>

@if(isset($configs))

@foreach($configs as $config)

@if($day == 0 && $config->config_date == 'domingo')

@if($hora > new DateTime($config->config_time) && $hora < new DateTime($config->config_time_end) && $config->config_status != 0)

    <?php

    $bool = true;

    $status = true;

    ?>

    @endif

    <?php

    if ($config->config_status == 0) {

        $desativado = true;
    }

    $horaFechamento = new DateTime($config->config_time_end);

    $horaAbertura = new DateTime($config->config_time);

    ?>

    @elseif($day == 1 && $config->config_date == 'segunda-feira')

    @if($hora > new DateTime($config->config_time) && $hora < new DateTime($config->config_time_end) && $config->config_status != 0)

        <?php

        $bool = true;

        $status = true;



        ?>

        @endif

        <?php

        if ($config->config_status == 0) {

            $desativado = true;
        }

        $horaFechamento = new DateTime($config->config_time_end);

        $horaAbertura = new DateTime($config->config_time);

        ?>

        @elseif($day == 2 && $config->config_date == 'terca-feira')

        @if($hora > new DateTime($config->config_time) && $hora < new DateTime($config->config_time_end) && $config->config_status != 0)

            <?php

            $bool = true;

            $status = true;

            ?>

            @endif

            <?php

            if ($config->config_status == 0) {

                $desativado = true;
            }

            $horaFechamento = new DateTime($config->config_time_end);

            $horaAbertura = new DateTime($config->config_time);

            ?>

            @elseif($day == 3 && $config->config_date == 'quarta-feira')

            @if($hora > new DateTime($config->config_time) && $hora < new DateTime($config->config_time_end) && $config->config_status != 0)

                <?php

                $bool = true;

                $status = true;

                ?>

                @endif

                <?php

                if ($config->config_status == 0) {

                    $desativado = true;
                }

                $horaFechamento = new DateTime($config->config_time_end);

                $horaAbertura = new DateTime($config->config_time);

                ?>

                @elseif($day == 4 && $config->config_date == 'quinta-feira')

                @if($hora > new DateTime($config->config_time) && $hora < new DateTime($config->config_time_end) && $config->config_status != 0)

                    <?php

                    $bool = true;

                    $status = true;

                    ?>

                    @endif

                    <?php

                    if ($config->config_status == 0) {

                        $desativado = true;
                    }

                    $horaFechamento = new DateTime($config->config_time_end);

                    $horaAbertura = new DateTime($config->config_time);

                    ?>

                    @elseif($day == 5 && $config->config_date == 'sexta-feira')

                    @if($hora > new DateTime($config->config_time) && $hora < new DateTime($config->config_time_end) && $config->config_status != 0)

                        <?php

                        $bool = true;

                        $status = true;

                        ?>

                        @endif

                        <?php

                        if ($config->config_status == 0) {

                            $desativado = true;
                        }

                        $horaFechamento = new DateTime($config->config_time_end);

                        $horaAbertura = new DateTime($config->config_time);

                        ?>

                        @elseif($day == 6 && $config->config_date == 'sabado')

                        @if($hora > new DateTime($config->config_time) && $hora < new DateTime($config->config_time_end) && $config->config_status != 0)

                            <?php

                            $bool = true;

                            $status = true;

                            ?>

                            @endif

                            <?php

                            if ($config->config_status == 0) {

                                $desativado = true;
                            }

                            $horaFechamento = new DateTime($config->config_time_end);

                            $horaAbertura = new DateTime($config->config_time);

                            ?>

                            @endif

                            @endforeach

                            @endif



                            <div class="lightbox" style="z-index: 999;">

                                <div class="lightbox__bg"></div>

                                <div class="lightbox__semcep">

                                    <div class="x">X</div>

                                    <div id="pog">

                                        <div class="titulo">Preencha seu endereço abaixo</div>

                                        <label for="uf">Estado</label><br />

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



                                        <label for="cidade">Cidade</label><br />

                                        <select name="cidade" id="cidade" required>
                                            <option value="Praia Grande"> Praia Grande </option>
                                            <option value="São Vicente"> São Vicente</option>
                                            <option value="Santos"> Santos</option>
                                        </select>

                                        <label for="endereco">Endereço</label><br />

                                        <input type="text" name="endereco" id="endereco" required />



                                        <input type="button" id="enviar-cep" value="PESQUISAR CEP" />

                                    </div>

                                </div>

                            </div>



                            <div class="agendar-hora">



                                <div class="bg"></div>



                                <div class="conteudo">

                                    <div class="x">X</div>

                                    <p>Nosso horário de atendimento acabou :(</p>

                                    <h3>Gostaria de continuar e agendar seu pedido?</h3>

                                    <label for="agendar-data">Pedido agendado para:</label>

                                    <input type="date" name="agendar-data" id="agendar-data" Disabled>

                                    <label for="agendar-hora">Digite a hora de entrega (<strong style="font-weight: bold;">a partir das hrs</strong>): </label>

                                    <input type="time" name="agendar-hora" id="agendar-hora">

                                    <input style="background-image: url({{ asset('/img/continuar.png') }}" class="btn" value="Continuar" id="continuar-agendamento" type="button" />

                                </div>



                                <script>
                                    var dateControl = document.querySelector('#agendar-data');

                                    dateControl.value = '2018-06-01';
                                </script>



                            </div>

                            @if(isset($banner) && !empty($banner->First()) && $banner->First()->promo_banner_home == '1')

                            <div class="produtos-banner">

                                <div class="container">

                                    <div class="produtos-banner__info">

                                        <h2>{{ $dias[$day] }}:</h2>

                                        <h3>{{ $banner->First()->getProduct->name_product }}</h3>

                                        <p>{{ $banner->First()->getProduct->description_product }}</p>

                                        <div class="btn">

                                            <input class="add-prod" id="{{ $banner->First()->getProduct->id }}" name="{{ $banner->First()->getProduct->name_product }}" price="{{$banner->First()->getProduct->price_product}}" type="submit" value="PEÇA AGORA">

                                        </div>

                                    </div>

                                    <div class="produtos-banner__img">

                                        <img src="{{ asset('/storage/media/banner/' . $banner->First()->promo_banner_pic_src) }}" alt="">

                                        <div class="price">

                                            <span>{{ number_format($banner->First()->getProduct->price_product, 2, ',', '.') }}</span>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            @endif

                            <div class="adicionarCarrinho"></div>

                            @if($bool == true && $desativado == false || $bool == false && $desativado == false)



                            <div class="produtos-nav">

                                <div class="container">

                                    <span>

                                        <form action="/delivery/loja">

                                            {{ csrf_field() }}

                                            <a id="cat-slide" class="prod-category" href="/delivery">

                                                <span>Todas</span>

                                            </a>

                                        </form>

                                        @foreach($categories as $category)

                                        @if($category->product()->count() > 0 && $category->id != 20 && $category->id != 8 )

                                        <?php $params = array('cat' => $category->name_category, 'category_id' => $category->id); ?>

                                        <a id="cat-slide" class="-prod-category" data_id="{{ $category->id }}" href="{{ route('productdelivery.categoria', $params) }}">

                                            <span>{{ $category->name_category }}</span>

                                        </a>



                                        @endif

                                        @endforeach

                                    </span>

                                </div>

                            </div>



                            <div class="produtos container clearfix">



                                <div class="produtos__banner" style="background-image: url({{ asset('/img/banner.jpg') }});"></div>

                                <!-- <div class="produtos__pesquisa clearfix">

                                    <input placeholder="Pesquisar..." type="text" id="produtos" />

                                    <input type="button" class="excluir-pesquisa" value="X" style="

			height: 46px;

			width: 46px;

			border: none;

			margin-left: -90px;

			margin-top: 2px;

			font-family: sans-serif;

			font-size: 18px;

			color: #d2d2d2;

			cursor: pointer;

			float: left;

			display: none;

			background: none;

			opacity: 1;

			" />

                                    <input class="enviar" type="button" value="Pesquisar" style="background-image: url({{ asset('/img/search.png') }});">

                                    <ul class="pesquisa-resultado-mobile" style="display:none;"></ul>

                                </div> -->

                                <!-- <div class="produtos__nav">

		<a href="#"><img src="{{ asset('img/icone-bebida.png')}}"/>Japa</a>

		<a href="#"><img src="{{ asset('img/icone-bebida.png')}}"/>Pratos</a>

		<a href="#"><img src="{{ asset('img/icone-bebida.png')}}"/>Sobremesas</a>

		<a href="#"><img src="{{ asset('img/icone-bebida.png')}}"/>Bebidas</a>

		<a href="#"><img src="{{ asset('img/icone-bebida.png')}}"/>Combos e Promoções</a>

	</div> -->



                                <div class="clearfix">

                                    <div class="produtos__conteudo">





                                        @if(sizeof($promoProducts) > 0)

                                        <h2>Promoções</h2>

                                        <div class="clearfix">

                                            @foreach($promoProducts as $product)

                                            @if($product->product_type == \App\Product::PROD_NORMAL)

                                            <div class="item-p" produto="{{ $product->name_product }}" pesquisa="{{ gerarSlug($product->name_product) }}">

                                                <div class="item-p__img">

                                                    <img src="{{ asset('/storage/media/product/'.$product->product_pic_src)}}" alt="{{ $product->name_product }}" title="{{ $product->name_product }}">

                                                </div>



                                                <div class="item-p__info">

                                                    <div class="info">

                                                        <div>

                                                            <a href="/delivery/produto/{{ gerarSlug($product->name_product) }}">{{ $product->name_product }}</a>

                                                        </div>

                                                        <div class="info__price">

                                                            @if($product->promotion_active == 1 && $product->promotion_price != 0 && ( $product->promotion_day == $day || $product->promotion_day == 7 ))

                                                            <small>{{ number_format($product->price_product, 2, ",", ".") }}</small>

                                                            @endif

                                                            <span p="{{ $product->id }}" id="preco-produto">

                                                                @if($product->promotion_active == 1 && $product->promotion_price != 0 && ( $product->promotion_day == $day || $product->promotion_day == 7 ))

                                                                {{ number_format($product->promotion_price, 2, ",", ".") }}

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

                                                        <input class="btn-item-product add-prod" type="button" id="{{ $product->id }}" name="{{$product->name_product}}" price="@if($product->promotion_active == 1 && $product->promotion_price != 0 && ( $product->promotion_day == $day || $product->promotion_day == 7 ))

												{{$product->promotion_price}}

												@else

												{{$product->price_product}}

												@endif" value="Adicionar ao Carrinho" />

                                                    </div>

                                                </div>

                                            </div>



                                            @elseif($product->product_type == \App\Product::PROD_VARIABLE)



                                            <div class="item-p" produto="{{ $product->name_product }}" pesquisa="{{ gerarSlug($product->name_product) }}">

                                                <div class="item-p__img">

                                                    <img src="{{ asset('/storage/media/product/'.$product->product_pic_src)}}" alt="{{ $product->name_product }}" title="{{ $product->name_product }}">

                                                </div>



                                                <div class="item-p__info">

                                                    <div class="info">

                                                        <div>

                                                            <a href="/delivery/produto/{{ gerarSlug($product->name_product) }}">{{ $product->name_product }}</a>

                                                        </div>

                                                        <div class="info__price">

                                                            @if($product->promotion_active == 1 && $product->promotion_price != 0 && ( $product->promotion_day == $day || $product->promotion_day == 7 ))

                                                            <small>{{ number_format($product->price_product, 2, ",", ".") }}</small>

                                                            @endif

                                                            <span>a partir de</span>

                                                            <span p="{{ $product->id }}" id="preco-produto">

                                                                @if($product->promotion_active == 1 && $product->promotion_price != 0 && ( $product->promotion_day == $day || $product->promotion_day == 7 ))

                                                                {{ number_format($product->promotion_price, 2, ",", ".") }}

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

                                                        <input class="btn-item-product add-var-prod" id="add-var-prod" type="button" id-produto="{{ $product->id }}" product-type="{{$product->product_type}}" name="{{$product->name_product}}" price="@if($product->promotion_active == 1 && $product->promotion_price != 0 && ( $product->promotion_day == $day || $product->promotion_day == 7 ))

												{{$product->promotion_price}}

												@else

												{{$product->price_product}}

												@endif" value="Adicionar ao Carrinho" />

                                                    </div>

                                                </div>

                                            </div>



                                            @elseif($product->product_type == \App\Product::PROD_COMPL)



                                            <div class="item-p" produto="{{ $product->id }}" pesquisa="{{ gerarSlug($product->name_product) }}" complemento="">

                                                <div class="item-p__img">

                                                    <img src="{{ asset('/storage/media/product/'.$product->product_pic_src)}}" alt="{{ $product->name_product }}" title="{{ $product->name_product }}">

                                                </div>



                                                <div class="item-p__info">

                                                    <div class="info">

                                                        <div><a href="/delivery/produto/{{ gerarSlug($product->name_product) }}">{{ $product->name_product }}</a></div>

                                                        <div class="info__price">

                                                            @if($product->promotion_active == 1 && $product->promotion_price != 0 && ( $product->promotion_day == $day || $product->promotion_day == 7 ))

                                                            <small>{{ number_format($product->price_product, 2, ",", ".") }}</small>

                                                            @endif

                                                            <span p="2" id="preco-produto">

                                                                @if($product->promotion_active == 1 && $product->promotion_price != 0 && ( $product->promotion_day == $day || $product->promotion_day == 7 ))

                                                                {{ number_format($product->promotion_price, 2, ",", ".") }}

                                                                @else

                                                                {{ number_format($product->price_product, 2, ",", ".") }}

                                                                @endif

                                                            </span>



                                                        </div>

                                                    </div>

                                                    <p p="{{ $product->id }}" id="nome-produto">{{ $product->description_product }}</p>

                                                    <div class="btn">

                                                        <input class="btn-item-product comp-prod" type="button" id="{{ $product->id }}" name="{{$product->name_product}}" price="

												@if($product->promotion_active == 1 && $product->promotion_price != 0 && ( $product->promotion_day == $day || $product->promotion_day == 7 ))

														{{$product->promotion_price}}

													@else

														{{$product->price_product}}

												@endif" comp-ids="{{ $product->product_comps }}" value="Ver Opções / Adicionar Complementos">

                                                    </div>

                                                </div>

                                            </div>



                                            @elseif($product->product_type == \App\Product::PROD_COMBO)

                                            <div class="item-p" produto="{{ $product->name_product }}" pesquisa="{{ gerarSlug($product->name_product) }}">

                                                <div class="item-p__img">

                                                    <img src="{{ asset('/storage/media/product/'.$product->product_pic_src)}}" alt="{{ $product->name_product }}" title="{{ $product->name_product }}">

                                                </div>



                                                <div class="item-p__info">

                                                    <div class="info">

                                                        <div>

                                                            <a href="/delivery/produto/{{ gerarSlug($product->name_product) }}">{{ $product->name_product }}</a>

                                                        </div>

                                                        <div class="info__price">

                                                            @if($product->promotion_active == 1 && $product->promotion_price != 0 && ( $product->promotion_day == $day || $product->promotion_day == 7 ))

                                                            <small>{{ number_format($product->price_product, 2, ",", ".") }}</small>

                                                            @endif

                                                            <span>a partir de</span>

                                                            <span p="{{ $product->id }}" id="preco-produto">

                                                                @if($product->promotion_active == 1 && $product->promotion_price != 0 && ( $product->promotion_day == $day || $product->promotion_day == 7 ))

                                                                {{ number_format($product->promotion_price, 2, ",", ".") }}

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

                                                        <input class="btn-item-product add-combo-prod" id="add-combo-prod" type="button" id-produto="{{ $product->id }}" product-type="{{$product->product_type}}" name="{{$product->name_product}}" price="@if($product->promotion_active == 1 && $product->promotion_price != 0 && ( $product->promotion_day == $day || $product->promotion_day == 7 ))

												{{$product->promotion_price}}

												@else

												{{$product->price_product}}

												@endif" value="Adicionar ao Carrinho" />

                                                    </div>

                                                </div>

                                            </div>
                                            @endif

                                            @endforeach

                                        </div>

                                        @endif

                                        @foreach($categories as $category)

                                        <?php $var = $category->product()->count(); ?>



                                        @if($category->product()->count() > 0 && isset($catId) && $category->id == intval($catId))

                                        <h2 data_id="{{ $category->id }}">{{ $category->name_category }}</h2>

                                        @elseif($category->product()->count() > 0 && !isset($catId))

                                        <h2 data_id="{{ $category->id }}">{{ $category->name_category }}</h2>

                                        @endif

                                        <div class="clearfix">



                                            @foreach($products as $product)



                                            @if($category->id == $product->category_id)



                                            @if($product->product_type == \App\Product::PROD_NORMAL)

                                            <div class="item-p" produto="{{ $product->name_product }}" pesquisa="{{ gerarSlug($product->name_product) }}">

                                                <div class="item-p__img">

                                                    <img src="{{ asset('/storage/media/product/'.$product->product_pic_src)}}" alt="{{ $product->name_product }}" title="{{ $product->name_product }}">

                                                </div>



                                                <div class="item-p__info">

                                                    <div class="info">

                                                        <div>

                                                            <a href="/delivery/produto/{{ gerarSlug($product->name_product) }}">{{ $product->name_product }}</a>

                                                        </div>

                                                        <div class="info__price">

                                                            @if($product->promotion_active == 1 && $product->promotion_price != 0 && ( $product->promotion_day == $day || $product->promotion_day == 7 ))

                                                            <small>{{ number_format($product->price_product, 2, ",", ".") }}</small>

                                                            @endif

                                                            <span p="{{ $product->id }}" id="preco-produto">

                                                                @if($product->promotion_active == 1 && $product->promotion_price != 0 && ( $product->promotion_day == $day || $product->promotion_day == 7 ))

                                                                {{ number_format($product->promotion_price, 2, ",", ".") }}

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

                                                        <input class="btn-item-product add-prod" type="button" id="{{ $product->id }}" name="{{$product->name_product}}" price="@if($product->promotion_active == 1 && $product->promotion_price != 0 && ( $product->promotion_day == $day || $product->promotion_day == 7 ))

												{{$product->promotion_price}}

												@else

												{{$product->price_product}}

												@endif" value="Adicionar ao Carrinho" />

                                                    </div>

                                                </div>

                                            </div>



                                            @elseif($product->product_type == \App\Product::PROD_COMPL)



                                            <div class="item-p" produto="{{ $product->id }}" pesquisa="{{ gerarSlug($product->name_product) }}" complemento="">

                                                <div class="item-p__img">

                                                    <img src="{{ asset('/storage/media/product/'.$product->product_pic_src)}}" alt="{{ $product->name_product }}" title="{{ $product->name_product }}">

                                                </div>



                                                <div class="item-p__info">

                                                    <div class="info">

                                                        <div><a href="/delivery/produto/{{ gerarSlug($product->name_product) }}">{{ $product->name_product }}</a></div>

                                                        <div class="info__price">

                                                            @if($product->promotion_active == 1 && $product->promotion_price != 0 && ( $product->promotion_day == $day || $product->promotion_day == 7 ))

                                                            <small>{{ number_format($product->price_product, 2, ",", ".") }}</small>

                                                            @endif

                                                            <span p="2" id="preco-produto">

                                                                @if($product->promotion_active == 1 && $product->promotion_price != 0 && ( $product->promotion_day == $day || $product->promotion_day == 7 ))

                                                                {{ number_format($product->promotion_price, 2, ",", ".") }}

                                                                @else

                                                                {{ number_format($product->price_product, 2, ",", ".") }}

                                                                @endif

                                                            </span>



                                                        </div>

                                                    </div>

                                                    <p p="{{ $product->id }}" id="nome-produto">{{ $product->description_product }}</p>

                                                    <div class="btn">

                                                        <input class="btn-item-product comp-prod" type="button" id="{{ $product->id }}" name="{{$product->name_product}}" price="

												@if($product->promotion_active == 1 && $product->promotion_price != 0 && ( $product->promotion_day == $day || $product->promotion_day == 7 ))

														{{$product->promotion_price}}

													@else

														{{$product->price_product}}

												@endif" comp-ids="{{ $product->product_comps }}" value="Ver Opções / Adicionar Complementos">

                                                    </div>

                                                </div>

                                            </div>



                                            @elseif($product->product_type == \App\Product::PROD_COMBO)

                                            <div class="item-p" produto="{{ $product->name_product }}" pesquisa="{{ gerarSlug($product->name_product) }}">

                                                <div class="item-p__img">

                                                    <img src="{{ asset('/storage/media/product/'.$product->product_pic_src)}}" alt="{{ $product->name_product }}" title="{{ $product->name_product }}">

                                                </div>



                                                <div class="item-p__info">

                                                    <div class="info">

                                                        <div>

                                                            <a href="/delivery/produto/{{ gerarSlug($product->name_product) }}">{{ $product->name_product }}</a>

                                                        </div>

                                                        <div class="info__price">

                                                            @if($product->promotion_active == 1 && $product->promotion_price != 0 && ( $product->promotion_day == $day || $product->promotion_day == 7 ))

                                                            <small>{{ number_format($product->price_product, 2, ",", ".") }}</small>

                                                            @endif

                                                            <span>a partir de</span>

                                                            <span p="{{ $product->id }}" id="preco-produto">

                                                                @if($product->promotion_active == 1 && $product->promotion_price != 0 && ( $product->promotion_day == $day || $product->promotion_day == 7 ))

                                                                {{ number_format($product->promotion_price, 2, ",", ".") }}

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

                                                        <input class="btn-item-product add-combo-prod" id="add-combo-prod" type="button" id-produto="{{ $product->id }}" product-type="{{$product->product_type}}" name="{{$product->name_product}}" price="@if($product->promotion_active == 1 && $product->promotion_price != 0 && ( $product->promotion_day == $day || $product->promotion_day == 7 ))

												{{$product->promotion_price}}

												@else

												{{$product->price_product}}

												@endif" value="Adicionar ao Carrinho" />

                                                    </div>

                                                </div>

                                            </div>

                                            @elseif($product->product_type == \App\Product::PROD_VARIABLE)



                                            <div class="item-p" produto="{{ $product->name_product }}" pesquisa="{{ gerarSlug($product->name_product) }}">

                                                <div class="item-p__img">

                                                    <img src="{{ asset('/storage/media/product/'.$product->product_pic_src)}}" alt="{{ $product->name_product }}" title="{{ $product->name_product }}">

                                                </div>



                                                <div class="item-p__info">

                                                    <div class="info">

                                                        <div>

                                                            <a href="/delivery/produto/{{ gerarSlug($product->name_product) }}">{{ $product->name_product }}</a>

                                                        </div>

                                                        <div class="info__price">

                                                            @if($product->promotion_active == 1 && $product->promotion_price != 0 && ( $product->promotion_day == $day || $product->promotion_day == 7 ))

                                                            <small>{{ number_format($product->price_product, 2, ",", ".") }}</small>

                                                            @endif

                                                            <span>a partir de</span>

                                                            <span p="{{ $product->id }}" id="preco-produto">

                                                                @if($product->promotion_active == 1 && $product->promotion_price != 0 && ( $product->promotion_day == $day || $product->promotion_day == 7 ))

                                                                {{ number_format($product->promotion_price, 2, ",", ".") }}

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

                                                        <input class="btn-item-product add-var-prod" id="add-var-prod" type="button" id-produto="{{ $product->id }}" product-type="{{$product->product_type}}" name="{{$product->name_product}}" price="@if($product->promotion_active == 1 && $product->promotion_price != 0 && ( $product->promotion_day == $day || $product->promotion_day == 7 ))

												{{$product->promotion_price}}

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

                                    <style>
                                        @media (min-width: 1120px) {

                                            .produtos__lista {

                                                border: none;

                                            }



                                            .produtos__lista--fixed {

                                                position: fixed;

                                                width: 350px;

                                                max-width: 350px;

                                                padding: 0 10px 10px;

                                                border-left: solid 1px #f1f1f1;

                                                border-right: solid 1px #f1f1f1;

                                                border-bottom: solid 1px #f1f1f1;

                                            }

                                        }
                                    </style>

                                    <div class="produtos__bg"></div>

                                    <div style="background-image: url({{ asset('/img/carrinho-mobile.svg')}})" class="produtos__action active"><span style="z-index: 1">0</span></div>

                                    <div class="produtos__lista">

                                        <div class="produtos__lista--fixed" data-margin-top="110">

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

                                                    <div class="carrinho-vazio" style="display: none;">

                                                        <img src="{{asset('img/sad.svg')}}">

                                                        <h3>Seu carrinho está vazio.</h3>

                                                        <p>Que tal iniciar seu pedido?</p>

                                                    </div>

                                                </div>

                                                <!-- <div class="valores" style="background-color: #f1f1f1;">

                                                     <div class="clearfix">

                                                        <span>Sub-Total:</span>

                                                        <span id="subtotal-carrinho">0,00</span>

                                                    </div> 

                                                    <div class="clearfix">

                                                        <span>Taxa de entrega:</span>

                                                        <span id="tx-entrega"></span>

                                                    </div> 

                                                </div>-->

                                                <!-- <div class="valores clearfix">

                                                    <span>Tempo de entrega estimado</span>

                                                    <span>

                                                    </span>

                                                </div> -->

                                                <div class="comprar">

                                                    <label for="obs">Obs:</label>

                                                    <textarea id="obs"></textarea>

                                                    <div class="clearfix">

                                                        <span>

                                                            TOTAL

                                                        </span>

                                                        <span id="total-carrinho">0,00</span>

                                                    </div>

                                                    <input type="button" value="Finalizar pedido" id="Finalizar-pedido">

                                                </div>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            </div>

                            @elseif($desativado == true)



                            <section class="closed">

                                <div class="container">

                                    <div class="row justify-content-center ">

                                        <div class="col-md-6">

                                            <img src="{{ asset('img/fechado.png') }}" alt="">



                                            <h2>Hoje <strong>não</strong> trabalhamos com entregas, </h2><br>

                                            <p>agradecemos a preferência!</p>





                                        </div>

                                    </div>



                                </div>

                            </section>



                            @endif

                            <script>
                                var agendamentoBool = false;





                                $(document.body).on('click', '#Finalizar-pedido', function() {



                                    if (verifyProds() > 0) {



                                        // var time = pegarHora();

                                        // var min = jQuery('#agendar-hora').attr('min');

                                        // var max = jQuery('#agendar-hora').attr('max');





                                        // var timeSplit = time.split(":");

                                        // var minSplit = min.split(":");

                                        // var maxSplit = max.split(":");



                                        // var abertura = new Date(2018, 01, 01, minSplit[0], minSplit[1]);

                                        // var fechamento = new Date(2018, 01, 01, maxSplit[0], maxSplit[1]);

                                        // var horaAtual = new Date(2018, 01, 01, timeSplit[0], timeSplit[1]);



                                        // if (abertura > fechamento) {

                                        //     fechamento.setDate(fechamento.getDate() + 1);

                                        //     if (horaAtual < abertura) {

                                        //         horaAtual.setDate(horaAtual.getDate() + 1);

                                        //     }

                                        // }

                                        // if (horaAtual >= abertura && horaAtual <= fechamento) {

                                        <?php

                                        if (!$bannerCarrinho->isEmpty()) {



                                        ?>

                                            getPromoBanner();

                                        <?php

                                        } else {



                                        ?>

                                            appendModalCep();

                                        <?php

                                        }



                                        ?>

                                        // } else {

                                        //     <?php



                                                //     if (!$banner->isEmpty()) {



                                                ?> agendamentoBool = true;

                                        //         getPromoBanner();

                                        //     <?php

                                                // } else {



                                                ?> jQuery(".agendar-hora").fadeIn(100);

                                        //     <?php

                                                // }



                                                ?>

                                        // }

                                    } else {

                                        alert("Adicione produtos ao carrinho para finalizar o pedido!");

                                    }

                                });

                                $(document).on('click', '#add-item-oferta', function() {

                                    var localId = JSON.parse(Base64Decode(localStorage.getItem("prods")));



                                    var idEntrega = JSON.parse(localStorage.getItem("entrega"));



                                    var id = $(this).attr('produto-id');



                                    var nome = $(this).attr('produto-nome');



                                    var preco = $(this).attr('produto-preco');



                                    var qtd = parseInt($('.qtd-item-oferta').val());



                                    adicionarProduto(id, qtd, nome, preco, localId, idEntrega);



                                    var obs = jQuery('#obs').val();



                                    localStorage.setItem("obs", obs);



                                    $('div.oferta').remove();



                                    appendModalCep();

                                });



                                function appendModalCep() {

                                    var html = `<section class="modal-cep ativo">



                                    <div class="bg"></div>

                                        <div class="conteudo">

                                        <div class="d-flex no-gutters modal-cep__bg justify-content-center align-items-center">

                                        <figure class="col-md-4">

                                        <img src="{{ asset('img/icon-map.svg') }}" alt="Entrega Rápida Sabor da Italia" title="Entrega Rápida Sabor da Italia">

                                        </figure>

                                        <div class="col-md-6">

                                        <h2>Entrega <br><strong>Rápida</strong></h2>

                                        </div>

                                        </div>

                                        <section class="modal-cep__content">

                                        <p>Digite seu CEP abaixo para começar:</p>

                                        <div class="modal-cep__form" style="display:flex; flex-direction: column; align-items: center;">

                                        <input name="cep " class="inicio__cep" placeholder="ex: 11700080" type="text">

                                        <input class="btn inicio__enviar" type="button" value="Continuar">
                                        
                                         <p class="btn inicio_retirar">Retirar na Loja</p>

                                        <p class="cep-error" style="font-size: 18px; color: red; display: none;">CEP inválido, tente novamente.</p>
                                            
                                            
                                        </div>

                                        </section>

                                        <p class="buscar">Não sei meu CEP</p>
                                        
                                       

                                       

                                        <div id="lojas-input">

                                        </div>

                                        <div onClick="fechaModal('.modal-cep')" class="x"><span onClick="fechaModal('.modal-cep')" class="x-desktop">X</span><span onClick="fechaModal('.modal-cep')" class="x-mobile">

                                        <svg fill="#797979" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="20.004px" height="20.004px" viewBox="0 0 400.004 400.004" style="enable-background:new 0 0 400.004 400.004;" xml:space="preserve">

                                        <g>

                                        <path d="M382.688,182.686H59.116l77.209-77.214c6.764-6.76,6.764-17.726,0-24.485c-6.764-6.764-17.73-6.764-24.484,0L5.073,187.757 c-6.764,6.76-6.764,17.727,0,24.485l106.768,106.775c3.381,3.383,7.812,5.072,12.242,5.072c4.43,0,8.861-1.689,12.242-5.072 c6.764-6.76,6.764-17.726,0-24.484l-77.209-77.218h323.572c9.562,0,17.316-7.753,17.316-17.315 C400.004,190.438,392.251,182.686,382.688,182.686z"></path>

                                        </g>

                                        </svg> 

                                        VOLTAR</span></div>



                                    </div>

                                    </section>`;



                                    $('body').append(html);

                                }



                                function getPromoBanner() {

                                    <?php

                                    if (!$banner->isEmpty()) {

                                    ?>

                                        var html = ` <div class="oferta ativo">

                                                        <div class="bg"></div>

                                                        <div class="conteudo">

                                                            <img src="<?php echo asset('/storage/media/banner/' . $banner->First()->promo_banner_pic_src) ?> " alt=""> 

                                                            <div class = "oferta-item" >

                                                        <span class = "clearfix qtd-itens" >

                                                        <p> Escolha a quantidade: </p> 

                                                        

                                                        <div class = "remItem"

                                                    id= "menos-item-oferta" > - </div>

                                                        <input class = "qtd-item-oferta" type= "number" value= "1" disabled>

                                                        <div class="addItem" id="mais-item-oferta"> + </div>

                                                         </span> <span>

                                                         <input style="background-image: url({{ asset('/img/continuar.png') }}; background-repeat: no-repeat;"

                                                    class = "btn prosseguir-pedido"

                                                    value = "Ignorar e prosseguir"

                                                    type = "button" / >

                                                        <input class = "btn add-item-oferta"

                                                    id= "add-item-oferta"

                                                    produto-id = "{{ $banner->First()->getProduct()->First()->id }}"

                                                    produto-nome = "{{ $banner->First()->getProduct()->First()->name_product }}"

                                                    produto-preco = "{{ $banner->First()->getProduct()->First()->price_product }}" value = "Adicionar ao carrinho" type = "button" / >

                                                    

                                                        </span> </div> </div> </div>`;



                                        $(html).insertAfter('body');

                                    <?php

                                    }

                                    ?>

                                }



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



                                // Carrinho fixed

                                if ($(window).innerWidth() > 1121) {

                                    $(this).scroll(function() {

                                        if ($(this).scrollTop() > 88) {

                                            $('.produtos__lista--fixed').css('top', '105px');



                                        } else {

                                            $('.produtos__lista--fixed').css('top', 'unset');

                                        }

                                    });

                                }
                            </script>

                            <script>
                                if (localStorage.getItem('entrega')) {
                                    localStorage.removeItem('entrega');
                                }

                                function fechaModal($class)

                                {

                                    $($class).remove();

                                }
                            </script>

                            @endsection