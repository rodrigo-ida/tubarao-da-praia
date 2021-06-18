function getRecuModal() {
    var html = `
   <div class="modal-recu-email ativo">

        <div class="bg"></div>
    
            <div class="conteudo">
                <div class="x">X</div>
        
            <div class="recu-email">
                <h3>Esqueceu seu e-mail?</h3>
                <label for="cel-recu">Digite o número do celular cadastrado:</label>
                <input type="text" id="cel-recu" required>
                <p class="alert alert-danger" id="email-error" style="display: none;">Nenhum e-mail cadastrado com esse número, tente outro.</p>
                <input style="background-image: url({{ asset('/img/continuar.png') }}" id="btn-recu-email" class="btn" value="Continuar" type="button"/>
            </div>
        
            <div class="success-email">	
                <h3>E-mail recuperado com sucesso!</h3>
                <p id="email-success"></p>
                <button class="btn" id="copy-email" onclick="copyToClipboard('#email-success')">Copiar</button>
            </div>
   
   
       </div>
   </div>`;

    $('body').append(html);
}

$(document).on('click', '#recu-email-show', function () {
    if ($('.modal-recu-email').length == 0) {

        getRecuModal();

    }

});

$(document).on('click', '.x', function () {
    jQuery('.modal-recu-email').remove();
});

function recuEmail(num) {

    num.replace(" ", '');

    $.ajax({
        url: "/delivery/finalizar/recu-email",
        data: {
            num: num
        },
        success: function (response) {
            if (response != 'false') {
                $('.recu-email').css('display', 'none');
                $('.success-email').css('display', 'block');
                $('#email-success').css('display', 'block');
                $('#email-success').text(response);

                return;
            }

            $('#email-error').show();
        },
        error: function (response) {
            alert('Houve um erro, tente novamente');
        }
    })
}

function copyToClipboard(element) {
    var $temp = jQuery("<input>");
    jQuery("body").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
    jQuery('#copy-email').text('Copiado');
}

$(document).on('click', '#btn-recu-email', function () {

    if ($('#email-error').css('display') == 'block') {
        $('#email-success').hide();
        $('#email-error').hide();
    }

    var num = $('#cel-recu').val();

    if ($('#cel-recu').val().length >= 10) {

        recuEmail(num);

    }

});