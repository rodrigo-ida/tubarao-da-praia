@extends('layouts.admin')

@section('title', 'Ofertas')

@section('content_header')
    <h1>Oferta</h1>
@stop

@section('content')

    <!-- messages -->
    @include('admin.helpers._messages')

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Editar oferta</h3>
            <div class="box-tools pull-right">
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        {!! Form::model($offer, ['route' => ['admin.offers.update', 'id' => $offer->id ], 'files' => true]) !!}
        <div class="box-body">

            <!-- validation errors messages -->
            @include('admin.errors._check')

            <!-- offer form -->
            @include('admin.offers._form')

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            {{ Form::submit('Salvar', ['class' => 'btn btn-success']) }}
            <a href="{{route('admin.offers.index')}}" class="btn btn-default">Cancelar</a>
        </div>
        <!-- box-footer -->
        {!! Form::close() !!}
    </div>
    <!-- /.box -->
@endsection