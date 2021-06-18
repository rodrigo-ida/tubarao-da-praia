$(document.body).on("click", ".add-combo-prod", function () {
  getComboModal($(this).attr("id-produto"), $(this).attr("product-category") + " " + $(this).attr("name"), $(this).attr("price"));
});

jQuery(".modal-cep .buscar").click(function () {
  jQuery(".lightbox").toggleClass("ativo");
  $("#pog").css("display", "");
  $("#ceps-pesquisados").remove();
});
jQuery(".lightbox__bg").click(function () {
  jQuery(".lightbox").toggleClass("ativo");
});
jQuery(".lightbox__semcep .x").click(function () {
  jQuery(".lightbox").toggleClass("ativo");
});

jQuery("#enviar").click(function () {
  var uf = jQuery("#uf").val();
  var cidade = jQuery("#cidade").val();
  var log = jQuery("#endereco").val();

  addLoadDiv();

  if (log.length != 0) {
    getCepsBySearch(uf, cidade, log);
  }

  removeLoadDiv();
});

$(document.body).on("click", ".checkbox-combo-item", function (event) {
  var cat_id = $(this).attr("cat-id");

  var num_esc = $(this).attr("num_esc");

  if ($('.checkbox-combo-item[cat-id="' + cat_id + '"]:checked').length > num_esc) {
    event.preventDefault();
    alert("você já selecionou os sabores");
  }
});

$(document.body).on("click", ".checkbox-combo-item", function (event) {
  var cat_id = $(this).attr("cat-id");

  var num_esc = $(this).attr("num_esc");

  if ($('.checkbox-combo-item[cat-id="' + cat_id + '"]:checked').length > num_esc) {
    event.preventDefault();
    alert("você já selecionou os sabores");
  }
});

$(document.body).on("click", "#add-combo", function (event) {
  var comboSelected = [];
  var cats = [];
  var ids = [];

  $.each($("input.checkbox-combo-item:checked"), function (i, p) {
    cats.push($(this).attr("cat_id"));
  });

  for (let c of cats) {
    comboSelected[c] = $('.checkbox-combo-item[cat_id="' + c + '"]:checked').length;
  }

  $.each($("input.checkbox-combo-item:checked"), function (i, p) {
    ids.push($(this).attr("value"));
  });

  if (!verifyCombo(comboSelected)) {
    alert("Selecione todas as combinações, por favor!");
    return;
  }

  addComboProduct(JSON.parse(Base64Decode(localStorage.getItem("prods"))), ids, $(this).attr("prod_id"), $(this).attr("prod_name"), $(".compl-price-prod").text());
});

jQuery(".produtos__action").click(function () {
  jQuery(".produtos__lista").toggleClass("ativo");
  jQuery(".produtos__bg").toggleClass("ativo");
  if (jQuery(this).hasClass("active")) {
    jQuery(this).removeClass("active");
  } else {
    jQuery(this).addClass("active");
    if ($(this).css("display") == "none") $(this).css("display", "block");
  }
});
jQuery(".produtos__bg").click(function () {
  jQuery(".produtos__lista").toggleClass("ativo");
  jQuery(".produtos__bg").toggleClass("ativo");
  if (jQuery(".produtos__action").hasClass("active")) {
    jQuery(".produtos__action").removeClass("active");
  } else {
    jQuery(".produtos__action").addClass("active");
  }
});

jQuery(".continuar-compra .x").click(function () {
  jQuery(".continuar-compra").toggleClass("ativo");
});

jQuery(".continuar-compra .bg").click(function () {
  jQuery(".continuar-compra").toggleClass("ativo");
});

jQuery(".escolher .x").click(function () {
  jQuery(".escolher").fadeOut(100);
});

jQuery(".escolher .bg").click(function () {
  jQuery(".escolher").fadeOut(100);
});

var bugAux = false;

var listaComplemento = [];
var complTotal = 0;

