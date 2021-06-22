@extends('layouts.tubarao-delivery-product')

@section('content')
<?php

$day = date('w');

?>

{{-- STYLE AQUI POIS DEVE SER ESPECIFICO APENAS PARA ESSA PAGINA   --}}


<style> 
    .produtos__lista {
        /* height: calc(100% - 80px); */
        z-index: 1;
        padding: 10px;


        position: fixed !important;
        bottom: 0px;
        right: 0px;
        height: 60%;
        background-color: rgba(240,240,240,.3);



    }

    .produtos__lista .valores div {
        margin-top: 0;
        margin-bottom: 4px;
    }

    .produtos__lista .comprar textarea {
        margin-bottom: 10px;
    }

    .produtos__bg {
        top: 80px;
        height: calc(100% - 80px);
        z-index: 1;
    }



    .produtos__lista .comprar textarea {
        height: 30px;
        padding: 0;
    }

    .produtos__action {
        z-index: 999 !important;
        -webkit-box-shadow: 1px 6px 10px 0 rgba(90, 81, 93, 0.25);
        box-shadow: 1px 6px 10px 0 rgba(90, 81, 93, 0.25);
        /* display: block !important; */
        width: 70px;
        height: 70px;
        background-position: center;
        background-repeat: no-repeat;
        background-color: red;
        position: fixed;
        bottom: 20px;
        right: 20px;
        cursor: pointer;
        border-radius: 35px;
        background-color: #fdec01;
        -webkit-transition: -webkit-transform ease-in-out 0.2s;
        transition: -webkit-transform ease-in-out 0.2s;
        -o-transition: transform ease-in-out 0.2s;
        transition: transform ease-in-out 0.2s;
        transition: transform ease-in-out 0.2s, -webkit-transform ease-in-out 0.2s;
        display: none;
        

    }

    
    .produtos__action.active span {
        -webkit-animation: popIn .3s forwards;
        animation: popIn .3s forwards;
    }

    .produtos__action span {
        position: unset !important;
        display: inline !important;
        padding: 3px 10px;
        width: 20px;
        height: 20px;
        background-color: #ff2f2f;
        top: 0;
        left: 0;
        border-radius: 15px;
        text-align: center;
        line-height: 20px;
        font-size: 14px;
        color: #ffffff;
        font-family: 'Oswald', sans-serif;
        -webkit-transform: scale(0, 0);
        -ms-transform: scale(0, 0);
        transform: scale(0, 0);
    }

    .produtos__action:active {
        -webkit-transform: scale(0.9, 0.9);
        -ms-transform: scale(0.9, 0.9);
        transform: scale(0.9, 0.9);
    }

    .produtos__action:hover {
        -webkit-transform: scale(1.1, 1.1);
        -ms-transform: scale(1.1, 1.1);
        transform: scale(1.1, 1.1);
    }

    /* .produtos__lista {
        position: fixed !important;
        top: 105px;
        right: -350px;
        height: calc(100% - 105px);
        -webkit-transition: right ease-in-out 0.2s;
        -o-transition: right ease-in-out 0.2s;
        transition: right ease-in-out 0.2s;
    } */

    .produtos__lista.ativo {
        right: 0px;
    }

    .produtos__bg.ativo {
        left: 0;
        background-color: rgba(0, 0, 0, 0.7);
    }

    .produtos__bg {
        display: block !important;
        position: fixed;
        left: 100%;
        top: 105px;
        height: calc(100% - 105px);
        width: 100%;
        background-color: transparent;
        -webkit-transition: background-color ease-in-out 0.2s;
        -o-transition: background-color ease-in-out 0.2s;
        transition: background-color ease-in-out 0.2s;
    }


    .carrinho-vazio {
        padding: 40px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-orient: vertical;
        -webkit-box-direction: normal;
        -ms-flex-direction: column;
        flex-direction: column;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        color: #d2d2d2;
    }

    .carrinho-vazio img {
        margin-left: 5px;
    }

    .carrinho-vazio h3 {
        margin-top: 10px;
        font-size: 24px;
    }

    .carrinho-vazio p {
        margin-top: 10px;
        font-weight: 300;
        font-size: 18px;
    }

    .saiba-mais__carrinho__addItem, .saiba-mais__carrinho__removeItem{
        display: flex;
        justify-content: center;
        align-items: center;
    }

 
</style>
<div class="escolher">

    <div class="bg"></div>
    <div class="conteudo">
        <div class="x">X</div>
        <div class="op"></div>
    </div>
</div>
<div class="produtos-nav">
    <div class="container">
        <span>
            <form action="/delivery">
                {{ csrf_field() }}
                <a id="cat-slide" class="prod-category" href="/delivery">
                    <span>Todas</span>
                </a>
            </form>
            @foreach($categories as $category)
            @if($category->product()->count() > 0)
            <form action="/delivery/categoria/{{ $category->name_category }}" data_id="{{ $category->id }}" class="form-category" method="GET">

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

