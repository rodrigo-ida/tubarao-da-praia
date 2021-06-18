@extends('layouts.admin')

@section('title', 'Configuração de Delivery')

@section('content_header')
    <h1>Configuração de Delivery</h1>
@stop

@section('content')

    <!-- messages -->
    @include('admin.helpers._messages')

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Editando: {{ strToUpper($config->config_date) }}</h3>
            <h3 class="box-title">- {{ $config->getLoja()->First()->nome_loja }}</h3>
            <div class="box-tools pull-right">
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        {!! Form::model($config, ['route' => ['admin.lojadeliveryconfig.update', 'id' => $config->id ], 'files' => false]) !!}
        <div class="box-body">

            <!-- validation errors messages -->
            @include('admin.errors._check')

            <!-- offer form -->
            @include('admin.deliveryconfigs._form-edit')

        </div>
        <!-- /.box-body -->
        <div class="box-footer">

            {{ Form::submit('Salvar', ['class' => 'btn btn-success']) }}

            <a href="{{route('admin.lojadeliveryconfig.index')}}" class="btn btn-default">Cancelar</a>
        </div>
        <!-- box-footer -->
        {!! Form::close() !!}
    </div>
    <!-- /.box -->
@endsection