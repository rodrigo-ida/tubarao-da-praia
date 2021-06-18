@extends('layouts.tubarao')

@section('head-styles')
    <style>
    </style>
@append

@section('content')
    @include('components.loading-layer')
    <div id="main-container" class="external-container">

        @if (isset($errors) && !$errors->isEmpty())
            <div class="alert alert-danger">
                @foreach($errors->getMessages() as $key => $value)
                    @if ($key == 'limite_excedido')
                        {{ 'O novo cupom não foi gerado pois o limite de cupons para esta oferta já foi utilizado' }}
                    @else
                        {{ $value[0] }}
                    @endif
                @endforeach
            </div>
        @endif

        <div id="col1" class="col col_6 show-form">
            <div class="mensagem alternativa">
                <p><span class="titulo">{{ $titulo }}</span></p>
                <p><span>{{ $descricao }}</span></p>
            </div>
            <div class="banner">
                <img src="{{ $offer->getImageURL() != null ? $offer->getImageURL() : asset("/img/tubarao-gray.png") }}" />
            </div>
            @if(!is_null($offer->expires_at))
                <div class="expires-at">
                    * oferta válida até {{ Carbon\Carbon::parse($offer->expires_at)->format('d/m/Y') }}
                </div>
            @endif
        </div>
        <div class="col col_6 show-form">
            @if ($cupons->count() <= 0)
                <div class="alert alert-info text-left"><i class="glyphicon glyphicon-info-sign"></i> Ainda não foram gerados cupons para esta oferta.</div>
            @else
                <h1 class="first">Estes são os seus cupons gerados</h1>
                <h2 class="alternative-title subtitle">Clique no cupom para mais detalhes</h2>

                <ul style="margin: 20px 0">
                    @foreach($cupons as $cupon)
                        <li class="coupom-box js-select-token" data-selected-token="{{ $cupon->id }}" >
                            {{ $cupon->validation_token }}
                        </li>
                    @endforeach
                </ul>
            @endif

            @if($limite == 0 || ($limite != 0 && $cuponsUtilizados < $limite))
                <div class="botao-gerar-cupom-container">
                    {{ Form::open(['route' => 'selecionar.cupons', 'style' => 'width: auto;', 'class' => 'js-form-gerar-cupom']) }}
                    {{ Form::hidden('offer', $offer->id) }}
                    {{ Form::submit($cuponsUtilizados == 0 ? 'Gerar cupom' : 'Gerar novo cupom', ['class' => 'ativo', 'id' => 'js-btn-gerar-cupom']) }}
                    {{ Form::close() }}
                </div>
            @endif

            @if($limite > 0)
                <div class="row parafraph" style="margin-top: 10px">
                    <p>Limite de cupons para esta oferta: {{ $limite }}</p>
                </div>
            @endif

            <a href="{{ route('visualizar.cupons') }}" class="cupom-link btn btn-default"><span class="glyphicon glyphicon-tag"></span> Ver outros cupons</a>
        </div>
        <div style="clear: both"></div>
    </div>

    <div id="myModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Selecione uma das opções abaixo</h4>
                </div>
                <div class="modal-footer js-modal-coupon-buttons-container">
                    {{ Form::open(['route' => 'selecionar.cupons', 'class' => 'form-coupon-modal']) }}
                    {{ Form::hidden('cupom_id', null, ['class' => 'js-cupom-id']) }}
                    {!! Form::button('<span class="glyphicon glyphicon-search"></span> Visualizar cupom', ['class' => 'btn btn-primary', 'type' => 'submit']) !!}
                    {{ Form::close() }}
                    <button id="print" type="button" class="btn btn-primary col1"><span class="glyphicon glyphicon-print"></span> Imprimir</button>
                    {{ Form::open(['id' => 'form-send-mail', 'class' => 'form-coupon-modal']) }}
                    {{ Form::hidden('cupom_utilizado', null, ['class' => 'js-cupom-id']) }}
                    {!! Form::button('<span class="glyphicon glyphicon-envelope"></span> Enviar por E-mail', ['class' => 'btn btn-primary', 'id' => 'sendEmail']) !!}
                    {{ Form::close() }}
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection

@section('footer-scripts')
    <script type="text/javascript">
        var wasSubmitted = false;
        $('.js-select-token').on('click', function () {
            $('#frame_cupom').remove();
           var token_id = $(this).data('selected-token');
           $('.js-cupom-id').val(token_id);
           $('#myModal').modal('show');

            var cssLink = document.createElement("link");
            cssLink.href = "{{  mix('/css/style.css') }}";
            cssLink.rel = "stylesheet";
            cssLink.type = "text/css";

           var frame_cupom = document.createElement('iframe');
           frame_cupom.setAttribute('id', 'frame_cupom');
           frame_cupom.appendChild(cssLink);
           frame_cupom.src = '{{ route('imprimir.cupons') }}' + "?cupom_id=" + token_id;
           frame_cupom.style = 'display: none';
           document.body.appendChild(frame_cupom);
        });
        $('.js-form-gerar-cupom').on('submit', function (evt) {
            if (!wasSubmitted) {
                wasSubmitted = true;
                $('js-btn-gerar-cupom').attr('disabled','disabled');
                $.loadingLayer('show');
                return true;
            }
            evt.preventDefault();
            return false;
        });
        $('#sendEmail').on('click', function (){
            $.post('{{ route('enviar.email.ajax') }}', $('#form-send-mail').serialize());
            $('#myModal').modal('hide');
            $('#erro-message').remove();
            $('#main-container').prepend("<div id='erro-message' class='external-container' style='clear: both; padding-top: 20px'><div class='alart alert-info' style='padding: 10px; margin-bottom: 10px; font-family: \"Roboto Mono\"'>Email enviado com sucesso!</div></div>");
        });
        $('#print').on('click', function (){
            var teste = document.getElementById('frame_cupom').contentWindow;
            teste.print();
            $('#myModal').modal('hide');
        });
    </script>
@append