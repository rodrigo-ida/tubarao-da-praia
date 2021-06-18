@extends('layouts.tubarao-delivery')


@section('content')

<div class="container">
<h3 style="text-align: center; font-size: 28px; padding: 10px;">Pedidos Realizados</h3>
    <div class="orders-content" style="
    max-width: 700px;
    margin: 0 auto;
    ">
    <span style="color: green;">Total de pedidos: {{ $orders->count() }}</span>
    
        <table class="table table-responsive table-hover">

            <thead>

                <tr>

                    <th>#</th>

                    <th>Data/Hora</th>
                    
                    <th>Total</th>
                    
                    <th>Unidade</th>

                    <th>Status do Pedido</th>

                    <th>Ação</th>

                </tr>

            </thead>

            <tbody>
            @foreach($orders as $order)
                <tr>    
                
                    <td>{{ $order->id }}</td>

                    <td>{{ date_format(new DateTime($order->created_at), 'd/m/Y H:i:s') }}</td>
                    
                    <td> R$ {{ number_format($order->order_total + $order->order_tax_rate, 2, ',', '.') }}</td>
                    
                    <td> {{ $order->getLoja()->First()->nome_loja }}</td>
                    
                    <td> {{ $order->status_name }}</td>
                    
                    <td><input id="btn-ver-pedido" data-id="{{ $order->id }}" type="button" value="Ver" class="btn btn-info"></td>
                
                </tr>
            @endforeach
            </tbody>

        </table>
    </div>
</div>

@endsection