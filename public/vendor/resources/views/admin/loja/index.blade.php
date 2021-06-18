@extends('layouts.admin')

@section('title', 'Lojas')

@section('content_header')
    <h1>Lojas</h1>
@stop

@section('content')

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                <a href="{{ route('admin.lojas.create')}}" class="btn btn-info">Nova</a>
            </h3>
            <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
            @if(!$lojas->isEmpty())
                <table class="table table-hover">
                    <thead>
                    <tr>
                        
                        <th>Nome</th>
                        <th>Bairro</th>
                        <th>Cidade</th>
                        <th>Telefone</th>
                        <th>Site</th>
                        <th>Facebook</th>
                        <th></th>
                        
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($lojas as $loja)
                        <tr>
                        
                            <td>
                                {{ $loja->nome_loja }}
                            </td>
                            <td>
                                {{ $loja->bairro_loja }}
                            </td>
                            <td>
                                {{ $loja->cidade_loja }}
                            </td>
                            <td>
                                {{ $loja->telefone_loja }}
                            </td>
                            <td>
                                {{ $loja->site_loja }}
                            </td>
                            <td>
                                {{ $loja->facebook_loja }}
                            </td>
                            <td></td>
                            <td>
                                <a href="{{ route('admin.lojas.show', ['id' => $loja->id]) }}" class="btn btn-info">ver</a>
                                <a href="{{ route('admin.lojas.edit', ['id' => $loja->id]) }}" class="btn btn-default">Editar</a>
                                <a href="{{ route('admin.lojas.destroy', ['id' => $loja->id]) }}" class="btn btn-danger">Excluir</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="alert alert-info">Não há lojas para listar</p>
            @endif
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            @if(!$lojas->isEmpty())
                
            @endif
        </div>
        <!-- box-footer -->
    </div>
    <!-- /.box -->
@endsection