@extends('layouts.tubarao-delivery')

@section('content')

<?php

use function GuzzleHttp\json_decode;

$hora = new DateTime("now");

if ($order != null) {
    $hora2 = new DateTime($order->First()->created_at);
} else {
    $hora2 = new DateTime("now");
}

$hora = date_create(date_format($hora, 'Y-m-d H:i:s'));

$hora2 = date_create(date_format($hora2, 'Y-m-d H:i:s'));

$diff = date_diff($hora, $hora2);

?>

<div class="user__container order clearfix">

    <div class="user__aside">
        <aside>
            <nav>

                <a href="{{ route('clientes.address') }}">ALTERAR ENDEREÇO</a>

                <a href="{{ route('clientes.userdata') }}">MEUS DADOS</a>

                <a class="ativo" href="{{ route('clientes.order') }}">ACOMPANHAR PEDIDO</a>

                <a href="{{ route('clientes.orders') }}">HISTÓRICO DE PEDIDOS</a>

            </nav>
        </aside>
    </div>

    <div class="user__block">
        <div class="order__status">

            @if($diff->h <= 1 && $diff->d == 0)
                @if($order != null)
                <a href="https://api.whatsapp.com/send?phone=55<?= str_replace('.', '', str_replace('(', '', str_replace(')', '', str_replace(' ', '', $order->First()->getLoja->whatsapp_loja)))) ?>&text=Ol%C3%A1%2C%20meu%20nome%20%C3%A9%20{{ $order->First()->nome }}%20e%20realizei%20o%20pedido%20de%20n%C3%BAmero%20{{ $order->First()->id }}%2C%20gostaria%20de%20saber%20o%20andamento.">
                    <div class="whatsapp"></div>
                </a>
                <div class="status-pedido">
                    @if($order->First()->status_name == 'Agendado')
                    <div id="step-4" class="ativo pedido-agendado"><span></span>
                        Seu pedido foi agendado para o dia
                        <span id="order-schedule-date"><?php echo date_format(new Datetime($order->First()->order_dev_date), 'd/m/Y') ?> às </span>
                        <span id="order-schedule-hour"><?php echo date_format(new Datetime($order->First()->order_dev_time), 'H:i') ?></span>
                    </div>
                    <!-- <div id="step-4" class="ativo"><span></span>Seu pedido foi agendado para dia </div> -->

                    @elseif($order->First()->status_name == 'Cancelado')

                    <div id="step-5" class="ativo pedido-cancelado"><span></span>
                        Pedido cancelado.
                        <span id="order-schedule-date"></span>
                        <span id="order-schedule-hour"></span>
                    </div>

                    @elseif($order->First()->status_name == 'Concluído')

                    <div id="step-6" class="ativo"><span></span>Seu pedido foi concluído</div>

                    @else

                    <div id="step-1" class="ativo"><span>1</span>Aguardando confirmação do restaurante.</div>
                    <h3>* Seu pedido poderá levar até 10 minutos para ser confirmado.</h3>

                    @if($order->First()->status_name == 'Em preparo' || $order->First()->status_name == 'Em entrega')

                    <div id="step-2" class="ativo"><span>2</span>Eba! Seu pedido está sendo preparado.</div>

                    @else

                    <div id="step-2"><span>2</span>Eba! Seu pedido está sendo preparado.</div>

                    @endif

                    @if($order->First()->status_name == 'Em entrega')

                    <div id="step-3" class="ativo"><span>3</span>Arrume a mesa! Seu pedido está a caminho.</div>

                    @else

                    <div id="step-3"><span>3</span>Arrume a mesa! Seu pedido está a caminho.</div>

                    @endif
                    @endif

                </div>

                <div class="pedido__dados">

                    <h3>Forma de Pagamento:</h3>
                    <p>{{ $order->First()->getPaymentMethod()->First()->name_method }}</p>
                    <p>- Seu pedido foi efetuado na loja <strong> {{ $loja->nome_loja }} </strong></p>

                </div>

        </div>

        <div class="order__itens">
            <div class="order__info">
                <div class="pedido__form clearfix">
                    <div class="pedido">
                        <div class="pedido__lista">
                            <h2>PEDIDO <span id="order"># {{ $order->First()->id }}</span></h2>

                            <div class="titulo clearfix">
                                <span>Qtd.</span>
                                <span>Produto</span>
                                <span>Total R$</span>
                            </div>
                            <div class="item clearfix">
                                @foreach($products as $product)

                                <?php $totalProd = 0; ?>
                                <div class="itens clearfix">
                                    <span>{{ $product->order_product_qtd }}</span>
                                    <span>
                                        @if($product->getVariations()->count() > 0)
                                        {{ $product->getVariations()->First()->prod_var_name }}
                                        @else
                                        {{ $product->getOrderProducts()->First()->name_product }}

                                        @endif
                                        @if($product->getOrderProducts()->First()->product_type == \App\Product::PROD_COMPL)
                                        @foreach($variableProds as $prod)

                                        @if($prod->order_product_id == $product->id)
                                        <div class="itens__compl">
                                            {{ $prod->getComplement()->First()->name_complement }}
                                        </div>

                                        <?php $totalProd += $prod->price_comp; ?>
                                        @endif

                                        @endforeach
                                        @elseif($product->getOrderProducts()->First()->product_type == \App\Product::PROD_COMBO)

                                      
                                        @endif
                                    </span>
                                    <span>{{ number_format($product->order_product_total, 2, ",", ".") }}</span>
                                    @if($product->getOrderProducts()->First()->product_type == \App\Product::PROD_COMPL)
                                    @foreach($variableProds as $prod)
                                    @if($prod->order_product_id == $product->id)
                                    <div class="itens__compl-price">

                                        {{ number_format($prod->price_comp * $product->order_product_qtd, 2, ",", ".") }}

                                    </div>
                                    @endif
                                    @endforeach
                                    @elseif($product->getOrderProducts()->First()->product_type == \App\Product::PROD_COMBO)

                                   

                                    @endif
                                </div>
                                @endforeach
                            </div>
                            <div class="valores" style="background-color: #f9f9f9;">
                                <div class="clearfix">
                                    <span>Sub-Total:</span>
                                    <span>R$ {{ number_format($order->First()->order_total, 2, ",", ".") }}</span>
                                </div>
                                <div class="clearfix">
                                    <span>Taxa de entrega:</span>
                                    <span>R$ {{ number_format($order->First()->order_tax_rate, 2, ",", ".") }}</span>
                                </div>
                            </div>
                            <div class="valores clearfix">
                                <span>Tempo de entrega estimado</span>
                                <span>
                                    @if(isset($tax->First()->order_shipping_time))
                                        @if(date_format(new DateTime($tax->First()->order_shipping_time), "H") == '00')
    
                                        {{ date_format(new DateTime($tax->First()->order_shipping_time), "i") }} min
    
                                        @else
    
                                        {{ date_format(new DateTime($tax->First()->order_shipping_time), "H") }} hora e {{ date_format(new DateTime($tax->First()->order_shipping_time), "i") }} min
    
                                        @endif
                                    @endif
                                </span>
                            </div>
                            <div class="comprar">
                                <div class="obs">
                                    <span>Obs:</span>
                                    <span></span>
                                </div>
                                <div class="clearfix total">
                                    <span>
                                        TOTAL
                                    </span>
                                    <span>
                                        {{number_format($order->First()->order_tax_rate + $order->First()->order_total, 2, ",", ".")}}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="pedidos-vazio">
                <img src="{{asset('img/sad.svg')}}">
                <h2>Você ainda não realizou nenhum pedido</h2>
                <p>que tal fazê-lo agora?</p><br>
                <button class="btn"><a href="/delivery">Realizar Pedido</a></button>
            </div>
        </div>
    </div>
    @endif
    @else
    <div class="pedidos-vazio">
        <img src="{{asset('img/sad.svg')}}">
        <h2>Você ainda não realizou nenhum pedido</h2>
        <p>que tal fazê-lo agora?</p><br>
        <button class="btn"><a href="/delivery">Realizar Pedido</a></button>
    </div>
