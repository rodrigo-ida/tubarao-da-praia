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


                Aqui começa os S Status
                @if(!$orders->isEmpty())
                <div class="order-list-card">

                <!-- div card agendado -->
                    <div class="div-cards">
                    <h3>Agendado</h3>

                    <!--Começo do card-->
                    <div class="scroll-div">
                    @foreach($orders as $order)
                    
                        @if(isset($order->getStatus->status_name) && $order->getStatus->status_name == 'Agendado')

                        <div p="{{ $order->id }}" style="background-color: #00c0ef;" class="order-card">
                        <a href="/admin/order/show/{{ $order->id }}">
                            <h3 id="id">#<strong> {{ $order->id }} </strong> 
                            
                                @if($order->userIsAdmin())
                                
                                    {{ $order->order_client_name }}

                                    @else

                                    {{ $order->getClient()->First()->nome }}
                                    
                                @endif
                            </h3>
                        </a>
                        <span>
                            Loja para Entregar:
                            <p>{{$order->getLoja()->First()->nome_loja}}</p>
                       
                       
                        </span>
                        <span>
                            Data/Hora do Pedido:
                            <p>{{ date_format($order->created_at, 'd/m/Y H:i:s') }}</p>

                        </span>
                        <span>
                            Data/Hora do Agendamento:
