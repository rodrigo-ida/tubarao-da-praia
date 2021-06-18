@extends('layouts.tubarao')

@section('head-styles')
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/bootstrap.custom.css') }}" />
@append

@section('content')

    <div class="external-container">

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(isset($messages))
        <div class="alert alert-info">
            <ul>
                @foreach ($messages as $message)
                    <li><span class="glyphicon glyphicon-info-sign"></span> {{ $message }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {!! Form::model( $cliente, ['route' => [$action], 'class' => 'dados']) !!}
    {!! Form::hidden('email', $cliente->email) !!}
    {!! Form::hidden('id', $cliente->id) !!}
    {!! Form::hidden('origem', 'ACEPG') !!}
    <div >
        <div>
            {!! Form::text('nome', null, ['id' => 'nome', 'placeholder' => 'Seu nome', 'required', 'autofocus', 'class' => 'purple-shadow-focused', 'tabindex' => '1', 'autocomplete' => 'off']) !!}
        </div>
    </div>
    <div class="row">
        <div class="col col_4 remove-margin-from-divs padding-right">
            <div id="js-datepicker" class="input-group date datepicker">
                {!! Form::text('data_nasc', null, ['id' => 'data_nasc', 'required', 'placeholder' => 'Data de Nascimento', 'autocomplete' => 'off', 'tabindex' => '2']) !!}
                <div class="input-group-addon" style="margin: 0">
                    <span class="glyphicon glyphicon-th"></span>
                </div>
            </div>
        </div>
        <div class="col col_3 padding-right">
            {!! Form::select('sexo', ['Masculino' => 'Masculino', 'Feminino' => 'Feminino'], null, ['id' => 'sexo', 'required', 'class' => 'purple-shadow-focused', 'autocomplete' => 'off', 'placeholder' => 'Sexo', 'style' => 'color: #757575;', 'tabindex' => '3']) !!}
        </div>
        <div class="col col_5">
            {!! Form::tel('whatsapp', null, ['id' => 'whatsapp', 'placeholder' => 'Whatsapp (00) 00000-0000', 'required', 'maxlenght' => 11, 'autocomplete' => 'off', 'class' => 'purple-shadow-focused','tabindex' => '4']) !!}
        </div>
    </div>
    <div class="clearfix row">
        <div class="col col_3 padding-right">
            {!! Form::tel('cep', null, ['id' => 'cep', 'placeholder' => 'CEP', 'required', 'maxlenght' => 8, 'class' => 'purple-shadow-focused', 'autocomplete' => 'off', 'tabindex' => '5']) !!}
        </div>
        <div class="col col_2 padding-right">
            {!! Form::text('estado', null, ['id' => 'estado', 'placeholder' => 'ESTADO', 'required', 'readonly', 'autocomplete' => 'off', 'tabindex' => '-1']) !!}
        </div>
        <div class="col col_7">
            {!! Form::text('cidade', null, ['id' => 'cidade', 'placeholder' => 'CIDADE', 'required', 'readonly', 'autocomplete' => 'off', 'tabindex' => '-1']) !!}
        </div>
    </div>
    <div class="clearfix">
        <div class="col col_4 padding-right">
            {!! Form::text('bairro', null, ['id' => 'bairro', 'placeholder' => 'BAIRRO', 'required', 'readonly', 'class' => 'purple-shadow-focused', 'autocomplete' => 'off', 'tabindex' => '-1']) !!}
        </div>
        <div class="col col_6 padding-right">
            {!! Form::text('logradouro', null, ['id' => 'logradouro', 'placeholder' => 'LOGRADOURO', 'required', 'class' => 'purple-shadow-focused', 'autocomplete' => 'off', 'readonly', 'tabindex' => '-1']) !!}
        </div>
        <div class="col col_2">
            {!! Form::text('numero', null, ['id' => 'numero', 'placeholder' => 'Nº 1', 'required', 'class' => 'purple-shadow-focused', 'autocomplete' => 'off', 'tabindex' => '10']) !!}
        </div>
    </div>
    <div class="clearfix">
        <div>
            {!! Form::text('complemento', null, ['id' => 'complemento', 'placeholder' => 'Complemento - Ex: Fundos', 'class' => 'purple-shadow-focused', 'autocomplete' => 'off', 'tabindex' => '11']) !!}
        </div>
    </div>
    <div class="clearfix">
        <div class="col col_3 padding-right">
            {!! Form::button('Voltar',['type' => 'button', 'onclick' => 'window.history.back();', 'class' => 'purple-shadow-focused']) !!}
        </div>
        <div class="col col_9">
            {!! Form::button('Ganhar Descontos!',['class' => 'ativo purple-shadow-focused', 'type' => 'submit']) !!}
        </div>
    </div>
    {!! Form::close() !!}

    </div>


@endsection

@section('footer-scripts')
    <link type="text/css" rel="stylesheet" href="{{ mix('/css/bootstrap-datepicker.min.css') }}">
@append

@section('footer-scripts')
    <script type="text/javascript" src="/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="/locales/bootstrap-datepicker.pt-BR.min.js"></script>
    <script type="text/javascript">
        @if(isset($required_fields))
        var required_fields;
        $(document).ready(function () {
            required_fields = {!!  $required_fields !!};
            if (required_fields) {
                Object.keys(required_fields).forEach(function (key) {
                    var field = required_fields[key];
                    if (field === 'data_nasc') {
                        field = 'js-datepicker';
                    }
                    var el = document.getElementById(field);
                    $(el).css('border-color', 'red');
                });
            }
            $('form input, form select, form textarea').each(function () {
                var achou = false;
                if (required_fields) {
                    var eu = this;
                    Object.values(required_fields).forEach(function (val) {
                        var fieldToCompare = $(eu).attr('name');
                        if (fieldToCompare == val){
                            achou = true;
                        }
                    });
                }
                if (!achou && $(this).attr('type') !== 'hidden'){
                    $(this).attr('disabled', 'disabled');
                }
            });
        })
        @endif
        $('.date').datepicker({
            language: 'pt-BR'
        });
        $(document).ready(function () {
            $("input[name='nome']").focus();
            $("form").validate({
                errorPlacement: function(error, element) {
                    if (element.attr("id") == "data_nasc") {
                        error.insertAfter("#js-datepicker");
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
            $('#data_nasc').on('focus', function () {
                $('.date').addClass('purple-shadow');
            });
            $('#data_nasc').on('blur', function () {
                $('.date').removeClass('purple-shadow');
            });
            $('#sexo').change(function () {
                if ($(this).val()){
                    $(this).css('color', 'black');
                } else {
                    $(this).css('color', '#757575');
                }
            });
        });
    </script>
@append
