@extends('layouts.admin')

@section('title', 'Complementos de produto')

@section('content_header')
    <h1>Complementos de produto</h1>
@stop

@section('content')
        <div class="box">
            <div class="form-group">
                
            <button id="complements-search" class="btn btn-success">
                    <i class="fa fa-search"></i><span class="hidden-xs"> Pesquisar</span>
            </button>
            @if($_SERVER['REQUEST_URI'] != '/admin/complements')
            <button id="complements-limpar" class="btn btn-danger">
                <i class="fa fa-times-circle-o"></i><span class="hidden-xs"> limpar</span>
            </button>
            @endif
        </div>
        <div class="box-header with-border">
            <h3 class="box-title">
                <a href="{{ route('admin.complements.create') }}" class="btn btn-info">Nova</a>
            </h3>
            <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
            @if(!$complements->isEmpty())
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Preço(R$)</th>
                        <th>Produto</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($complements as $complement)
                        <tr>
                            <td>             
                                  
                                {{ $complement->name_complement }}
                            
                            </td>

                            <td>

                                {{ number_format($complement->price_complement, 2, ",", ".") }}

                            </td>  

                            <td>
                            @if($complement->product != null)
                                {{ $complement->product()->First()->name_product }}
                                @else
                                -
                            @endif
                            </td>

                            <td>
                                <a href="{{ route('admin.complements.edit', ['id' => $complement->id]) }}" class="btn btn-default">Editar</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="alert alert-info">Não há complementos de produto para listar</p>
            @endif
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            @if(!$complements->isEmpty())
            {{ $complements->links(null, ['classes' => ['pagination-sm', 'no-margin', 'pull-right'], 'ariaLabel' => 'Paginação de resultados']) }}
            @endif
        </div>
        <!-- box-footer -->
    </div>
    <!-- /.box -->
@endsection

@section('js')
    <script>
        $(function () {
            $('#complements-search').on('click', function(){
                var id = $('.form-group select option:selected').val();

                    window.location.href = '/admin/complements/search/' + id;    //<---- Add this line
            });
        });

        $(function () {
            $('#complements-limpar').on('click', function(){
                var id = $('.form-group select option:selected').val();

                    window.location.href = '/admin/complements';    //<---- Add this line
            });
        });
    </script>
@endsection