{{ csrf_field() }}
@if ($_SERVER['REQUEST_URI'] != '/admin/lojas/create')
    @if ($loja->hasImage())
        <div>
            <img src="{{ $loja->getImageURL() }}" style="max-width: 300px;"/>
        </div>
    @endif
@endif
<div class="form-group">
    {{ Form::label('image', 'Imagem')}}
    {{ Form::file('image', ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('Nome', 'Nome')}}
    {{ Form::text('nome_loja', null,  ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('Whatsapp', 'Whatsapp')}}
    {{ Form::tel('whatsapp_loja', null, ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('Telefone', 'Telefone')}}
    {{ Form::tel('telefone_loja', null, ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('Email', 'Email') }}
    {{ Form::email('email_loja', null, ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('Cep', 'Cep') }}
    {{ Form::number('cep_loja', null, ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('Estado', 'Estado') }}
    {{ Form::text('estado_loja', null, ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('Cidade', 'Cidade') }}
    {{ Form::text('cidade_loja', null, ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('Bairro', 'Bairro') }}
    {{ Form::text('bairro_loja', null, ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('Logradouro', 'Logradouro') }}
    {{ Form::text('logradouro_loja', null, ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('Número', 'Número') }}
    {{ Form::number('numero_loja', null, ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('Facebook URL', 'Facebook URL') }}
    {{ Form::text('facebook_loja', null, ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('Site', 'Site') }}
    {{ Form::text('site_loja', null, ['class' => 'form-control']) }}
</div>