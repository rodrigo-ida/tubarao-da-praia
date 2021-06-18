@extends('layouts.tubarao-delivery')
<!-- <script src="{{ asset('/js/sticky.min.js')}}"></script> -->

@section('content')
<div class="escolher">

    <div class="bg"></div>
    <div class="conteudo">
        <div class="x">X</div>
        <div class="op"></div>
    </div>
</div>

<script>
    addLoadDiv();
</script>

@include('admin.helpers._messages')

<script>
    if (localStorage.getItem('entrega') == null || localStorage.getItem('entrega').length == 0) {
        alert("Não foi selecionado o CEP, por favor, retorne e digite seu CEP.");
        window.location = '/delivery';
    }

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

                            <div class="agendar-hora">

                                <div class="bg"></div>

                                <div class="conteudo">
                                    <div class="x">X</div>
                                    <p>Nosso horário de atendimento acabou :(</p>
                                    <h3>Gostaria de continuar e agendar seu pedido?</h3>
                                    <label for="agendar-data">Pedido agendado para:</label>
                                    <input type="date" name="agendar-data" id="agendar-data" Disabled>
                                    <label for="agendar-hora">Digite a hora de entrega (<strong style="font-weight: bold;">a partir das {{ date_format($horaAbertura, "H:i") }}hrs</strong>): </label>
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

                            <div class="produtos-nav">
                                <div class="container">
                                    <span>
                                        <form action="/delivery/loja-{{ $shopName }}">
                                            {{ csrf_field() }}
                                            <a id="cat-slide" class="prod-category" href="/delivery">
                                                <span>Todas</span>
                                            </a>
                                        </form>
                                        @foreach($categories as $category)
                                        @if($category->product()->count() > 0)
                                        <form action="/delivery/categoria/{{ $category->name_category }}" data_id="{{ $category->id }}" class="form-category" method="GET">
                                            <!-- <input type="hidden" name="id-loja" value="{{ $loja }}">
                                            <input type="hidden" name="cep-id" value="{{ $tax->First()->id }}"> -->
                                            <input type="hidden" name="category_id" value="{{ $category->id }}">
                                            {{ csrf_field() }}
                                            <a id="cat-slide" class="prod-category" data_id="{{ $category->id }}" href="#">
                                                <span>{{ $category->name_category }}</span>
                                            </a>
                                        </form>
                                        @endif
                                        @endforeach
                                    </span>
                                </div>
                            </div>

                            <div class="produtos container clearfix">

                                <div class="produtos__banner" style="background-image: url({{ asset('/img/banner.jpg') }});"></div>
                                <div class="produtos__pesquisa clearfix">
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
                                        <h3 class="alert">Atendimento <strong>{{ $shopName->nome_loja }}</strong> das <span>{{ date_format($horaAbertura, "H:i") }}</span> às <span>{{ date_format($horaFechamento, "H:i") }}</span>, agende seu pedido!</h3>
                                        @else
                                        <h3 class="success">Atendimento <strong>{{ $shopName->nome_loja }}</strong> das <span>{{ date_format($horaAbertura, "H:i") }}</span> às <span>{{ date_format($horaFechamento, "H:i") }}</span>, faça seu pedido!</h3>
                                        @endif

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
                                                            {{ $product->name_product }}
                                                        </div>
                                                        <div class="info__price">
                                                            @if($product->promotion_active == 1 && $product->promotion_price != 0 && $product->promotion_day == $day)
                                                            <small>{{ number_format($product->price_product, 2, ",", ".") }}</small>
                                                            @endif
                                                            <span p="{{ $product->id }}" id="preco-produto">
                                                                @if($product->promotion_active == 1 && $product->promotion_price != 0 && $product->promotion_day == $day)
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
                                                        <input class="btn-item-product add-prod" type="button" id="{{ $product->id }}" name="{{$product->name_product}}" price="@if($product->promotion_active == 1 && $product->promotion_price != 0 && $product->promotion_day == $day)
												{{$product->promotion_price}}
												@else
												{{$product->price_product}}
												@endif" value="Adicionar ao Carrinho" />
                                                    </div>
                                                </div>
                                            </div>

                                            @elseif($product->product_type == \App\Product::PROD_VARIABLE)

                                            <div class="item-p" produto="{{ $product->id }}" pesquisa="{{ gerarSlug($product->name_product) }}" complemento="">
                                                <div class="item-p__img">
                                                    <img src="{{ asset('/storage/media/product/'.$product->product_pic_src)}}" alt="{{ $product->name_product }}" title="{{ $product->name_product }}">
                                                </div>

                                                <div class="item-p__info">
                                                    <div class="info">
                                                        <div>{{ $product->name_product }}</div>
                                                        <div class="info__price">
                                                            @if($product->promotion_active == 1 && $product->promotion_price != 0 && $product->promotion_day == $day)
                                                            <small>{{ number_format($product->price_product, 2, ",", ".") }}</small>
                                                            @endif
                                                            <span p="2" id="preco-produto">
                                                                @if($product->promotion_active == 1 && $product->promotion_price != 0 && $product->promotion_day == $day)
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
												@if($product->promotion_active == 1 && $product->promotion_price != 0 && $product->promotion_day == $day)
														{{$product->promotion_price}}
													@else
														{{$product->price_product}}
												@endif" comp-ids="{{ $product->product_comps }}" value="Ver Opções">
                                                    </div>
                                                </div>
                                            </div>

                                            @else
                                            <div class="item-p" produto="{{ $product->name_product }}" pesquisa="{{ gerarSlug($product->name_product) }}">
                                                <div class="item-p__img">
                                                    <img src="{{ asset('/storage/media/product/'.$product->product_pic_src)}}" alt="{{ $product->name_product }}" title="{{ $product->name_product }}">
                                                </div>

                                                <div class="item-p__info">
                                                    <div class="info">
                                                        <div>
                                                            {{ $product->name_product }}
                                                        </div>
                                                        <div class="info__price">
                                                            @if($product->promotion_active == 1 && $product->promotion_price != 0 && $product->promotion_day == $day)
                                                            <small>{{ number_format($product->price_product, 2, ",", ".") }}</small>
                                                            @endif
                                                            <span>a partir de</span>
                                                            <span p="{{ $product->id }}" id="preco-produto">
                                                                @if($product->promotion_active == 1 && $product->promotion_price != 0 && $product->promotion_day == $day)
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
                                                        <input class="btn-item-product add-var-prod" id="add-var-prod" type="button" id-produto="{{ $product->id }}" name="{{$product->name_product}}" price="@if($product->promotion_active == 1 && $product->promotion_price != 0 && $product->promotion_day == $day)
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
                                                            {{ $product->name_product }}
                                                        </div>
                                                        <div class="info__price">
                                                            @if($product->promotion_active == 1 && $product->promotion_price != 0 && $product->promotion_day == $day)
                                                            <small>{{ number_format($product->price_product, 2, ",", ".") }}</small>
                                                            @endif
                                                            <span p="{{ $product->id }}" id="preco-produto">
                                                                @if($product->promotion_active == 1 && $product->promotion_price != 0 && $product->promotion_day == $day)
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
                                                        <input class="btn-item-product add-prod" type="button" id="{{ $product->id }}" name="{{$product->name_product}}" price="@if($product->promotion_active == 1 && $product->promotion_price != 0 && $product->promotion_day == $day)
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
                                                        <div>{{ $product->name_product }}</div>
                                                        <div class="info__price">
                                                            @if($product->promotion_active == 1 && $product->promotion_price != 0 && $product->promotion_day == $day)
                                                            <small>{{ number_format($product->price_product, 2, ",", ".") }}</small>
                                                            @endif
                                                            <span p="2" id="preco-produto">
                                                                @if($product->promotion_active == 1 && $product->promotion_price != 0 && $product->promotion_day == $day)
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
												@if($product->promotion_active == 1 && $product->promotion_price != 0 && $product->promotion_day == $day)
														{{$product->promotion_price}}
													@else
														{{$product->price_product}}
												@endif" comp-ids="{{ $product->product_comps }}" value="Ver Opções">
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
                                                            {{ $product->name_product }}
                                                        </div>
                                                        <div class="info__price">
                                                            @if($product->promotion_active == 1 && $product->promotion_price != 0 && $product->promotion_day == $day)
                                                            <small>{{ number_format($product->price_product, 2, ",", ".") }}</small>
                                                            @endif
                                                            <span>a partir de</span>
                                                            <span p="{{ $product->id }}" id="preco-produto">
                                                                @if($product->promotion_active == 1 && $product->promotion_price != 0 && $product->promotion_day == $day)
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
                                                        <input class="btn-item-product add-combo-prod" id="add-combo-prod" type="button" id-produto="{{ $product->id }}" name="{{$product->name_product}}" price="@if($product->promotion_active == 1 && $product->promotion_price != 0 && $product->promotion_day == $day)
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
                                                            {{ $product->name_product }}
                                                        </div>
                                                        <div class="info__price">
                                                            @if($product->promotion_active == 1 && $product->promotion_price != 0 && $product->promotion_day == $day)
                                                            <small>{{ number_format($product->price_product, 2, ",", ".") }}</small>
                                                            @endif
                                                            <span>a partir de</span>
                                                            <span p="{{ $product->id }}" id="preco-produto">
                                                                @if($product->promotion_active == 1 && $product->promotion_price != 0 && $product->promotion_day == $day)
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
                                                        <input class="btn-item-product add-var-prod" id="add-var-prod" type="button" id-produto="{{ $product->id }}" name="{{$product->name_product}}" price="@if($product->promotion_active == 1 && $product->promotion_price != 0 && $product->promotion_day == $day)
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
                                                    <span>
                                                        @if(date_format(new DateTime($tax->order_shipping_time), "H") == '00')

                                                        {{ date_format(new DateTime($tax->order_shipping_time), "i") }} min

                                                        @else

                                                        {{ date_format(new DateTime($tax->order_shipping_time), "H") }} hora e {{ date_format(new DateTime($tax->order_shipping_time), "i") }} min

                                                        @endif
                                                    </span>
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
                                $(document.body).on('click', '.add-combo-prod', function() {
                                    getComboModal($(this).attr('id-produto'), $(this).attr('name'), $(this).attr('price'));
                                });

                                $(document.body).on('click', '.checkbox-combo-item', function(event) {

                                    var cat_id = $(this).attr('cat-id');

                                    var num_esc = $(this).attr('num_esc');

                                    if ($('.checkbox-combo-item[cat-id="' + cat_id + '"]:checked').length > num_esc) {
                                        event.preventDefault();
                                        alert('você já selecionou os sabores');
                                    }

                                });

                                $(document.body).on('click', '.checkbox-combo-item', function(event) {

                                    var cat_id = $(this).attr('cat-id');

                                    var num_esc = $(this).attr('num_esc');

                                    if ($('.checkbox-combo-item[cat-id="' + cat_id + '"]:checked').length > num_esc) {

                                        event.preventDefault();
                                        alert('você já selecionou os sabores');

                                    }

                                });

                                $(document.body).on('click', '#add-combo', function(event) {
                                    var comboSelected = [];
                                    var cats = [];
                                    var ids = [];

                                    $.each($('input.checkbox-combo-item:checked'), function(i, p) {

                                        cats.push($(this).attr('cat_id'));

                                    });

                                    for (let c of cats) {

                                        comboSelected[c] = $('.checkbox-combo-item[cat_id="' + c + '"]:checked').length;

                                    }

                                    $.each($('input.checkbox-combo-item:checked'), function(i, p) {

                                        ids.push($(this).attr('name'));

                                    });

                                    if (!verifyCombo(comboSelected)) {
                                        alert('Selecione todas as combinações, por favor!');
                                        return;
                                    }

                                    addComboProduct(JSON.parse(Base64Decode(localStorage.getItem("prods"))), ids, $(this).attr('prod_id'), $(this).attr('prod_name'), $(this).attr('prod_price'));
                                });

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

                                    inicializacao(<?php echo $loja; ?>, <?php echo $tax->order_tax_price; ?>);

                                    if ($(window).width() > 1120) {

                                        // var sticky 	  = new Sticky('.produtos__lista--sticky');

                                    }

                                    var listaComplemento = getComplements(listaComplemento);

                                    //desktop
                                    jQuery('.pesquisa-produtos #produtos').keyup(function() {
                                        input = jQuery(this);
                                        valor = input.val();
                                        filtro = valor.toUpperCase();

                                        if (input.val().length > 0) {
                                            $('.excluir-pesquisa').show();
                                        } else {
                                            $('.excluir-pesquisa').hide();
                                        }

                                        jQuery('.pesquisa-resultado li').each(function() {
                                            item = jQuery(this).text().toUpperCase();
                                            if (item.indexOf(filtro) > -1) {
                                                $('.excluir-pesquisa').css('opacity', 1);
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

                                        if (input.val().length > 0) {
                                            $('.excluir-pesquisa').show();
                                        } else {
                                            $('.excluir-pesquisa').hide();
                                        }

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
                                        if (texto == '') {
                                            texto = $('#produtos').val();
                                        }
                                        pesquisaScrollBtn(texto);
                                    });
                                    //mobile
                                    jQuery(document.body).on('click', '.produtos__pesquisa .enviar', function() {
                                        var texto = jQuery('.pesquisa-resultado-mobile li.on').first().text();
                                        if (texto == '') {
                                            texto = $('#produtos').val();
                                        }
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

                                    $(document.body).on('click', '.x', function() {
                                        $('#var-modal').remove();
                                    });

                                    $(document.body).on('click', '.addVarItem', function() {
                                        var id = $(this).attr('id-var');

                                        var qt = $('#qt-variation[id-var="' + id + '"]').val();

                                        $('#qt-variation[id-var="' + id + '"]').text('');

                                        $('#qt-variation[id-var="' + id + '"]').val(parseInt(qt) + 1);
                                    });

                                    $(document.body).on('click', '.remVarItem', function() {
                                        var id = $(this).attr('id-var');

                                        var qt = $('#qt-variation[id-var="' + id + '"]').val();

                                        if (parseInt(qt) == 0) {
                                            return;
                                        }

                                        $('#qt-variation[id-var="' + id + '"]').text('');

                                        $('#qt-variation[id-var="' + id + '"]').val(parseInt(qt) - 1);
                                    });

                                    $('.excluir-pesquisa').click(function() {
                                        $('.produtos__pesquisa #produtos').val('');
                                        $('.pesquisa-produtos  #produtos').val('');
                                        $(this).hide();
                                    });

                                    removeLoadDiv()

                                });

                                jQuery(document).ready(function() {
                                    jQuery(document.body).click(function() {
                                        if (jQuery('#produtos').val().length != 0 && jQuery('body').data('clicked', true)) {
                                            jQuery('.pesquisa-resultado').hide();
                                        }
                                    })
                                });

                                $(document.body).on('click', '.add-var-prod', function() {

                                    getVariationsModal($(this).attr('id-produto'));

                                    // var id		  = $(this).attr('id-produto');

                                    // var price 	  = parseFloat($('select[id-produto="' + id + '"] option:selected').val());

                                    // var id_var 	  = $('select[id-produto="' + id + '"] option:selected').attr('id-variation');

                                    // var name 	  = $('select[id-produto="' + id + '"] option:selected').attr('name-variation');

                                    // var qtd 	  = 1;

                                    // var prods 	  = JSON.parse(Base64Decode(localStorage.getItem('prods')));

                                    // var idEntrega = JSON.parse(localStorage.getItem('entrega'));

                                    // if(id_var !== undefined){

                                    // 	$('select[id-produto="' + id + '"]').css('border-color', '');

                                    // 	adicionarProdutoVariavel(id, id_var, idEntrega, qtd, name, price, prods);

                                    // 	addProdAlert();

                                    // }else{
                                    // 	$('select[id-produto="' + id + '"]').css('border-color', 'red');
                                    // }

                                });

                                $(document).on('click', '#addVarProd', function() {
                                    $('.qt-variation').each(function() {
                                        if ($(this).val() > 0) {

                                            var id = $(this).attr('id-prod');

                                            var price = $(this).attr('price');

                                            var id_var = $(this).attr('id-var');

                                            var name = $(this).attr('name');

                                            var qtd = $(this).val();

                                            var prods = JSON.parse(Base64Decode(localStorage.getItem('prods')));

                                            var idEntrega = JSON.parse(localStorage.getItem('entrega'));

                                            adicionarProdutoVariavel(id, id_var, idEntrega, qtd, name, price, prods);

                                            $('#var-modal').remove();

                                        }
                                    });
                                });

                                $(document.body).on('click', '.add-prod', function() {
                                    var id = $(this).attr('id');
                                    var qtd = 1;
                                    var nome = $(this).attr('name');
                                    var preco = $(this).attr('price');

                                    if (localStorage.getItem("prods") != null && Object.keys(localStorage.getItem("prods")).length !== 0) {

                                        var localId = JSON.parse(
                                            Base64Decode(localStorage.getItem("prods"))
                                        );

                                    } else {

                                        var localId = [];

                                    }

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
                                    var comps = $(this).attr('comp-ids');

                                    jQuery('.escolher').fadeIn(100);

                                    var obj = JSON.stringify(listaComplemento);
                                    var obj = JSON.parse(obj);

                                    complementosModal(id, qtd, nome, preco, checkbox, obj, JSON.parse(comps));

                                });
                                $(document.body).on('click', '.add-comp', function() {
                                    var produtosLista = JSON.parse(Base64Decode(localStorage.getItem("prods")));
                                    var complementosLista = JSON.parse(Base64Decode(localStorage.getItem("complementos")));

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
                                        Base64Decode(localStorage.getItem("prods"))
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
                                        Base64Decode(localStorage.getItem("complementos"))
                                    );

                                    if ($(this).attr('var') !== null && $(this).attr('var') !== undefined) {

                                        removerQtProdVar($(this).attr('var'), idEntrega, el, form, localId);

                                    } else if ($(this).attr('comboVar')) {

                                        var comboVar = $(this).attr('comboVar');
                                        removerQt(el, form, localId, idEntrega, id, compId, complementosLista, comboVar);
                                        console.log(JSON.parse(Base64Decode(localStorage.getItem('prods'))));

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
                                        Base64Decode(localStorage.getItem("prods"))
                                    );

                                    var idEntrega = JSON.parse(
                                        localStorage.getItem("entrega")
                                    );

                                    if ($(this).attr('var') !== null && $(this).attr('var') !== undefined) {

                                        adicionarQtProdVar($(this).attr('var'), idEntrega, el, form, localId);

                                    } else if ($(this).attr('comboVar')) {
                                        var comboVars = $(this).attr('comboVar');
                                        adicionarQt(el, form, id, localId, idEntrega, compId, comboVars);
                                        console.log('ADICIONANDO:', JSON.parse(Base64Decode(localStorage.getItem('prods'))));
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
                                                window.location = "/client/area-do-cliente";
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
                                    var localId = JSON.parse(Base64Decode(localStorage.getItem("prods")));

                                    var idEntrega = JSON.parse(localStorage.getItem("entrega"));

                                    var id = $(this).attr('produto-id');

                                    var nome = $(this).attr('produto-nome');

                                    var preco = $(this).attr('produto-preco');

                                    var qtd = parseInt($('.qtd-item-oferta').val());

                                    adicionarProduto(id, qtd, nome, preco, localId, idEntrega);

                                    var obs = jQuery('#obs').val();

                                    localStorage.setItem("obs", obs);

                                    window.location = "/delivery/identificacao";
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

                                        window.location = "/delivery/identificacao";

                                    }

                                });

                                jQuery(document).ready(function() {

                                    jQuery('.pesquisa-produtos').click(function() {
                                        jQuery('.pesquisa-resultado').css('display', 'block');
                                    });

                                    jQuery("body").on("click", function(e) {
                                        var search = jQuery('.pesquisa-produtos');
                                        if (search.has(e.target).length || e.target == search[0])
                                            return;
                                        jQuery('.pesquisa-resultado').css('display', 'none');
                                    });

                                    var i = verifyProds();

                                    if (i == 0) {
                                        $('.carrinho-vazio').show();
                                    }

                                    var header_height = $('header').height();

                                    var cart_height = $('.produtos__lista--fixed').height();

                                    var window_height = screen.height;

                                    var val = (window_height - header_height) - cart_height - 150;

                                    $('.list-products').css('max-height', val);

                                });

                                $(window).scroll(function() {
                                    if ($(this).scrollTop() > 168) {
                                        $('.produtos__lista--fixed').css('top', '105px');

                                    } else {
                                        $('.produtos__lista--fixed').css('top', 'unset');
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
                                                                <div class="addItem" id="mais-item-oferta">+</div>
                                                                    <input class="qtd-item-oferta" type="number" value="1" disabled>
                                                                <div class="remItem" id="menos-item-oferta">-</div>
                                                            </span>
                                                    <span>
                                                        <input class="btn add-item-oferta"
                                                        id="add-item-oferta" 
                                                        produto-id="{{ $banner->First()->getProduct()->First()->id }}" 
                                                        produto-nome="{{ $banner->First()->getProduct()->First()->name_product }}"
                                                        produto-preco="{{ $banner->First()->getProduct()->First()->price_product }}"
                                                        value="Adicionar ao carrinho" type="button"/>
                                                        <input style="background-image: url({{ asset('/img/continuar.png') }}; background-repeat: no-repeat;" class="btn prosseguir-pedido" value="Ignorar e prosseguir" type="button"/>
                                                    </span>
                                                        </div>
                                                    </div>
                                                </div>`;

                                        $(html).insertAfter('body');
                                    <?php
                                }
                                ?>
                                }

                                $(document).on('click', '.prod-category', function() {

                                    $('.form-category[data_id="' + $(this).attr('data_id') + '"]').submit();
                                });

                                //altura carrinho
                                (function() {

                                    var header_height = jQuery('header').innerHeight();

                                    var produtos_nav = jQuery('.produtos-nav').innerHeight();

                                    var titulo = jQuery('.produtos__lista .titulo').innerHeight();

                                    var valores = jQuery('.produtos__lista .valores').innerHeight();

                                    var valores2 = jQuery('.produtos__lista .valores:nth-child(3)').innerHeight();

                                    var comprar = jQuery('.produtos__lista .comprar').innerHeight();

                                    var window_height = screen.height;

                                    var val = window_height - (header_height + produtos_nav + titulo + valores + valores2 + comprar);

                                    jQuery('.carrinho-vazio').css('max-height', val - 20 - 115);

                                    jQuery('.list-products').css('max-height', val - 20 - 115);

                                })();
                            </script>

                            @endsection