$(document).ready(function () {
  inicializacao(null, null);

  if ($(window).width() > 1120) {
    // var sticky 	  = new Sticky('.produtos__lista--sticky');
  }

  var listaComplemento = getComplements(listaComplemento);

  //desktop
  jQuery(".pesquisa-produtos #produtos").keyup(function () {
    input = jQuery(this);
    valor = input.val();
    filtro = valor.toUpperCase();

    if (input.val().length > 0) {
      $(".excluir-pesquisa").show();
    } else {
      $(".excluir-pesquisa").hide();
    }

    jQuery(".pesquisa-resultado li").each(function () {
      item = jQuery(this).text().toUpperCase();
      if (item.indexOf(filtro) > -1) {
        $(".excluir-pesquisa").css("opacity", 1);
        jQuery(this).css("display", "block");
        jQuery(this).addClass("on");
      } else {
        jQuery(this).css("display", "none");
        jQuery(this).removeClass("on");
      }
    });
  });

  jQuery(".pesquisa-produtos #produtos").focus(function () {
    jQuery(".pesquisa-resultado").css("display", "block");
  });
  jQuery(".produtos__pesquisa #produtos").focus(function () {
    jQuery(".pesquisa-resultado-mobile").css("display", "block");
  });

  //mobile
  jQuery(".produtos__pesquisa #produtos").keyup(function () {
    input = jQuery(this);
    valor = input.val();
    filtro = valor.toUpperCase();

    if (input.val().length > 0) {
      $(".excluir-pesquisa").show();
    } else {
      $(".excluir-pesquisa").hide();
    }

    jQuery(".pesquisa-resultado-mobile li").each(function () {
      item = jQuery(this).text().toUpperCase();
      if (item.indexOf(filtro) > -1) {
        jQuery(this).css("display", "block");
        jQuery(this).addClass("on");
      } else {
        jQuery(this).css("display", "none");
        jQuery(this).removeClass("on");
      }
    });
  });

  jQuery(document.body).on("click", ".pesquisa-resultado li, .pesquisa-resultado-mobile li", function () {
    var texto = jQuery(this).text();
    pesquisaScroll(texto);
  });

  //desktop
  jQuery(document.body).on("click", ".pesquisa-produtos .enviar", function () {
    var texto = $("#produtos").val();
    if (texto == "") {
      texto = jQuery(".pesquisa-resultado li.on").first().text();
    }
    pesquisaScrollBtn(texto);
  });
  //mobile
  jQuery(document.body).on("click", ".produtos__pesquisa .enviar", function () {
    var texto = $("#produtos").val();
    if (texto == "") {
      texto = jQuery(".pesquisa-resultado-mobile li.on").first().text();
    }
    pesquisaScrollBtn(texto);
  });

  var timeIni = '<?php echo date_format($horaAbertura, "H:i"); ?>';
  var timeFin = '<?php echo date_format($horaFechamento, "H:i"); ?>';
  definirHorarios(timeIni, timeFin);

  jQuery(document.body).on("click", ".agendar-hora .x", function () {
    jQuery(".agendar-hora").css("display", "none");
  });
  jQuery(document.body).on("click", ".agendar-hora .bg", function () {
    jQuery(".agendar-hora").css("display", "none");
  });

  jQuery(document.body).on("click", "#continuar-agendamento", function () {
    agendamento();
  });

  $(document.body).on("click", ".x", function () {
    $("#var-modal").remove();
  });

  $(document.body).on("click", ".addVarItem", function () {
    var id = $(this).attr("id-var");

    var qt = $('#qt-variation[id-var="' + id + '"]').val();

    $('#qt-variation[id-var="' + id + '"]').text("");

    $('#qt-variation[id-var="' + id + '"]').val(parseInt(qt) + 1);
  });

  $(document.body).on("click", ".remVarItem", function () {
    var id = $(this).attr("id-var");

    var qt = $('#qt-variation[id-var="' + id + '"]').val();

    if (parseInt(qt) == 0) {
      return;
    }

    $('#qt-variation[id-var="' + id + '"]').text("");

    $('#qt-variation[id-var="' + id + '"]').val(parseInt(qt) - 1);
  });

  $(".excluir-pesquisa").click(function () {
    $(".produtos__pesquisa #produtos").val("");
    $(".pesquisa-produtos  #produtos").val("");
    $(this).hide();
  });

  removeLoadDiv();
});