<p> @if( $order->order_dev_date != '2000-01-01 00:00:00' ) {{ date_format($order->order_dev_date, 'd/m/Y')."  ".$order->order_dev_time}}</p>
                            <p> @else {{ 'Sem Agendamento '}}@endif</p>
                        </span>
                         <hr>
                        
                        <span>
                            <strong>Nome do Cliente </strong>
                           <p>  {{ $order->order_client_name }}</p>
                            

                        </span>
                        <span>

                            Whatsapp:
                            <p>@if($order->userIsAdmin()) {{$order->getClient()->First()->whatsapp }} @else{{ $order->getClient()->First()->whatsapp }} @endif <a href="https://api.whatsapp.com/send?phone=55{{$order->getClient()->First()->whatsapp }}&text=">Falar com cliente</a></p></p>

                        </span>
                         <span>

                            Endereço:
                            <p> 
                                CEP: {{ $order->getClient()->First()->cep }} <br>
                                End.: {{ $order->order_street . ", $order->order_number - " . $order->order_neighborhood }}<br>
                                Complemento: {{$order->order_complement}}
                                Cidade: {{$order->order_city}} <br>
                                Referência:  {{$order->order_reference}} <br>

                            </p>

                        </span>

                        <hr>


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
                        <span>
                            Observação do pedido:
                            @if(isset($order->order_obs))
                            
                                <p>{{ $order->order_obs }}</p>

                            @else

                                <p>-</p>

                            @endif
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
                    @if($order->cpf_nota != 'null' && !empty($order->cpf_nota))
                        <span>

                            CPF na nota:
                            @if(!empty($order->cpf_nota))
                            <p>{{ $order->cpf_nota }}</p>
                            @endif

                        </span>
                    @endif

                    <span p="{{ $order->id }}">

                            Status:
                            <p>{{ $order->getStatus->status_name }} </p>

                        </span>
                    
                    @if($order->getEredeTid() != null)
                        
                            <span>

                            Tid Erede:
                            <p>{{ $order->getEredeTid() }} - Aprovado</p>

                        </span>
                        @endif



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
                        @if(isset($order->getStatus->status_name) && $order->getStatus->status_name == 'Pendente')

                        <div p="{{ $order->id }}" style="background-color: #FF8B32;" class="order-card">
                        <a href="/admin/order/show/{{ $order->id }}">
                            <h3 id="id">#<strong> {{ $order->id }} </strong> 

                                @if($order->userIsAdmin())
                                
                                    {{ $order->order_client_name }}

                                    @else

                                    {{ $order->getClient()->First()->nome }}
                                    
                                @endif

                            </h3>
                        </a>

                         <span>
                            Loja para Entregar:
                            <p>{{$order->getLoja()->First()->nome_loja}}</p>
                       
                       
                        </span>
                        <span>
                            Data/Hora do Pedido:
                            <p>{{ date_format($order->created_at, 'd/m/Y H:i:s') }}</p>
                            

                        </span>
                        <span>
                            Data/Hora do Agendamento:
                            <p> @if( $order->order_dev_date != '2000-01-01 00:00:00' ) {{ date_format($order->order_dev_date, 'd/m/Y')."  ".$order->order_dev_time}}</p>
                            <p> @else {{ 'Sem Agendamento '}}@endif</p>
                        </span>
                         <hr>
                        
                        <span>
                            <strong>Nome do Cliente </strong>
                           <p>  {{ $order->order_client_name }}</p>
                            

                        </span>
                        <span>

                            Whatsapp:
                            <p>@if($order->userIsAdmin()) {{$order->getClient()->First()->whatsapp }} @else{{ $order->getClient()->First()->whatsapp }} @endif <a href="https://api.whatsapp.com/send?phone=55{{$order->getClient()->First()->whatsapp }}&text=">Falar com cliente</a></p></p>

                        </span>
                         <span>

                            Endereço:
                            <p> 
                                CEP: {{ $order->getClient()->First()->cep }} <br>
                                End.: {{ $order->order_street . ", $order->order_number - " . $order->order_neighborhood }}<br>
                                Complemento: {{$order->order_complement}}<br>
                                Cidade: {{$order->order_city}} <br>
                                Referência:  {{$order->order_reference}} <br>

                            </p>

                        </span>

                        <hr>


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
                        <span>
                            Observação do pedido:
                            @if(isset($order->order_obs))
                            
                                <p>{{ $order->order_obs }}</p>

                            @else

                                <p>-</p>

                            @endif
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
                    @if($order->cpf_nota != 'null' && !empty($order->cpf_nota))
                        <span>

                            CPF na nota:
                            @if(!empty($order->cpf_nota))
                            <p>{{ $order->cpf_nota }}</p>
                            @endif

                        </span>
                    @endif

                    <span p="{{ $order->id }}">

                            Status:
                            <p>{{ $order->getStatus->status_name }} </p>

                        </span>
                    
                    @if($order->getEredeTid() != null)
                        
                            <span>

                            Tid Erede:
                            <p>{{ $order->getEredeTid() }} - Aprovado</p>

                        </span>
                        @endif

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

                                    <input p="{{ $order->id }}" btn-id="{{ $stat->id }}" data-loja-id="{{ $order->order_loja_id }}" id="captar-pedido" type="button" value="Captar Pedido" />                            
                            
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
                        @if(isset($order->getStatus->status_name) && $order->getStatus->status_name == 'Em preparo')

                        <div p="{{ $order->id }}" style="background-color: #605ca8;" class="order-card">
                        <div class="clearfix">    
                            <input type="button" btn-id="{{ $order->id }}" class="btn btn-primary btn-impressao" btn-data="imprimir" value="imprimir" />
                            <input type="button" btn-id="{{ $order->id }}" class="btn btn-primary btn-impressao" btn-data="cozinha" value="cozinha" />                        
                            <input type="button" btn-id="{{ $order->id }}" class="btn btn-primary btn-impressao" btn-data="imprimir" value="motoboy" /> 
                        </div>
                            <a href="/admin/order/show/{{ $order->id }}" style="display: block;">
                            <h3 id="id">#<strong> {{ $order->id }} </strong> @if($order->userIsAdmin()) {{ $order->order_client_name }} @else {{ $order->getClient()->First()->nome }} @endif</h3>
                        </a>


                        <span>
                            Loja para Entregar:
                            <p>{{$order->getLoja()->First()->nome_loja}}</p>
                       
                       
                        </span>
                        <span>
                            Data/Hora do Pedido:
                            <p>{{ date_format($order->created_at, 'd/m/Y H:i:s') }}</p>

                        </span>
                        <span>
                            Data/Hora do Agendamento:
