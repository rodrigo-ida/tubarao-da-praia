@extends('layouts.tubarao-delivery')

@section('content')

@include('admin.helpers._messages')

@if(isset($dataOrder))

{{ header('Location: /delivery') }}

@endif
<a href="https://api.whatsapp.com/send?phone=55{{ str_replace('(','', str_replace(')', '', str_replace('-', '', str_replace(' ', '', $loja->First()->whatsapp_loja)))) }}&text=Olá! Me chamo {{ $order->First()->nome }} e realizei o pedido de número #{{ $order->First()->id }}. Gostaria de saber o status do meu pedido." target="_BLANK">
  <div class="whatsapp"></div>
</a>
<div class="container">
  <div class="order clearfix">
    <!-- <div class="steps">
        <ul class="clearfix">
          <li class="steps__item" id="step__login">
              <span class="steps__label">Identificação</span>
          </li>
          <li class="steps__item steps__item--active" id="step__finalize">
              <span class="steps__label">Pagamento e Endereço</span>
          </li>
          <li class="steps__item steps__item--alert" id="step__confirm">
              <span class="steps__label">Confirmação</span>
          </li>
        </ul>
    </div> -->
    <div class="col-60">
        <div class="status-pedido">
          <h2>Status do Pedido<span id="order"></span></h2>
          @if($order->First()->status_name == 'Agendado')
          <div id="step-4" class="ativo pedido-agendado"><span></span>
            Seu pedido foi agendado para o dia
            <span id="order-schedule-date"><?php echo date_format(new Datetime($order->First()->order_dev_date), 'd/m/Y') ?> às </span>
            <span id="order-schedule-hour"><?php echo date_format(new Datetime($order->First()->order_dev_time), 'H:i') ?></span>
				  </div>
            <!-- <div id="step-4" class="ativo"><span></span>Seu pedido foi agendado para dia </div> -->

            @elseif($order->First()->status_name == 'Cancelado')

            <div id="step-5" class="ativo pedido-cancelado"><span></span>
              Pedido cancelado.
              <span id="order-schedule-date"></span>
              <span id="order-schedule-hour"></span>
            </div>

            @elseif($order->First()->status_name == 'Concluído')

            <div id="step-6" class="ativo"><span></span>Seu pedido foi concluído</div>

            @else
            
            <div id="step-1" class="ativo"><span>1</span>Aguardando confirmação do restaurante.</div>
            <h3>* Seu pedido poderá levar até 10 minutos para ser confirmado.</h3>

            @if($order->First()->status_name == 'Em preparo' || $order->First()->status_name == 'Em entrega')

            <div id="step-2" class="ativo"><span>2</span>Eba! Seu pedido está sendo preparado.</div>

              @else

              <div id="step-2"><span>2</span>Eba! Seu pedido está sendo preparado.</div>

            @endif

            @if($order->First()->status_name == 'Em entrega')
            
            <div id="step-3" class="ativo"><span>3</span>Arrume a mesa! Seu pedido está a caminho.</div>
              
              @else

              <div id="step-3"><span>3</span>Arrume a mesa! Seu pedido está a caminho.</div>

            @endif
          @endif
        </div>
        <div class="pedido__dados">
          @if(isset($order->First()->cpf_nota) && $order->First()->cpf_nota != 'null')
          <p>CPF na nota: {{ $order->First()->cpf_nota }}</p>
          @endif
          <h3>Forma de Pagamento:</h3>
          <p>{{ $order->First()->name_method }}</p>
          @if(isset($order->First()->order_obs_payment))
          <p>Observação de pagamento: {{ $order->First()->order_obs_payment}}</p>
          @endif
          <h3>Dados da Loja:</h3>
          <p>Loja: {{ $loja->First()->nome_loja }}</p>
          <p>Telefone: {{ str_replace('.', '-', $loja->First()->telefone_loja) }}</p>
        </div>
    </div>
    <div class="col-40">
        <div class="order__info">
          <div class="pedido__form clearfix">
              <div class="pedido">
                <div class="pedido__lista">
                    <h2>PEDIDO #{{ $order->First()->id }} <span id="order"></span></h2>
                    <div class="titulo clearfix">
                      <span>Qtd.</span>
                      <span>Produto</span>
                      <span>Total R$</span>
                    </div>
                    <div class="item clearfix">
            @foreach($products as $product)
            
              
              <div class="itens clearfix">
                <span>{{ $product->order_product_qtd }}</span>
                <span>
                @if($product->getVariations()->count() > 0)
                  {{ $product->getVariations()->First()->prod_var_name }}
                  @else
                  {{ $product->getOrderProducts()->First()->name_product }}
                  
                @endif	
                  @if($product->getOrderProducts()->First()->product_type == \App\Product::PROD_COMPL)
                    @foreach($variableProds as $prod)

                    @if($prod->order_product_id == $product->id)
                    <div class="itens__compl">
                      {{ $prod->getComplement()->First()->name_complement }}
                    </div>

                      <?php //$totalProd += $prod->price_comp; ?>
                    @endif

                    @endforeach
                  @endif
                </span>
                <span>{{ number_format($product->order_product_total, 2, ",", ".") }}</span>
                @if($product->getOrderProducts()->First()->product_type == \App\Product::PROD_COMPL)
                    @foreach($variableProds as $prod)
                      @if($prod->order_product_id == $product->id)
                      <div class="itens__compl-price">

                        {{ number_format($prod->price_comp * $product->order_product_qtd, 2, ",", ".") }}

                      </div>
                      @endif
                    @endforeach
                  @endif
              </div>
          @endforeach
                    </div>
                    <div class="valores" style="background-color: #f9f9f9;">
                      <div class="clearfix">
                          <span>Sub-Total:</span> 
                          <span>R$ {{ number_format($order->First()->order_total, 2, ",", ".") }}</span>
                      </div>
                      <div class="clearfix">
                          <span>Taxa de entrega:</span>
                          <span>R$ {{ number_format($order->First()->order_tax_rate, 2, ",", ".") }}</span>
                      </div>
                    </div>
                    <div class="valores clearfix">
                      <span>Tempo de entrega estimado</span>
                      <span>

                        @if(date_format(new DateTime($tax->First()->order_shipping_time), "H") == '00')
            
                            {{ date_format(new DateTime($tax->First()->order_shipping_time), "i") }} min 
                          
                          @else

                            {{ date_format(new DateTime($tax->First()->order_shipping_time), "H") }} hora e {{ date_format(new DateTime($tax->First()->order_shipping_time), "i") }} min

                        @endif

                      </span>
                    </div>
                    <div class="comprar">
                      <div class="obs">
                          <span>Observação: </span>
                          <div style="padding: 10px;word-break:break-word;font-weight: 300;color:#5b5b5f;font-style: italic;">{{ $order->First()->order_obs }}</div>
                      </div>
                      <div class="clearfix total">
                          <span>
                          TOTAL
                          </span>
                          <span>
                            {{number_format($order->First()->order_tax_rate + $order->First()->order_total, 2, ",", ".")}}
                          </span>
                      </div>
                    </div>
                </div>
              </div>
          </div>
        </div>
    </div>
  </div>
