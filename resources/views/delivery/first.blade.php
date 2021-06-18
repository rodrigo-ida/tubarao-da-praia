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
    .inicio {
  min-height: calc(100vh - 100px);
  text-align: center;
  padding-left: 12px;
  padding-right: 12px;
  font-family: 'Oswald', sans-serif;
  padding-bottom: 35px;
  background-image: url('../img/comida-japonesa.jpg'), url('../img/tigela-açai-granola.png');
  background-repeat: no-repeat;
  background-position: right bottom, left bottom;
  background-size: 420px, 530px;
  max-width: 1700px;
  margin: 0 auto;
}

@media (min-width: 1700px) {
  .inicio {
    background-size: 520px, 630px;
  }
}

@media (max-width: 1030px) {
  .inicio {
    background-size: 294px, 379px
  }
}

@media (max-width: 942px) {
  .inicio {
    background-size: 315px, 400px;
  }
}

@media (max-width: 712px) {
  .inicio {
    background-size: 300px, 370px;
  }
}

@media (max-width: 612px) {
  .inicio {
    background-size: 45%, 55%;
background-position: 155px bottom,
-96px bottom;
background-size: 83%,
90%;
}
}


.inicio__novidade {
  visibility: hidden;
  color: #ffffff;
  background-color: #800b58;
  display: inline-block;
  padding: 15px 35px;
  line-height: 65px;
  font-size: 70px;
  border-radius: 50px;
  font-weight: 500;
  margin-top: 140px;
}

@media (max-width: 1400px) {
  .inicio__novidade {
    margin-top: 12px;
    padding: 5px 35px;
    font-size: 60px;
  }
}

.inicio h2 {
  color: #800b58;
  font-weight: 600;
  font-size: 80px;
  margin-top: 15px;
  padding-bottom: 20px;
}

.inicio p {
  color: #757575;
  display: block;
  font-size: 32px;
  font-weight: 300;
  font-family: 'Open sans';
}

.inicio__form {
  margin-top: 40px;
  max-width: 555px;
  margin-left: auto;
  margin-right: auto;
}

.inicio__cep {
  background-color: #f7f7f7;
  border: solid 2px #f7f7f7;
  -webkit-box-shadow: 0 4px 10px rgba(0, 0, 0, 0.07);
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.07);
  font-size: 20px;
  width: calc(100% - 95px);
  padding-left: 35px;
  padding-right: 70px;
  -webkit-box-sizing: border-box;
  box-sizing: border-box;
  border-top-left-radius: 35px;
  border-bottom-left-radius: 35px;
  outline: none;
  height: 66px;
  display: block;
  float: left;
  font-family: 'Open sans', sans-serif;
}

.inicio__cep:focus {
  border: solid 2px #800b58;
}

.inicio__enviar {
  font-family: 'Oswald', sans-serif;
  outline: none;
  display: block;
  float: left;
  height: 66px;
  color: #fdec01;
  background-color: #800b58;
  width: 130px;
  border-radius: 35px;
  border: solid 2px #800b58;
  font-size: 28px;
  margin-left: -35px;
  cursor: pointer;
  font-weight: 300;
}

@media (max-width: 500px) {
  .inicio__cep {
    width: 100%;
    height: 52px;
    float: none;
    border-top-right-radius: 35px;
    border-bottom-right-radius: 35px;
  }

  .inicio__enviar {
    width: 55%;
    float: none;
    margin-left: auto;
    margin-right: auto;
    margin-top: 12px;
    height: 52px;
  }
}

.inicio strong {
  font-weight: 600;
}

.inicio span {
  display: block;
  text-align: center;
  color: #757575;
  padding: 16px;
  font-size: 18px;
}

.inicio .buscar {
  color: #800b58;
  font-weight: 500;
  font-size: 20px;
  text-decoration: underline;
}

@media (max-width: 1330px) {
  .inicio h2 {
    font-size: 70px;
  }

}

@media (max-width: 1170px) {
  .inicio {
    width: 100%;
  }
}