<p> @if( $order->order_dev_date != '2000-01-01 00:00:00' ) {{ date_format($order->order_dev_date, 'd/m/Y')."  ".$order->order_dev_time}}</p>
                            <p> @else {{ 'Sem Agendamento '}}@endif</p>
                        </span>
                         <hr>
                        
                        <span>
                            <strong>Nome do Cliente </strong>
                           <p>  {{ $order->order_client_name }}</p>
                            

                        </span>
                        <span>

                            Whatsapp:
                            <p>@if($order->userIsAdmin()) {{$order->getClient()->First()->whatsapp }} @else{{ $order->getClient()->First()->whatsapp }}   @endif <a href="https://api.whatsapp.com/send?phone=55{{$order->getClient()->First()->whatsapp }}&text=">Falar com cliente</a></p></p>

                        </span>
                         <span>

                            Endereço:
                            <p> 
                                CEP: {{ $order->getClient()->First()->cep }} <br>
                                End.: {{ $order->order_street . ", $order->order_number - " . $order->order_neighborhood }}<br>
                                Complemento: {{$order->order_complement}}<br>
                                Cidade: {{$order->order_city}} <br>
                                Referência:  {{$order->order_reference}} <br>

                            </p>

                        </span>

                        <hr>


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
                        <span>
                            Observação do pedido:
                            @if(isset($order->order_obs))
                            
                                <p>{{ $order->order_obs }}</p>

                            @else

                                <p>-</p>

                            @endif
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
                    @if($order->cpf_nota != 'null' && !empty($order->cpf_nota))
                        <span>

                            CPF na nota:
                            @if(!empty($order->cpf_nota))
                            <p>{{ $order->cpf_nota }}</p>
                            @endif

                        </span>
                    @endif

                    <span p="{{ $order->id }}">

                            Status:
                            <p>{{ $order->getStatus->status_name }} </p>

                        </span>
                    
                    @if($order->getEredeTid() != null)
                        
                            <span>

                            Tid Erede:
                            <p>{{ $order->getEredeTid() }} - Aprovado</p>

                        </span>
                        @endif


<hr>
                        <span>
                        Definir Entregador:
                        <p style="color: #000">
                            <select>
                                <option value="">Selecione o motoboy...</option>
                                @foreach(json_decode($entregadores) as $ent)
                                    @if($ent->loja_id === $order->getLoja()->First()->id)
                                        <option value="{{ $ent->id }}">{{ $ent->name }}</option>
                                    @endif
                                @endforeach
                            </select>   
                        </p>

                        </span>
                        <hr>
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

                                        <input p="{{ $order->id }}" btn-id="{{ $stat->id }}" btn-data="ep" type="button" style="background-color: #605ca8; margin:5px;" value="Em preparo" >

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
                        @if(isset($order->getStatus->status_name) && $order->getStatus->status_name == 'Em entrega')

                        <div p="{{ $order->id }}" style="background-color: #F2C335;" class="order-card">
                        <div class="clearfix">    
                            <input type="button" btn-id="{{ $order->id }}" class="btn btn-primary btn-impressao" btn-data="imprimir" value="imprimir" />
                            <input type="button" btn-id="{{ $order->id }}" class="btn btn-primary btn-impressao" btn-data="cozinha" value="cozinha" />                        
                            <input type="button" btn-id="{{ $order->id }}" class="btn btn-primary btn-impressao" btn-data="imprimir" value="motoboy" /> 
                        </div>
                        <a href="/admin/order/show/{{ $order->id }}">
                            <h3 id="id">#<strong> {{ $order->id }} </strong> @if($order->userIsAdmin()) {{ $order->order_client_name }} @else {{ $order->getClient()->First()->nome }} @endif</h3>
                        </a>


