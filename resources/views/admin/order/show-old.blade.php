@extends('layouts.admin')



@section('title', 'Pedido')



@section('content_header')



@if(empty($next->First()))

<input style="float:right; " class="btn btn-info" type="button" id="verificar-pedidos" value="Verificar novos Pedidos">

@endif

<h1 id="select-status">Pedido: # {{ $order->First()->id }}</br>

    Status: {{ Form::select('id', $status) }}

    <input class="btn btn-info" type="button" id="mstatus" value="Mudar Status">

</h1>

<h1 id='select-exportar'>

    Exportar: {{ Form::select('id', $lojas, array('class' => 'select-exportar')) }}

    <input class="btn btn-info" type="button" id="exportar" value="Exportar Pedido">

</h1>

@stop



@section('content')
<style>
    .modal-body {
        display: flex;
        flex-direction: column;
    }

    .modal-body input {
        width: 100%;
        display: block;
    }

    .modal-footer .btn {
        width: 100%;
    }

    .continuar-compra .bg {
        background-color: rgba(35, 35, 35, 0.7);

    }

    .modal-login {
        position: fixed;
        width: 100%;
        height: 100%;
        z-index: 9999;
        display: none;
        top: 0;
        text-align: center;
        left: 0;
    }

    .modal-login .conteudo {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #ffffff;
        padding: 35px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        max-width: 480px;
        width: calc(100% - 24px);
    }

    .modal-login .conteudo::before {
        content: url('../img/clock.png');
        position: absolute;
        top: -22px;
        left: calc(50% - 11px);
    }

    .modal-login .bg {
        background-color: rgba(35, 35, 35, 0.7);
        width: 100%;
        height: 100%;
    }

    .modal-login .x {
        position: absolute;
        right: 30px;
        top: 30px;
        cursor: pointer;
        color: #cccccc;
    }

    .modal-login h3 {
        font-size: 40px;
        margin-bottom: 20px;
    }

    .modal-login label {
        float: left;
        margin-bottom: 10px;
    }

    .modal-login input {
        width: 100%;
        margin-top: 12px;
        margin-bottom: 20px;
        display: block;
        font-size: 20px;
        font-family: 'Oswald', sans-serif;
        padding: 8px;
        box-sizing: border-box;
        border: solid 2px #cccccc;
        outline: none;
        color: #848484;
    }

    .modal-login input:focus {
        border: solid 2px #800b58;
    }

    .modal-login .btn {
        color: white;
    }

    .modal-login.ativo {
        display: block;
    }

    @media (max-width: 555px) {
        .modal-login input {
            width: 100%;
            margin: 0 0 14px 0;
        }

        .modal-login .conteudo {
            padding: 50px;
        }
    }
</style>
<div class="modal-login">
    <div class="bg"></div>
    <div class="conteudo">
        <div class="x">X</div>
        <h3>Login</h3>
        <label for="email">Email</label>
        <input type="email" name="username" id="username">
        <label for="senha">Senha</label>
        <input type="password" name="password" id="password">
        <input class="btn btn-success" id="fazer-login" value="Fazer Login" type="button" />
    </div>
</div>
<!-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Login</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label for="username">
            Email
            <input type="email" name="username" id="username">

        </label>

        <label for="password">
            Senha   
            <input type="password" name="password" id="password">

        </label>
      </div>
      <div class="modal-footer">
        <button type="button" id="fazer-login" class="btn btn-success">Fazer Login</button>
      </div>
    </div>
  </div>
</div> -->

