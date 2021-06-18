@extends('layouts.tubarao-delivery')

@section('content')
<style>
    .menu-lateral {
        display: flex;
        justify-content: center;
        margin-top: 50px;
        position: fixed;
    }
    .menu-lateral ul {
        list-style: none;
        background-color: #800b58;
        border: 5px solid transparent;
        border-color: #bc1080;
        border-radius: 5px;
    }
    .menu-lateral ul li {
        padding: 15px;
    }
    .menu-lateral ul a {
        color: #fdec01;
        font-size: 20px;
        font-family: 'Oswald', sans-serif;
        font-weight: 300;
        text-decoration: none;
    }
    .menu-lateral ul li:hover {
        background-color: #bc1080;
    }
    @media(max-width: 767px){
        .menu-lateral {
            position: relative;
        }
        .menu-lateral ul {
            width: 100%;
            margin-top: -40px;
        }
    }
</style>
<div class="container">
    
    <div class="row">

        <div class="col-md-12">
            
        <form id="logout" action="{{ route('clientes.logout') }}" method="POST">
            {{ csrf_field() }}
            <input type="image" style="position: relative; float: right; margin-top: 10px;" src="{{ asset('img/logout-tubarao.png') }}" width="40" height="30" alt="logout">
            
        </form>

        </div>

    </div>

    <div class="row">

        <div class="col-md-2">

            <div class="menu-lateral">
                <ul>
                <a href="#"><li>Pedidos</li></a>
                <a href="#"><li>Pedidos</li></a>
                <a href="#"><li>Pedidos</li></a>
                <a href="#"><li>Pedidos</li></a>
                </ul>
            </div>
        
        </div>

    <div class="col-md-10">

        <div style="height: 30px; margin: 10px;">
                <span style="font-weight: 300;
    font-size: 36px;
    font-family: 'Oswald', sans-serif;
    text-align: left;">Pedidos</span>
                
            </div>
        
            <div class="box-body table-responsive">
        
                <table class="table table-hover table-resposive ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Taxa</th>
                            <th>Subtotal</th>
                            <th>Total</th>
                            <th>Qtd. Produtos</th>
                            <th>Método Pagamento</th>
                            <th>Data/hora Pedido</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>R$ {{ number_format($order->order_tax_rate, 2, ',', '.') }}</td>
                            <td>R$ {{ number_format($order->order_total, 2, ',', '.') }}</td>
                            <td>R$ {{ number_format($order->order_total + $order->order_tax_rate, 2, ',', '.') }}</td>
                            <td>{{ $order->order_prod_qtd }}</td>
                            <td>{{ $order->getPaymentMethod()->First()->name_method }}</td>
                            <td>{{ date_format($order->created_at, 'd/m/Y H:i:s') }}</td>
                            <td>{{ $order->getStatus()->First()->status_name }}</td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        
            </div>
        </div>
    </div>
</div>

@endsection