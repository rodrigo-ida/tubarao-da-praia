@extends('layouts.admin')



@section('title', 'Produtos')



@section('content_header')

<h1>Produtos</h1>

@stop


@section('content')
<section class='list-products'>

    <div class="box">

        <div class="form-group search">
            <div class="search-form">

                {{ Form::label('Categoria', 'Categoria') }}

                {{ Form::select('id', $categories, isset($catID) ? $catID : null) }}

                <button id="products-search" class="btn btn-success">

                    <i class="fa fa-search"></i><span class="hidden-xs"> Pesquisar</span>

                </button>

                @if(isset($catID))

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
        </div>


        <!-- /.box-header -->

        <div class="box-body table-responsive">
            <div class="input-group">
                <input name="prod-search" id="product-search-term-input" type="text" class="form-control" placeholder="Digite para pesquisar por nome" value="">
                <div class="input-group-btn">
                    <button class="btn btn-info search-product-name">
                        <i class="fa fa-search"></i><span class="hidden-xs"> Pesquisar</span>
                    </button>
                </div>
            </div>
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


                            <span class="status-border-on">
                            </span>

                            @else


                            <span class="status-border-off">
                            </span>
                            @endif

                        </td>

                        <td>

                            {{ $product->name_category }}

                        </td>

                        <td></td>

                        <td style="width: 120px;border-left:1px solid #ECF0F5">
                            <a href="{{ route('admin.products.destroy', ['id' => $product->id]) }}" class="btn btn-delete">
                                <svg fill="#e90e0e" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="16.899px" height="16.899px" viewBox="0 0 459 459" style="enable-background:new 0 0 459 459;" xml:space="preserve">
                                    <g>
                                        <g id="delete">
                                            <path d="M76.5,408c0,28.05,22.95,51,51,51h204c28.05,0,51-22.95,51-51V102h-306V408z M408,25.5h-89.25L293.25,0h-127.5l-25.5,25.5    H51v51h357V25.5z"></path>
                                        </g>
                                    </g>

                                </svg>

                            </a>
                            <a href="{{ route('admin.products.edit', ['id' => $product->id]) }}" class="btn btn-edit" style="margin-left:10px">
                                <svg fill="#2196f3" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="16.899px" height="16.899px" viewBox="0 0 528.899 528.899" style="enable-background:new 0 0 528.899 528.899;" xml:space="preserve">
                                    <g>
                                        <path d="M328.883,89.125l107.59,107.589l-272.34,272.34L56.604,361.465L328.883,89.125z M518.113,63.177l-47.981-47.981   c-18.543-18.543-48.653-18.543-67.259,0l-45.961,45.961l107.59,107.59l53.611-53.611   C532.495,100.753,532.495,77.559,518.113,63.177z M0.3,512.69c-1.958,8.812,5.998,16.708,14.811,14.565l119.891-29.069   L27.473,390.597L0.3,512.69z"></path>
                                    </g>

                                </svg>

                            </a>



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

        $('.search-product-name').on('click', function() {

            var name = $('#product-search-term-input').val();

            window.location.href = '/admin/products/search=' + name; //<---- Add this line

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