<div class="box">

    <a href="{{ route('admin.orders.index') }}"><input style="margin: 10px;" class="btn btn-primary" type="button" value="Voltar"></a>

    <div class="box-header with-border">

        <h2 class="box-title">Informações do Cliente<br />

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

            Informações de Entrega<br />

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

            Informações de Pagamento<br />

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

                    {{ $method->name_method }}

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

                <td id="total-order-prod">

                    @if(!empty($order->First()->order_prod_qtd) ||

                    $order->First()->order_prod_qtd != null)

                    {{ $order->First()->order_prod_qtd }}

                    @else

                    -

                    @endif

                </td>

                <td id="total-order" style="color: green; font-weight: bold;">

                    @if(!empty($order->First()->order_total) ||

                    $order->First()->order_total !=null)

                    {{ number_format($order->First()->order_total + $order->First()->order_tax_rate, 2, ",", ".") }}

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

            Produtos do Pedido<br />

        </h2>

        <table id="products" class="table">

            <thead>

                <tr>

                    <th>Nome</th>

                    <th>Descrição</th>

                    <th>Preço(R$)</th>

                    <th>Quantidade</th>

                    <th>Total(R$)</th>

                    <th></th>

                </tr>

            </thead>

            <tbody>

                <?php $total = 0 ?>

                @foreach($products as $product)

                @if($product->getOrderProducts()->First()->product_type == \App\Product::PROD_COMPL)
                <tr id-produto="{{ $product->id }}" style="background-color: #bee5eb;">

                    <td>

                        @if($product->getVariations()->count() > 0)
                        {{ $product->getVariations()->First()->prod_var_name }}
                        @else
                        {{ $product->getOrderProducts()->First()->name_product }}
                        @endif

                    </td>

                    <td>

                        {{ $product->getOrderProducts()->First()->description_product }}

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

                    <td>

                        -

                    </td>

                </tr>
                @foreach($variableProds as $prod)
                @if($prod->order_product_id == $product->id)
                <tr style="background-color: #bee5eb;">

                    <td>

                        +({{ $product->getOrderProducts()->First()->name_product . ") - " . $prod->getComplement()->First()->name_complement }}

                    </td>

                    <td>

                        {{ $product->getOrderProducts()->First()->description_product }}

                    </td>

                    <td style="color: green; font-weight: bold;">

                        {{ number_format($prod->price_comp, 2, ",", ".") }}

                    </td>

                    <td>

                        {{ $prod->qtd_comp }}

                    </td>

                    <td style="color: green; font-weight: bold;">

                        {{ number_format($prod->price_comp * $prod->qtd_comp, 2, ",", ".") }}

                    </td>

                    <!-- <td>
                                    
                                        <input type="button" id-produto="{{ $prod->id }}" id="excluir-produto" value="Excluir">

                                    </td> -->

                </tr>

                @endif
                @endforeach
                <?php $total += $product->order_product_total; ?>
                @elseif($product->getOrderProducts()->First()->product_type == \App\Product::PROD_COMBO)
                <tr id-produto="{{ $product->id }}" style="background-color: #bee5eb;">

                    <td>

                        {{ $product->getOrderProducts()->First()->name_product }}

                    </td>

                    <td>

                        {{ $product->getOrderProducts()->First()->description_product }}

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

                    <td>

                        <input type="button" id-produto="{{ $product->id }}" order-id="{{ $order->First()->id }}" total-prod="{{ $product->order_product_total }}" qtd-prod="{{ $product->order_product_qtd }}" id="excluir-produto" data-toggle="modal" class="btn btn-danger" value="Excluir">

                    </td>

                </tr>

                @foreach(json_decode($product->order_product_combo_id) as $prod)

                <tr style="background-color: #bee5eb;">

                    <td>

                        +({{ $product->getOrderProducts()->First()->name_product . ") - " . $prod }}

                    </td>

                    <td>

                        -

                    </td>

                    <td style="color: green; font-weight: bold;">

                        -

                    </td>

                    <td>

                        -

                    </td>

                    <td style="color: green; font-weight: bold;">

                        -

                    </td>

                    @endforeach


                    <?php $total += $product->order_product_total; ?>

                    @else
                <tr id-produto="{{ $product->id }}" style="background-color: #bee5eb;">

                    <td>
                        @if($product->getVariations()->count() > 0)
                        {{ $product->getVariations()->First()->prod_var_name }}
                        @else
                        {{ $product->getOrderProducts()->First()->name_product }}
                        @endif
                    </td>

                    <td>

                        {{ $product->getOrderProducts()->First()->description_product }}

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

                    <td>

                        <input type="button" id-produto="{{ $product->id }}" order-id="{{ $order->First()->id }}" total-prod="{{ $product->order_product_total }}" qtd-prod="{{ $product->order_product_qtd }}" id="excluir-produto" data-toggle="modal" class="btn btn-danger" value="Excluir">

                    </td>

                </tr>

                <?php $total += $product->order_product_total; ?>
                @endif

                @endforeach

                @if($total !== 0)

                <tr>

                    <td>Status do Pedido: <span style="color: green;" id="status-do-pedido">{{ $order->First()->getStatus()->First()->status_name }}</span></td>

                    <td></td>

                    <td></td>

                    <td>

                        Total de produtos:

                    </td>

                    <td id="total-prod" style="color: green; font-weight: bold;">

                        R$ {{ number_format($order->First()->order_total, 2, ",", ".") }}

                    </td>

                </tr>

                @endif

            </tbody>

        </table>

        @if(!empty($next->First()))

        @if($order->First()->getStatus()->First()->status_name == "finalizado")



        <a href="/admin/order/show/{{$next->First()->id}}"><input class="btn btn-primary" id="prox" type="button" value="Próximo" /></a>



        @else

        <a href="/admin/order/show/{{$next->First()->id}}"><input class="btn btn-primary" id="prox" type="button" value="Próximo" /></a>



        @endif

        @endif

    </div>

    <!-- /.box-body -->

    <!-- box-footer -->

</div>

<!-- /.box -->

@endsection



@section('js')

<script type="text/javascript">
    $(document).ready(function() {

        $('#verificar-pedidos').click(function() {

            if ($('input#prox').each().length == 0)

            {

                $.ajax({

                    url: "/admin/order/next/" + "{{ $order->First()->id }}",

                    type: "GET",

                    success: function(response) {

                        var html = '<a href="/admin/order/show/' + response + '"><input class="btn btn-primary" id="prox" type="button" value="Próximo"/></a>';

                        $(html).insertAfter('table#products');

                    },

                    error: function(response) {

                        alert("Não foram encontrados novos pedidos.");

                    }
                })

            }

        })

    });
</script>

<script>
    $(document).ready(function() {

        $('#mstatus').click(function() {

            var status = $('h1#select-status select option:selected').val();

            var status_name = $('h1#select-status select option:selected').text();

            if (status != "") {

                $.get('/admin/order/status/update/' + '{{ $order->First()->id }}' + '/' + status, function(response) {

                    if (response == 1) {

                        alert('Status atualizado com sucesso');

                        $("#status-do-pedido").text('');

                        $("#status-do-pedido").text(status_name);

                    } else {

                        alert('Não foi possível atualizar o status, tente novamente mais tarde.');

                    }

                })

            }

        });

    });
</script>

<script type="text/javascript">
    $(document).ready(function() {

        $('#exportar').click(function() {

            var id_loja = $('h1#select-exportar select option:selected').val();

            var id_pedido =

                <?= $order->First()->id ?>;

            var token = "{{ csrf_token() }}";

            $.post({

                url: "/admin/order/export",

                type: "POST",

                data: {
                    "_token": token,
                    "loja": id_loja,
                    "id": id_pedido
                },

                success: function(response) {

                    window.location = '/admin/orders';

                },

                error: function(response)

                {

                    alert("Não foi possível exportar o pedido.");

                }

            })

        })

    });
</script>

<script>
    var authenticated = false;
    var total_order = parseFloat(<?=
                                        $order->First()->order_total + $order->First()->order_tax_rate
                                    ?>);
    var total_prods = <?= $order->First()->order_prod_qtd ?>;
    var td = parseFloat(<?=
                            $order->First()->order_total
                        ?>);
    $(document.body).on('click', '#excluir-produto', function() {

        if (authenticated == false) {

            $('.modal-login').show();

        } else {
            var id_produto = $(this).attr('id-produto');
            var id_order = $(this).attr('order-id');
            var total = parseFloat($(this).attr('total-prod'));
            var qtd = $(this).attr('qtd-prod');
            var new_value = total_order - total;
            total_order = new_value;

            total_prods = total_prods - qtd;
            td = td - total;

            $.ajax({
                url: "/admin/order/edit/prod/exclude/" + id_produto + '/' + id_order + '/' + td + '/' + total_prods,
                type: 'GET',
                success: function(response) {
                    if (response == "true") {
                        $('tr[id-produto="' + id_produto + '"]').remove();
                        $('#total-order').text(numberToReal(new_value));
                        $('#total-order-prod').text(total_prods);
                        console.log(td);
                        $('td#total-prod').text("R$ " + numberToReal(td));
                        return;
                    }
                    alert("Não foi possível excluir o produto");
                },
                error: function(response) {
                    alert("Não foi possível excluir o produto");
                }
            })
        }

    });

    function numberToReal(numero) {

        numero = parseFloat(numero);
        var numero = numero.toFixed(2).split('.');
        numero[0] = numero[0].split(/(?=(?:...)*$)/).join('.');

        return numero.join(',');

    }

    function authenticUser(email, password) {
        $.ajax({
            url: '/admin/order/edit/user/' + email + '/' + password,
            type: 'GET',
            success: function(response) {
                if (response == "true") {
                    $('.modal-login').hide();
                    authenticated = true;
                    alert("Usuário autenticado com sucesso!");
                }
            },
            error: function(response) {
                alert('Usuário ou senha incorreto! Tente novamente!');
            }
        })
    }

    function excludeProd(id, value, qtd) {
        var total_prod = $('#total-prod').text();
        total_prod = parseFloat(total_prod.replace('R$', ''));

    }

    $(document).on('click', '#fazer-login', function() {

        var email = $('input[name="username"]').val();
        var password = $('input[name="password"]').val();

        authenticUser(email, password);
    });
</script>

@endsection