<span>
                            Loja para Entregar:
                            <p>{{$order->getLoja()->First()->nome_loja}}</p>
                       
                       
                        </span>
                        <span>
                            Data/Hora do Pedido:
                            <p>{{ date_format($order->created_at, 'd/m/Y H:i:s') }}</p>

                        </span>
                        <span>
                            Data/Hora do Agendamento:
                            <p> @if( $order->order_dev_date != '2000-01-01 00:00:00' ) {{ date_format($order->order_dev_date, 'd/m/Y')."  ".$order->order_dev_time}}</p>
                            <p> @else {{ 'Sem Agendamento '}}@endif</p>
                        </span>
                         <hr>
                        
                        <span>
                            <strong>Nome do Cliente </strong>
                           <p>  {{ $order->order_client_name }}</p>
                            

                        </span>
                        <span>

                            Whatsapp:
                            <p>@if($order->userIsAdmin()) {{$order->getClient()->First()->whatsapp }} @else{{ $order->getClient()->First()->whatsapp }} @endif <a href="https://api.whatsapp.com/send?phone=55{{$order->getClient()->First()->whatsapp }}&text=">Falar com cliente</a></p></p>

                        </span>
                         <span>

                            Endereço:
                            <p> 
                                CEP: {{ $order->getClient()->First()->cep }} <br>
                                End.: {{ $order->order_street . ", $order->order_number - " . $order->order_neighborhood }}<br>
                                Complemento: {{$order->order_complement}}<br>
                                Cidade: {{$order->order_city}} <br>
                                Referência:  {{$order->order_reference}} <br>

                            </p>

                        </span>

                        <hr>


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
                        <span>
                            Observação do pedido:
                            @if(isset($order->order_obs))
                            
                                <p>{{ $order->order_obs }}</p>

                            @else

                                <p>-</p>

                            @endif
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
                    @if($order->cpf_nota != 'null' && !empty($order->cpf_nota))
                        <span>

                            CPF na nota:
                            @if(!empty($order->cpf_nota))
                            <p>{{ $order->cpf_nota }}</p>
                            @endif

                        </span>
                    @endif

                    <span p="{{ $order->id }}">

                            Status:
                            <p>{{ $order->getStatus->status_name }} </p>

                        </span>
                    
                    @if($order->getEredeTid() != null)
                        
                            <span>

                            Tid Erede:
                            <p>{{ $order->getEredeTid() }} - Aprovado</p>

                        </span>
                        @endif


                        <hr>
                        
                       <!--<hr>
                        <span>
                        Definir Entregador:
                        <p style="color: #000">
                            <select>
                                <option value="">Selecione o motoboy...</option>
                                @foreach(json_decode($entregadores) as $ent)
                                    @if($ent->loja_id === $order->getLoja()->First()->id)
                                        <option value="{{ $ent->id }}">{{ $ent->name }}</option>
                                    @endif
                                @endforeach
                            </select>   
                        </p>

                        </span>
                        <hr>-->

<!--
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
                            <p>@if($order->userIsAdmin()) -- @else{{ $order->getClient()->First()->whatsapp }} @endif</p>

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

                        @if($order->cpf_nota != 'null' && !empty($order->cpf_nota))
                        <span>

                            CPF na nota:
                            @if(!empty($order->cpf_nota))
                            <p>{{ $order->cpf_nota }}</p>
                            @endif

                        </span>
                        @endif

                        @if($order->getEredeTid() != null)
                        
                            <span>

                            Tid Erede:
                            <p>{{ $order->getEredeTid() }} - Aprovado</p>

                        </span>
                        @endif
