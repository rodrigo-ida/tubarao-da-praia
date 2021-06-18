@extends('layouts.tubarao-delivery')

@section('content')

<div class="user__container user__historico clearfix">

    <div class="user__aside col-md-4">
        <aside>
            <nav>
                <a href="{{ route('clientes.address') }}">ALTERAR ENDEREÇO</a>

                <a href="{{ route('clientes.userdata') }}">MEUS DADOS</a>

                <a href="{{ route('clientes.order') }}">ACOMPANHAR PEDIDO</a>

                <a class="ativo" href="{{ route('clientes.orders') }}">HISTÓRICO DE PEDIDOS</a>

            </nav>
        </aside>
    </div>

    <div class="user__block col-lg-5 col-md-12 col-sm-12">
        @if(isset($orders[0]))
        <div class="user__historico__itens" data-group>
            <h2>Seus Pedidos</h2>
            @foreach($orders as $order)
            <a href="#" data-click="{{ $order->id }}">
                <div class="list-info">
                    <p><strong>#{{ $order->id }}</strong></p>
                    <p>{{ date('d/m/Y', strtotime($order->created_at)) }}</p>
                    <p>R$ {{number_format($order->order_tax_rate + $order->order_total, 2, ",", ".")}}</p>
                    <div class="user__historico__itens-ver">+</div>
                </div>
                <div class="pedido__lista" data-target="{{ $order->id }}">
                    <div class="item clearfix">
                        <div class="itens clearfix">
                            <span>Endereço:</span>
                            <span>{{ $order->order_street . ', ' . $order->order_number . ' - ' . $order->order_neighborhood }}</span>

                        </div>
                    </div>
                    @foreach($order->getOrderProducts as $product)

                    <div class="item clearfix">
                        <?php

                        $totalProd = 0;

                        ?>
                        <div class="itens clearfix">
                            <span>{{ $product->order_product_qtd }}</span>
                            <span>
                                @if($product->getVariations()->count() > 0)

                                {{ $product->getVariations()->First()->prod_var_name }}
                                @else
                                {{ $product->getOrderProducts()->First()->name_product }}

                                @endif
                                @if($product->product_type == \App\Product::PROD_COMPL && $product->order_id == $order->id)
                                @foreach($order->getOrderComplements as $prod)
                                @if($prod->id_prod == $product->id)
                                <div class="itens__compl">
                                    {{ $prod->name_complement }}
                                </div>

                                <?php $totalProd += $prod->price_comp; ?>
                                @endif
 
                                @endforeach
                                @elseif($product->product_type == \App\Product::PROD_COMBO)
                               
                                @endif

                            </span>
                            <span>
                                {{ number_format($product->order_product_total, 2, ",", ".") }}
                                @if($product->product_type == \App\Product::PROD_COMPL)
                                @foreach($order->getOrderComplements as $prod)
                                @if($prod->id_prod == $product->id)
                                <div class="itens__compl-price">

                                    {{ number_format($prod->price_comp * $product->order_product_qtd, 2, ",", ".") }}

                                </div>
                                @endif
                                @endforeach
                                @endif
                            </span>
                        </div>
                        <!-- <div class="itens clearfix">
									<span>2</span>
									<span>Barca casadinho</span>
									<span>6,49</span>
								</div> -->
                    </div>


                    @endforeach


                    <div class="comprar">
                        <div class="valores" style="background-color: #f9f9f9;">
                            <div class="clearfix">
                                <span>Sub-Total:</span>
                                <span>R$ {{number_format($order->order_total, 2, ",", ".")}}</span>
                            </div>
                            <div class="clearfix">
                                <span>Taxa de entrega:</span>
                                <span>R$ {{number_format($order->order_tax_rate, 2, ",", ".")}}</span>
                            </div>
                        </div>
                        <div class="obs">
                            <span>Obs: {{ $order->order_obs }}</span>
                            <span></span>
                        </div>
                        <div class="clearfix total">
                            <span>
                                TOTAL
                            </span>
                            <span>
                                {{number_format($order->order_tax_rate + $order->order_total, 2, ",", ".")}}
                            </span>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    <div class="user__block col-lg-3 col-md-12 col-sm-12">
        <div class="card-pesq-pedido">
            <figure>
                <img src="{{ asset('../img/mapa-encontrar.svg') }}" alt="">
            </figure>
            <p>Você fez algum pedido com a gente? Quer saber onde ele está?</p>
            <a href="{{ route('clientes.order') }}">Acompanhe por aqui</a>
        </div>
    </div>
</div>

@else

<div class="pedidos-vazio">
    <img src="{{asset('img/thinking.svg')}}">
    <h2>Você ainda não realizou nenhum pedido</h2>
    <p>Tem certeza que não vai pedir nada?</p>
    <br>
    <button class="btn"><a href="/delivery">Realizar Pedido</a></button>
</div>

@endif

</div>

<script>
    //collapse user historico
    (function() {
        $('[data-group]').each(function() {
            var $allTarget = $(this).find('[data-target]'),
                $allClick = $(this).find('[data-click]'),
                classActive = 'active';

            $allClick.click(function(e) {
                e.preventDefault();
                var idTab = $(this).data('click'),
                    $target = $('[data-target ="' + idTab + '" ]');

                if ($target.hasClass(classActive)) {
                    $target.removeClass(classActive);
                    $(this).removeClass(classActive);
                    return;
                } else {
                    $allTarget.removeClass(classActive);
                    $allClick.removeClass(classActive);
                }
                $target.addClass(classActive);
                $(this).addClass(classActive);
            });
        });
    })();
</script>

@endsection