</div>
</div>

@endif
</div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="https://js.pusher.com/4.3/pusher.min.js"></script>

<script>
    var pusher = new Pusher('723e0e5c3eb1c0ce1629', {
        cluster: 'us2',
        forceTLS: true
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
        newStatus(data);
    });
</script>

@if($order != null)
<script type="text/javascript">
    function newStatus(response) {
        if (parseInt(response.order_id) == <?= $order->First()->id ?>) {

            if (response != "Pendente" && response != "Agendado") {

            }

            if (response.order_status == "Em preparo") {
                if ($('#step-4').length == 1) {
                    $('#step-4').remove();
                    var html = `<div id="step-1" class="ativo"><span>1</span>Aguardando confirmação do restaurante.</div>
        <div id="step-2" class="ativo"><span>2</span>Eba! Seu pedido está sendo preparado.</div>
        <div id="step-3"><span>3</span>Arrume a mesa! Seu pedido está a caminho.</div>`;

                    $('.status-pedido').append(html);
                    return;
                }

                $('#step-2').addClass('ativo');

            } else if (response.order_status == "Em preparo") {

                $('#step-2').addClass('ativo');

            } else if (response.order_status == "Em entrega") {

                $('#step-3').addClass('ativo');

            } else if (response.order_status == "Concluído") {
                $('#step-1').remove();
                $('#step-2').remove();
                $('#step-3').remove();
                $('#step-5').remove();

                $('.status-pedido').append('<div id="step-6" class="ativo"><span></span>Seu pedido foi concluído</div>');

            } else if (response.order_status == "Cancelado") {
                $('#step-1').remove();
                $('#step-2').remove();
                $('#step-3').remove();
                $('#step-6').remove();

                $('.status-pedido').append(`
            <div id="step-5" class="ativo pedido-cancelado"><span></span>
              Pedido cancelado.
              <span id="order-schedule-date"></span>
              <span id="order-schedule-hour"></span>
            </div>`);

            }

        }

    }
</script>
@endif

@endsection