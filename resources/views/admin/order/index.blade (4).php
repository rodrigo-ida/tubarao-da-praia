@extends('layouts.admin')



@section('title', 'Pedidos')



@section('content_header')

    <h1>Pedidos</h1>

@stop
<style>
::-webkit-scrollbar              { /* 1 */ }
::-webkit-scrollbar-button       { /* 2 */ }
::-webkit-scrollbar-track        { /* 3 */ }
::-webkit-scrollbar-track-piece  { /* 4 */ }
::-webkit-scrollbar-thumb        { /* 5 */ }
::-webkit-scrollbar-corner       { /* 6 */ }
::-webkit-resizer                { /* 7 */ }

::-webkit-scrollbar-track {
    background-color: #F4F4F4;
}
::-webkit-scrollbar {
    width: 10px;
    background: #F4F4F4;
}
::-webkit-scrollbar-thumb {
    background: #dad7d7;
}

.order-list-card {
    display: inline-block;
    width: 100%;
    margin: 15px;

}

.order-card {
    margin: 10px;
    width: 380px;
    display: inline-block;
    height: 675px;
    padding: 10px;
    max-width: 30.5%;
    box-shadow: 5px 5px 10px 1px rgba(0,0,0,0.2);
    white-space: normal;
}

@media (max-width: 768px) {
    .order-card {
        max-width: 90%;
        width: 90%;
    }
}

@media (max-width: 425px) {
    .order-card {
        max-width: 87%;
        width: 87%;
    }
}

.order-card h3 {
    font-size: 25px;
    margin-top: 0;
    margin-bottom: 20px;
    color: #fff;
}

.order-card span {
    font-size: 15px;
    color: #fff;
}

.order-card span p {
    word-wrap: break-word;
}

.order-card input {
    padding: 10px;
    background-color: transparent;
    border: 2px solid #CCC;
    border-radius: 5px;
    float: right;
}

/* .status-buttons {
    display: inline-block;
} */

.status-buttons,.order-card {
    display: inline-table;
}

.status-buttons:before, 
.status-buttons:after,
.order-card:before, 
.order-card:after{
content:" ";
display: table;
}
.status-buttons:after,
.order-card:after
{
    clear: both;
}

.order-status {
    margin: 5px;
    width: calc(33.3% - 10px);
    padding: 10px;
    border: none;
    border-radius: 5px;
}

.order-status-subtitle {
    padding: 10px;
}

.order-status-subtitle div {
    display: inline-block;
    width: 10px;
    height: 10px;
    border: 1px solid black;
    margin: 5px;
}

.scroll-div {
    width: 97.3%;
    height: auto;
    overflow-x: scroll;
    overflow-y: hidden;
    white-space: nowrap;
}
.loading{
	z-index: 999;
    width: 100%;
    height: 100%;
    position: fixed;
    background: #fbfbfbf5;
	top: 0;
	display: flex;
    justify-content: center;
    align-items: center;
    top: 0;
    left: 0;
    display: none;
}
.loading span img {
    width: 150px;
	}

</style>