// jQuery(document).ready(function () {
//     jQuery(document.body).click(function () {
//         if (jQuery('#produtos').val().length != 0 && jQuery('body').data('clicked', true)) {
//             jQuery('.pesquisa-resultado').hide();
//         }
//     })
// });

$(document.body).on("click", ".add-var-prod", function () {
  if ($(this).attr("product-type") == 3) {
    getComboModal(
      $(this).attr("id-produto"),
      //   $(this).attr("product-category")+" "+
      $(this).attr("name"),
      $(this).attr("price")
    );
  } else {
    getVariationsModal($(this).attr("id-produto"));
  }

  // var id		  = $(this).attr('id-produto');

  // var price 	  = parseFloat($('select[id-produto="' + id + '"] option:selected').val());

  // var id_var 	  = $('select[id-produto="' + id + '"] option:selected').attr('id-variation');

  // var name 	  = $('select[id-produto="' + id + '"] option:selected').attr('name-variation');

  // var qtd 	  = 1;

  // var prods 	  = JSON.parse(Base64Decode(localStorage.getItem('prods')));

  // var idEntrega = JSON.parse(localStorage.getItem('entrega'));

  // if(id_var !== undefined){

  // 	$('select[id-produto="' + id + '"]').css('border-color', '');

  // 	adicionarProdutoVariavel(id, id_var, idEntrega, qtd, name, price, prods);

  // 	addProdAlert();

  // }else{
  // 	$('select[id-produto="' + id + '"]').css('border-color', 'red');
  // }
});

$(document).on("click", "#addVarProd", function () {
  $(".qt-variation").each(function () {
    if ($(this).val() > 0) {
      var id = $(this).attr("id-prod");

      var price = $(this).attr("price");

      var id_var = $(this).attr("id-var");

      var name = $(this).attr("name");

      var qtd = $(this).val();

      var prods = JSON.parse(Base64Decode(localStorage.getItem("prods")));

      var idEntrega = JSON.parse(localStorage.getItem("entrega"));

      adicionarProdutoVariavel(id, id_var, idEntrega, qtd, name, price, prods);

      $("#var-modal").remove();
    }
  });
});

$(document.body).on("click", ".add-prod", function () {
  var id = $(this).attr("id");
  var qtd = 1;
  var nome = $(this).attr("name");
  var preco = $(this).attr("price");

  if (localStorage.getItem("prods") != null && Object.keys(localStorage.getItem("prods")).length !== 0) {
    var localId = JSON.parse(Base64Decode(localStorage.getItem("prods")));
  } else {
    var localId = [];
  }

  var idEntrega = JSON.parse(localStorage.getItem("entrega"));
  qtd = parseInt(qtd);
  adicionarProduto(id, qtd, nome, preco, localId, idEntrega);
  addProdAlert();
});
$(document.body).on("click", ".comp-prod", function () {
  var id = $(this).attr("id");
  var qtd = 1;
  var nome = $(this).attr("name");
  var preco = $(this).attr("price");
  var checkbox = "";
  var comps = $(this).attr("comp-ids");

  jQuery(".escolher").fadeIn(100);

  var obj = JSON.stringify(listaComplemento);
  var obj = JSON.parse(obj);
  complementosModal(id, qtd, nome, preco, checkbox, obj, JSON.parse(comps));
});
$(document.body).on("click", ".add-comp", function () {
  var produtosLista = JSON.parse(Base64Decode(localStorage.getItem("prods")));
  var complementosLista = JSON.parse(Base64Decode(localStorage.getItem("complementos")));

  adicionarComplemento(produtosLista, complementosLista);
  addProdAlert();
});

