@extends('layouts.tubarao-delivery')

@section('content')

<div class="user__container clearfix">

	<div class="user__aside">
		<aside>
			<nav>
				<a href="{{ route('clientes.address') }}">ALTERAR ENDEREÇO</a>
				<a class="ativo" href="{{ route('clientes.userdata') }}">MEUS DADOS</a>
				<a href="{{ route('clientes.order') }}">ACOMPANHAR PEDIDO</a>
				<a href="{{ route('clientes.orders') }}">HISTÓRICO DE PEDIDOS</a>
			</nav>
		</aside>
	</div>

	<div class="user__block">

		<div class="user__dados">

		@if(Session::get('error'))
		
			<div class="alert alert-error"> {{ Session::get('error') }} </div>
	
			@elseif(Session::get('success'))
		
				<div class="alert alert-success"> {{ Session::get('success') }} </div>

		@endif

		<h2>Meus Dados</h2>

		<form method="post" action="{{ route('clientes.atualizardados') }}" class="dados__form clearfix">
		{{ csrf_field() }}
		
		<label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
			Nome<span>*</span>
			<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="sobrenome" value="@if(isset($user->nome)) {{ $user->nome }} @endif" class="form" type="text" disabled>		</label>

		<label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
			Sobrenome<span>*</span>
			<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="sobrenome" value="@if(isset($user->sobrenome)) {{ $user->sobrenome }} @endif" class="form" type="text" disabled>		</label>

		<label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
			Data de Nascimento<span>*</span>
			<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="data" value="@if(isset($user->data_nasc)) {{ $user->data_nasc }} @endif" class="form" type="text" disabled>		</label>

		<label class="form-g2 form-label" style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 50%;">
			Whatsapp<span>*</span>
				<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" value="@if(isset($user->whatsapp)) {{ $user->whatsapp }} @endif" name="whatsapp" class="form" type="text">
			</label>
			<label class="form-label">
			Email<span>*</span>
				<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="email" value="@if(isset($user->email)) {{ $user->email }} @endif" class="form" type="email">
			<p style="display: none;" class='msg'>Por favor, informe um email válido.</p>
			</label>
			<label class="form-label">
			Senha<span></span>
				<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="password" value="" class="form" type="password">
			</label>
			<label style="width: 100%;">
				<input class="form-btn" style="margin-top: 10px;" type="button" value="Atualizar">
			</label>
		</form>

		</div>

	</div>

</div>

<script src="{{ asset('/js/jquery.mask.min.js') }}"></script>

<script>
	$(document).ready(function() {
		$('input[name="whatsapp"]').mask('(00) 00000-0000');

		function validateEmail(email) {

			var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if (!filter.test(email)) {

				$('input[name="email"]').css('border-color', 'red');
			
				$(".msg").show();
			
				return false;
			
			}

			$('input[name="email"]').css('border-color', 'green');

			$('.msg').hide();

			return true;
		}

		$('input[name="email"]').focusout(function(){
			validateEmail($(this).val());
		});

		$(document).on('click', '.form-btn', function(){
			
			if($('input[name="whatsapp"]').val().length == 15 && validateEmail($('input[name="email"]').val())) {
				$('.dados__form').submit();			
				return;
			}

			alert('Por favor, preencha os dados obrigatórios corretamente.');
	
		});
		
	});
</script>
    
@endsection