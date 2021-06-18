@extends('layouts.admin')

@section('title', 'Custos de produto')

@section('content_header')
    <h1>Custos de produto</h1>
@stop

@section('content')
        <div class="box">
            <div class="form-group">
                
            <button id="complements-search" class="btn btn-success">
                    <i class="fa fa-search"></i><span class="hidden-xs"> Pesquisar</span>
            </button>
            @if($_SERVER['REQUEST_URI'] != '/admin/products/costs')
            <button id="complements-limpar" class="btn btn-danger">
                <i class="fa fa-times-circle-o"></i><span class="hidden-xs"> limpar</span>
            </button>
            @endif
        </div>
        <div class="box-header with-border">
            <h3 class="box-title">
                <a href="{{ route('admin.prodcosts.create') }}" class="btn btn-info">Nova</a>
            </h3>
            <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
            @if(!$costs->isEmpty())
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Preço atual(R$)</th>
                        <th>Preço de custo(R$)</th>
                        <th>Data</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($costs as $cost)
                        <tr>
                            <td>             
                                  
                                {{ $cost->product()->First()->name_product }}
                            
                            </td>
                            <td>

                                {{ number_format($cost->product()->First()->price_product, 2, ",", ".") }}

                            </td>            
                            <td>

                                {{ number_format($cost->product_cost_price, 2, ",", ".") }}

                            </td>            
                            <td>             
                                  
                                {{ date_format($cost->updated_at,"d/m/Y") }}
                            
                            </td>           
                            <td>
                                <a href="{{ route('admin.prodcosts.edit', ['id' => $cost->id]) }}" class="btn btn-default">Editar</a>
                                <a href="{{ route('admin.prodcosts.destroy', ['id' => $cost->id]) }}" class="btn btn-danger">Excluir</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="alert alert-info">Não há custos de produto para listar</p>
            @endif
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            @if(!$costs->isEmpty())
            {{ $costs->links(null, ['classes' => ['pagination-sm', 'no-margin', 'pull-right'], 'ariaLabel' => 'Paginação de resultados']) }}
            @endif
        </div>
        <!-- box-footer -->
    </div>
    <!-- /.box -->
@endsection

@section('js')
    <script>
        $(function () {
            $('#cost-search').on('click', function(){
                var id = $('.form-group select option:selected').val();

                    window.location.href = '/admin/products/cost/search/' + id;    //<---- Add this line
            });
        });

        $(function () {
            $('#cost-limpar').on('click', function(){
                var id = $('.form-group select option:selected').val();

                    window.location.href = '/admin/products/cost';    //<---- Add this line
            });
        });
    </script>
@endsection