$(document.body).on("click", ".checkbox-item", function () {
  var preco = parseInt(jQuery(".nm-produto span").attr("price"));
  jQuery(".escolher__conteudo label").each(function () {
    if (jQuery(this).children("input[type=checkbox]").prop("checked")) {
      preco += parseInt(jQuery(this).children(".price").attr("price"));
    }
  });
  jQuery(".nm-produto span").text(numberToReal(preco));
});

function checkLimit(limit, cat_id) {
  let check = 0;
  jQuery(".checkbox-combo-item").each(function () {
    if (jQuery(this).attr("cat_id") == cat_id) {
      if ($(this).is(":checked")) check++;
    }
  });
  if (check <= limit) {
    var preco = parseInt(jQuery(".nm-produto span").attr("price"));
    let arrayPizza = [];
    jQuery(".escolher__conteudo label").each(function () {
      if (jQuery(this).children("input[type=checkbox]").prop("checked")) {
        preco += parseInt(jQuery(this).children(".price").attr("price"));
      }
    });
    jQuery(".nm-produto span").text(numberToReal(preco));
  } else if (check > limit) {
    if (limit == 1) {
      $(".checkbox-combo-item").prop("checked", false);
      $(this).prop("checked", true);
      this.checked = true;
      console.log($(this).prop("checked"));
      console.log(this.checked);
    } else {
      $(".checkbox-combo-item").prop("checked", false);
      alert(`Não é possivel adicionar mais que ${limit} itens`);
    }
  }
}

function checkLimitForRadio() {
  var checkBoxTrigger = $("input:checkbox:checked")[0];

  if (checkBoxTrigger != null) {
    var event = new Event("change");
    checkBoxTrigger.dispatchEvent(event);
  } else {
    var preco = parseInt(jQuery(".nm-produto span").attr("price"));

    if (jQuery("#broto").prop("checked")) {
      preco *= 0.6;
    }
    jQuery(".nm-produto span").text(numberToReal(preco));
  }
}

// $(document.body).on("change", ".checkbox-combo-item", function () {
//   var preco = parseInt(jQuery(".nm-produto span").attr("price"));
//   let arrayPizza = [];
//   jQuery(".escolher__conteudo label").each(function () {
//     if (jQuery(this).children("input[type=checkbox]").prop("checked")) {
//       if (jQuery(this).children("input[type=checkbox]").attr("cat_id") == 5) {
//         arrayPizza.push(
//           jQuery(this).children("input[type=checkbox]").attr("price")
//         );
//         if (arrayPizza.length == 1) preco += Math.max(arrayPizza);
//         arrayPizza.reduce((a, b) => {
//           preco -= Math.min(a, b);
//           preco += Math.max(a, b);
//         });
//       } else preco += parseInt(jQuery(this).children(".price").attr("price"));
//       if (jQuery("#broto").prop("checked") && precoBroto == false) {
//         preco *= 0.6;
//         precoBroto = true;
//       } else if (precoBroto == true) {
//         preco /= 0.6;
//         precoBroto = false;
//       } else if (!jQuery("#broto").prop("checked")) preco;
//       alert(precoBroto);
//     }
//   });
//   jQuery(".nm-produto span").text(numberToReal(preco));
// });

var items = [];

jQuery(document.body).on("click", ".remItem", function () {
  var el = jQuery(this).parent();
  var form = jQuery(this).prev();
  var localId = JSON.parse(Base64Decode(localStorage.getItem("prods")));
  var idEntrega = JSON.parse(localStorage.getItem("entrega"));
  if (el.parent().attr("comp")) {
    var compId = el.parent().attr("comp");
  } else {
    var compId = false;
  }
  var id = el.attr("p");

  var complementosLista = JSON.parse(Base64Decode(localStorage.getItem("complementos")));

  if ($(this).attr("var") !== null && $(this).attr("var") !== undefined) {
    removerQtProdVar($(this).attr("var"), idEntrega, el, form, localId);
  } else if ($(this).attr("comboVar")) {
    var comboVar = $(this).attr("comboVar");
    removerQt(el, form, localId, idEntrega, id, compId, complementosLista, comboVar);
    console.log(JSON.parse(Base64Decode(localStorage.getItem("prods"))));
  } else {
    removerQt(el, form, localId, idEntrega, id, compId, complementosLista);
  }
});

