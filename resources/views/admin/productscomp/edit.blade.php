@extends('layouts.admin')

@section('title', 'Complementos de Produto')

@section('content_header')
    <h1>Complementos de produto</h1>
@stop

@section('content')

    <!-- messages -->
    @include('admin.helpers._messages')

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Mudar Complemento de Produto: {{ $complement->name_complement }}</h3>
            <div class="box-tools pull-right">
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        {!! Form::model($complement, ['route' => ['admin.complements.update', 'id' => $complement->id], 'files' => true]) !!}
        <div class="box-body">

            <!-- validation errors messages -->
            @include('admin.errors._check')

            <!-- offer form -->
            @include('admin.productscomp._form')

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            {{ Form::submit('Salvar', ['class' => 'btn btn-success']) }}
            <a href="{{route('admin.complements.index')}}" class="btn btn-default">Cancelar</a>
        </div>
        <!-- box-footer -->
        {!! Form::close() !!}
    </div>
    <!-- /.box -->
@endsection