@extends('layouts.admin')

@section('title', 'Promoções de Produto')

@section('content_header')
    <h1>Promoções de produto</h1>
@stop

@section('content')

    <!-- messages -->
    @include('admin.helpers._messages')

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Mudar promoção de Produto: {{ $promotion->name_promotion }}</h3>
            <div class="box-tools pull-right">
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        {!! Form::model($promotion, ['route' => ['admin.prodpromotions.update', 'id' => $promotion->id], 'files' => false]) !!}
        <div class="box-body">

            <!-- validation errors messages -->
            @include('admin.errors._check')

            <!-- offer form -->
            @include('admin.productspromotion._form')

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            {{ Form::submit('Salvar', ['class' => 'btn btn-success']) }}
            <a href="{{route('admin.prodpromotions.index')}}" class="btn btn-default">Cancelar</a>
        </div>
        <!-- box-footer -->
        {!! Form::close() !!}
    </div>
    <!-- /.box -->
@endsection