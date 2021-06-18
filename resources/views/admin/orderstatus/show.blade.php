@extends('layouts.admin')

@section('title', 'Pedido')

@section('content_header')
    <h1>Pedido: # {{ $order->First()->id }}</br> 
        Status: {{ Form::select('', $status) }}  
        <input class="btn btn-info" type="button" id="mstatus" value="Mudar Status">
    </h1>
@stop

@section('content')

    <div class="box">
        <div class="box-header with-border">
            <h2 class="box-title">Informações do Cliente<br/>
            </h2>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nome do cliente</th>
                        <th>Rua</th>
                        <th>Número</th>
                        <th>Bairro</th>
                        <th>Cidade</th>
                        <th>Email</th>
                        <th>Whatsapp</th>
                    </tr>
                </thead>
                <tbody>
                    <td>
                        @if(!empty($order->First()->getClient()->First()->nome) || 
                        $order->First()->getClient()->First()->nome != null)
                            {{ $order->First()->getClient()->First()->nome }}
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        @if(!empty($order->First()->getClient()->First()->logradouro) || 
                        $order->First()->getClient()->First()->logradouro != null)
                            {{ $order->First()->getClient()->First()->logradouro }}
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        @if(!empty($order->First()->getClient()->First()->numero) ||
                        $order->First()->getClient()->First()->numero != null)
                            {{ $order->First()->getClient()->First()->numero }}
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        @if(!empty($order->First()->getClient()->First()->bairro) || 
                        $order->First()->getClient()->First()->bairro !=null)
                            {{ $order->First()->getClient()->First()->bairro }}
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        @if(!empty($order->First()->getClient()->First()->cidade) || 
                        $order->First()->getClient()->First()->cidade)
                        {{ $order->First()->getClient()->First()->cidade }}
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        @if(!empty($order->First()->getClient()->First()->email) ||
                        $order->First()->getClient()->First()->email)
                            {{ $order->First()->getClient()->First()->email }}
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        @if(!empty($order->First()->getClient()->First()->whatsapp) ||
                        $order->First()->getClient()->First()->whatsapp)
                            {{ $order->First()->getClient()->First()->whatsapp }}
                        @else
                        -
                        @endif
                    </td>
                </tbody>
            </table>
            <h2 class="box-title">
            Informações de Entrega<br/>
            </h2>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Rua</th>
                        <th>Número</th>
                        <th>Bairro</th>
                        <th>Complemento</th>
                        <th>Referência</th>
                        <th>Cidade</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <td>
                        @if(!empty($order->First()->order_street) || 
                        $order->First()->order_street != null)
                            {{ $order->First()->order_street }}
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        @if(!empty($order->First()->order_number) || 
                        $order->First()->order_number != null)
                            {{ $order->First()->order_number }}
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        @if(!empty($order->First()->order_neighborhood) ||
                        $order->First()->order_neighborhood != null)
                            {{ $order->First()->order_neighborhood }}
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        @if(!empty($order->First()->order_complement) || 
                        $order->First()->order_complement !=null)
                            {{ $order->First()->order_complement }}
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        @if(!empty($order->First()->order_reference) || 
                        $order->First()->order_reference)
                        {{ $order->First()->order_reference }}
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        @if(!empty($order->First()->order_city) ||
                        $order->First()->order_city)
                            {{ $order->First()->order_city }}
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        @if(!empty($order->First()->order_state) ||
                        $order->First()->order_state)
                            {{ $order->First()->order_state }}
                        @else
                        -
                        @endif
                    </td>
                </tbody>
            </table>
            <h2 class="box-title">
            Informações de Pagamento<br/>
            </h2>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Forma de pagamento</th>
                        <th>Taxa de entrega(R$)</th>
                        <th>Qtd. Produtos</th>
                        <th>Total do pedido(R$)</th>
                        <th>*Observação do Cliente</th>
                    </tr>
                </thead>
                <tbody>
                    <td>
                        @if(!empty($order->First()->order_payment_method) || 
                        $order->First()->order_payment_method != null)
                            {{ $order->First()->order_payment_method }}
                        @else
                        -
                        @endif
                    </td>
                    <td style="color: green; font-weight: bold;">
                        @if(!empty($order->First()->order_tax_rate) || 
                        $order->First()->order_tax_rate != null)
                            {{ number_format($order->First()->order_tax_rate, 2, ",", ".") }}
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        @if(!empty($order->First()->order_prod_qtd) ||
                        $order->First()->order_prod_qtd != null)
                            {{ $order->First()->order_prod_qtd }}
                        @else
                        -
                        @endif
                    </td>
                    <td style="color: green; font-weight: bold;">
                        @if(!empty($order->First()->order_total) || 
                        $order->First()->order_total !=null)
                            {{ number_format($order->First()->order_total, 2, ",", ".") }}
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        @if(!empty($order->First()->order_obs) || 
                        $order->First()->order_obs)
                        {{ $order->First()->order_obs }}
                        @else
                        -
                        @endif
                    </td>
                </tbody>
            </table>
            <h2 class="box-title">
            Produtos do Pedido<br/>
            </h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Preço(R$)</th>
                        <th>Quantidade</th>
                        <th>Total(R$)</th>
                    </tr>
                </thead>
                <tbody>
                <?php $total = 0 ?>
                @foreach($products as $product)
                
                    <tr style="background-color: #bee5eb;">
                        <td>
                            {{ $product->get_order_products[0]->name_product }}
                        </td>
                        <td>
                            {{ $product->get_order_products[0]->description_product }}
                        </td>
                        <td style="color: green; font-weight: bold;">
                            {{ number_format($product->order_product_price, 2, ",", ".") }}
                        </td>
                        <td>
                            {{ $product->order_product_qtd }}
                        </td>
                        <td style="color: green; font-weight: bold;">
                            {{ number_format($product->order_product_total, 2, ",", ".") }}
                        </td>
                    </tr>
                <?php $total += $product->order_product_total ?>
                @endforeach
                @if($total !== 0)
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            Total de produtos:
                        </td>
                        <td style="color: green; font-weight: bold;">
                            R$ {{ number_format($total, 2, ",", ".") }}
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
            @if(!empty($next->First()))
                <a href="/admin/order/show/{{$next->First()->id}}"><input class="btn btn-primary" type="button" value="Próximo"/></a>
            @endif      
        </div>
        <!-- /.box-body -->
        <!-- box-footer -->
    </div>
    <!-- /.box -->
@endsection