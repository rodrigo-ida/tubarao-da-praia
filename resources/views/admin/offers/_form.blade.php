<div class="form-group">
    {{ Form::label('titulo', 'Título')}}
    {{ Form::text('titulo', null, ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('descricao', 'Descrição')}}
    {{ Form::text('descricao', null, ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('coupon_limit', 'Limite de Cupons <small>(0 = sem limite)</small>', [], false)}}
    {{ Form::text('coupon_limit', null, ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('begins_at', 'Inicia em:')}}
    <div class="input-group date">
        {{ Form::text('begins_at', null, ['class' => 'form-control']) }}
        <div class="input-group-addon">
            <span class="glyphicon glyphicon-th"></span>
        </div>
    </div>
</div>
<div class="form-group">
    {{ Form::label('expires_at', 'Finaliza em:')}}
    <div class="input-group date">
        {{ Form::text('expires_at', null, ['class' => 'form-control']) }}
        <div class="input-group-addon">
            <span class="glyphicon glyphicon-th"></span>
        </div>
    </div>
</div>
<div class="checkbox">
    <label>
        {{ Form::checkbox('active', 1) }}
        Ativo
    </label>
</div>
@if ($offer->hasImage())
<div>
    <img src="{{ $offer->getImageURL() }}" style="max-width: 300px;"/>
</div>
@endif
<div class="form-group">
    {{ Form::label('image', 'Imagem')}}
    {{ Form::file('image', ['class' => 'form-control']) }}
</div>
@push('css')
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/datepicker/datepicker3.css') }}">
@endpush

@push('js')
    <<!-- bootstrap datepicker -->
    <script src="{{ asset('vendor/adminlte/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('vendor/adminlte/plugins/datepicker/locales/bootstrap-datepicker.pt-BR.js') }}"></script>
    <script type="text/javascript">
        $(function () {
            //Date picker
            $('#expires_at, #begins_at').datepicker({
                autoclose: true,
                language: 'pt-BR',
                format: "yyyy-mm-dd",
                clearBtn: true,
                todayHighlight: true
            })
        });
    </script>
@endpush