<style>
    span {
        font-family: "Lucida Console";
        font-size: "10px";
    }

    ul li {
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
        <img style="width: 150px; height: 100px; margin-left: 80px;" src="{{ asset('/img/logo-cupom.png') }}" alt="Tubarão da Praia"></br>
        <span>------------------------------</span></br>
        <span>Restaurante: <br>{{ $order->First()->getLoja()->First()->nome_loja }}</span></br>
        <hr>
        @if(!empty($order->First()->created_at))
        <span>Pedido: #{{ $order->First()->id }} </br> Data: {{ date_format($order->First()->created_at, "d/m/Y H:i:s") }}</span>
        @endif
        </br>
        <hr>
      
        <span>Dados do cliente</span></br>
        @if($order->First()->userIsAdmin())
        <span>Nome: {{ $order->First()->order_client_name }}</span></br>
        @else
        <span>Nome: {{ $order->First()->getClient()->First()->nome }}</span></br>
        @endif
        @if(!empty($order->First()->getClient()->First()->whatsapp))
        <span>Whatsapp: {{ $order->First()->getClient()->First()->whatsapp }}</span></br>
        @endif
        @if(!empty($order->First()->getClient()->First()->telefone))
        <span>Telefone: {{ $order->First()->getClient()->First()->telefone }}</span></br>
        @endif

        @if(!empty($order->First()->order_street))
        <span>Endereço: <strong> {{ $order->First()->order_street . ", " . $order->First()->order_number }}</strong></span></br>
        @endif
        @if(!empty($order->First()->order_neighborhood))
        <span>Bairro: {{ $order->First()->order_neighborhood }}</span></br>
        @endif
        @if(!empty($order->First()->order_complement))
        <span>Complemento: {{ $order->First()->order_complement }}</span></br>
        @endif
        @if(!empty($order->First()->order_reference))
        <span>Referência: {{ $order->First()->order_reference }}</span></br>
        @endif
        @if(!empty($order->First()->order_city))
        <span>Cidade: {{ $order->First()->order_city }}</span></br>
        @endif
        @if(!empty($order->First()->getClient()->First()->cep))
        <span>CEP: {{ $order->First()->getClient()->First()->cep }}</span></br>
        @endif
      
         <hr>

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

                        @if($product->getVariations()->count() > 0)

                        {{ $product->getVariations()->First()->prod_var_name }}

                        @else

                        {{ $product->getOrderProducts()->First()->name_product }}

                        @endif

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
                @if($product->getOrderProducts()->First()->product_type == \App\Product::PROD_COMPL)

                @foreach($variableProds as $prod)
                @if($prod->order_product_id == $product->id)
                <tr>

                    <td>

                        +({{ $product->getOrderProducts()->First()->name_product . ") - " . $prod->getComplement()->First()->name_complement }}

                    </td>

                    <td>

                        1

                    </td>

                    <td>

                        {{ number_format($prod->price_comp, 2, ",", ".") }}

                    </td>

                    <td>

                        {{ number_format($prod->price_comp, 2, ",", ".") }}

                    </td>

                </tr>
                @endif

                @endforeach

                @elseif($product->getOrderProducts()->First()->product_type == \App\Product::PROD_COMBO)

                @foreach(json_decode($product->order_product_combo_id) as $prod)
                <tr>

                    <td>

                        +({{ $product->getOrderProducts()->First()->name_product . ") - " . $prod }}

                    </td>

                    <td>

                        -

                    </td>

                    <td>

                        -

                    </td>

                    <td>

                        -

                    </td>

                </tr>
                @endforeach
                @endif
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
                        R$ {{ number_format($order->First()->order_total, 2, ",", ".") }}
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

                    --------------------------

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
 <hr>
        <span>Forma de Pagamento</span></br>
        <span>{{ $method->name_method }}</span></br>
        </br>
         <hr>
        <span>Observação de Pagamento</span></br>
        @if( $order->First()->order_obs_payment)
        <span>{{ $order->First()->order_obs_payment }}</span></br>
        @else
        <span>-</span>
        @endif
        </br>
         <hr>
        <span>Observação do Pedido</span></br>
        @if( $order->First()->order_obs)
        <span>{{ $order->First()->order_obs }}</span>
        @else
        <span> - </span>
        @endif
        @endif
    </div>
    <div>

        @elseif($_GET['type'] == "cozinha")
        <div style="display: flex; justify-content: center; width: 302.362205px; height: auto; background-color: transparent;">
            <div style="print-header">
                <img style="width: 150px; height: 100px; margin-left: 90px;" src="{{ asset('/img/logo-cupom.png') }}" alt=""></br>
                
                </br>
                <span>Restaurante:<br>
                    {{ $order->First()->getLoja()->First()->nome_loja }}</span></br>
                    <hr>


                @if(!empty($order->First()->created_at))
                <span>Pedido: #{{ $order->First()->id }} </br> Data: {{ date_format($order->First()->created_at, "d/m/Y H:i:s") }}</span>
                @endif
                </br>
<hr>
         <span><strong>Dados do cliente</strong></span></br>
        @if($order->First()->userIsAdmin())
        <span>Nome: {{ $order->First()->order_client_name }}</span></br>
        @else
        <span>Nome: {{ $order->First()->getClient()->First()->nome }}</span></br>
        @endif

               <hr>

                <span>Itens do Pedido</span>

                <table id="products" class="table">

                    <thead>

                        <tr>

                            <th>Item</th>
                            <th> </th>

                            <th>Qtd</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php $total = 0 ?>

                        @foreach($products as $product)
                        <tr>

                            <td>

                                @if($product->getVariations()->count() > 0)

                                {{ $product->getVariations()->First()->prod_var_name }}

                                @else

                                {{ $product->getOrderProducts()->First()->name_product }}

                                @endif

                            </td>
                            <td></td>

                            <td>

                                {{ $product->order_product_qtd }}

                            </td>

                        </tr>
                        @if($product->getOrderProducts()->First()->product_type == \App\Product::PROD_COMPL)

                        @foreach($variableProds as $prod)
                        @if($prod->order_product_id == $product->id)
                        <tr>

                            <td>

                                +({{ $product->getOrderProducts()->First()->name_product . ") - " . $prod->getComplement()->First()->name_complement }}

                            </td>

                            <td>

                                1

                            </td>



                        </tr>
                        @endif
                        @endforeach

                        @elseif($product->getOrderProducts()->First()->product_type == \App\Product::PROD_COMBO)

                        
                        @endif
                        <?php $total += $product->order_product_total ?>

                        @endforeach


                    </tbody>

                </table>

                </br>

                
                @if($order->First()->order_obs)
                <span><strong>Observação</strong></span></br>
                <span>{{ $order->First()->order_obs }}</span>
                @else
                <span>-</span>
                @endif
            </div>
            <div>

                @endif

                <script type="text/javascript">
                    window.onload = function() {
                        window.print();
                    }
                </script>