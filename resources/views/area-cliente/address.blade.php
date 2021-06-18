@extends('layouts.tubarao-delivery')

@section('content')

<div class="user__container clearfix">

	<div class="user__aside">
		<aside>
			<nav>
				<a class="ativo" href="{{ route('clientes.address') }}">ALTERAR ENDEREÇO</a>
				<a href="{{ route('clientes.userdata') }}">MEUS DADOS</a>
				<a href="{{ route('clientes.order') }}">ACOMPANHAR PEDIDO</a>
				<a href="{{ route('clientes.orders') }}">HISTÓRICO DE PEDIDOS</a>
			</nav>
		</aside>
	</div>

	<div class="user__block">

		<div class="user__endereco">

		@if(Session::get('error'))
		
			<div class="alert alert-error"> {{ Session::get('error') }} </div>
	
			@elseif(Session::get('success'))
		
				<div class="alert alert-success"> {{ Session::get('success') }} </div>

		@endif
		<h2>Meu Endereço</h2>

		<form method="post" action="{{ route('clientes.atualizarendereco') }}" class="endereco__form clearfix">
			{{ csrf_field() }}
			<label>
				CEP<span>*</span>
				<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="cep" value="{{ $user->cep }}" max="9" class="form" type="text" required>
			</label>
			<label>
				Estado<span>*</span>
				<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="estado" value="{{ $user->estado }}" class="form" type="text" readonly required>
			</label>
			<label>
				Bairro<span>*</span>
				<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" value="{{ $user->bairro }}" name="bairro" class="form" type="text" readonly required>
			</label>
			<label>
				Cidade<span>*</span>
				<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="cidade" value="{{ $user->cidade }}" class="form" type="text" readonly required>
			</label>
			<label>
				Logradouro<span>*</span>
				<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="logradouro" value="{{ $user->logradouro }}" class="form" type="text" readonly required>
			</label>
			<label style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 25%;">
				Número<span>*</span>
				<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="numero" value="{{ $user->numero }}" class="form" type="text" required>
			</label>
			<label style="padding-left: 12px;padding-right: 12px;padding-top: 12px;display: block;font-size: 17px;color: #5b5b5f;float: left;width: 25%;">
				Compl.<span></span>
				<input style="border: solid 1px #cacaca;margin-top: 8px;padding: 8px;font-family: 'Oswald', sans-serif;display: block;width: 100%;box-sizing: border-box;border-radius: 10px;outline: none;" name="complemento" value="{{ $user->complemento }}" class="form" type="text">
			</label>
			<label style="width: 100%;">
				<input class="form-btn" style="margin-top: 10px;" type="submit" value="Atualizar">
			</label>
		</form>

		</div>

	</div>

</div>

<script src="{{ asset('/js/jquery.mask.min.js') }}"></script>

<script>

	function getLocation(cep) {

    $.ajax({
        url: "https://viacep.com.br/ws/" + cep + "/json/",
        type: 'GET',
        datatype: 'JSON',
			success: function (response) {

				$('input[name="estado"]').val(response.uf);
				$('input[name="cidade"]').val(response.localidade);
				$('input[name="bairro"]').val(response.bairro);
				$('input[name="logradouro"]').val(response.logradouro);
				
			},
			error: function (response) {
				alert("esse cep não existe");
			}
    	});
	}

	$('input[name="cep"]').keyup(function(){

		if($(this).val().length == 9) {
			getLocation($(this).val().replace('-', ''));
			return;
		}

	});

	$('input[name="cep"]').mask('00000-000');

</script>
@endsection