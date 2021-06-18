@extends('layouts.admin')



@section('title', 'Taxa de entrega')



@section('content_header')

    <h1>Taxa de entrega</h1>

@stop



@section('content')

    <div class="box">

        <div class="box-header with-border">

            <h3 class="box-title">

                <a href="{{ route('admin.ordertax.create') }}" class="btn btn-info">Novo</a>

            </h3>

            <div class="box-tools pull-right">
            

                <!-- Buttons, labels, and many other things can be placed here! -->

                <!-- Here is a label for example -->

            </div>

            <!-- /.box-tools -->

        </div>
        
        
        

        <!-- /.box-header -->

        <div class="box-body table-responsive">
        
         <div class="form-group search">
            <div class="search-form">

                

                <button id="products-search" class="btn btn-success">

                    <i class="fa fa-search"></i><span class="hidden-xs"> Pesquisar</span>

                </button>

               

                <button id="products-limpar" class="btn btn-danger">

                    <i class="fa fa-times-circle-o"></i><span class="hidden-xs"> limpar</span>

                </button>


            </div>
        
        <div class="input-group">
                <input name="prod-search" id="tax-search-term-input" type="text" class="form-control" placeholder="Digite para pesquisar por nome" value="">
                <div class="input-group-btn">
                    <button class="btn btn-info search-taxs-name">
                        <i class="fa fa-search"></i><span class="hidden-xs"> Pesquisar</span>
                    </button>
                </div>
            </div>

            @if(!$taxes->isEmpty())

                <table class="table table-hover">

                    <thead>

                    <tr>

                        <th>CEP inicial</th>

                        <th>CEP final</th>

                        <th>Bairro</th>

                        <th>Status</th>

                        <th>Preço</th>

                        <th>Loja</th>

                        <th></th>

                    </tr>

                    </thead>

                    <tbody>
                        
                    <? echo $taxes ;?>

                    @foreach($taxes as $tax)

                        <tr>

                            <td>             

                                

                                {{ $tax->order_tax_cep_inicial }}

                            

                            </td>

                            <td>



                                {{ $tax->order_tax_cep_final }}



                            </td>

                            <td>
                            
                                {{ $tax->order_tax_neighborhood }}
                            
                            </td>

                            <td>

                            @if($tax->order_tax_status == App\OrderTax::OrderTaxActive)

                                

                                    Ativo

                                

                                @else

                            

                                    Desativado



                            @endif

                            </td>

                            <td>

                            

                                R$ {{ number_format($tax->order_tax_price, 2, ',', '.') }}

                            

                            </td> 

                            <td>

                            

                            

                            {{ $tax->order_tax_loja_id }}

                            </td>

                            <td>

                                <a href="{{ route('admin.ordertax.edit', ['id' => $tax->id]) }}" class="btn btn-default">Editar</a>

                                <a href="{{ route('admin.ordertax.destroy', ['id' => $tax->id]) }}" class="btn btn-danger">Excluir</a>

                            </td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

            @else

                <p class="alert alert-info">Não há taxas de entrega para listar</p>

            @endif

        </div>

        <!-- /.box-body -->

        <div class="box-footer">

            @if(!$taxes->isEmpty())

            {{ $taxes->links(null, ['classes' => ['pagination-sm', 'no-margin', 'pull-right'], 'ariaLabel' => 'Paginação de resultados']) }}

            @endif

        </div>

        <!-- box-footer -->

    </div>

    <!-- /.box -->

@endsection


@section('js')

<script>
    

    $(function() {

        $('.search-taxs-name').on('click', function() {

            var name = $('#tax-search-term-input').val();
            
            window.location.href = '/admin/order/tax/search=' + name; //<---- Add this line

        });

    });
    
    
    $(function() {

        $('#products-search').on('click', function() {

            var id = $('.form-group select option:selected').val();



            window.location.href = '/admin/products/search/' + id; //<---- Add this line

        });

    });



    $(function() {

        $('#products-limpar').on('click', function() {

            var id = $('.form-group select option:selected').val();



            window.location.href = '/admin/tax'; //<---- Add this line

        });

    });



    
</script>

@endsection