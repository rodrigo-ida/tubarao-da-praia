@extends('layouts.tubarao-delivery-email')

@section('content')

    <div class="show-form" style="margin-bottom: 20px; background-color: #fff">
        @if($order->getStatus->status_name == 'Em preparo')
            <p class="first" style="color: #6d1357; font-size: 42px; font-weight: 200;">Eba {{ $order->getClient()->First()->nome }}, seu pedido está em preparo!</p>
        
            @elseif($order->getStatus->status_name == 'Em entrega')
            <p class="first" style="color: #6d1357; font-size: 42px; font-weight: 200;">{{ $order->getClient()->First()->nome }}, seu pedido acabou de sair para entrega!</p>
            
            @elseif($order->getStatus->status_name == 'Concluído')
            <p class="first" style="color: #6d1357; font-size: 42px; font-weight: 200;">{{ $order->getClient()->First()->nome }}, seu pedido foi entregue e finalizado, agradecemos sua prefêrencia!</p>
        
            @elseif($order->getStatus->status_name == 'Cancelado')
            <p class="first" style="color: #6d1357; font-size: 42px; font-weight: 200;">Poxa {{ $order->getClient()->First()->nome }}, seu pedido foi cancelado, mas tudo bem, agradecemos sua preferência! :(</p>
       
            @endif
        
        @if($order->getStatus->status_name == 'Concluído')
            <p>Faça uma avaliação de nossos serviços, é rapidinho. Clique abaixo. :)</p>
            
           

        

       @if($order->order_loja_id == '1')
        
       <?php  $urlavaliacao = "https://www.facebook.com/tubaraodapraiboqueirao/reviews/"; ?>

        @elseif($order->order_loja_id == '3')

       <?php  $urlavaliacao = "https://www.facebook.com/tubaraodapraiavilatupi/reviews/"; ?>

        @elseif($order->order_loja_id == '4')

       <?php  $urlavaliacao = "https://www.facebook.com/tubaraodapraiasaovicente/reviews/"; ?>
        
       @endif

            <a href="{{$urlavaliacao}}" style="background-color: #0275d8!important; color: #fff; border: 1px solid #5bc0de!important; padding: 20px; border-radius: 4px;" > Fazer Avaliação </a>
            
            <!-- 
            <a href="https://pedidos.tubaraodapraia.com.br/delivery/avaliacao/ $ava->First()->token }}">Fazer Avaliação</a>-->
        @endif
        
        @if($order->getStatus->status_name == 'Cancelado')
            <p style="color: #6d1357; font-size: 30px;">Gostaria de fazer um novo pedido? Clique abaixo!</p>
            <a href="https://pedidos.tubaraodapraia.com.br/delivery" style="background-color: #0275d8!important; color: #fff; border: 1px solid #5bc0de!important; padding: 20px; border-radius: 4px;">
                Fazer Pedido
            </a>   
        @elseif($order->getStatus->status_name != 'Concluído'&& $order->getStatus->status_name != 'Cancelado')
            <p style="color: #6d1357; font-size: 30px;">Gostaria de acompanhar seu pedido? Clique abaixo!</p>
            <a href="https://pedidos.tubaraodapraia.com.br/client/area-do-cliente/ultimo-pedido" style="background-color: #0275d8!important; color: #fff; border: 1px solid #5bc0de!important; padding: 20px; border-radius: 4px;">

                Acompanhar Pedido

            </a>   
        @endif


    </div>

@endsection