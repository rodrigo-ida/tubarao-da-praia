@extends('layouts.admin')

@section('title', 'Produto')

@section('content_header')
    <h1>Produto</h1>
@stop

@section('content')

    <!-- messages -->
    @include('admin.helpers._messages')

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">Mudar produto: {{ $product->name_product }}</h3>
            <div class="box-tools pull-right">
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        {!! Form::model($product, ['route' => ['admin.products.update', 'id' => $product->id], 'files' => true]) !!}
        <div class="box-body">

            <!-- validation errors messages -->
            @include('admin.errors._check')

            <!-- offer form -->
            @include('admin.products._form')

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            {{ Form::submit('Salvar', ['class' => 'btn btn-success']) }}
            <a href="{{route('admin.products.index')}}" class="btn btn-default">Cancelar</a>
        </div>
        <!-- box-footer -->
        {!! Form::close() !!}
    </div>
    <!-- /.box -->
@endsection
<script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
<script type="text/javascript">
    $(document).on('click', '#add-variation', function(){
        var html = `
        <div class="variation">
            <label for="prod_var_name">
                Nome:
                <input type="text" name="prod_var_name[]" id="prod_var_name">

            </label>

            <label for="prod_var_price">
                Preço:
                <input type="number" step="any" name="prod_var_price[]" id="prod_var_price">

            </label>

            <label for="prod_var_active">
                Promoção ativa:
                <select name="prod_var_active[]" id="prod_var_active">
                    <option value="0">Desativado</option>
                    <option value="1">Ativo</option>
                </select>

            </label>

            <label for="prod_var_promo_day">
                Dia de Promoção:
                <select name='prod_var_promo_day[]' >
                    <option value="0">Domingo</option>
                    <option value="1">Segunda-feira</option>
                    <option value="2">Terça-feira</option>
                    <option value="3">Quarta-feira</option>
                    <option value="4">Quinta-feira</option>
                    <option value="5">Sexta-feira</option>
                    <option value="6">Sábado</option>
                </select>

            </label>

            <label for="prod_var_promo_price">
            Preço de promoção:
                <input type="number" step="any" name="prod_var_promo_price[]" id="prod_var_promo_price" value="">

            </label>

           <label for="prod_var_status">
                Ativo:
                <select name="prod_var_status[]" id="prod_var_status">
                    <option value="0">Desativado</option>
                    <option value="1">Ativo</option>
                </select>

            </label>

            <hr>
        </div>
        `;
        $(html).insertAfter('.variation:last');
    });

    function addVariationTable(){
        var html = "";

        html = `<div id="varTable" class="form-group">
            <div class="box-header with-border">
            <h3 class="box-title">
                Variações
            </h3>
                <input type="button" id="add-variation" class="btn btn-info" value="+">
            </div>
                <div class="variation">
                <label for="prod_var_name">
                    Nome:
                    <input type="text" name="prod_var_name[]" id="prod_var_name">

                </label>

                <label for="prod_var_price">
                    Preço:
                    <input type="number" step="any" name="prod_var_price[]" id="prod_var_price">

                </label>

                <label for="prod_var_active">
                    Promoção ativa:
                    <select name="prod_var_active[]" id="prod_var_active">
                        <option value="0">Desativado</option>
                        <option value="1">Ativo</option>
                    </select>

                </label>

                <label for="prod_var_promo_day">
                        Dia de Promoção:
                        <select name='prod_var_promo_day[]' >
                            <option value="0">Domingo</option>
                            <option value="1">Segunda-feira</option>
                            <option value="2">Terça-feira</option>
                            <option value="3">Quarta-feira</option>
                            <option value="4">Quinta-feira</option>
                            <option value="5">Sexta-feira</option>
                            <option value="6">Sábado</option>
                        </select>

                    </label>

                    <label for="prod_var_promo_price">
                    Preço de promoção:
                    <input type="number" step="any" name="prod_var_promo_price[]" id="prod_var_promo_price" value="">

                    </label>

                <label for="prod_var_status">
                Ativo:
                <select name="prod_var_status[]" id="prod_var_status">
                    <option value="0">Desativado</option>
                    <option value="1">Ativo</option>
                </select>

            </label>
                <hr>
            </div>
        </div>`;

        $(html).insertAfter('.form-group:last');
    }

    $(document).on('click', '#product_type', function(){

        if($(this).val() == "1"){
            
            addVariationTable();

        }else{
            $('#varTable').remove();
        }
    });

    $(document).on('click', '#excluir-variacao', function(){
        var id = $(this).attr('data-id');
        $.ajax({
            url: "/admin/products/variation/exclude/" + id,
            method: "GET",
            success: function(response){
                $('.variation[id="' + id + '"]').css('background-color', '#dd4b39');
                $('.variation[id="' + id + '"]').delay(1000).fadeOut(250);
                $('.variation[id="' + id + '"]').delay(1500).remove();
            },
            error: function(response){
                alert("Não foi possível excluir a variação, tente novamente!");
            }
        })
    });

     $(document).on('click', '#product_type', function(){

        if($(this).val() == "2"){
            
            $('#complementsUl').show();

        }else{

            $('#complementsUl').hide();
            
        }
    });

</script>