-->
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
                        @if(isset($order->getStatus->status_name) && $order->getStatus->status_name == 'Concluído')

                        <div p="{{ $order->id }}" style="background-color: #2F922F;" class="order-card">
                        <div class="clearfix">    
                            <input type="button" btn-id="{{ $order->id }}" class="btn btn-primary btn-impressao" btn-data="imprimir" value="imprimir" />
                            <input type="button" btn-id="{{ $order->id }}" class="btn btn-primary btn-impressao" btn-data="cozinha" value="cozinha" />                        
                            <input type="button" btn-id="{{ $order->id }}" class="btn btn-primary btn-impressao" btn-data="imprimir" value="motoboy" /> 
                        </div>
                        <a href="/admin/order/show/{{ $order->id }}">
                            <h3 id="id">#<strong> {{ $order->id }} </strong> @if($order->userIsAdmin()) {{ $order->order_client_name }} @else {{ $order->getClient()->First()->nome }} @endif</h3>
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
                            Data/Hora do Agendamento:
                           <p> @if( $order->order_dev_date != '2000-01-01 00:00:00' ) {{ date_format($order->order_dev_date, 'd/m/Y')."  ".$order->order_dev_time}}</p>
                            <p> @else {{ 'Sem Agendamento '}}@endif</p>
                        </span>
                        <span>

                            Loja:
                            <p>{{$order->getLoja()->First()->nome_loja }}</p>
                        
                        </span>
                        <span>

                            Whatsapp:
                            <p>@if($order->userIsAdmin()) -- @else{{ $order->getClient()->First()->whatsapp }} @endif <a href="https://api.whatsapp.com/send?phone=55{{$order->getClient()->First()->whatsapp }}&text=">Falar com cliente</a></p></p>

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

                        @if($order->cpf_nota != 'null' && !empty($order->cpf_nota))
                        <span>

                            CPF na nota:
                            @if(!empty($order->cpf_nota))
                            <p>{{ $order->cpf_nota }}</p>
                            @endif

                        </span>
                        @endif

                        @if($order->getEredeTid() != null)
                        
                            <span>

                            Tid Erede:
                            <p>{{ $order->getEredeTid() }} - Aprovado</p>

                        </span>
                        @endif

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
                            <h3 id="id">#<strong> {{ $order->id }} </strong> @if($order->userIsAdmin()) {{ $order->order_client_name }} @else {{ $order->getClient()->First()->nome }} @endif</h3>
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
                            Data/Hora do Agendamento:
                            <p> @if( $order->order_dev_date != '2000-01-01 00:00:00' ) {{ date_format($order->order_dev_date, 'd/m/Y')."  ".$order->order_dev_time}}</p>
                            <p> @else {{ 'Sem Agendamento '}}@endif</p>
                        </span>
                        <span>
                            Loja:
                            <p>{{$order->getLoja()->First()->nome_loja}}</p>
                        
                        </span>
                        <span>

                            Whatsapp:
                            <p>@if($order->userIsAdmin()) -- @else{{ $order->getClient()->First()->whatsapp }} @endif <a href="https://api.whatsapp.com/send?phone=55{{$order->getClient()->First()->whatsapp }}&text=">Falar com cliente</a></p></p>

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

                        @if($order->cpf_nota != 'null' && !empty($order->cpf_nota))
                        <span>

                            CPF na nota:
                            @if(!empty($order->cpf_nota))
                            <p>{{ $order->cpf_nota }}</p>
                            @endif

                        </span>
                        @endif

                        @if($order->getEredeTid() != null)
                        
                            <span>

                            Tid Erede:
                            <p>{{ $order->getEredeTid() }} - Aprovado</p>

                        </span>
                        @endif

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

    var entregadores = <?= $entregadores ?>;

    function getLoadDiv(){
        $('.loading').show();
    }

    function removeLoadDiv(){
        $('.loading').hide();
    }

    function updateStatus(id, status_id, status, ent, name = null) {
        
            var html = 
            `
                <div class="clearfix">
                    <input type="button" btn-id="${id}" class="btn btn-primary btn-impressao" btn-data="imprimir" value="imprimir" />
                    <input type="button" btn-id="${id}" class="btn btn-primary btn-impressao" btn-data="cozinha" value="cozinha" />                        
                    <input type="button" btn-id="${id}" class="btn btn-primary btn-impressao" btn-data="imprimir" value="motoboy" />                        
                </div>
            
            `;
        
        var url = '';

        if(status != "")
        {
            console.log(ent, name);

            getLoadDiv();

            if(status == 'et' || status == 'co' && ent != null)
            {
                url = '/admin/order/status/update/' + id + '/' + status_id + '/' + ent
            }
            else 
            {
                url = '/admin/order/status/update/' + id + '/' + status_id;
            }

            var r = $.get(url, function(response){

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
                        var input = $('div[p="' + id + '"].order-card span').last();
                        $(`<span>
                            Entregador: 
                                <p data-entregador-id="${ent}">${name}</p>
                            </span>`).insertBefore(input);
                  
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



        if(status == 'co' || status == 'et')
        {
            if(status == 'et')
            {
                var ent   = $('div[p="' + id + '"] select option:selected').val();
                var ent_name = $('div[p="' + id + '"] select option:selected').text();


                //var ent = $('.order-card[p="' + id + '"] span p[data-entregador-id]').attr('data-entregador-id');

                //var ent_name = $('.order-card[p="' + id + '"] span p[data-entregador-id="' + ent + '"').text();
            
            } else if(status == 'co') {

                var ent = $('.order-card[p="' + id + '"] span p[data-entregador-id]').attr('data-entregador-id');

                var ent_name = $('.order-card[p="' + id + '"] span p[data-entregador-id="' + ent + '"').text();
            } else{

                var entregadorId = $('.order-card[p="' + id + '"] span p[data-entregador-id]').attr('data-entregador-id');
            
            var nomeEntregador = $('div[p="' + id + '"] select option:selected').text();

            }

            

            localStorage.setItem("entregadorID", entregadorId);
            localStorage.setItem("nomeEntregador", nomeEntregador);
        
            if(!ent && !ent_name) {


                 var ent = $('.order-card[p="' + id + '"] span p[data-entregador-id]').attr('data-entregador-id');

                var ent_name = $('.order-card[p="' + id + '"] span p[data-entregador-id="' + ent + '"').text();


                //return alert('Selecione o motoboy para mudar o status do pedido ou mude o status para "em entrega"!');
            }
            $('.order-card[p="' + id + '"] span').last().prev().remove();
        }

        html += $('.order-card[p="' + id + '"]').html();
        
        $('.order-card[p="' + id + '"]').remove();

        moveOrderDiv(html, status);
        
        updateStatus(id, status_id, status, ent ? ent : null, ent_name ? ent_name : null);
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
    function getDeliveryMans(id) {

        //alert("chama getDeliveryMans ");
        var html = "<option value=''> Selecione o entregador... <option>";

        for(let ent of entregadores) {
            if(ent.loja_id === id)
            html += `<option value="${ent.id}"> ${ent.name} <option>`;
        }
        return html;
    }

        $(document.body).on('click', '#captar-pedido', function(){
            var id        = $(this).attr('p');

            var loja_id   = $(this).data('loja-id');

            var status_id = $(this).attr('btn-id');

            var status    = "ep1";

            var url       = '/admin/order/print/' + id + "?type=cozinha";
            
            var resp      = updateStatus(id, status_id, status);

            var html      = '';

            window.open(url, '_blank');

            $(this).remove();
            
            html = `
            <span>Definir Entregador:<p style="color: #000">
            <select>` + getDeliveryMans(loja_id) + `</select></p></span>
            <span class="status-buttons">
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

                                <input p="${ order[i].id }" btn-id="${ order[i].get_status.id }" data-loja-id="${ order[i].order_loja_id }" id="captar-pedido" type="button" value="Captar Pedido" />                            
                        
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
setInterval(function() {
   
     

       

        $.ajax({
            url: "https://pedidos.tubaraodapraia.com.br/admin/ajax-index-order",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
            }
        }).done(function(data) {
            console.log(data);
            //colocar a logica de replace do item acima
           
            console.log(data  > 0)
            if(data  > 0 ){
            
            snd.play();
            

            }
        });

            var snd = new Audio("data:audio/wav;base64,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qqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqkxBTUUzLjk5LjWqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqv/7ksQ5A8AAAaQAAAAgAAA0gAAABKqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqpMQU1FMy45OS41qqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqr/+5LEOQPAAAGkAAAAIAAANIAAAASqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqqq");  
   
}, 10000);

    </script>

@endsection