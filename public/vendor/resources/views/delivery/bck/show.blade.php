@extends('layouts.tubarao-delivery')

@section('content')
<div class="container">
	<div class="order clearfix">
		<!-- <div class="steps">
			<ul class="clearfix">
				<li class="steps__item steps__item--active" id="step__login">
					<span class="steps__label">Identificação</span>
				</li>

				<li class="steps__item steps__item--active" id="step__finalize">
					<span class="steps__label">Pagamento e Endereço</span>
				</li>
				@if($order->First()->status_name == "Pendente" || $order->First()->status_name == "Agendado")
				<li class="steps__item steps__item--alert" id="step__confirm">
					<span class="steps__label">Confirmação</span>
				</li>
					@else
					<li class="steps__item steps__item--active" id="step__confirm">
						<span class="steps__label">Confirmação</span>
					</li>	
				@endif
			</ul>
		</div> -->
		
		<!-- @if($order->First()->status_name == 'Pendente')
		<div class="order__status" id="order-status-pending">
			<p>Aguardando 
				<span style="color:#FF8B32;">confirmação</span> do restaurante
			</p>
		</div>
		@endif

		@if($order->First()->status_name == 'Em preparo')
		<div class="order__status" id="order-status-prepare">
			<p>Eba! Seu pedido está sendo 
				<span style="color:#605ca8;">preparado</span>
			</p>
		</div>
		@endif  

		@if($order->First()->status_name == 'Em entrega')
		<div class="order__status" id="order-status-caminho">
			<p>Seu pedido está a 
				<span style="color:#F2C335;">caminho</span>
			</p>
		</div>
		@endif

		@if($order->First()->status_name == 'Concluído')
		<div class="order__status" id="order-status-delivered">
			<p>Seu pedido foi 
				<span style="color:#2F922F;">entregue</span>
			</p>
		</div>
		@endif

		@if($order->First()->status_name == 'Cancelado')
		<div class="order__status" id="order-status-cancel">
			<p>Pedido 
				<span style="color:#B63A3A;">cancelado</span>
			</p>
		</div>
		@endif

		@if($order->First()->status_name == 'Agendado')
		<div class="order__status" id="order-status-schedule">
			<p>Pedido <span style="color:#00c0ef;">agendado</span> para 
				<span id="order-schedule-date"><?php echo date_format(new Datetime($order->First()->order_dev_date), 'd/m/Y') ?> às</span>
				<span id="order-schedule-hour"><?php echo date_format(new Datetime($order->First()->order_dev_time), 'H:i') ?></span>
			</p>
		</div>
		@endif -->
		
		<div class="order__info">


			<h2>PEDIDO <span id="order"># {{ $order->First()->id }}</span></h2>
			
			<div class="pedido__form clearfix">
				<div class="pedido ">
				<div class="pedido__lista">
				<div class="titulo clearfix">
					<span>Qtd.</span>
					<span>Produto</span>
					<span>Total R$</span>
				</div>
					<div class="item clearfix">

						@foreach($products as $product)
						
							<?php $totalProd = 0; ?>
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
												<?php $totalProd += $prod->price_comp; ?>
											@endif

											@endforeach
										@endif
									</span>
									<span>{{ number_format($product->order_product_total, 2, ",", ".") }}</span>
									@if($product->getOrderProducts()->First()->product_type == \App\Product::PROD_VARIABLE)
											@foreach($variableProds as $prod)
												@if($prod->order_product_id == $product->id)
												<div class="itens__compl-price">

													{{ number_format($prod->price_comp, 2, ",", ".") }}

												</div>
												@endif
											@endforeach
										@endif
								</div>
							
						@endforeach
					</div>
					<div class="valores" style="background-color: #f1f1f1;">
						<div class="clearfix">
							<span>Sub-Total:</span> 
							<span>
								R$ {{ number_format($order->First()->order_total, 2, ",", ".") }}
							</span>
						</div>
						<div class="clearfix">
							<span>Taxa de entrega:</span>
							<span>R$ {{ number_format($order->First()->order_tax_rate, 2, ",", ".") }}</span>
						</div>
					</div>
					<div class="valores clearfix">
						<span>Tempo de entrega estimado</span>
						<span>60min</span>
					</div>
					<div class="comprar">
						<div class="obs">
							<span>Obs:</span>
							<span></span>
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

		<hr>
		
		<div class="pedido__dados">
			<h3>Dados de Cadastro:</h3>
			<p>{{ $order->First()->nome }}</p>
			<p>{{ $order->First()->order_street . " - ". $order->First()->order_neighborhood . " - " . $order->First()->order_city }}</p>
			<h3>Forma de Pagamento:</h3>
			<p>{{ $order->First()->name_method }}</p>
		</div>

		</div>
		</div>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script src="https://js.pusher.com/4.3/pusher.min.js"></script>

<script>

// Enable pusher logging - don't include this in production
Pusher.logToConsole = false;

var pusher = new Pusher('b88b3e9717d2c9900dc8', {
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
				
				html = `
				<div class="order__status" id="order-status-prepare">
					<p>Eba! Seu pedido está sendo 
						<span style="color:#605ca8;">preparado</span>
					</p>
				</div>`;

			}
			else if(response.order_status == "Em entrega") {

				html = `
				<div class="order__status" id="order-status-caminho">
					<p>Seu pedido está a 
						<span style="color:#F2C335;">caminho</span>
					</p>
				</div>`;

			}
			else if(response.order_status == "Concluído") {

				html = `
				<div class="order__status" id="order-status-delivered">
					<p>Seu pedido foi 
						<span style="color:#2F922F;">entregue</span>
					</p>
				</div>`;

			}
			else if(response.order_status == "Cancelado") {
				html = `
				<div class="order__status" id="order-status-cancel">
					<p>Pedido 
						<span style="color:#B63A3A;">cancelado</span>
					</p>
				</div>
				`;
			}

			$(html).insertAfter('.steps');
		}
		
	}
                
</script>
@endsection