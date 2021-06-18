@extends('layouts.tubarao-delivery-email')

@section('content')

    <div class="show-form" style="margin-bottom: 20px;">
        <div class="products-table" style="background-color: #fff; color: #6d1357;">
        <p class="first" style="color: #6d1357; font-size: 42px; font-weight: 200;">Legal {{ $order->getClient()->First()->nome }}! Seu pedido foi realizado com sucesso!</p>
            <h3 style="font-size: 40px; color: #6d1357;">Pedido #{{ $order->id }}</h3>
            <table class="produtos" style="color: #6d1357; margin: 0 auto; font-size: 20px;">
                <thead style="text-align: left;">
                    <th>
                        Nome
                    </th>
                    <th>
                        Quantidade
                    </th>
                    <th>
                        Total
                    </th>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>    

                        <td>{{ $product->getOrderProducts->First()->name_product }}</td>

                        <td>{{ $product->order_product_qtd }}</td>

                        <td>{{ "R$" . number_format($product->order_product_total, 2, ',', '.') }}</td>

                    </tr>
                @endforeach
                    <tr>    

                        <td></td>

                        <td>Subtotal: </td>

                        <td>{{ "R$" . number_format($order->order_total, 2, ',', '.') }}</td>

                    </tr>
                    <tr>    

                        <td></td>

                        <td>Taxa: </td>

                        <td>{{ "R$" . number_format($order->order_tax_rate, 2, ',', '.') }}</td>

                    </tr>
                    <tr>    

                        <td></td>

                        <td>Total: </td>

                        <td>{{ "R$" . number_format($order->order_tax_rate + $order->order_total, 2, ',', '.') }}</td>

                    </tr>
                </tbody>  
            </table>  
        </div>
        <p style="color: #fdec01; font-size: 30px;">Gostaria de acompanhar seu pedido? Clique abaixo!</p>
        <a href="https://pedidos.tubaraodapraia.com.br/client/area-do-cliente/ultimo-pedido">
            <input style="background-color: #0275d8!important; color: #fff; border: 1px solid #5bc0de!important; padding: 20px; border-radius: 4px;" type="button" value="Acompanhar Pedido" />
        </a>    
    </div>

@endsection