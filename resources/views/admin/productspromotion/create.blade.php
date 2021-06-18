@extends('layouts.admin')

@section('title', 'Promoção de Produto')

@section('content_header')
    <h1>Promoção de produto</h1>
@stop

@section('content')

    <!-- messages -->
    @include('admin.helpers._messages')

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Criar nova promoção de produto</h3>
            <div class="box-tools pull-right">
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        {!! Form::model(null, ['route' => ['admin.prodpromotions.store'], 'files' => false]) !!}
        <div class="box-body">

            <!-- validation errors messages -->
            @include('admin.errors._check')

            <!-- offer form -->
            @include('admin.productspromotion._form')

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            {{ Form::submit('Criar', ['class' => 'btn btn-success']) }}
            <a href="{{ route('admin.prodpromotions.index') }}" class="btn btn-default">Cancelar</a>
        </div>
        <!-- box-footer -->
        {!! Form::close() !!}
    </div>
    <!-- /.box -->
@endsection