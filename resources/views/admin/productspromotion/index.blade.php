@extends('layouts.admin')

@section('title', 'Promoções de produto')

@section('content_header')
    <h1>Promoções de produto</h1>
@stop

@section('content')
        <div class="box">
            <div class="form-group">
                
            <button id="complements-search" class="btn btn-success">
                    <i class="fa fa-search"></i><span class="hidden-xs"> Pesquisar</span>
            </button>
            @if($_SERVER['REQUEST_URI'] != '/admin/products/promotion')
            <button id="complements-limpar" class="btn btn-danger">
                <i class="fa fa-times-circle-o"></i><span class="hidden-xs"> limpar</span>
            </button>
            @endif
        </div>
        <div class="box-header with-border">
            <h3 class="box-title">
                <a href="{{ route('admin.prodpromotions.create') }}" class="btn btn-info">Nova</a>
            </h3>
            <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
            @if(!$productPromotion->isEmpty())
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Preço(R$)</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($productPromotion as $promotion)
                        <tr>
                            <td>             
                                  
                                {{ $promotion->name_promotion }}
                            
                            </td>
                            <td>

                                {{ number_format($promotion->price_promotion_after, 2, ",", ".") }}

                            </td>                       
                            <td>
                                <a href="{{ route('admin.prodpromotions.edit', ['id' => $promotion->id]) }}" class="btn btn-default">Editar</a>
                                <a href="{{ route('admin.prodpromotions.destroy', ['id' => $promotion->id]) }}" class="btn btn-danger">Excluir</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="alert alert-info">Não há promoções para listar</p>
            @endif
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            @if(!$productPromotion->isEmpty())
            {{ $productPromotion->links(null, ['classes' => ['pagination-sm', 'no-margin', 'pull-right'], 'ariaLabel' => 'Paginação de resultados']) }}
            @endif
        </div>
        <!-- box-footer -->
    </div>
    <!-- /.box -->
@endsection

@section('js')
    <script>
        $(function () {
            $('#promotion-search').on('click', function(){
                var id = $('.form-group select option:selected').val();

                    window.location.href = '/admin/products/promotion/search/' + id;    //<---- Add this line
            });
        });

        $(function () {
            $('#promotion-limpar').on('click', function(){
                var id = $('.form-group select option:selected').val();

                    window.location.href = '/admin/products/promotion';    //<---- Add this line
            });
        });
    </script>
@endsection