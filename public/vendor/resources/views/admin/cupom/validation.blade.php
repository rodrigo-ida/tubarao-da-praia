@extends('layouts.admin')

@section('content')
<div class="container" id="consulta-coupon">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">Consultar Cupom</h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-4">
                    {!! Form::label('code', 'Digite o código:', ['class' => 'control-label']) !!}
                    <div class="input-group">
                        {!! Form::text('code', null, ['class' => 'form-control input-lg', 'maxlength' => 6]) !!}
                        <span class="input-group-btn">
                            <button class="btn btn-danger btn-lg" type="button" id="clear-code">
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="loader-container">
                <div class="loader spinner center-block hidden">
                    <div class="rect1"></div>
                    <div class="rect2"></div>
                    <div class="rect3"></div>
                    <div class="rect4"></div>
                    <div class="rect5"></div>
                </div>
            </div>
            <div id="coupon"></div>
            <div id="message"></div>
        </div>
        <div class="panel-footer">
            {!! Form::button('<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Utilizar Cupom',
            ['class' => 'btn btn-success btn-lg btn-block', 'disabled' => 'disabled', 'id' => 'use-coupon']) !!}
        </div>
    </div>
</div>
@endsection

@push('js')
<script id="couponTmpl" type="text/x-jsrender">
<div class="row">
    <div class="col-lg-12">
        <p>
            <h2><b><%:offer.titulo%></b></h2>
            <%:offer.descricao%>
        </p>
    </div>
</div>
</script>
<script id="messageTmpl" type="text/x-jsrender">
    <div>
        <div class="alert alert-<%:level%>" role="alert">
            <%if icon%>
            <span class="glyphicon glyphicon-<%:icon%>" aria-hidden="true"></span>
            <%/if%>
            <%:message%>
        </div>
    </div>
</script>
<script type="text/javascript">
    (function ($) {

        var couponManager = {

            couponTmpl : $.templates("#couponTmpl"),
            coupon :  null,
            code: null,
            searching: false,
            consultaCoupon : function (code) {

                if(this.searching || this.code == code)
                    return;

                this.searching = true;
                this.code = code;

                console.log('Consultando coupon: ' + code);

                $('.loader').removeClass('hidden');
                messageManager.showMessage('Aguarde, consultando cupom ...');
                axios.get('{{ $showCupomRoute }}/' + code)
                    .then(function (response) {
                        console.log(response.data);
                        couponManager.setCoupon(response.data);
                    })
                    .catch(function (error) {
                        console.log(error);
                        if (error.response.status == 404) {
                            couponManager.setCoupon(null);
                            messageManager.showErrorMessage('<b>Código de cupom inválido!</b>');
                        }
                    })
                    .finally(function () {
                        //console.log('acabou');
                        couponManager.searching = false;
                        $('.loader').addClass('hidden');
                    });
            },
            showCoupon : function () {

                if (this.coupon != null) {
                    var html = this.couponTmpl.render(this.coupon);
                    $('#coupon').html(html);

                    if(this.coupon.validation_date) {
                        messageManager.showErrorMessage('<b>Atenção!</b> Cupom já utilizado.');
                    } else {
                        messageManager.showSuccessMessage('<b>Tudo certo!</b> Este cupom poder ser utilizado.')
                    }

                } else {
                    $('#coupon').html('');
                }
            },
            setCoupon : function (coupon) {
                this.coupon = coupon;
                this.showCoupon();
                $('#use-coupon').prop("disabled", this.coupon != null ? this.coupon.validation_date !== null : true);
            },
            validateCoupon : function() {

                $('.loader').removeClass('hidden');
                $('#coupon').addClass('hidden');
                messageManager.showMessage('Aguarde ...');

                axios.get('{{ $validateCupomRoute }}/' + this.coupon.validation_token)
                    .then(function (response) {
                        console.log(response);
                        data = response.data;
                        if (data.status == 'success') {
                            messageManager.showSuccessMessage('Cupom <b>' + data.coupon.validation_token + '</b> utilizado com sucesso!');
                            $("input[name='code']").val('').focus();
                            couponManager.setCoupon(null);
                        }
                        else if (data.status == 'error') {
                            messageManager.showErrorMessage(data.message);
                        }
                        else {
                            messageManager.showMessage(data.message);
                        }
                    })
                    .catch(function (error) {
                        if (error.response.status == 404) {
                            messageManager.showErrorMessage('<b>Erro, tente novamente!</b>');
                        }
                    })
                    .finally(function () {
                        //couponManager.searching = false;
                        $('.loader').addClass('hidden');
                        $('#coupon').removeClass('hidden');

                    });
            }
        }

        var messageManager = {

            messageTmpl: $.templates("#messageTmpl"),
            messageEl: $('#message'),

            showErrorMessage: function (msg) {
                html = this.messageTmpl.render({message: msg, level: 'danger', 'icon': 'exclamation-sign'});
                this.messageEl.html(html);
            },
            showSuccessMessage: function (msg) {
                html = this.messageTmpl.render({message: msg, level: 'success', 'icon': 'ok'});
                this.messageEl.html(html);
            },
            showMessage: function (msg) {
                html = this.messageTmpl.render({message: msg, level: 'info'});
                this.messageEl.html(html);
            },
            clearMessages: function () {
                this.messageEl.html('');
            }
        };

        $(document).ready(function () {

            codeInput = $("input[name='code']");
            clearCodeButton = $("#clear-code");
            codeInput.focus();
            codeInputLast = codeInput.val();
            validteButton = $("#use-coupon");

            codeInput.on('keyup paste change', function (e) {

                var when = 0;
                if (e.type == 'paste') {
                    when = 100; //para aguardar o tempo até que o valor colado seja aplicado no input
                }

                setTimeout(function () {

                    var code = codeInput.val().toUpperCase();
                    var codeLength = code.length;
                    codeInput.val(code);

                    if (codeInputLast === code)
                        return;

                    codeInputLast = code;

                    messageManager.clearMessages();
                    if (codeLength === 6) {
                        couponManager.consultaCoupon(code);
                    } else {
                        couponManager.setCoupon(null);
                        couponManager.code = null;
                    }

                }, when);

            });

            validteButton.click(function () {
                couponManager.validateCoupon();
            })

            clearCodeButton.click(function() {
                codeInput.val('').focus();
            });
        });

    })(jQuery);
</script>
@endpush
