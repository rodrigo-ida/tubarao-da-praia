@extends('layouts.acepg')

@section('content')
	<div class="external-container">
		<h1 class="first">Parceria Exclusiva do Tubarão da Praia com ACEPG</h1>
		<h1>cupons de descontos exclusivos, Pegue <span>grátis</span> e economize!</h1>
		<form action="{{ route('verificar.cadastro') }}" class="email clearfix" method="post">

			{!! Form::hidden('origem', 'ACEPG') !!}

			{{ csrf_field() }}
			<input type="email" class="col col_9" placeholder="Digite seu e-mail para gerar seu cupom" name="email" id="email" required autofocus/>
			<button class="ativo col col_3">Ganhar Descontos!</button>
			@if(isset($invalidLink) && $invalidLink)
				<div class="error-message">O link que você acessou não está mais disponível. Favor, insira seu email para receber um novo link.</div>
			@endif
		</form>
	</div>
@endsection

@section('footer-scripts')
	<script type="text/javascript">
        $("input[name='email']").on('focus', function () {
            $(this).addClass('purple-shadow');
            $('button').addClass('purple-shadow');
        })
        $("input[name='email']").focus();
	</script>
@endsection