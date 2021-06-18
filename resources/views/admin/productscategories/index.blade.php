@extends('layouts.admin')

@section('title', 'Categorias de Produto')

@section('content_header')
    <h1>Categorias de produto</h1>
@stop

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                <a href="{{ route('admin.pcategories.create') }}" class="btn btn-info">Nova</a>
            </h3>
            <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
            @if(!$categories->isEmpty())
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td>             
                                  
                                {{ $category->name_category }}
                            
                            </td>
                            <td>
                                <a href="{{ route('admin.pcategories.edit', ['id' => $category->id]) }}" class="btn btn-default">Editar</a>
                                <a href="{{ route('admin.pcategories.destroy', ['id' => $category->id]) }}" class="btn btn-danger">Excluir</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="alert alert-info">Não há categorias para listar</p>
            @endif
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            @if(!$categories->isEmpty())
            {{ $categories->links(null, ['classes' => ['pagination-sm', 'no-margin', 'pull-right'], 'ariaLabel' => 'Paginação de resultados']) }}
            @endif
        </div>
        <!-- box-footer -->
    </div>
    <!-- /.box -->
@endsection