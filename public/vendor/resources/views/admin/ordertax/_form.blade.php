<div class="form-group">

    {{ Form::label('Faixa de CEP inicial', 'Faixa de CEP inicial')}}

    {{ Form::text('order_tax_cep_inicial', null,  ['class' => 'form-control', 'maxlength' => '9']) }}

</div>

<div class="form-group">

    {{ Form::label('Faixa de CEP final', 'Faixa de CEP final')}}

    {{ Form::text('order_tax_cep_final', null,  ['class' => 'form-control', 'maxlength' => '9']) }}

</div>

<div class="form-group">
    {{ Form::label('Bairro', 'Bairro')}}
    {{ Form::text('order_tax_neighborhood', null,  ['class' => 'form-control']) }}
</div>


<div class="form-group">
    {{ Form::label('Taxa de Entrega', 'Taxa de Entrega')}}
    {{ Form::text('order_tax_price', null,  ['class' => 'form-control']) }}
</div>



<div class="form-group">

    {{ Form::label('Loja', 'Loja')}}

    {{ Form::select('order_tax_loja_id', $lojas) }}

</div>

<div class="checkbox">

    {{ Form::label('Status: ', 'Status: ')}}

    <label>

        {{ Form::radio('order_tax_status', '1') }}

        Ativado

    </label>

    <label>

        {{ Form::radio('order_tax_status', '0')}}

        Desativado

    </label>


</div>

<div class="form-group">

    <label>

        {{ Form::label('Tempo de entrega: ', 'Tempo de entrega: ')}}

        {{ Form::time('order_shipping_time', null, ['class' => 'form-control']) }}

    </label>

</div>