$(document.body).on("click", ".addItem", function () {
  var el = jQuery(this).parent();
  var form = jQuery(this).next();
  var id = el.attr("p");

  if (el.parent().attr("comp")) {
    var compId = el.parent().attr("comp");
  } else {
    var compId = false;
  }

  var localId = JSON.parse(Base64Decode(localStorage.getItem("prods")));

  var idEntrega = JSON.parse(localStorage.getItem("entrega"));

  if ($(this).attr("var") !== null && $(this).attr("var") !== undefined) {
    adicionarQtProdVar($(this).attr("var"), idEntrega, el, form, localId);
  } else if ($(this).attr("comboVar")) {
    var comboVars = $(this).attr("comboVar");
    adicionarQt(el, form, id, localId, idEntrega, compId, comboVars);
    console.log("ADICIONANDO:", JSON.parse(Base64Decode(localStorage.getItem("prods"))));
  } else {
    adicionarQt(el, form, id, localId, idEntrega, compId);
  }
});

var agendamentoBool = false;

// $(document.body).on('click', '#Finalizar-pedido', function () {

//     if (verifyProds() > 0) {
//         var time = pegarHora();
//         var min = jQuery('#agendar-hora').attr('min');
//         var max = jQuery('#agendar-hora').attr('max');

//         var timeSplit = time.split(":");
//         var minSplit = min.split(":");
//         var maxSplit = max.split(":");

//         var abertura = new Date(2018, 01, 01, minSplit[0], minSplit[1]);
//         var fechamento = new Date(2018, 01, 01, maxSplit[0], maxSplit[1]);
//         var horaAtual = new Date(2018, 01, 01, timeSplit[0], timeSplit[1]);

//         if (abertura > fechamento) {
//             fechamento.setDate(fechamento.getDate() + 1);
//             if (horaAtual < abertura) {
//                 horaAtual.setDate(horaAtual.getDate() + 1);
//             }
//         }

//         if (horaAtual >= abertura && horaAtual <= fechamento) {

//             window.location = "/client/area-do-cliente";
//             <?php

//             agendamentoBool = true;
//             getPromoBanner();
//             <?php

//         alert("Adicione produtos ao carrinho para finalizar o pedido!");

// });

$(document).on("click", "#mais-item-oferta", function () {
  var qtd = parseInt($(".qtd-item-oferta").val());

  $(".qtd-item-oferta").val(qtd + 1);
});

$(document).on("click", "#menos-item-oferta", function () {
  var qtd = parseInt($(".qtd-item-oferta").val());

  if (qtd != 1) {
    $(".qtd-item-oferta").val(qtd - 1);
  }
});

$(document).on("click", ".prosseguir-pedido", function () {
  $("div.oferta").remove();
  appendModalCep();
});

jQuery(document).ready(function () {
  jQuery(".pesquisa-produtos").click(function () {
    jQuery(".pesquisa-resultado").css("display", "block");
  });

  jQuery("body").on("click", function (e) {
    var search = jQuery(".pesquisa-produtos");
    if (search.has(e.target).length || e.target == search[0]) return;
    jQuery(".pesquisa-resultado").css("display", "none");
  });

  var i = verifyProds();

  if (i == 0) {
    $(".carrinho-vazio").show();
  }

  var header_height = $("header").height();

  var cart_height = $(".produtos__lista--fixed").height();

  var window_height = screen.height;

  var val = window_height - header_height - cart_height - 150;

  $(".list-products").css("max-height", val);
});

$(document).on("click", ".prod-category", function () {
  $('.form-category[data_id="' + $(this).attr("data_id") + '"]').submit();
});