</div>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="https://js.pusher.com/4.3/pusher.min.js"></script>

<script type="text/javascript">

  
  $('.pesquisa-pedido').remove();
  $('.pesquisa-produtos').remove();

</script>

<script>

  var pusher = new Pusher('723e0e5c3eb1c0ce1629', {
    cluster: 'us2',
    forceTLS: true
  });

  var channel = pusher.subscribe('my-channel');
  channel.bind('my-event', function(data) {
    newStatus(data);
  });

</script>

<script type="text/javascript">
	function newStatus(response){
		if(parseInt(response.order_id) == {{ $order->First()->id }}){
			
			if(response != "Pendente" && response != "Agendado") {
				
				$('.order__status').remove();

      }

      if(response.order_status == "Em preparo") {
        if($('#step-4').length == 1){
          $('#step-4').remove();
        var html = `<div id="step-1" class="ativo"><span>1</span>Aguardando confirmação do restaurante.</div>
        <div id="step-2" class="ativo"><span>2</span>Eba! Seu pedido está sendo preparado.</div>
        <div id="step-3"><span>3</span>Arrume a mesa! Seu pedido está a caminho.</div>`;
  
         $('.status-pedido').append(html);
         return;
        }
				
				$('#step-2').addClass('ativo');

			}
			else if(response.order_status == "Em preparo") {
				
				$('#step-2').addClass('ativo');

			}
			else if(response.order_status == "Em entrega") {

        $('#step-3').addClass('ativo');
        
      }
      else if(response.order_status == "Concluído") {
        $('#step-1').remove();
        $('#step-2').remove();
        $('#step-3').remove();
        $('#step-5').remove();

        $('.status-pedido').append('<div id="step-6" class="ativo"><span></span>Seu pedido foi concluído</div>');

      }
      else if(response.order_status == "Cancelado") {
        $('#step-1').remove();
        $('#step-2').remove();
        $('#step-3').remove();
        $('#step-6').remove();

        $('.status-pedido').append(`
            <div id="step-5" class="ativo pedido-cancelado"><span></span>
              Pedido cancelado.
              <span id="order-schedule-date"></span>
              <span id="order-schedule-hour"></span>
            </div>`);

      }

		}
		
  }
  
  $(document).ready(function(){
    localStorage.removeItem('agendamento_pedido');
    localStorage.removeItem('complementos');
    localStorage.removeItem('entrega');
    localStorage.removeItem('loja_id');
    localStorage.removeItem('obs');
    localStorage.removeItem('prods');
  });
                
</script>

@endsection