@section('content')
<div class="loading"><span style="display: block;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%,-50%);"><img src="{{ asset('/img/gif-load-admin.gif') }}" alt="gif-loading" /></span></div>

        <div class="box">
            <div class="order-status-subtitle">
            @foreach($status as $stat)
                @if($stat->status_name == 'Agendado')

                    <div style="background-color: #00c0ef;">
                    </div>

                {{ $stat->status_name }}

                @elseif($stat->status_name == 'Pendente')

                    <div class="order-status-subtitle-box" style="background-color: #FF8B32;">
                    </div>

                    {{ $stat->status_name }}
                @elseif($stat->status_name == 'Em preparo')

                    <div class="order-status-subtitle-box" style="background-color: #605ca8;">
                    </div>

                    {{ $stat->status_name }}
                @elseif($stat->status_name == 'Em entrega')

                    <div class="order-status-subtitle-box" style="background-color: #F2C335;">
                    </div>

                    {{ $stat->status_name }}
                @elseif($stat->status_name == 'Concluído')

                    <div class="order-status-subtitle-box" style="background-color: #2F922F;">
                    </div>

                    {{ $stat->status_name }}
                @elseif($stat->status_name == 'Cancelado')

                    <div class="order-status-subtitle-box" style="background-color: #B63A3A;">
                    </div>

                    {{ $stat->status_name }}           
                @endif
        
                @endforeach          
                </div>
                @if(!$orders->isEmpty())
                <div class="order-list-card">

                <!-- div card agendado -->
                    <div class="div-cards">
                    <h3>Agendado</h3>

                    <!--Começo do card-->
                    <div class="scroll-div">
                    @foreach($orders as $order)
                        @if($order->getStatus->status_name == 'Agendado')

                        <div p="{{ $order->id }}" style="background-color: #00c0ef;" class="order-card">
                        <a href="/admin/order/show/{{ $order->id }}">
                            <h3 id="id">#<strong> {{ $order->id }} </strong> {{ $order->getClient()->First()->nome }}</h3>
                        </a>
                        <span>
                            Observação do pedido:
                        @if(isset($order->order_obs))
                        
                            <p>{{ $order->order_obs }}</p>

                        @else

                            <p>-</p>

                        @endif
                        </span>
                        <span>
                            Data/Hora:
                            <p>{{ date_format($order->created_at, 'd/m/Y H:i:s') }}</p>

                        </span>
                        <span>
                            Loja:
                            <p>{{$order->getLoja()->First()->nome_loja}}</p>
                        
                        </span>
                        <span>

                            Whatsapp:
                            <p>@if(isset($order->getClient()->First()->whatsapp)){{ $order->getClient()->First()->whatsapp }} @endif</p>

                        </span>
                        <span>

                            Endereço:
                            <p style="word-wrap: break-word;">{{ $order->order_street . ", $order->order_number - " . $order->order_neighborhood . " - " . $order->order_city }}</p>

                        </span>
                        <span>

                            Total de produtos:
                            <p>{{ $order->order_prod_qtd }}</p>

                        </span>
                        <span>

                            Taxa de entrega:
                            <p>R$ {{ number_format($order->order_tax_rate, 2, ',','.') }}</p>

                        </span>
                        <span>

                            Total do pedido:
                            <p>R$ {{ number_format($order->order_total + $order->order_tax_rate, 2, ',','.') }}</p>

                        </span>
                        <span p="{{ $order->id }}">

                            Status:
                            <p>{{ $order->getStatus->status_name }} </p>

                        </span>
                        <span>

                            Forma de Pagamento:
                            <p>{{ $order->getPaymentMethod()->First()->name_method }}</p>

                        </span>
                        <span>

                            Observação de Pagamento:
                            @if(!empty($order->order_obs_payment))
                            <p>{{ $order->order_obs_payment }}</p>
                                @else
                                <p>-</p>
                            @endif

                        </span>

                        <?php $count = 0; ?>
                        <?php $list  = []; ?>
                        <?php $i     = 0; ?>

                        <!-- começo foreach status-->
                        @foreach($status as $stat)
                        <?php 

                            $list['id']   = $order->getStatus->id;
                            $list['name'] = $order->getStatus->status_name;
                            $i++;

                        ?>
                        @if($stat->status_name == 'Em preparo')
                            @if($count != 1)
                                <span>

                                    <input p="{{ $order->id }}" btn-id="{{ $stat->id }}" id="captar-pedido" type="button" value="Captar Pedido" />                            
                            
                                </span>
                            
                                <?php $count = 1; ?>
                            @endif
                        @endif
                    @endforeach
                    </div>
                        <!-- fim foreach status-->
                @endif
            @endforeach
            
                </div>
            </div>
            <!-- fim div agendado -->
            
            <!-- div pendente -->
            <div class="div-cards">
                    <h3>Pendente</h3>

                    <!--Começo do card-->
                    <div id="pendente" class="scroll-div">
                    @foreach($orders as $order)
                        @if($order->getStatus->status_name == 'Pendente')

                        <div p="{{ $order->id }}" style="background-color: #FF8B32;" class="order-card">
                        <a href="/admin/order/show/{{ $order->id }}">
                            <h3 id="id">#<strong> {{ $order->id }} </strong> @if(isset($order->getClient()->First()->nome)){{ $order->getClient()->First()->nome }} @endif</h3>
                        </a>

                        <span>
                            Observação do pedido:
                        @if(isset($order->order_obs))
                        
                            <p>{{ $order->order_obs }}</p>

                        @else

                            <p>-</p>

                        @endif
                        </span>

                        <span>
                            Data/Hora:
                            <p>{{ date_format($order->created_at, 'd/m/Y H:i:s') }}</p>

                        </span>
                        <span>
                            Loja:
                            <p>{{$order->getLoja()->First()->nome_loja}}</p>
                        
                        </span>
                        <span>

                            Whatsapp:
                            <p>@if(isset($order->getClient()->First()->whatsapp)){{ $order->getClient()->First()->whatsapp }} @endif</p>

                        </span>
                        <span>

                            Endereço:
                            <p>{{ $order->order_street . ", $order->order_number - " . $order->order_neighborhood . " - " . $order->order_city }}</p>

                        </span>
                        <span>

                            Total de produtos:
                            <p>{{ $order->order_prod_qtd }}</p>

                        </span>
                        <span>

                            Taxa de entrega:
                            <p>R$ {{ number_format($order->order_tax_rate, 2, ',','.') }}</p>

                        </span>
                        <span>

                            Total do pedido:
                            <p>R$ {{ number_format($order->order_total + $order->order_tax_rate, 2, ',','.') }}</p>

                        </span>
                        <span p="{{ $order->id }}">

                            Status:
                            <p>{{ $order->getStatus->status_name }} </p>

                        </span>
                        <span>

                            Forma de Pagamento:
                            <p>{{ $order->getPaymentMethod()->First()->name_method }}</p>

                        </span>
                        <span>

                            Observação de Pagamento:
                            @if(!empty($order->order_obs_payment))
                            <p>{{ $order->order_obs_payment }}</p>
                                @else
                                <p>-</p>
                            @endif

                        </span>

                        <?php $count = 0; ?>
                        <?php $list  = []; ?>
                        <?php $i     = 0; ?>

                        <!-- começo foreach status-->
                        @foreach($status as $stat)
                        <?php 

                            $list['id']   = $order->getStatus->id;
                            $list['name'] = $order->getStatus->status_name;
                            $i++;

                        ?>
                        @if($stat->status_name == 'Em preparo')
                            @if($count != 1)
                                <span>

                                    <input p="{{ $order->id }}" btn-id="{{ $stat->id }}" id="captar-pedido" type="button" value="Captar Pedido" />                            
                            
                                </span>
                            
                                <?php $count = 1; ?>
                            @endif
                        @endif
                    @endforeach
                    </div>
                        <!-- fim foreach status-->
                @endif
            @endforeach
                </div>
            </div>
            <!-- fim div pendente -->

            <!-- div em preparo -->
            <div class="div-cards">
                    <h3>Em preparo</h3>

                    <!--Começo do card-->
                    <div id="preparo" class="scroll-div">
                    @foreach($orders as $order)
                        @if($order->getStatus->status_name == 'Em preparo')

                        <div p="{{ $order->id }}" style="background-color: #605ca8;" class="order-card">
                        <div class="clearfix">    
                            <input type="button" btn-id="{{ $order->id }}" class="btn btn-primary btn-impressao" btn-data="imprimir" value="imprimir" />
                            <input type="button" btn-id="{{ $order->id }}" class="btn btn-primary btn-impressao" btn-data="cozinha" value="cozinha" />                        
                            <input type="button" btn-id="{{ $order->id }}" class="btn btn-primary btn-impressao" btn-data="imprimir" value="motoboy" /> 
                        </div>
                            <a href="/admin/order/show/{{ $order->id }}" style="display: block;">
                            <h3 id="id">#<strong> {{ $order->id }} </strong>  @if(isset($order->getClient()->First()->nome)){{ $order->getClient()->First()->nome }} @endif</h3>
                        </a>

                        <span>
                            Observação do pedido:
                        @if(isset($order->order_obs))
                        
                            <p>{{ $order->order_obs }}</p>

                        @else

                            <p>-</p>

                        @endif
                        </span>

                        <span>
                            Data/Hora:
                            <p>{{ date_format($order->created_at, 'd/m/Y H:i:s') }}</p>

                        </span>
                        <span>
                            Loja:
                            <p>{{$order->getLoja()->First()->nome_loja}}</p>
                        
                        </span>
                        <span>

                            Whatsapp:
                            <p>@if(isset($order->getClient()->First()->whatsapp)){{ $order->getClient()->First()->whatsapp }} @endif</p>

                        </span>
                        <span>

                            Endereço:
                            <p>{{ $order->order_street . ", $order->order_number - " . $order->order_neighborhood . " - " . $order->order_city }}</p>

                        </span>
                        <span>

                            Total de produtos:
                            <p>{{ $order->order_prod_qtd }}</p>

                        </span>
                        <span>

                            Taxa de entrega:
                            <p>R$ {{ number_format($order->order_tax_rate, 2, ',','.') }}</p>

                        </span>
                        <span>

                            Total do pedido:
                            <p>R$ {{ number_format($order->order_total + $order->order_tax_rate, 2, ',','.') }}</p>

                        </span>
                        <span p="{{ $order->id }}">

                            Status:
                            <p>{{ $order->getStatus->status_name }} </p>

                        </span>
                        <span>

                            Forma de Pagamento:
                            <p>{{ $order->getPaymentMethod()->First()->name_method }}</p>

                        </span>
                        <span>

                            Observação de Pagamento:
                            @if(!empty($order->order_obs_payment))
                            <p>{{ $order->order_obs_payment }}</p>
                                @else
                                <p>-</p>
                            @endif

                        </span>

                        <?php $count = 0; ?>
                        <?php $list  = []; ?>
                        <?php $i     = 0; ?>

                        <!-- começo foreach status-->
            
                        @if($order->getStatus->status_name != 'Agendado' && $order->getStatus->status_name != 'Pendente')
                            <span class="status-buttons">
                                <h3 style="display:flex; justify-content: center; align-items: center;">Status</h3>
                            @foreach($status as $stat)
                            <?php 
                        
                                $list['id']   = $order->getStatus->id;
                                $list['name'] = $order->getStatus->status_name;
                                $i++;

                            ?>
                                @if($stat->status_name == 'Agendado')

                                    <!-- <input p="{{ $order->id }}" btn-id="{{ $stat->id }}" btn-data="ag" type="button" style="background-color: #00c0ef;" value="Agendado" class="order-status" /> -->
        
                                    @elseif($stat->status_name == 'Pendente')
                    
                                        <!-- <input p="{{ $order->id }}" btn-id="{{ $stat->id }}" btn-data="pe" type="button" style="background-color: #FF8B32" value="Pendente" class="order-status" /> -->
                                    
                                    @elseif($stat->status_name == 'Em preparo')

                                        <input p="{{ $order->id }}" btn-id="{{ $stat->id }}" btn-data="ep" type="button" style="background-color: #605ca8;" value="Em preparo" class="order-status">

                                    @elseif($stat->status_name == 'Em entrega')
            
                                        <input p="{{ $order->id }}" btn-id="{{ $stat->id }}" btn-data="et" type="button" style="background-color: #F2C335;" value="Em entrega" class="order-status">                                
                                    
                                    @elseif($stat->status_name == 'Concluído')

                                        <input p="{{ $order->id }}" btn-id="{{ $stat->id }}" btn-data="co" type="button" style="background-color: #2F922F;" value="Concluído" class="order-status">

                                    @elseif($stat->status_name == 'Cancelado')

                                        <input p="{{ $order->id }}" btn-id="{{ $stat->id }}" btn-data="ca" type="button" style="background-color: #B63A3A;" value="Cancelado" class="order-status">
                                @endif
                            @endforeach
                        @endif
                            </span>
                            </div>
                        <!-- fim foreach status-->
                @endif
            @endforeach
                </div>
            </div>
            <!-- fim div em preparo -->

            <!-- div em entrega -->
            <div class="div-cards">
                    <h3>Em entrega</h3>

                    <!--Começo do card-->
                    <div id="entrega" class="scroll-div">
                    @foreach($orders as $order)
                        @if($order->getStatus->status_name == 'Em entrega')

                        <div p="{{ $order->id }}" style="background-color: #F2C335;" class="order-card">
                        <div class="clearfix">    
                            <input type="button" btn-id="{{ $order->id }}" class="btn btn-primary btn-impressao" btn-data="imprimir" value="imprimir" />
                            <input type="button" btn-id="{{ $order->id }}" class="btn btn-primary btn-impressao" btn-data="cozinha" value="cozinha" />                        
                            <input type="button" btn-id="{{ $order->id }}" class="btn btn-primary btn-impressao" btn-data="imprimir" value="motoboy" /> 
                        </div>
                        <a href="/admin/order/show/{{ $order->id }}">
                            <h3 id="id">#<strong> {{ $order->id }} </strong>  @if(isset($order->getClient()->First()->nome)){{ $order->getClient()->First()->nome }} @endif</h3>
                        </a>

                        <span>
                            Observação do pedido:
                        @if(isset($order->order_obs))
                        
                            <p>{{ $order->order_obs }}</p>

                        @else

                            <p>-</p>

                        @endif
                        </span>

                        <span>
                            Data/Hora:
                            <p>{{ date_format($order->created_at, 'd/m/Y H:i:s') }}</p>

                        </span>
                        <span>
                            Loja:
                            <p>{{$order->getLoja()->First()->nome_loja}}</p>
                        
                        </span>
                        <span>

                            Whatsapp:
                            <p>@if(isset($order->getClient()->First()->whatsapp)){{ $order->getClient()->First()->whatsapp }} @endif</p>

                        </span>
                        <span>

                            Endereço:
                            <p>{{ $order->order_street . ", $order->order_number - " . $order->order_neighborhood . " - " . $order->order_city }}</p>

                        </span>
                        <span>

                            Total de produtos:
                            <p>{{ $order->order_prod_qtd }}</p>

                        </span>
                        <span>

                            Taxa de entrega:
                            <p>R$ {{ number_format($order->order_tax_rate, 2, ',','.') }}</p>

                        </span>
                        <span>

                            Total do pedido:
                            <p>R$ {{ number_format($order->order_total + $order->order_tax_rate, 2, ',','.') }}</p>

                        </span>
                        <span p="{{ $order->id }}">

                            Status:
                            <p>{{ $order->getStatus->status_name }} </p>

                        </span>
                        <span>

                            Forma de Pagamento:
                            <p>{{ $order->getPaymentMethod()->First()->name_method }}</p>

                        </span>
                        <span>

                            Observação de Pagamento:
                            @if(!empty($order->order_obs_payment))
                            <p>{{ $order->order_obs_payment }}</p>
                                @else
                                <p>-</p>
                            @endif

                        </span>

                        <?php $count = 0; ?>
                        <?php $list  = []; ?>
                        <?php $i     = 0; ?>

                        <!-- começo foreach status-->
                        @if($order->getStatus->status_name != 'Agendado' && $order->getStatus->status_name != 'Pendente')
                            <span class="status-buttons">
                                <h3 style="display:flex; justify-content: center; align-items: center;">Status</h3>
                            @foreach($status as $stat)
                            <?php 
                        
                                $list['id']   = $order->getStatus->id;
                                $list['name'] = $order->getStatus->status_name;
                                $i++;

                            ?>
                                @if($stat->status_name == 'Agendado')

                                    <!-- <input p="{{ $order->id }}" btn-id="{{ $stat->id }}" btn-data="ag" type="button" style="background-color: #00c0ef;" value="Agendado" class="order-status" /> -->
        
                                    @elseif($stat->status_name == 'Pendente')
                    
                                        <!-- <input p="{{ $order->id }}" btn-id="{{ $stat->id }}" btn-data="pe" type="button" style="background-color: #FF8B32" value="Pendente" class="order-status" /> -->
                                    
                                    @elseif($stat->status_name == 'Em preparo')

                                        <input p="{{ $order->id }}" btn-id="{{ $stat->id }}" btn-data="ep" type="button" style="background-color: #605ca8;" value="Em preparo" class="order-status">

                                    @elseif($stat->status_name == 'Em entrega')
            
                                        <input p="{{ $order->id }}" btn-id="{{ $stat->id }}" btn-data="et" type="button" style="background-color: #F2C335;" value="Em entrega" class="order-status">                                
                                    
                                    @elseif($stat->status_name == 'Concluído')

                                        <input p="{{ $order->id }}" btn-id="{{ $stat->id }}" btn-data="co" type="button" style="background-color: #2F922F;" value="Concluído" class="order-status">

                                    @elseif($stat->status_name == 'Cancelado')

                                        <input p="{{ $order->id }}" btn-id="{{ $stat->id }}" btn-data="ca" type="button" style="background-color: #B63A3A;" value="Cancelado" class="order-status">
                                @endif
                            @endforeach
                        @endif
                            </span>
                            </div>
                        <!-- fim foreach status-->
                @endif
            @endforeach
                </div>
            </div>
            <!-- fim div em entrega -->

            <!-- div concluído -->
            <div class="div-cards">
                    <h3>Concluído</h3>

                    <!--Começo do card-->
                    <div id="concluido" class="scroll-div">
                    @foreach($orders as $order)
                        @if($order->getStatus->status_name == 'Concluído')

                        <div p="{{ $order->id }}" style="background-color: #2F922F;" class="order-card">
                        <div class="clearfix">    
                            <input type="button" btn-id="{{ $order->id }}" class="btn btn-primary btn-impressao" btn-data="imprimir" value="imprimir" />
                            <input type="button" btn-id="{{ $order->id }}" class="btn btn-primary btn-impressao" btn-data="cozinha" value="cozinha" />                        
                            <input type="button" btn-id="{{ $order->id }}" class="btn btn-primary btn-impressao" btn-data="imprimir" value="motoboy" /> 
                        </div>
                        <a href="/admin/order/show/{{ $order->id }}">
                            <h3 id="id">#<strong> {{ $order->id }} </strong>  @if(isset($order->getClient()->First()->nome)){{ $order->getClient()->First()->nome }} @endif</h3>
                        </a>

                        <span>
                            Observação do pedido:
                        @if(isset($order->order_obs))
                        
                            <p>{{ $order->order_obs }}</p>

                        @else

                            <p>-</p>

                        @endif
                        </span>

                        <span>
                            Data/Hora:
                            <p>{{ date_format($order->created_at, 'd/m/Y H:i:s') }}</p>

                        </span>
                        <span>

                            Loja:
                            <p>{{$order->getLoja()->First()->nome_loja }}</p>
                        
                        </span>
                        <span>

                            Whatsapp:
                            <p>@if(isset($order->getClient()->First()->whatsapp)){{ $order->getClient()->First()->whatsapp }} @endif</p>

                        </span>
                        <span>

                            Endereço:
                            <p>{{ $order->order_street . ", $order->order_number - " . $order->order_neighborhood . " - " . $order->order_city }}</p>

                        </span>
                        <span>

                            Total de produtos:
                            <p>{{ $order->order_prod_qtd }}</p>

                        </span>
                        <span>

                            Taxa de entrega:
                            <p>R$ {{ number_format($order->order_tax_rate, 2, ',','.') }}</p>

                        </span>
                        <span>

                            Total do pedido:
                            <p>R$ {{ number_format($order->order_total + $order->order_tax_rate, 2, ',','.') }}</p>

                        </span>
                        <span p="{{ $order->id }}">

                            Status:
                            <p>{{ $order->getStatus->status_name }} </p>

                        </span>
                        <span>

                            Forma de Pagamento:
                            <p>{{ $order->getPaymentMethod()->First()->name_method }}</p>

                        </span>
                        <span>

                            Observação de Pagamento:
                            @if(!empty($order->order_obs_payment))
                            <p>{{ $order->order_obs_payment }}</p>
                                @else
                                <p>-</p>
                            @endif

                        </span>

                        <?php $count = 0; ?>
                        <?php $list  = []; ?>
                        <?php $i     = 0; ?>

                        <!-- começo foreach status-->
                        @if($order->getStatus->status_name != 'Agendado' && $order->getStatus->status_name != 'Pendente')
                            <span class="status-buttons">
                                <h3 style="display:flex; justify-content: center; align-items: center;">Status</h3>
                            @foreach($status as $stat)
                            <?php 
                        
                                $list['id']   = $order->getStatus->id;
                                $list['name'] = $order->getStatus->status_name;
                                $i++;

                            ?>
                                @if($stat->status_name == 'Agendado')

                                    <!-- <input p="{{ $order->id }}" btn-id="{{ $stat->id }}" btn-data="ag" type="button" style="background-color: #00c0ef;" value="Agendado" class="order-status" /> -->
        
                                    @elseif($stat->status_name == 'Pendente')
                    
                                        <!-- <input p="{{ $order->id }}" btn-id="{{ $stat->id }}" btn-data="pe" type="button" style="background-color: #FF8B32" value="Pendente" class="order-status" /> -->
                                    
                                    @elseif($stat->status_name == 'Em preparo')

                                        <input p="{{ $order->id }}" btn-id="{{ $stat->id }}" btn-data="ep" type="button" style="background-color: #605ca8;" value="Em preparo" class="order-status">

                                    @elseif($stat->status_name == 'Em entrega')
            
                                        <input p="{{ $order->id }}" btn-id="{{ $stat->id }}" btn-data="et" type="button" style="background-color: #F2C335;" value="Em entrega" class="order-status">                                
                                    
                                    @elseif($stat->status_name == 'Concluído')

                                        <input p="{{ $order->id }}" btn-id="{{ $stat->id }}" btn-data="co" type="button" style="background-color: #2F922F;" value="Concluído" class="order-status">

                                    @elseif($stat->status_name == 'Cancelado')

                                        <input p="{{ $order->id }}" btn-id="{{ $stat->id }}" btn-data="ca" type="button" style="background-color: #B63A3A;" value="Cancelado" class="order-status">
                                @endif
                            @endforeach
                        @endif
                            </span>
                            </div>
                        <!-- fim foreach status-->
                @endif
            @endforeach
                </div>
            </div>
            <!-- fim div concluído -->

            <!-- div cancelado -->
            <div class="div-cards">
                    <h3>Cancelado</h3>

                    <!--Começo do card-->
                    <div id="cancelado" class="scroll-div">
                    @foreach($orders as $order)
                        @if($order->getStatus->status_name == 'Cancelado')

                        <div p="{{ $order->id }}" style="background-color: #B63A3A;" class="order-card">
                        <div class="clearfix">    
                            <input type="button" btn-id="{{ $order->id }}" class="btn btn-primary btn-impressao" btn-data="imprimir" value="imprimir" />
                            <input type="button" btn-id="{{ $order->id }}" class="btn btn-primary btn-impressao" btn-data="cozinha" value="cozinha" />                        
                            <input type="button" btn-id="{{ $order->id }}" class="btn btn-primary btn-impressao" btn-data="imprimir" value="motoboy" /> 
                        </div>
                        <a href="/admin/order/show/{{ $order->id }}">
                            <h3 id="id">#<strong> {{ $order->id }} </strong>  @if(isset($order->getClient()->First()->nome)){{ $order->getClient()->First()->nome }} @endif</h3>
                        </a>

                        <span>
                            Observação do pedido:
                        @if(isset($order->order_obs))
                        
                            <p>{{ $order->order_obs }}</p>

                        @else

                            <p>-</p>

                        @endif
                        </span>

                        <span>
                            Data/Hora:
                            <p>{{ date_format($order->created_at, 'd/m/Y H:i:s') }}</p>

                        </span>
                        <span>
                            Loja:
                            <p>{{$order->getLoja()->First()->nome_loja}}</p>
                        
                        </span>
                        <span>

                            Whatsapp:
                            <p>@if(isset($order->getClient()->First()->whatsapp)){{ $order->getClient()->First()->whatsapp }} @endif</p>

                        </span>
                        <span>

                            Endereço:
                            <p>{{ $order->order_street . ", $order->order_number - " . $order->order_neighborhood . " - " . $order->order_city }}</p>

                        </span>
                        <span>

                            Total de produtos:
                            <p>{{ $order->order_prod_qtd }}</p>

                        </span>
                        <span>

                            Taxa de entrega:
                            <p>R$ {{ number_format($order->order_tax_rate, 2, ',','.') }}</p>

                        </span>
                        <span>

                            Total do pedido:
                            <p>R$ {{ number_format($order->order_total + $order->order_tax_rate, 2, ',','.') }}</p>

                        </span>
                        <span p="{{ $order->id }}">

                            Status:
                            <p>{{ $order->getStatus->status_name }} </p>

                        </span>
                        <span>

                            Forma de Pagamento:
                            <p>{{ $order->getPaymentMethod()->First()->name_method }}</p>

                        </span>
                        <span>

                            Observação de Pagamento:
                            @if(!empty($order->order_obs_payment))
                            <p>{{ $order->order_obs_payment }}</p>
                                @else
                                <p>-</p>
                            @endif

                        </span>

                        <?php $count = 0; ?>
                        <?php $list  = []; ?>
                        <?php $i     = 0; ?>

                        <!-- começo foreach status-->
                        @if($order->getStatus->status_name != 'Agendado' && $order->getStatus->status_name != 'Pendente')
                            <span class="status-buttons">
                                <h3 style="display:flex; justify-content: center; align-items: center;">Status</h3>
                            @foreach($status as $stat)
                            <?php 
                        
                                $list['id']   = $order->getStatus->id;
                                $list['name'] = $order->getStatus->status_name;
                                $i++;

                            ?>
                                @if($stat->status_name == 'Agendado')

                                    <!-- <input p="{{ $order->id }}" btn-id="{{ $stat->id }}" btn-data="ag" type="button" style="background-color: #00c0ef;" value="Agendado" class="order-status" /> -->
        
                                    @elseif($stat->status_name == 'Pendente')
                    
                                        <!-- <input p="{{ $order->id }}" btn-id="{{ $stat->id }}" btn-data="pe" type="button" style="background-color: #FF8B32" value="Pendente" class="order-status" /> -->
                                    
                                    @elseif($stat->status_name == 'Em preparo')

                                        <input p="{{ $order->id }}" btn-id="{{ $stat->id }}" btn-data="ep" type="button" style="background-color: #605ca8;" value="Em preparo" class="order-status">

                                    @elseif($stat->status_name == 'Em entrega')
            
                                        <input p="{{ $order->id }}" btn-id="{{ $stat->id }}" btn-data="et" type="button" style="background-color: #F2C335;" value="Em entrega" class="order-status">                                
                                    
                                    @elseif($stat->status_name == 'Concluído')

                                        <input p="{{ $order->id }}" btn-id="{{ $stat->id }}" btn-data="co" type="button" style="background-color: #2F922F;" value="Concluído" class="order-status">

                                    @elseif($stat->status_name == 'Cancelado')

                                        <input p="{{ $order->id }}" btn-id="{{ $stat->id }}" btn-data="ca" type="button" style="background-color: #B63A3A;" value="Cancelado" class="order-status">
                                @endif
                            @endforeach
                        @endif
                            </span>
                            </div>
                        <!-- fim foreach status-->
                @endif
            @endforeach
                </div>
            </div>
            <!-- fim div cancelado -->
            @endif
        </div>
                

    <!-- /.box -->

