<div class="form-group">
    {{ Form::label('Nome status', 'Nome status')}}
    {{ Form::text('status_name', null,  ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('ativo', 'ativo')}}
    {{ Form::radio('active_status','1') }} sim
    {{ Form::radio('active_status','1') }} não
</div>