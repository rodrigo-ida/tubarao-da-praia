@extends('layouts.admin')

@section('content')
<style>
body {font-family: Arial, Helvetica, sans-serif;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 9999; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;c
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
  background-color: #fefefe;
  margin: auto;
  padding: 20px;
  border: 1px solid #888;
  width: 80%;
  z-index:9999;
}

/* The Close Button */
.close {
  color: #aaaaaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #000;
  text-decoration: none;
  cursor: pointer;
}
</style>

@if($caixaAberto)

<h1>Valor no Caixa</h1>


                  
                  {{"Total" ." : R$". $caixaToday}}</br>
                        

 {!! Form::model(null, ['route' => ['admin.cashier.storeP'], 'files' => false]) !!}
<div class="form-group col-md-6">

    {{ Form::label('Nome', 'Nome Cliente')}}
    {{ Form::text('name_product', null,  ['class' => 'form-control','id' => 'search']) }}

</div>
<!--<div id="prod-preco" class="form-group  col-md-6">-->

    <!--<label for="Preço do Produto">Preço (R$)</label>-->

    <!--{{ Form::number('price_product', null,  ['class' => 'form-control', 'step' => 'any']) }}-->

    <!-- <p><strong>Se o produto for variavél, o preço acima será "à partir de".</strong></p><strong> -->

    <!--</strong>-->
<!--</div>-->
<div class="form-group col-md-6">
    <label for="Preço do Produto">Produto </label></br>
 
   <select name="Price" id="cars" onchange="myFunction()">
@foreach($prodK as $prodKT)

  <option data-id='{{$prodKT['id']}}' value={{$prodKT['price_product']}}>{{$prodKT['name_product']}}</option>
   
  
  

@endforeach
</select>

<input  id="otherdata" name="idProd" type="hidden" value = {{$prodK[0]['id']}}> 
</div>


<script>    
    
  function myFunction() {
  var x = document.getElementById("cars");
  
  
    var y = document.getElementById("otherdata");
  
    y.value = $(x).find(':selected').data('id');
  
 
}

</script>
<div class="form-group col-md-12">



    {{ Form::label('Observação') }}

    {{ Form::text('obs', null, ['class' => 'form-control']) }}



    <br>
</div>
   <div class="box-footer">


        {{ Form::submit('Criar', ['class' => 'btn btn-success']) }}

        <a href="{{ route('admin.products.index') }}" class="btn btn-default">Cancelar</a>

    </div>
     <input type="button" id="cashierOpen" class="btn btn-info" value="Suprimento">
     <input type="button" id="cashierSangria" class="btn btn-info" value="Sangria">
   </br>
     

    <!-- box-footer -->

    {!! Form::close() !!}
     {!! Form::model(null, ['route' => ['admin.cashier.storeD'], 'files' => false]) !!}
 {{ Form::submit('Fechar caixa', ['class' => 'btn btn-success']) }}
 {!! Form::close() !!}







@else 

<h1>CAIXA FECHADO</h1>
<!--{!! Form::model(null, ['route' => ['admin.cashier.storeC'], 'files' => false]) !!}-->
<!-- {{ Form::submit('Abrir caixa', ['class' => 'btn btn-success']) }}-->
<!-- {!! Form::close() !!}-->
 <input type="button" id="cashierOpen" class="btn btn-info" value="Abrir Caixa">
 
 
@endif



<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    {!! Form::model(null, ['route' => ['admin.cashier.store'], 'files' => false]) !!}
    {{ Form::label('Conta de Destino', 'Conta de Destino')}}
    {{ Form::text('conta', null,  ['class' => 'form-control']) }}
     {{ Form::label('Valor') }}
     {{ Form::number('valor', null,  ['class' => 'form-control', 'step' => 'any']) }}
     {{ Form::label('Forma de Pagamento') }}
    {{ Form::select('tipo', array('Dinheiro' => 'Dinheiro', 'Debito' => 'Debito', 'Credito' => 'Credito' )) }}
   </br>
    {{ Form::label('Observacao', 'Observacao')}}
    {{ Form::hidden('acao', 'suprimento') }}
    {{ Form::text('obs', null,  ['class' => 'form-control']) }}
     {{ Form::submit('Criar', ['class' => 'btn btn-success']) }}
     {!! Form::close() !!}
  </div>

</div>








<div id="myModalSangria" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    {!! Form::model(null, ['route' => ['admin.cashier.store'], 'files' => false]) !!}
    {{ Form::label('Conta de Destino', 'Conta de Destino')}}
    {{ Form::text('conta', null,  ['class' => 'form-control']) }}
     {{ Form::label('Valor') }}
     {{ Form::number('valor', null,  ['class' => 'form-control', 'step' => 'any']) }}
     {{ Form::label('Forma de Pagamento') }}
    {{ Form::select('tipo', array('Dinheiro' => 'Dinheiro', 'Debito' => 'Debito', 'Credito' => 'Credito' )) }}
   </br>
    {{ Form::label('Observacao', 'Observacao')}}
    {{ Form::hidden('acao', 'sangria') }}
    {{ Form::text('obs', null,  ['class' => 'form-control']) }}
     {{ Form::submit('Criar', ['class' => 'btn btn-success']) }}
     {!! Form::close() !!}
  </div>

</div>






<div id="myModalAbertura" class="modal"> 

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span> 
    <h2>Valor de abertura de caixa</h2>
    {!! Form::model(null, ['route' => ['admin.cashier.storeC'], 'files' => false]) !!}
    {{ Form::label('Conta de Destino', 'Conta de Destino')}}
    {{ Form::text('conta', null,  ['class' => 'form-control']) }}
     {{ Form::label('Valor') }}
     {{ Form::number('valor', null,  ['class' => 'form-control', 'step' => 'any']) }}
     {{ Form::label('Forma de Pagamento') }}
    {{ Form::select('tipo', array('Dinheiro' => 'Dinheiro', 'Debito' => 'Debito', 'Credito' => 'Credito' )) }}
   </br>
    {{ Form::label('Observacao', 'Observacao')}}
    {{ Form::hidden('acao', 'suprimento') }}
    {{ Form::text('obs', null,  ['class' => 'form-control']) }}
     {{ Form::submit('Criar', ['class' => 'btn btn-success']) }}
     {!! Form::close() !!}
  </div>

</div>




<script>
// Get the modal
var modal = document.getElementById("myModal");
var modalSangria = document.getElementById("myModalSangria");

var modalOpen = document.getElementById("myModalAbertura");

// Get the button that opens the modal
var btn = document.getElementById("cashierOpen");
var btnS = document.getElementById("cashierSangria");
var btnO = document.getElementById("cashierOpen");


// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var span1 = document.getElementsByClassName("close")[1];
var span2 = document.getElementsByClassName("close")[2];


// When the user clicks the button, open the modal 
@if($caixaAberto)

btn.onclick = function() {
  modal.style.display = "block";
}
btnS.onclick = function() {
  modalSangria.style.display = "block";
}

@endif
btnO.onclick = function() {
  modalOpen.style.display = "block";
}


// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modalOpen.style.display = "none";
  modal.style.display = "none";
  
}
span1.onclick = function() {
  modalSangria.style.display = "none";
}
span2.onclick = function() {
  modalOpen.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal || event.target == modalSangria ) {
    modal.style.display = "none";
    modalSangria.style.display = "none";
  }
  
}





//Nova sessao testes live search






















</script>

@endsection