@extends('layouts.admin')

@section('title', 'Editar Banner')

@section('content_header')
    <h1>Editar Banner</h1>
@stop

@section('content')

    <!-- messages -->
    @include('admin.helpers._messages')

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Editar Banner: #{{ $banner->id }}</h3>
            <div class="box-tools pull-right">
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        {!! Form::model($banner, ['route' => ['admin.banner.update', 'id' => $banner->id ], 'files' => true]) !!}
        <div class="box-body">

            <!-- validation errors messages -->
            @include('admin.errors._check')

            <!-- offer form -->
            @include('admin.promobanners._form')

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            {{ Form::submit('Salvar', ['class' => 'btn btn-success']) }}
            <a href="{{route('admin.banner.index')}}" class="btn btn-default">Cancelar</a>
        </div>
        <!-- box-footer -->
        {!! Form::close() !!}
    </div>
    <!-- /.box -->
@endsection