//altura carrinho
(function () {
  var header_height = jQuery("header").innerHeight();

  var produtos_nav = jQuery(".produtos-nav").innerHeight();

  var titulo = jQuery(".produtos__lista .titulo").innerHeight();

  var valores = jQuery(".produtos__lista .valores").innerHeight();

  var valores2 = jQuery(".produtos__lista .valores:nth-child(3)").innerHeight();

  var comprar = jQuery(".produtos__lista .comprar").innerHeight();

  var window_height = screen.height;

  var val = window_height - (header_height + produtos_nav + titulo + valores + valores2 + comprar);

  jQuery(".carrinho-vazio").css("max-height", val - 20 - 115);

  jQuery(".list-products").css("max-height", val - 20 - 115);
});

$(document.body).on("click", ".inicio__enviar", function () {

  console.log('CRIQUEEEEE');
  var cep = parseCEP($("input.inicio__cep").val());

  var html = "";

  if (cep.length == 8) {
    $(".list-group").remove();

    addLoadDiv();

    getDeliveryCeps(cep);

    //alert(cep);

    setTimeout(function () {
      removeLoadDiv();
    }, 5000);
  } else {
    $("p.cep-error").show();

    setTimeout(function () {
      $("p.cep-error").hide();
    }, 3500);
  }
});

$(document.body).on("click", ".lightbox__semcep .x", function () {
  $(".lightbox").toggleClass("ativo");
  $("#pog").css("display", "");
  $("#ceps-pesquisados").remove();
});

$(document.body).on("click", ".modal-cep .buscar", function () {
  $(".lightbox").toggleClass("ativo");
  $("#pog").css("display", "");
  $("#ceps-pesquisados").remove();
});
$(document.body).on("click", "#enviar-cep", function () {
  var uf = $("#uf").val();
  var cidade = $("#cidade").val();
  var log = $("#endereco").val();

  addLoadDiv();

  if (log.length != 0) {
    getCepsBySearch(uf, cidade, log);
  }

  removeLoadDiv();
});

jQuery("#enviar-cep").click(function () {
  var uf = jQuery("#uf").val();
  var cidade = jQuery("#cidade").val();
  var log = jQuery("#endereco").val();

  addLoadDiv();

  if (log.length != 0) {
    getCepsBySearch(uf, cidade, log);
  }

  removeLoadDiv();
});

$(document.body).on("click", "#log-cep", function () {
  var cep = parseCEP($(this).attr("data-cep"));

  removeDivs();

  if (cep.length == 8) {
    addLoadDiv();

    getDeliveryCeps(cep);

    removeLoadDiv();
  } else if (cep.length < 8) {
    $("p.cep-error").show();

    setTimeout(function () {
      $("p.cep-error").hide();
    }, 3500);
  }
});

if ($(window).innerWidth() > 1121) {
  $(window).scroll(function () {
    var header_height = $("header").height() + $(".produtos-banner").height() + $(".produtos__banner").height();
    if ($(this).scrollTop() > header_height) {
      $(".produtos__lista--fixed").css("top", "105px");
    } else {
      $(".produtos__lista--fixed").css("top", "unset");
    }
  });
}

$(document.body).on("click", ".inicio_retirar", function () {
  var html = "";

  $(".list-group").remove();

  addLoadDiv();

  var data = {
    taxa: 0.0,
    cidade: "Loja",
    cep: "Loja",
    logradouro: "Loja",
    bairro: "Loja",
    uf: "Loja",
    tempo: 0,
  };

  localStorage.setItem("entrega", JSON.stringify(data));
  //alert(JSON.stringify(data));

  html = "<ul style='display: inline-block; margin-bottom: 10px;' class='list-group'>";
  html +=
    '<li style="display: inline-block; border: none; background-color:transparent;" class="list-group-item"><form id="cep-encontrado" style="display: none;" action="/delivery/selecionar-cep" method="POST"><input type="hidden" name="allLojas" value="sim"> </form></li>';
  $("#lojas-input").append(html);
  $("#cep-encontrado").submit();

  setTimeout(function () {
    removeLoadDiv();
  }, 5000);
});
