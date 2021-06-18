@extends('layouts.admin')

@section('title', 'Custo de Produto')

@section('content_header')
    <h1>Custo de produto</h1>
@stop

@section('content')

    <!-- messages -->
    @include('admin.helpers._messages')

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Criar novo custo de produto</h3>
            <div class="box-tools pull-right">
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        {!! Form::model(null, ['route' => ['admin.prodcosts.store'], 'files' => false]) !!}
        <div class="box-body">

            <!-- validation errors messages -->
            @include('admin.errors._check')

            <!-- offer form -->
            @include('admin.productcosts._form')

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            {{ Form::submit('Criar', ['class' => 'btn btn-success']) }}
            <a href="{{ route('admin.prodcosts.index') }}" class="btn btn-default">Cancelar</a>
        </div>
        <!-- box-footer -->
        {!! Form::close() !!}
    </div>
    <!-- /.box -->
@endsection