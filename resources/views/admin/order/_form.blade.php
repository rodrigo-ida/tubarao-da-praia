<div class="form-group">
    {{ Form::label('Nome', 'Nome')}}
    {{ Form::select('product_id', $product) }}
</div>
<div class="form-group">
    {{ Form::label('Preço de custo', 'Preço de custo')}}
    {{ Form::number('product_cost_price', null,  ['class' => 'form-control', 'step' => 'any']) }}
</div>