@extends('layouts.admin')



@section('title', 'Produtos')



@section('content_header')

<h1>Produtos</h1>

@stop


@section('content')
<section class='list-products'>

    <div class="box">

        <div class="form-group">

            {{ Form::label('Categoria', 'Categoria') }}

            {{ Form::select('id', $categories) }}

            <button id="products-search" class="btn btn-success">

                <i class="fa fa-search"></i><span class="hidden-xs"> Pesquisar</span>

            </button>

            @if($_SERVER['REQUEST_URI'] != '/admin/products')

            <button id="products-limpar" class="btn btn-danger">

                <i class="fa fa-times-circle-o"></i><span class="hidden-xs"> limpar</span>

            </button>

            @endif

        </div>

        <div class="box-header with-border">

            <h3 class="box-title">

                <a href="{{ route('admin.products.create') }}" class="btn btn-info"><strong>+ </strong>Adicionar Produto</a>

            </h3>

            <div class="box-tools pull-right">

                <!-- Buttons, labels, and many other things can be placed here! -->

                <!-- Here is a label for example -->

            </div>

            <!-- /.box-tools -->

        </div>

        <!-- /.box-header -->

        <div class="box-body table-responsive">

            @if(!$products->isEmpty())

            <table class="table table-hover">

                <thead>

                    <tr>

                        <th>imagem</th>

                        <th>Nome</th>

                        <th>Descrição</th>

                        <th>Preço(R$)</th>

                        <th>Status</th>

                        <th>Categoria</th>

                        <th></th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($products as $product)

                    <tr>

                        <td>

                            <img style="width: 60px; height: 60px;" src="{{$product->getImageURL()}}" />

                        </td>

                        <td>

                            {{ $product->name_product }}

                        </td>

                        <td>

                            {{ $product->description_product }}

                        </td>

                        <td>

                            {{ number_format($product->price_product, 2, ",", ".") }}

                        </td>

                        <td>

                            @if($product->status_product == 1)

                            publicado

                            @else

                            pausado

                            @endif

                        </td>

                        <td>

                            {{ $product->name_category }}

                        </td>

                        <td></td>

                        <td>

                            <a href="{{ route('admin.products.edit', ['id' => $product->id]) }}" class="btn btn-edit">Editar</a>

                            <a href="{{ route('admin.products.destroy', ['id' => $product->id]) }}" class="btn btn-delete">Excluir</a>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

            @else

            <p class="alert alert-info">Não há produtos para listar</p>

            @endif

        </div>

        <!-- /.box-body -->

        <div class="box-footer">

            @if(!$products->isEmpty())

            {{ $products->links(null, ['classes' => ['pagination-sm', 'no-margin', 'pull-right'], 'ariaLabel' => 'Paginação de resultados']) }}

            @endif

        </div>

        <!-- box-footer -->

    </div>

    <!-- /.box -->

</section>
@endsection



@section('js')

<script>
    $(function() {

        $('#products-search').on('click', function() {

            var id = $('.form-group select option:selected').val();



            window.location.href = '/admin/products/search/' + id; //<---- Add this line

        });

    });



    $(function() {

        $('#products-limpar').on('click', function() {

            var id = $('.form-group select option:selected').val();



            window.location.href = '/admin/products'; //<---- Add this line

        });

    });
</script>

@endsection