{{ csrf_field() }}
<div class="form-group">
    {{ Form::label('Nome', 'Nome')}}
    {{ Form::text('name', null,  ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('Email', 'Email')}}
    {{ Form::email('email', null, ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('Senha', 'Senha')}}
    {{ Form::password('password', ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('Loja', 'Loja') }}
    {{ Form::select('loja_id', $lojas) }}
</div>
<div class="checkbox">
    {{ Form::label('Permissão: ', 'Permissão: ')}}
    <label>
        {{ Form::radio('role', '1') }}
        Admin
    </label>
    <label>
        {{ Form::radio('role', '0')}}
        Loja
    </label>
    <label>
        {{ Form::radio('role', '3')}}
        Entregador
    </label>
</div>