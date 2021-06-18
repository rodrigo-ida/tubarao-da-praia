
<style>
    span {
        font-family: "Lucida Console";
        font-size: "10px";
    }

    ul li{
        list-style: none;
    }
    .print-header {
        width: 100%;
        height: 10%;
    }

    .print-header h2 {
        text-align: center;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table thead {
        text-align: left;
    }

    .table tr {
        display: table-row;
        vertical-align: inherit;
        border-bottom: 1px solid black;
        box-sizing: border-box;
    }

    .table td {
        padding-left: 8px; 
    }

    .fix-li {
        float: right;
        
    }

}
</style>
@if($_GET['type'] == "imprimir")

<div style="display: flex; justify-content: center; width: 302.362205px; height: auto; background-color: transparent;">
    <div style="print-header">
        <img style="width: 150px; height: 100px; margin-left: 90px;" src="{{ asset('/img/logo-cupom.png') }}" alt=""></br>
        <span>-------------------------------</span></br>
        <span>Restaurante: {{ $order->First()->getLoja()->First()->nome_loja }}</span></br>
        @if(!empty($order->First()->created_at))
        <span>Pedido: #{{ $order->First()->id }} </br> Data: {{ date_format($order->First()->created_at, "d/m/Y H:i:s") }}</span>
        @endif
        </br>
        </br>
        <span>Dados do cliente</span></br>
        @if(!empty($order->First()->getClient()->First()->nome))
            <span>Nome: {{ $order->First()->getClient()->First()->nome }}</span></br>
        @endif
        @if(!empty($order->First()->getClient()->First()->whatsapp))
           <span>Whatsapp: {{ $order->First()->getClient()->First()->whatsapp }}</span></br>
        @endif
        @if(!empty($order->First()->order_street))
           <span>Endereço: {{ $order->First()->order_street . ", " . $order->First()->order_number }}</span></br>
        @endif
        @if(!empty($order->First()->order_neighborhood))
            <span>Bairro: {{ $order->First()->order_neighborhood }}</span></br>
        @endif
        @if(!empty($order->First()->order_city))
            <span>Cidade: {{ $order->First()->order_city }}</span></br>
        @endif
        @if(!empty($order->First()->getClient()->First()->cep))
            <span>CEP: {{ $order->First()->getClient()->First()->cep }}</span></br>
        @endif
        </br>
        
        <span>Itens do Pedido</span>

        <table id="products" class="table">

        <thead>

            <tr>

                <th>Item</th>

                <th>Qtd</th>

                <th>Preço</th>

                <th>Total</th>

            </tr>

        </thead>

    <tbody>

    <?php $total = 0 ?>

    @foreach($products as $product)

        <tr>

            <td>

                {{ $product->get_order_products[0]->name_product }}

            </td>


            <td>

                {{ $product->order_product_qtd }}

            </td>
            
            <td>

                {{ number_format($product->order_product_price, 2, ",", ".") }}

            </td>

            <td>

                {{ number_format($product->order_product_total, 2, ",", ".") }}

            </td>

        </tr>

            <?php $total += $product->order_product_total ?>

        @endforeach

        </tbody>

        </table>
        @if($total !== 0)
        <ul class="total-order">
            <li>
                <span>
                    SubTotal:
                    <span class="fix-li">
                    R$ {{ number_format($total, 2, ",", ".") }}
                    </span>
                </span>
            </li>
            <li>
                <span>
                    Taxa de entrega:
                    <span class="fix-li">
                    R$ {{ number_format($order->First()->order_tax_rate, 2, ",", ".") }}
                    </span>
                </span>
            </li>
            <li>
                <span>
               
                        ---------------------------    
               
                </span>
            </li>
            <li>
                <span>
                    Total:
                    <span class="fix-li">
                    R$ {{ number_format($order->First()->order_total + $order->First()->order_tax_rate, 2, ",", ".") }}
                    </span>
                </span>
            </li>
        </ul>

        <span>Forma de Pagamento</span></br>
        <span>{{ $method->name_method }}</span></br>
        </br>
        <span>Observação</span></br>
        <span>{{ $order->First()->order_obs }}</span>
        @endif
    </div>
<div>

    @elseif($_GET['type'] == "cozinha")
        <div style="display: flex; justify-content: center; width: 302.362205px; height: auto; background-color: transparent;">
            <div style="print-header">
                <img style="width: 150px; height: 100px; margin-left: 90px;" src="{{ asset('/img/logo-cupom.png') }}" alt=""></br>
                <span>-------------------------------</span></br>
                <span>Restaurante: {{ $order->First()->getLoja()->First()->nome_loja }}</span></br>
                @if(!empty($order->First()->created_at))
                <span>Pedido: #{{ $order->First()->id }} </br> Data: {{ date_format($order->First()->created_at, "d/m/Y H:i:s") }}</span>
                @endif
                </br>
                </br>
                
                <span>Itens do Pedido</span>

                <table id="products" class="table">

                <thead>

                    <tr>

                        <th>Item</th>

                        <th>Qtd</th>

                    </tr>

                </thead>

            <tbody>

            <?php $total = 0 ?>

            @foreach($products as $product)

                <tr>

                    <td>

                        {{ $product->get_order_products[0]->name_product }}

                    </td>


                    <td>

                        {{ $product->order_product_qtd }}

                    </td>
                    

                </tr>

                    <?php $total += $product->order_product_total ?>

                @endforeach

                </tbody>

                </table>

                </br>
                
                <span>Observação</span></br>
                <span>{{ $order->First()->order_obs }}</span>
               
            </div>
        <div>
    
@endif

<!-- <script type="text/javascript">
    window.onload = function() {
        window.print();
    }
</script> -->