@extends('layouts.admin')

@section('title', 'Status de Pedido')

@section('content_header')
    <h1>Status de Pedido</h1>
@stop

@section('content')

    <!-- messages -->
    @include('admin.helpers._messages')

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Criar novo status de pedido</h3>
            <div class="box-tools pull-right">
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        {!! Form::model(null, ['route' => ['admin.orderstatus.store'], 'files' => false]) !!}
        <div class="box-body">

            <!-- validation errors messages -->
            @include('admin.errors._check')

            <!-- offer form -->
            @include('admin.orderstatus._form')

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            {{ Form::submit('Criar', ['class' => 'btn btn-success']) }}
            <a href="{{ route('admin.orderstatus.index') }}" class="btn btn-default">Cancelar</a>
        </div>
        <!-- box-footer -->
        {!! Form::close() !!}
    </div>
    <!-- /.box -->
@endsection