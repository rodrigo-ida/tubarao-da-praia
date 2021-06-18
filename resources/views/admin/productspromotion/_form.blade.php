<div class="form-group">
    {{ Form::label('Nome', 'Nome')}}
    {{ Form::text('name_promotion', null,  ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('Preço da Promoção', 'Preço da Promoção')}}
    {{ Form::number('price_promotion_after', null,  ['class' => 'form-control', 'step' => 'any']) }}
</div>