@extends('layouts.tubarao-delivery')


@section('content')
@include('admin.helpers._messages')
<style>
    .flash-message {
        margin-top: 15px;
    }
    .container:nth-of-type(2) {
        max-width: 1700px !important;
        margin: 0 auto !important;
        padding-left: 0  !important;
        padding-right: 0 !important;
    }
</style>

<?php

function toAscii($str, $replace = array(), $delimiter = '-')
{
    if (!empty($replace)) {
        $str = str_replace((array)$replace, ' ', $str);
    }

    $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
    $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
    $clean = strtolower(trim($clean, '-'));
    $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

    return $clean;
}

?>

<div id="div-inicio" class="inicio clearfix" style="background: none;">

<div class="lightbox">
    <div class="lightbox__bg"></div>
    <div class="lightbox__semcep">
        <div class="x">X</div>
        <div id="pog">
            <div class="titulo">Preencha seu endereço abaixo</div>
            <label for="uf">Estado</label><br/>
            <select id="uf" required disabled>
                <!-- <option value="">UF</option>
                <option value="AC">AC</option>
                <option value="AL">AL</option>
                <option value="AP">AP</option>
                <option value="AM">AM</option>
                <option value="BA">BA</option>
                <option value="CE">CE</option>
                <option value="DF">DF</option>
                <option value="ES">ES</option>
                <option value="GO">GO</option>
                <option value="MA">MA</option>
                <option value="MS">MS</option>
                <option value="MT">MT</option>
                <option value="MG">MG</option>
                <option value="PA">PA</option>
                <option value="PB">PB</option>
                <option value="PR">PR</option>
                <option value="PE">PE</option>
                <option value="PI">PI</option>
                <option value="RJ">RJ</option>
                <option value="RN">RN</option>
                <option value="RS">RS</option>
                <option value="RO">RO</option>
                <option value="RR">RR</option>
                <option value="SC">SC</option> -->
                <option value="SP">SP</option>
                <!-- <option value="SE">SE</option>
                <option value="TO">TO</option> -->
            </select>

            <label for="cidade">Cidade</label><br/>
            <input type="text" name="cidade" id="cidade" value="Praia Grande" required disabled />

            <label for="endereco">Endereço</label><br/>
            <input type="text" name="endereco" id="endereco" required />

            <input type="button" id="enviar" value="PESQUISAR CEP"/>
        </div>
    </div>
</div>

<!-- <div class="inicio__novidade">NOVIDADE</div>
    <h2>Tubarão da Praia Delivery</h2>--> <br><br>
        <p>Escolha uma <strong>Loja</strong> abaixo para começar:</p> 
            <div class="inicio__form loja-escolha clearfix">
                @foreach($lojas as $loja)
                <form action="/delivery/loja-{{ toAscii($loja['nome_loja']) }}" method="GET">

                    <div>

                        {{ csrf_field() }}

                        <img src="{{ asset('/storage/media/loja/' . $loja['loja_pic_src']) }}" alt="{{ $loja['nome_loja'] }}">

                        <input type="hidden" name="id-loja" value="{{ $loja['id'] }}">

                        <input type="hidden" name="cep-id" value="{{ $loja['tax_id'] }}">

                        <input type="submit" class="btn btn-loja" value="{{ $loja['nome_loja'] }}" class="btn">

                    </div>

                </form>
                
                @endforeach
            </div>

@endsection