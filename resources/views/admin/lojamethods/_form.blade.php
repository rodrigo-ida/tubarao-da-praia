<div class="form-group">
    {{ Form::label('Loja', 'Loja')}}
    {{ Form::select('payment_method_loja_id', $lojas) }}
</div>
<div class="form-group">
    {{ Form::label('Métodos de Pagamento', 'Métodos de pagamento')}}
    {{ Form::select('payment_method_ids', $methods) }}
</div>