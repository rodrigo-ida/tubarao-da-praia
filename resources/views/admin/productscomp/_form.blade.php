{{ csrf_field() }}
@if ($_SERVER['REQUEST_URI'] != '/admin/complements/create')
@endif
<div class="form-group">
    {{ Form::label('image', 'Imagem')}}
    {{ Form::file('image', ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('Nome', 'Nome')}}
    {{ Form::text('name_complement', null,  ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('Preço do Complemento', 'Preço do Complemento')}}
    {{ Form::number('price_complement', null,  ['class' => 'form-control', 'step' => 'any']) }}
</div>
<div class="form-group">
    {{ Form::label('product_id', 'Produto')}}
    {{ Form::select('product_id', $products) }}
</div>
<div class="form-group">
    {{ Form::label('category_id', 'Categoria')}}
    {{ Form::select('category_id', $categories) }}
</div>
<div class="form-group">
    {{ Form::label('complements_status', 'Status') }}
    <select name="complements_status" id="complements_status">
        <option value="0">Desativado</option>
        <option value="1">Ativado</option>
    </select>
</div>