@extends('layouts.tubarao-delivery')


@section('content')
@include('admin.helpers._messages')

<?php

$day = date('w');
$hora = new DateTime("now");
$bool = false;
$desativado = false;
$horaFechamento = "";
$horaAbertura = "";
$data['cidade'] ?? $data['cidade'] = '';


function gerarSlug($str)
{
    $str = strtolower(utf8_decode($str));
    $i = 1;
    $str = strtr($str, utf8_decode('àáâãäåæçèéêëìíîïñòóôõöøùúûüýýÿÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÑÒÓÔÕÖØÙÚÛÜÝÝŸ'), 'aaaaaaaceeeeiiiinoooooouuuuyyyaaaaaaaceeeeiiiinoooooouuuuyyy');
    $str = preg_replace("/([^a-z0-9])/", '-', utf8_encode($str));
    while ($i > 0)
        $str = str_replace('--', '-', $str, $i);
    if (substr($str, -1) == '-')
        $str = substr($str, 0, -1);
    return $str;
}

?>

@foreach($configz as $config)
@if($day == 0 && $config->config_date == 'domingo')
@if($hora > new DateTime($config->config_time) && $hora < new DateTime($config->config_time_end) && $config->config_status != 0)
    <?php
    $bool = true;
    $status = true;
    ?>
    @endif
    <?php
    if ($config->config_status == 0) {
        $desativado = true;
    }
    $horaFechamento = new DateTime($config->config_time_end);
    $horaAbertura = new DateTime($config->config_time);
    ?>
    @elseif($day == 1 && $config->config_date == 'segunda-feira')
    @if($hora > new DateTime($config->config_time) && $hora < new DateTime($config->config_time_end) && $config->config_status != 0)
        <?php
        $bool = true;
        $status = true;

        ?>
        @endif
        <?php
        if ($config->config_status == 0) {
            $desativado = true;
        }
        $horaFechamento = new DateTime($config->config_time_end);
        $horaAbertura = new DateTime($config->config_time);
        ?>
        @elseif($day == 2 && $config->config_date == 'terca-feira')
        @if($hora > new DateTime($config->config_time) && $hora < new DateTime($config->config_time_end) && $config->config_status != 0)
            <?php
            $bool = true;
            $status = true;
            ?>
            @endif
            <?php
            if ($config->config_status == 0) {
                $desativado = true;
            }
            $horaFechamento = new DateTime($config->config_time_end);
            $horaAbertura = new DateTime($config->config_time);
            ?>
            @elseif($day == 3 && $config->config_date == 'quarta-feira')
            @if($hora > new DateTime($config->config_time) && $hora < new DateTime($config->config_time_end) && $config->config_status != 0)
                <?php
                $bool = true;
                $status = true;
                ?>
                @endif
                <?php
                if ($config->config_status == 0) {
                    $desativado = true;
                }
                $horaFechamento = new DateTime($config->config_time_end);
                $horaAbertura = new DateTime($config->config_time);
                ?>
                @elseif($day == 4 && $config->config_date == 'quinta-feira')
                @if($hora > new DateTime($config->config_time) && $hora < new DateTime($config->config_time_end) && $config->config_status != 0)
                    <?php
                    $bool = true;
                    $status = true;
                    ?>
                    @endif
                    <?php
                    if ($config->config_status == 0) {
                        $desativado = true;
                    }
                    $horaFechamento = new DateTime($config->config_time_end);
                    $horaAbertura = new DateTime($config->config_time);
                    ?>
                    @elseif($day == 5 && $config->config_date == 'sexta-feira')
                    @if($hora > new DateTime($config->config_time) && $hora < new DateTime($config->config_time_end) && $config->config_status != 0)
                        <?php
                        $bool = true;
                        $status = true;
                        ?>
                        @endif
                        <?php
                        if ($config->config_status == 0) {
                            $desativado = true;
                        }
                        $horaFechamento = new DateTime($config->config_time_end);
                        $horaAbertura = new DateTime($config->config_time);
                        ?>
                        @elseif($day == 6 && $config->config_date == 'sabado')
                        @if($hora > new DateTime($config->config_time) && $hora < new DateTime($config->config_time_end) && $config->config_status != 0)
                            <?php
                            $bool = true;
                            $status = true;
                            ?>
                            @endif
                            <?php
                            if ($config->config_status == 0) {
                                $desativado = true;
                            }
                            $horaFechamento = new DateTime($config->config_time_end);
                            $horaAbertura = new DateTime($config->config_time);
                            ?>
                            @endif
                            @endforeach
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


        <h2>Escolha uma <strong>Loja</strong> abaixo para começar:</h2>

        <div class="inicio__form clearfix">

            <div class="row justify-content-center">
                @foreach($lojas as $loja)
                <!-- <form action="/client/area-do-cliente" method="POST"> -->
                <div class="col-md-6 col-lg-4">

                    <div class="loja-escolha__card">
                        {{ csrf_field() }}

                        <h3>{{ $loja['nome_loja'] }}</h3>

                        <img src="{{ asset('/storage/media/loja/' . $loja['loja_pic_src']) }}" alt="{{ $loja['nome_loja'] }}" class="btn" id="{{ $loja['id'] }}" value="{{ $loja['nome_loja'] }}" >

                        @if($loja['configs']['bool'] != false)

                        <section class="loja-escolha__info">
                            <?php $time = new DateTime($loja['time']); ?>
                           <p> A taxa de entrega para
                            <br/> o Bairro <strong>{{ $loja['neighborhood'] }}</strong>  em <strong> {{ $data['cidade'] }}</strong>  é <br/><br/>de  <strong>R$ {{ number_format($loja['price'], 2, ',', '.') }}</strong> | Tempo Médio de Espera<strong> {{ $time->format('H:i') }}</strong></p>

                        </section>
                        <input type="hidden" name="id-loja-{{ $loja['id'] }}" value="{{ $loja['id'] }}">

                        <input type="hidden" name="cep-id-{{ $loja['id'] }}" value="{{ $loja['tax_id'] }}">

                        <input type="hidden" name="price-{{ $loja['id'] }}" value="{{ $loja['price'] }}">

                        <input type="hidden" name="cidade-{{ $loja['id'] }}" value="{{ $data['cidade'] }}">

                        <input type="hidden" name="time-{{ $loja['id'] }}" value="{{ $loja['time'] }}">

                        <input type="hidden" name="neigh-{{ $loja['id'] }}" value="{{ $loja['neighborhood'] }}">

                        <input type="button" class="btn btn-loja" id="{{ $loja['id'] }}" value="{{ $loja['nome_loja'] }}"class="btn">

                        @else

                        <section class="loja-escolha__info">
                            <?php $time = new DateTime($loja['time']); ?>
                            <p><span>A loja encontra-se fechada no momento! :(</strong></span><br/></p><br/><br/>
                            <p>Mas a taxa de entrega para
                            <br/> o Bairro <strong>{{ $loja['neighborhood'] }}</strong>  em <strong> {{ $data['cidade'] }}</strong>  é <br/><br/>de  <strong>R$ {{ number_format($loja['price'], 2, ',', '.') }}</strong> | Tempo Médio de Espera<strong> {{ $time->format('H:i') }}</strong></p>
</br>
                        <input type="hidden" name="id-loja-{{ $loja['id'] }}" value="{{ $loja['id'] }}">

                        <input type="hidden" name="cep-id-{{ $loja['id'] }}" value="{{ $loja['tax_id'] }}">

                        <input type="hidden" name="price-{{ $loja['id'] }}" value="{{ $loja['price'] }}">

                        <input type="hidden" name="cidade-{{ $loja['id'] }}" value="{{ $data['cidade'] }}">

                        <input type="hidden" name="time-{{ $loja['id'] }}" value="{{ $loja['time'] }}">

                        <input type="hidden" name="neigh-{{ $loja['id'] }}" value="{{ $loja['neighborhood'] }}">
                        
                        <input type="button" class="btn" id="Finalizar-pedido" value="Agendar pedido na {{ $loja['nome_loja'] }}"class="btn">
                        </section>
                        @endif

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
                                    <p class="alert">Atendimento <strong>{{ $shopName->nome_loja }}</strong> das <span>{{ date_format($horaAbertura, "H:i") }}</span> às <span>{{ date_format($horaFechamento, "H:i") }}</span>, agende seu pedido!</p>
                                    <label for="agendar-data">Pedido agendado para:</label>
                                    <input type="date" name="agendar-data" id="agendar-data" Disabled>
                                    <label for="agendar-hora">Digite a hora de entrega (<strong style="font-weight: bold;">a partir das {{ date_format($horaAbertura, "H:i") }}hrs</strong>): </label>
                                    <input type="time" name="agendar-hora" id="agendar-hora">
                                    <input style="background-image: url({{ asset('/img/continuar.png') }}" class="btn" value="Continuar" id="continuar-agendamento" type="button" />
                                </div>

                                <script>
                                    var dateControl = document.querySelector('#agendar-data');
                                    dateControl.value = '2018-06-01';
                                </script>

                            </div>
    <script>
        $(document.body).on('click', '.btn-loja', function() {

           
            var id = $(this).attr('id'),
                loja = $('input[name="id-loja-' + id + '"]').val(),
                cidade = $('input[name="cidade' + id + '"]').val(),
                cep = $('input[name="cep-id-' + id + '"]').val(),
                tx = $('input[name="price-' + id + '"]').val(),
                tempo = $('input[name="time-' + id + '"]').val(),
                bairro = $('input[name="neigh-' + id + '"]').val(),
                data = JSON.parse(localStorage.getItem('entrega')),
                loja_id = {
                    loja_id: id
                };

                    
            localStorage.removeItem('agendamento_pedido');

                if (loja && cep) {

                data.taxa = tx;
                data.tempo + tempo;

                localStorage.setItem('loja_id', JSON.stringify(loja_id));

                localStorage.setItem('entrega', JSON.stringify(data));

                window.location = '/client/area-do-cliente';

            }
           
            
        });
        
        $(document).ready(function() {

                                    
                                    var timeIni = '<?php echo date_format($horaAbertura, "H:i"); ?>';
                                    var timeFin = '<?php echo date_format($horaFechamento, "H:i"); ?>';
                                    definirHorarios(timeIni, timeFin);

                                    jQuery(document.body).on('click', '.agendar-hora .x', function() {
                                        jQuery('.agendar-hora').css('display', 'none');
                                    });
                                    jQuery(document.body).on('click', '.agendar-hora .bg', function() {
                                        jQuery('.agendar-hora').css('display', 'none');
                                    });

                                    jQuery(document.body).on('click', '#continuar-agendamento', function() {
                                        agendamento();
                                    });

                                  var time = pegarHora();
                                        var min = jQuery('#agendar-hora').attr('min');
                                        var max = jQuery('#agendar-hora').attr('max');


                                        var timeSplit = time.split(":");
                                        var minSplit = min.split(":");
                                        var maxSplit = max.split(":");

                                        var abertura = new Date(2018, 01, 01, minSplit[0], minSplit[1]);
                                        var fechamento = new Date(2018, 01, 01, maxSplit[0], maxSplit[1]);
                                        var horaAtual = new Date(2018, 01, 01, timeSplit[0], timeSplit[1]);
                                        
                                  if(horaAtual < abertura || horaAtual > fechamento) {
                                  var link = document.getElementById('Finalizar-pedido');
                                  link.click();
                                  }

                                });
                                                                $(document.body).on('click', '#Finalizar-pedido', function() {
                                                                    
                                                                    
                                                                    
                var id = $(this).attr('id'),
                loja = $('input[name="id-loja-' + id + '"]').val(),
                cidade = $('input[name="cidade' + id + '"]').val(),
                cep = $('input[name="cep-id-' + id + '"]').val(),
                tx = $('input[name="price-' + id + '"]').val(),
                tempo = $('input[name="time-' + id + '"]').val(),
                bairro = $('input[name="neigh-' + id + '"]').val(),
                data = JSON.parse(localStorage.getItem('entrega')),
                loja_id = {
                    loja_id: {{$loja['id']}}
                };
                                                                    
                                                                   

            
    //   data.taxa = tx;
    //             data.tempo + tempo;

                localStorage.setItem('loja_id',JSON.stringify( loja_id ));

               // localStorage.setItem('entrega', JSON.stringify(data));
                
                                    
                                        var time = pegarHora();
                                        var min = jQuery('#agendar-hora').attr('min');
                                        var max = jQuery('#agendar-hora').attr('max');


                                        var timeSplit = time.split(":");
                                        var minSplit = min.split(":");
                                        var maxSplit = max.split(":");

                                        var abertura = new Date(2018, 01, 01, minSplit[0], minSplit[1]);
                                        var fechamento = new Date(2018, 01, 01, maxSplit[0], maxSplit[1]);
                                        var horaAtual = new Date(2018, 01, 01, timeSplit[0], timeSplit[1]);

                                        if (abertura > fechamento) {
                                            fechamento.setDate(fechamento.getDate() + 1);
                                            if (horaAtual < abertura) {
                                                horaAtual.setDate(horaAtual.getDate() + 1);
                                            }
                                        }

                                        if (horaAtual >= abertura && horaAtual <= fechamento) {
                                            <?php
                                            if (!$banner->isEmpty()) {
                                                ?>
                                                // getPromoBanner();
                                            <?php
                                        } else {
                                            ?>
                                                window.location = "/client/area-do-cliente";
                                            <?php
                                        }
                                        ?>
                                        } else {
                                          
                                           
                                                jQuery(".agendar-hora").fadeIn(100);
                                           
                                        }
                                

                                });
                                $(document).on('click', '.prosseguir-pedido', function() {
                                    if (agendamentoBool) {

                                        $('.oferta.ativo').fadeOut(100);
                                        $('.agendar-hora').fadeIn(100);

                                    } else {

                                        window.location = "/delivery/identificacao";

                                    }

                                });
                                
    </script>

    
    @endsection