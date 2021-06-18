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

        <h3 class="box-title">Criar novo produto</h3>

        <div class="box-tools pull-right">

        </div>

        <!-- /.box-tools -->

    </div>

    <!-- /.box-header -->

    @if(Session::get('msg-success'))

    <div class="alert alert-success" style="max-width: 90%; margin: 0 auto; margin-top: 10px;" role="alert">
        O produto <strong>{{ Session::get('msg-success') }}</strong> foi criado com sucesso!
    </div>

    @endif

    {!! Form::model(null, ['route' => ['admin.products.store'], 'files' => true]) !!}

    <div class="box-body">



        <!-- validation errors messages -->

        @include('admin.errors._check')



        <!-- offer form -->

        @include('admin.products._form')



    </div>

    <!-- /.box-body -->

    <div class="box-footer">


        {{ Form::submit('Criar', ['class' => 'btn btn-success']) }}

        <a href="{{ route('admin.products.index') }}" class="btn btn-default">Cancelar</a>

    </div>

    <!-- box-footer -->

    {!! Form::close() !!}

</div>

<!-- /.box -->

@endsection

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>



<script type="text/javascript">
    $(document).on('click', '#add-variation', function() {

        var html = `

        <div class="variation row">
        <div class="form-group col-md-4">


            <label for="prod_var_name">

            Nome:</label>

            <input type="text" class="form-control" name="prod_var_name[]" id="prod_var_name">
        </div>


    


        <div class="form-group col-md-4">

    <label for="prod_var_price">

        Preço: </label>

        <input type="number" class="form-control" step="any" name="prod_var_price[]" id="prod_var_price">

    </div>

    <div class="form-group col-md-4">

<label for="prod_var_status">

Ativo:</label>

<select class="form-control" name="prod_var_status[]" id="prod_var_status">

<option value="0">Desativado</option>

<option value="1">Ativo</option>

</select>
</div>

   
    <div class="form-group col-md-4">
            

    <label for="prod_var_active">

        Promoção ativa:  </label>

        <select class="form-control" name="prod_var_active[]" id="prod_var_active">

            <option value="0">Desativado</option>

            <option value="1">Ativo</option>

        </select>
    </div>



  


    <div class="form-group col-md-4">

    <label for="prod_var_promo_day">

            Dia de Promoção:  </label>

            <select class="form-control" name='prod_var_promo_day[]' >

                <option value="0">Domingo</option>

                <option value="1">Segunda-feira</option>

                <option value="2">Terça-feira</option>

                <option value="3">Quarta-feira</option>

                <option value="4">Quinta-feira</option>

                <option value="5">Sexta-feira</option>

                <option value="6">Sábado</option>

            </select>

        </div>


      

        <div class="form-group col-md-4">


        <label for="prod_var_promo_price">

        Preço de promoção:</label>

        <input class="form-control" type="number" step="any" name="prod_var_promo_price[]" id="prod_var_promo_price" value="">

    </div>

    <hr>

        `;

        $(html).insertAfter('.variation:last');

    });



    function addVariationTable() {

        var html = "";

        html = `<div id="varTable" class="form-group">

<div class="box-header with-border">

<h3 class="box-title">

Variações
</br>
<input type="button" id="add-variation" style="margin-top: 10px;" class="btn btn-info" value="+ Adiciona Variação">
</h3>


</div>

<div class="variation row">
<div class="form-group col-md-4">


    <label for="prod_var_name">

    Nome:</label>

    <input type="text" class="form-control" name="prod_var_name[]" id="prod_var_name">
</div>





<div class="form-group col-md-4">

<label for="prod_var_price">

Preço: </label>

<input type="number" class="form-control" step="any" name="prod_var_price[]" id="prod_var_price">

</div>

<div class="form-group col-md-4">

<label for="prod_var_status">

Ativo:</label>

<select class="form-control" name="prod_var_status[]" id="prod_var_status">

<option value="0">Desativado</option>

<option value="1">Ativo</option>

</select>
</div>


<div class="form-group col-md-4">
    

<label for="prod_var_active">

Promoção ativa:  </label>

<select class="form-control" name="prod_var_active[]" id="prod_var_active">

    <option value="0">Desativado</option>

    <option value="1">Ativo</option>

</select>
</div>






<div class="form-group col-md-4">

<label for="prod_var_promo_day">

    Dia de Promoção:  </label>

    <select class="form-control" name='prod_var_promo_day[]' >

        <option value="0">Domingo</option>

        <option value="1">Segunda-feira</option>

        <option value="2">Terça-feira</option>

        <option value="3">Quarta-feira</option>

        <option value="4">Quinta-feira</option>

        <option value="5">Sexta-feira</option>

        <option value="6">Sábado</option>

    </select>

</div>




<div class="form-group col-md-4">


<label for="prod_var_promo_price">

Preço de promoção:</label>

<input class="form-control" type="number" step="any" name="prod_var_promo_price[]" id="prod_var_promo_price" value="">

</div>

<hr>

</div>

</div>`;



        $(html).insertAfter('.form-group:last');

    }



    $(document).on('click', 'input[name="product_type"]', function() {

        if ($('.variation').attr('id') != undefined) {
            return;
        }

        if ($(this).val() == "1") {



            addVariationTable();



        } else {



            $('#varTable').remove();



        }

    });



    $(document).on('click', 'input[name="product_type"]', function(event) {

        if ($('.variation').attr('id') != undefined) {
            $(this).attr('checked', false);
            alert('Exclua a variação antes de mudar o produto de tipo.');
            return;
        }

        if ($('.combo-variation').length >= 1) {
            event.preventDefault();
            return alert('Exclua as variações antes de prosseguir com a mudança do produto');
        }

        if ($(this).val() == "2") {



            $('#complementsUl').show();



        } else {



            $('#complementsUl').hide();



        }

        if ($('#comboTable').css('display') == 'block' && $(this).val() != '3') {
            $('#comboTable').remove();
        }

    });
</script>