@media (max-width: 760px) {
  .inicio h2 {
    font-size: 40px;
  }

  .inicio__novidade {
    margin-top: 12px;
    padding: 0px 25px;
    font-size: 40px;
  }

  .inicio p {
    font-size: 20px;
  }
    
</style>

<div id="div-inicio" class="inicio clearfix" style="background-image: url({{ asset('../img/tigela-acai-granola.png')}}), url({{asset('../img/comida-japonesa.jpg')}});">

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

    <div class="inicio__novidade">NOVIDADE</div>
    <h2>Tubarão da Praia Delivery</h2>
    <p>Digite seu <strong>CEP</strong> abaixo para verificar a disponibilidade:</p>
    <div class="inicio__form clearfix">
        <input name="cep" class="inicio__cep" placeholder="Seu CEP" type="text">
        <input class="inicio__enviar" type="button" value="Pesquisar">
    </div>
    <p class="cep-error" style="font-size: 18px; color: red; display: none;">CEP inválido, tente novamente.</p>
    <span>ou</span>
    <div class="buscar">Buscar CEP</div>
    <div id="lojas-input">
    </div>
</div>

@endsection

@section('footer-scripts')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">
    function parseCEP(cep) {
        return cep.replace('-', '');
    }
</script>

<script type="text/javascript">
    var html = '';

    $(document.body).on('click', '.inicio__enviar', function() {

        var cep = parseCEP($('input[name="cep"]').val());

        var html = '';

        if (cep.length == 8) {
            $('.list-group').remove();

            addLoadDiv();

            getDeliveryCepsConsulta(cep);

            setTimeout(function() {

                removeLoadDiv();

            }, 5000);

        } else {
            $('p.cep-error').show();

            setTimeout(function() {

                $('p.cep-error').hide();

            }, 3500);
        }

    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        
        window.location.href = "https://pedidos.tubaraodapraia.com.br/delivery/";

        // if(localStorage.getItem('prods')) {
        //     localStorage.removeItem('prods');
        // }

        $(document.body).on('click', '#btn-loja', function() {

            var ent = JSON.parse(localStorage.getItem('entrega'));

            var id = $(this).attr('data-id');

            var tx = $(this).attr('tx');

            var name = $(this).val();

            var time = $(this).attr('data-time');

            var data = {
                loja_id: id,
                nome: name
            };

            localStorage.setItem('loja_id', JSON.stringify(data));

            var data = {
                taxa: tx,
                cidade: ent.cidade,
                cep: ent.cep,
                logradouro: ent.logradouro,
                bairro: ent.bairro,
                uf: ent.uf,
                tempo: time
            }

            localStorage.removeItem('entrega');

            localStorage.setItem('entrega', JSON.stringify(data));

        })

        var loja_id = JSON.parse(localStorage.getItem('loja_id'));

        if (verifyStorageTime()) {

            // var pedido = `
            //     <div class="continuar-compra ativo">

            //     <div class="bg"></div>
            //     <div class="conteudo">
            //     <div class="x">X</div>
            //     <h3>
            //     Notamos que vc não
            //     finalizou sua compra...
            //     </h3>
            //     <p>
            //     Gostaria de continuar de onde você parou ou fazer um novo pedido?
            //     </p>
            //     <div>
            //     <input value="Novo Pedido" id="novopedido" type="button">
            //     <form action="/delivery/loja" method="POST">
            //         <input type="hidden" name="id-loja" value="${loja_id.loja_id}" />
            //         <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            //         <input style="background-image: url({{ asset('/img/continuar.png') }}" value="Continuar" id="continuarpedido" type="submit">
            //     </form>
            //     </div>
            //     </div>

            //     </div>
            //     `;

            localStorage.removeItem('prods');
        }

        var prods = localStorage.getItem('prods');
        var entrega = localStorage.getItem('entrega');

        // if(prods && loja_id && entrega){
        //     jQuery('header').after(pedido);
        // }

        jQuery(document.body).on('click', '.continuar-compra .x', function() {
            localStorage.removeItem('prods');
            localStorage.removeItem('loja_id');
            localStorage.removeItem('entrega');
            localStorage.removeItem('obs');
            jQuery('.continuar-compra').remove();
        });
        jQuery(document.body).on('click', '.continuar-compra .bg', function() {
            localStorage.removeItem('prods');
            localStorage.removeItem('loja_id');
            localStorage.removeItem('entrega');
            localStorage.removeItem('obs');
            jQuery('.continuar-compra').remove();
        });
        jQuery(document.body).on('click', '#novopedido', function() {
            localStorage.removeItem('prods');
            localStorage.removeItem('loja_id');
            localStorage.removeItem('entrega');
            localStorage.removeItem('obs');
            jQuery('.continuar-compra').remove();
        });
        jQuery(document.body).on('click', '#continuarpedido', function() {
            window.location = "/delivery/" + loja_id.loja_id;
        });

    });
</script>

<script>
    jQuery('.buscar').click(function() {
        jQuery('.lightbox').toggleClass('ativo');
        $('#pog').css('display', '');
        $('#ceps-pesquisados').remove();
    });
    jQuery('.lightbox__bg').click(function() {
        jQuery('.lightbox').toggleClass('ativo');
    });
    jQuery('.lightbox__semcep .x').click(function() {
        jQuery('.lightbox').toggleClass('ativo');
    });

    jQuery('#enviar').click(function() {
        var uf = jQuery('#uf').val();
        var cidade = jQuery('#cidade').val();
        var log = jQuery('#endereco').val();

        addLoadDiv();

        if (log.length != 0) {

            getCepsBySearch(uf, cidade, log)

        }

        removeLoadDiv();

    });
</script>

<script type="text/javascript">
    $(document.body).on('click', '#log-cep', function() {

        var cep = parseCEP($(this).attr('data-cep'));

        removeDivs();

        if (cep.length == 8) {

            addLoadDiv();

            getDeliveryCepsConsulta(cep);

            removeLoadDiv();

        } else if (cep.length < 8) {

            $('p.cep-error').show();

            setTimeout(function() {

                $('p.cep-error').hide();

            }, 3500);
        }
    });

    $(document).on('click', '.close', function() {
        $('.flash-message').remove();
    });

    function verifyStorageTime() {

        var local = localStorage.getItem('time');

        var date2 = new Date(local);

        var timeDiff = Math.abs(local - Date.now());

        var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

        if (diffDays >= 2) {

            return false;

        }

        return true;

    }
</script>

@endsection