<section class="product-single">


        <div class="produtos__lista" data-margin-top="110">
            <div class="produtos-header">
                <img src="{{ asset('/img/carrinho-header.svg') }}" alt="">
                <span>Seu carrinho</span>
            </div>
            <div class="titulo clearfix">
                <span>Qtd.</span>
                <span>Produto</span>
                <span>Total R$</span>
            </div>
            <form>
                <div class="item clearfix list-products" style="max-height: 120px;">
                    <div class="carrinho-vazio" style="">
                        <img src="{{ asset('/img/sad.svg') }}">
                        <h3>Seu carrinho está vazio.</h3>
                        <p>Que tal iniciar seu pedido?</p>
                    </div>
                </div>
                <!--  <div class=" valores" style="background-color: #f1f1f1;">
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
                    <a href="#"><input type="button" value="Finalizar pedido" id="Finalizar-pedido"></a>
                </div>
            </form>
        </div>


    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 product-single__img ">
                <figure>
                    <img style="width: 100%; height: calc(100vh - 211px);max-height: 100%;object-fit: cover;" src="{{ asset('/storage/media/product/'.$product->First()->product_pic_src)}}" alt="{{ $product->First()->name_product }}" title="{{ $product->First()->name_product }}">
                </figure>
                <a href="{{ route('productdelivery.index') }}">
                    <span class="back-to-products">
                        <svg fill="#797979" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="20.004px" height="20.004px" viewBox="0 0 400.004 400.004" style="enable-background:new 0 0 400.004 400.004;" xml:space="preserve">
                            <g>
                                <path d="M382.688,182.686H59.116l77.209-77.214c6.764-6.76,6.764-17.726,0-24.485c-6.764-6.764-17.73-6.764-24.484,0L5.073,187.757   c-6.764,6.76-6.764,17.727,0,24.485l106.768,106.775c3.381,3.383,7.812,5.072,12.242,5.072c4.43,0,8.861-1.689,12.242-5.072   c6.764-6.76,6.764-17.726,0-24.484l-77.209-77.218h323.572c9.562,0,17.316-7.753,17.316-17.315   C400.004,190.438,392.251,182.686,382.688,182.686z" />
                            </g>
                        </svg>
                        VOLTAR AO MENU
                    </span>
                </a>
            </div>
            <div class="col-md-5 product-single__info">
                <h2>{{ $product->First()->name_product }}</h2>
                <p>
                    {{ $product->First()->description_product }}
                </p>
                <div class="content-price">
                    <small>
                        @if($product->First()->promotion_active == 1 && $product->First()->promotion_price != 0 && ( $product->First()->promotion_day == $day || $product->First()->promotion_day == 7 ))
                        R$ {{ number_format($product->First()->price_product, 2, ",", ".") }}
                        @endif</small>
                    <span class="product-single__info-price">
                        @if($product->First()->promotion_active == 1 && $product->First()->promotion_price != 0 && ( $product->First()->promotion_day == $day || $product->First()->promotion_day == 7 ))
                        {{ number_format($product->First()->promotion_price, 2, ",", ".") }}
                        @else
                        {{ number_format($product->First()->price_product, 2, ",", ".") }}
                        @endif</span>

                    
                    <div class="produtos__bg"></div>
                    <div style="background-image: url('/img/carrinho-mobile.svg')" class="produtos__action active"><span style="z-index: 1">0</span></div>
                    
                </div>
                <div class="product-single__info-btns row align-items-center">

                    @if($product->First()->product_type == \App\Product::PROD_NORMAL)
                    <!-- <div class="col-md-6 col-lg-5">
                        <span class="d-flex justify-content-center">
                            <div class="remItem">
                                <svg fill="#797979" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="isolation:isolate" viewBox="142 2560.343 73.17 8.484" width="17px" height="17px">

                                    <g>
                                        <path fill="#797979" d=" M 210.928 2560.343 L 182.827 2560.343 L 174.343 2560.343 L 146.242 2560.343 C 143.9 2560.343 142 2562.246 142 2564.585 C 142 2566.932 143.9 2568.827 146.242 2568.827 L 174.343 2568.827 L 182.827 2568.827 L 210.928 2568.827 C 213.272 2568.827 215.17 2566.931 215.17 2564.585 C 215.17 2562.246 213.271 2560.343 210.928 2560.343 Z " fill="rgb(0,0,0)" />
                                    </g>

                                </svg>
                            </div>
                            <input class="qt" type="number" value="1" disabled>
                            <div class="addItem">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="#797979" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="17px" height="17px" viewBox="0 0 73.17 73.17" style="enable-background:new 0 0 73.17 73.17;" xml:space="preserve">
                                    <g id="Plus">
                                        <g>
                                            <path d="M68.928,32.343H40.827V4.243C40.827,1.903,38.928,0,36.585,0s-4.242,1.903-4.242,4.242v28.101H4.242     C1.9,32.343,0,34.246,0,36.585c0,2.347,1.9,4.242,4.242,4.242h28.101v28.1c0,2.349,1.899,4.242,4.242,4.242     s4.242-1.896,4.242-4.242v-28.1h28.101c2.344,0,4.242-1.896,4.242-4.242C73.17,34.246,71.271,32.343,68.928,32.343z" />
                                        </g>
                                    </g>
                                </svg>
                            </div>
                        </span>
                    </div> -->
                    @endif
                    <div class="col-md-6">
                        @if($product->First()->product_type == \App\Product::PROD_COMPL)

                        <input class="btn-item-product comp-prod" type="button" id="{{ $product->First()->id }}" name="{{$product->First()->name_product}}" price="
                        @if($product->First()->promotion_active == 1 && $product->First()->promotion_price != 0 && ( $product->First()->promotion_day == $day || $product->First()->promotion_day == 7 ))
                                {{$product->First()->promotion_price}}
                            @else
                                {{$product->First()->price_product}}
                        @endif" comp-ids="{{ $product->First()->product_comps }}" value="Ver Opções">

                        @elseif($product->First()->product_type == \App\Product::PROD_VARIABLE)

                        <input class="btn-item-product add-var-prod" id="add-var-prod" type="button" id-produto="{{ $product->First()->id }}" name="{{$product->First()->name_product}}" price="
                        @if($product->First()->promotion_active == 1 && $product->First()->promotion_price != 0 && ( $product->First()->promotion_day == $day || $product->First()->promotion_day == 7 ))
                        {{$product->First()->promotion_price}}
                        @else
                        {{$product->First()->price_product}}
                        @endif" value="Adicionar ao Carrinho" />

                        @elseif($product->First()->product_type == \App\Product::PROD_NORMAL)

                        <input class="btn-item-product add-prod" type="button" id="{{ $product->First()->id }}" name="{{$product->First()->name_product}}" price="
                        @if($product->First()->promotion_active == 1 && $product->First()->promotion_price != 0 && ( $product->First()->promotion_day == $day || $product->First()->promotion_day == 7 ))
                                {{ $product->First()->promotion_price }}
                            @else
                                {{ $product->First()->price_product }}
                        @endif" value="Adicionar ao Carrinho" />

                        @elseif($product->First()->product_type == \App\Product::PROD_COMBO)

                        <input class="btn-item-product add-combo-prod" id="add-combo-prod" type="button" id-produto="{{ $product->First()->id }}" name="{{$product->First()->name_product}}" price="
                        @if($product->First()->promotion_active == 1 && $product->First()->promotion_price != 0 && ( $product->First()->promotion_day == $day || $product->First()->promotion_day == 7 ))
                        {{$product->First()->promotion_price}}
                        @else
                        {{$product->First()->price_product}}
                        @endif" value="Adicionar ao Carrinho" />

                        @endif
                    </div>
                    <!-- <input class="btn-item-product" type="submit" value="Adicionar ao Carrinho"> -->

                </div>
            </div>
        </div>
    </div>
