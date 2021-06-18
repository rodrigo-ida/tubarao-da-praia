try {
    window.$ = window.jQuery = require('jquery');
} catch (e) {}

require('jquery-validation-pt-br');
require('jquery.inputmask.bundle');
require('bootstrap-sass');

jQuery(document).ready((function($){
//    $("form").validate();

    $('#cep').inputmask('99999-999');

    if (typeof $('#cep').inputmask === "function") {
        $('#data_nasc').inputmask('date', {
            alias: "dd/mm/yyyy",
            placeholder: "dd/mm/aaaa"
        });
        $('#cep').inputmask('99999-999', {
            "clearIncomplete": true
        });
        $('#whatsapp').inputmask('(99) 99999-9999', {
            "clearIncomplete": true
        });
    }

    var buscaCep = function buscaCep() {
        var field = $(this);
        var cep_code = field.inputmask('unmaskedvalue');

        $("input#bairro").attr('readonly', 'readonly');
        $("input#bairro").attr('tabindex', '-1');
        $("input#logradouro").attr('readonly', 'readonly');
        $("input#logradouro").attr('tabindex', '-1');
        $("input#cidade").attr('readonly', 'readonly');
        $("input#estado").attr('tabindex', '-1');
        $("input#estado").attr('readonly', 'readonly');
        $("input#cidade").attr('tabindex', '-1');

        if (cep_code.length < 8) {
            $("input#estado").val('');
            $("input#cidade").val('');
            $("input#bairro").val('');
            $("input#logradouro").val('');
            return;
        }
        var cepService = $.get("//viacep.com.br/ws/" + cep_code + "/json/unicode/", function (result) {
            if (result.erro) {
                $("input#cep").val( '' );
                $("input#estado").val( '' );
                $("input#cidade").val( '' );
                $("input#bairro").val( '' );
                $("input#logradouro").val( '' );

                alert(result.message || "CEP não encontrado.");
                return;
            }
            $("input#cep").val( result.cep );
            $("input#estado").val( result.uf );
            $("input#cidade").val( result.localidade );
            if (result.bairro) {
                $("input#bairro").val( result.bairro );
                $("input#numero").focus();
            } else {
                $("input#bairro").removeAttr('readonly');
                $("input#bairro").attr('tabindex', '8');
                $("input#bairro").focus();
            }
            if (result.logradouro) {
                $("input#logradouro").val( result.logradouro );
            } else {
                $("input#logradouro").removeAttr('readonly');
                $("input#logradouro").attr('tabindex', '9');
            }
        });
        cepService.fail(function () {
            $("input#estado").attr('tabindex', '6');
            $("input#cidade").attr('tabindex', '7');
            $("input#bairro").attr('tabindex', '8');
            $("input#logradouro").attr('tabindex', '9');
            $("input#logradouro").removeAttr('readonly');
            $("input#bairro").removeAttr('readonly');
            $("input#cidade").removeAttr('readonly');
            $("input#estado").removeAttr('readonly');
            $("input#estado").focus();
        });

    };


    jQuery(function($){
        $("#cep").on('input change', buscaCep);
    });

})(jQuery));
