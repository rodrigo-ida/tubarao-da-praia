@extends('layouts.admin')

@section('title', 'Loja')

@section('content_header')
    <h1>Loja</h1>
@stop

@section('content')

    <!-- messages -->
    @include('admin.helpers._messages')

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Criar nova loja</h3>
            <div class="box-tools pull-right">
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        {!! Form::model(null, [ 'route' => ['admin.lojas.store'], 'files' => true]) !!}
        <div class="box-body">

            <!-- validation errors messages -->
            @include('admin.errors._check')

            <!-- offer form -->
            @include('admin.loja._form')

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            {{ Form::submit('Criar', ['class' => 'btn btn-success']) }}
            <a href="{{route('admin.lojas.index')}}" class="btn btn-default">Cancelar</a>
        </div>
        <!-- box-footer -->
        {!! Form::close() !!}
    </div>
    <!-- /.box -->
@endsection