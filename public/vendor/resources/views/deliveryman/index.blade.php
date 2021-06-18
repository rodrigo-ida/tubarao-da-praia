@extends('layouts.tubarao-deliveryman', $deliveryManLogged)



@section('title', 'Área do Entregador')



@section('content')

<section class="area-motoboy">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-7">

                <div class="row">

                    <div class="col-md-12">

                        @if($orders->count() > 0)

                        @foreach($orders as $order)

                        <div class="area-motoboy-pedido row justify-content-end" data-order-id="{{ $order->id }}">

                            <div class="col-8">

                                <h3>#{{ $order->id }}</h3>

                            </div>

                            <div class="col-4"></div>

                            <div class="col-12">

                                <p>{{ $order->order_street . ', ' . $order->order_number . ' - ' . $order->order_neighborhood }}</p>

                                @if(!$order->order_reference)

                                <p><b>Referência:<b> {{ $order->order_reference }}</p>

                                @endif



                            </div>

                            <div class="col-4" style="align-self: center;">

                                <img src="{{ asset('img/money.svg') }}" alt="Pagamento em dinheiro">

                            </div>

                            <div class="col-8"><small>{{ $order->getPaymentMethod->name_method }}</small>

                                <p style="font-size: 24px;"><b>{{number_format($order->order_tax_rate + $order->order_total, 2, ",", ".")}}</b></p>

                            </div>

                            <div class="col-md-12">

                                <hr>

                            </div>

                            <div class="col-12">



                                <input type="button" data-id-order="{{ $order->id }}" class="order-delivered" value="Confirmar Entrega">

                            </div>

                        </div>

                        @endforeach

                        @else

                        <div>

                            <p style="text-align: center;margin-top: 100px;">Não há pedidos para entregar!</p>

                        </div>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>

<input type="hidden" id="latLng" value="">

<script>

    //collapse user historico

    (function() {

        $('[data-group]').each(function() {

            var $allTarget = $(this).find('[data-target]'),

                $allClick = $(this).find('[data-click]'),

                classActive = 'active';



            $allClick.click(function(e) {

                e.preventDefault();

                var idTab = $(this).data('click'),

                    $target = $('[data-target ="' + idTab + '" ]');



                if ($target.hasClass(classActive)) {

                    $target.removeClass(classActive);

                    $(this).removeClass(classActive);

                    return;

                } else {

                    $allTarget.removeClass(classActive);

                    $allClick.removeClass(classActive);

                }

                $target.addClass(classActive);

                $(this).addClass(classActive);

            });

        });

    })();

    $(document.body).on('click', '.order-delivered', function() {

        var id = $(this).data('id-order'),

            div = $('div[data-order-id="' + id + '"]'),

            input = $(this);

        if (navigator.onLine) {

            if (getLocation()) {

                setTimeout(function() {



                    var l = $('input#latLng').val();



                    if (l) {



                        $.ajax({

                            url: "/deliveryman/delivered",

                            method: "POST",

                            dataType: "JSON",

                            data: {

                                "_token": "{{ csrf_token() }}",

                                id: id,

                                latLng: l

                            },

                            success: function(res) {

                                if (res.status_code === 200) {

                                    $(div).addClass('area-motoboy-pedido-entregue');

                                    $(input).prop('disabled', true);

                                    alert(res.msg);

                                }

                            },

                            error: function(res) {

                                console.log(res.responseText);

                            }

                        })



                    }



                }, 2000);

            }



        } else {

            alert('Você não possui conexão com a internet, verifique e tente novamente!');

        }

    });



    $(document.body).on('click', '.btn-status', function() {

        var v,

            id = $(this).data('id-user'),

            input = $(this);

        if ($(this).hasClass('status-on')) v = '0';

        else v = '1';



        if (id != undefined && v != undefined) {



            $.ajax({

                url: '/deliveryman/online',

                method: "POST",

                data: {

                    "_token": "{{ csrf_token() }}",

                    id: id,

                    deliveryman_online: v

                },

                dataType: "JSON",

                success: function(res) {

                    if (res.status == 400) {

                        return alert('Não foi possível mudar seu status, tente novamente mais tarde!');

                    }

                    if (v == '0') {

                        $(input).removeClass('status-on');

                        $(input).addClass('status-off');

                    } else {

                        $(input).removeClass('status-off');

                        $(input).addClass('status-on');

                    }

                },

                error: function(res) {

                    console.log("ERROR: " + res.msg, res.responseText);

                }

            })



        }

    });



    function showPosition(position) {

        var value = position.coords.latitude + "," + position.coords.longitude;

        $('input#latLng').val(value);

    }



    function getLocation() {

        if (navigator.geolocation) {

            navigator.geolocation.getCurrentPosition(showPosition);



            return true;

        } else {

            x.innerHTML = "Geolocation is not supported by this browser.";

        }

    }



    setInterval(function() {

        registerLastPosition();

    }, 120000);



    function registerLastPosition() {

        if (navigator.onLine) {

            var id = $('.btn-status').data('id-user'),

                l = $('input#latLng').val();

            getLocation();

            setTimeout(function() {



                $.ajax({

                    url: '/deliveryman/updateLocation',

                    method: "POST",

                    data: {

                        "_token": "{{ csrf_token() }}",

                        id: id,

                        latLng: l

                    },

                    dataType: "JSON",

                    success: function(res) {

                        console.log(res);

                    },

                    error: function(res) {

                        console.log("ERROR: " + res.msg, res.responseText);

                    }

                })



            }, 2000);

        }

    }

</script>

@endsection