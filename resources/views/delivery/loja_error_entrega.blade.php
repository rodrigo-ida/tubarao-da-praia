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
        padding-left: 0 !important;
        padding-right: 0 !important;
    }
    
    footer {
        position: absolute;
        bottom: 0;
        width: 100vw;
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


//var_dump($lojas);

//var_dump($data);
?>

<div id="div-inicio" class="inicio clearfix" style="background: none;">

    <div class="lightbox">
        <div class="lightbox__bg"></div>
        <div class="lightbox__semcep">
            <div class="x">X</div>
            <div id="pog">
                <div class="titulo">Preencha seu endereço abaixo</div>
                <label for="uf">Estado</label><br />
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

                <label for="cidade">Cidade</label><br />
                <input type="text" name="cidade" id="cidade" value="Praia Grande" required disabled />

                <label for="endereco">Endereço</label><br />
                <input type="text" name="endereco" id="endereco" required />

                <input type="button" id="enviar" value="PESQUISAR CEP" />
            </div>
        </div>
    </div>

    <!-- <div class="inicio__novidade">NOVIDADE</div>
    <h2>Tubarão da Praia Delivery</h2>--> <br><br>
    <div class="container loja-escolha ">


        <h2>Endereço fora dos limites de entrega</h2>

        <div class="inicio__form clearfix">

            <div class="row justify-content-center">
                @foreach($lojas as $loja)
                <!-- <form action="/client/area-do-cliente" method="POST"> -->
                <div class="col-md-6 col-lg-4">

                    <div class="loja-escolha__card">
                        {{ csrf_field() }}

                        <h3>Nao entregamos no seu endereço</h3>

                       

                       

                        <section class="loja-escolha__info">
                            
                            <p><span>A loja encontra-se fechada no momento! :(</strong></span><br/></p><br/><br/>
                            
                           
                      
                        </section>
                        

                    </div>
                </div>
                <!-- </form> -->

                @endforeach
            </div>
        </div>
    </div>
    
<div class="agendar-hora">

                                <div class="bg"></div>

                                <div class="conteudo">
                                    <div class="x">X</div>
                                    
                                    <h3>Gostaria de continuar e agendar seu pedido?</h3>
                                   
                                    <label for="agendar-data">Pedido agendado para:</label>
                                    <input type="date" name="agendar-data" id="agendar-data" Disabled>
                                
                                    <input type="time" name="agendar-hora" id="agendar-hora">
                                    <input style="background-image: url({{ asset('/img/continuar.png') }}" class="btn" value="Continuar" id="continuar-agendamento" type="button" />
                                </div>

                                <script>
                                    var dateControl = document.querySelector('#agendar-data');
                                    dateControl.value = '2018-06-01';
                                </script>

                            </div>
    
    
    @endsection