</section>



<script src="{{ asset('/js/delivery.js') }}"></script>

<script src="{{ asset('/js/delivery-first.js') }}"></script>

<script src="{{ asset('/js/delivery-scripts.js') }}"></script>

<script>

 function appendModalCep() {

                                    var html = `<section class="modal-cep ativo">



                                    <div class="bg"></div>

                                        <div class="conteudo">

                                        <div class="d-flex no-gutters modal-cep__bg justify-content-center align-items-center">

                                        <figure class="col-md-4">

                                        <img src="{{ asset('img/icon-map.svg') }}" alt="Entrega Rápida Tubarão da Praia" title="Entrega Rápida Tubarão da Praia">

                                        </figure>

                                        <div class="col-md-6">

                                        <h2>Entrega <br><strong>Rápida</strong></h2>

                                        </div>

                                        </div>

                                        <section class="modal-cep__content">

                                        <p>Digite seu CEP abaixo para começar:</p>

                                        <div class="modal-cep__form">

                                        <input name="cep " class="inicio__cep" placeholder="ex: 11700080" type="text">

                                        <input class="btn inicio__enviar" type="button" value="Continuar">

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
                                
    $(document.body).on('click', '#Finalizar-pedido', function() {

        if (verifyProds() > 0) {

            appendModalCep();

        } else {
            alert("Adicione produtos ao carrinho para finalizar o pedido!");
        }
    });
</script>
@endsection