@endsection

@section('js')
    <script>

    function getLoadDiv(){
        $('.loading').show();
    }

    function removeLoadDiv(){
        $('.loading').hide();
    }

    function updateStatus(id, status_id, status) {
        var html = 
        `
            <div class="clearfix">
                <input type="button" btn-id="${id}" class="btn btn-primary btn-impressao" btn-data="imprimir" value="imprimir" />
                <input type="button" btn-id="${id}" class="btn btn-primary btn-impressao" btn-data="cozinha" value="cozinha" />                        
                <input type="button" btn-id="${id}" class="btn btn-primary btn-impressao" btn-data="imprimir" value="motoboy" />                        
            </div>
        `;

        if(status != "")
        {
            getLoadDiv();
           var r = $.get('/admin/order/status/update/' + id + '/' + status_id, function(response){

                if(response == 1)
                {

                    if(status == 'ag') {
                        
                        $("div[p=" + id + "]").css('background-color', '#00c0ef');

                        $("span[p=" + id + "] p").text('Agendado');

                    }
                    else if(status == 'pe') {
                        
                        $("div[p=" + id + "]").css('background-color', '#FF8B32');
                        $("span[p=" + id + "] p").text('Pendente');
                   
                    }
                    else if(status == 'ep' || status == 'ep1') {
                        
                        $("div[p=" + id + "]").css('background-color', '#605ca8');
                        $("span[p=" + id + "] p").text('Em preparo');
                    
                    }
                    else if(status == 'et') {
                        
                        $("div[p=" + id + "]").css('background-color', '#F2C335');
                        $("span[p=" + id + "] p").text('Em Entrega');
                  
                    }
                    else if(status == 'co') {
                        
                        $("div[p=" + id + "]").css('background-color', '#2F922F');
                        $("span[p=" + id + "] p").text('Concluído');

                    }
                    else {
                        
                        $("div[p=" + id + "]").css('background-color', '#B63A3A');
                        $("span[p=" + id + "] p").text('Cancelado');

                    }

                    if(status == 'ep1') {
                        
                        $(html).insertBefore('div[p="' + id + '"] h3#id');

                    }
                   
                }
                else 
                {

                    alert('Não foi possível atualizar o status, tente novamente mais tarde.');

                }
                
                removeLoadDiv();
            })
        }
    };

    function getStatus(id) {
        
        html = `
        @foreach($status as $stat)
            @if($stat->status_name == 'Agendado')

                @elseif($stat->status_name == 'Em preparo')

                    <input p="${id}" btn-id="{{ $stat->id }}" btn-data="ep" type="button" style="background-color: #605ca8;" value="Em preparo" class="order-status">

                @elseif($stat->status_name == 'Em entrega')

                    <input p="${id}" btn-id="{{ $stat->id }}" btn-data="et" type="button" style="background-color: #F2C335;" value="Em entrega" class="order-status">                                

                @elseif($stat->status_name == 'Concluído')

                    <input p="${id}" btn-id="{{ $stat->id }}" btn-data="co" type="button" style="background-color: #2F922F;" value="Concluído" class="order-status">

                @elseif($stat->status_name == 'Cancelado')

                    <input p="${id}" btn-id="{{ $stat->id }}" btn-data="ca" type="button" style="background-color: #B63A3A;" value="Cancelado" class="order-status">
            @endif
        @endforeach
        `;
        
        return html
    }

    $(document.body).on('click', '.order-status', function() {
        var id        = $(this).attr('p');

        var status_id = $(this).attr('btn-id');

        var status    = $(this).attr('btn-data');

        var html      = `<div p="${ id }" class="order-card">`;
        
        html         += $('.order-card[p="' + id + '"]').html();
        
        $('.order-card[p="' + id + '"]').remove();

        moveOrderDiv(html, status);
        
        updateStatus(id, status_id, status);
    });
       
    </script>
    <script type="text/javascript">

    function moveOrderDiv(html, status) {
        html   += `</div>`;
        var num = 0;
        var s   = "";

        if(status == 'ep' || status == 'ep1'){
           
            s = 'pendente';
            
        }
        else if(status == 'et'){
            
            s = 'entrega'

        }
        else if(status == 'co'){

            s = 'concluido';

        }
        else{
            
            s = 'cancelado';
        
        }
        
        $('#' + s + ' .order-card').each(function(){
            num++;
        });
        
        if(status == 'ep' || status == 'ep1') {
            
            if(num !== 0){
                
                $(html).insertBefore('#preparo .order-card:first');

            }   
            else{
                
                $('#preparo').append(html);
                
            }        
        
        }
        else if(status == 'et') {
            
            if(num !== 0){

                $(html).insertBefore('#entrega .order-card:first');

            }
            else{

                $('#entrega').append(html);

            }
        
        }
        else if(status == 'co') {
            
            if(num !== 0){
                
                $(html).insertBefore('#concluido .order-card:first');
                
            }
            else {

                $('#concluido').append(html);

            }

        }
        else {
            
            if(num !== 0){
                
                $(html).insertBefore('#cancelado .order-card:first');
                
            }
            else{

                $('#cancelado').append(html)

            }

        }

    }

        $(document.body).on('click', '#captar-pedido', function(){
            var id        = $(this).attr('p');

            var status_id = $(this).attr('btn-id');

            var status    = "ep1";

            var url       = '/admin/order/print/' + id + "?type=cozinha";
            
            var resp      = updateStatus(id, status_id, status);

            var html      = "";

            window.open(url, '_blank');

            $(this).remove();
            
            html = `<span class="status-buttons">
                        <h3 style="display:flex; justify-content: center; align-items: center;">Status</h3>`;

            html += getStatus(id);

            $("div[p=" + id + "]").append(html);

            var html      = `<div p="${ id }" class="order-card">`;
        
            html         += $('.order-card[p="' + id + '"]').html();
            
            $('.order-card[p="' + id + '"]').remove();

            moveOrderDiv(html, status);
        });

        $(document.body).on('click', '.btn-impressao', function(){
            var id   = $(this).attr('btn-id');
            var data = $(this).attr('btn-data');

            if(id.length && data.length != 0) {
            
                imprimir(id, data);
                $(this).css('background-color', '#337ab7');

            }
        });

    function imprimir(id, data) {
        var url = '/admin/order/print/' + id + '?type=' + data;
        window.open(url, '_blank');
    };

    </script>
    <script type="text/javascript">
    
    var listOrdersId = [];

    setInterval(function(){
        listOrdersId = [];
            $('.order-card').each(function(i){
                
                var id = parseInt($(this).attr('p'));
                listOrdersId.push(id);
                
            });
            console.log(Math.max.apply(null, listOrdersId));
            getNewOrders(Math.max.apply(null, listOrdersId));

    }, 60000);

        function getNewOrders(id_produto){
            $.ajax({
                url: "/admin/orders/get-new-orders/order/" + id_produto,
                dataType: "JSON",
                success: function(response){
                    if(response.length !== 0) {
                        
                        appendNewOrder(response, id_produto);
                        $.playSound(<?php echo '"/mp3/order-notification.mp3"'; ?>);

                    }
                },
                error: function(response){
                    console.log(response.responseText);
                }
            })
        };

        function appendNewOrder(order, id){
            var html = "";

            for(i = 0; i < order.length; i++) {
            html     += 
            `
            <div p="${ order[i].id }" style="background-color: #FF8B32; box-shadow: 5px 5px 10px 1px rgba(0,0,0,0.2); " class="order-card">
                        <a href="/admin/order/show/${ order[i].id }">
                            <h3 id="id">#<strong> ${ order[i].id } </strong> ${ order[i].get_client.nome }</h3>
                        </a>
                        <span>
                            Observação do pedido:
                       
                        </span>
                        <span>

                            Loja:
                            <p>${ order[i].get_loja.nome_loja }</p>

                        </span>
                        <span>

                            Endereço:
                            <p>${ order[i].order_street + "," + order[i].order_number + "-" + order[i].order_neighborhood + " - " + order[i].order_city }</p>

                        </span>
                        <span>

                            Total de produtos:
                            <p>${ order[i].order_prod_qtd }</p>

                        </span>
                        <span>

                            Taxa de entrega:
                            <p>R$ ${ order[i].order_tax_rate }</p>

                        </span>
                        <span>

                            Total do pedido:
                            <p>R$ ${ order[i].order_total + order[i].order_tax_rate }</p>

                        </span>
                        <span p="${ order[i].id }">

                            Status:
                            <p>${ order[i].get_status.status_name } </p>

                        </span>
                        <span>

                            Forma de Pagamento:
                            <p>${ order[i].get_payment_method.name_method }</p>

                        </span>
                        <span>

                            Observação de Pagamento:
                            `; 

                            if(order[i].order_obs_payment) {
                               
                                html += `<p>${ order[i].order_obs_payment }</p>`;
                            
                            } else {
                                
                                html += `<p>-</p>`;

                            }
                            

                        html += `</span>
                            <span>

                                <input p="${ order[i].id }" btn-id="${ order[i].get_status.id }" id="captar-pedido" type="button" value="Captar Pedido" />                            
                        
                            </span>
                    </div>
                </div>
            </div>

            `;

            }

            var t = 0;

            $('#pendente .order-card').each(function(i){

                t++;     

            });

            if(t !== 0 ) {
                
                $(html).insertBefore('#pendente .order-card[p="'+ id +'"]');

            }else {

                $('#pendente').append(html);

            }

        }

        (function ($) {
        $.extend({
        playSound: function () {
            return $(
                   '<audio class="sound-player" autoplay="autoplay" style="display:none;">'
                     + '<source src="' + arguments[0] + '" />'
                     + '<embed src="' + arguments[0] + '" hidden="true" autostart="true" loop="false"/>'
                   + '</audio>'
                 ).appendTo('body');
        },
        stopSound: function () {
            $(".sound-player").remove();
        }
    });
})(jQuery);

    </script>

@endsection