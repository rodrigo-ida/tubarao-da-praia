@extends('layouts.admin')

@section('title', 'Status de Pedido')

@section('content_header')
    <h1>Status de Pedido</h1>
@stop

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                <a href="{{ route('admin.orderstatus.create') }}" class="btn btn-info">Novo</a>
            </h3>
            <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
            @if(!$status->isEmpty())
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome status</th>
                        <th>Ativo</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($status as $item)
                        <tr>
                            <td>             
                                
                                {{ $item->id }}
                            
                            </td>
                            <td>

                                {{ $item->status_name }}

                            </td> 
                            <td>
                                @if($item->active_status == 1)
                                    ativo
                                 @else
                                    desativado
                                @endif
                            </td>            
                            <td>
                                <a href="{{ route('admin.orderstatus.destroy', ['id' => $item->id]) }}" class="btn btn-danger">Excluir</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="alert alert-info">Não há status de pedido para listar</p>
            @endif
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            @if(!$status->isEmpty())
            {{ $status->links(null, ['classes' => ['pagination-sm', 'no-margin', 'pull-right'], 'ariaLabel' => 'Paginação de resultados']) }}
            @endif
        </div>
        <!-- box-footer -->
    </div>
    <!-- /.box -->
@endsection