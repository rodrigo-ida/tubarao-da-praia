<?php

    $day  = date('w');
    $hora = date('H:i:s'); 

 ?>
<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, minimum-scale=1.0">

    <meta name="theme-color" content="#6d1357">

    <!-- CSRF Token -->

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">

    <!-- <link rel="stylesheet" href="{{ mix('/css/style.css') }}" type="text/css">

    <script

    src="https://code.jquery.com/jquery-3.3.1.slim.js"

    integrity="sha256-fNXJFIlca05BIO2Y5zh1xrShK3ME+/lYZ0j+ChxX2DA="

    crossorigin="anonymous"> -->

    <noscript>  

        <meta http-equiv="Refresh" content="1;   url=/">

    </noscript>

    <script src="{{ asset('/js/jquery-3.2.1.min.js') }}"></script>

    <script src="{{ asset('/css/bootstrap/js/popper.js') }}"></script>

    <script src="{{ asset('/css/bootstrap/js/bootstrap.min.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('/css/bootstrap/bootstrap.min.css') }}">

    <script src="{{ asset('/js/delivery.js') }}"></script>

    <script type="text/javascript">
   
        $(document).ready(function(){

            $(document.body).on('click', '#pesquisar-pedido', function(){

                var email = $('#email-pedido').val();

                if(email)
                {

                    window.location = '/delivery/pedido/' + email;

                }

            })

        });

    </script>

    <style>

        .navbar-brand {

            background-image: url(/img/logo.png);

            display: inline-block;

            float: left;

            height: 90px;

            margin-top: 12px;

            width: 148px;

            background-size: 100% 100%;

        }

        .shopping-cart {

            font-family: FontAwesome;

            font-size: 30px;

            content: "\f07a";

        }

        body {

            background-image: url(/img/bg.jpg);

        }

    </style>

    <title>@yield('title', 'Tubarão da Praia - Delivery ')</title>

    @yield('head-scripts')

    @yield('head-styles')

    <header>

        <nav style="background-color:#800b58;" class="navbar navbar-expand-lg">

            <a class="navbar-brand" href="#"></a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">

                <ul class="navbar-nav mr-auto mt-2 mt-lg-0">

                <li class="nav-item">

                    <a style="color: rgb(255, 240, 0);" class="nav-link" href="{{ route('productdelivery.index')}}">Delivery</a>

                </li>

                <!-- <li class="nav-item">

                    <a style="color: rgb(255, 240, 0);" class="nav-link" href="#">Link</a>

                </li>

                <li class="nav-item">

                    <a style="color: rgb(255, 240, 0);" class="nav-link disabled" href="#">Disabled</a>

                </li> -->

                @if($_SERVER['REQUEST_URI'] != '/delivery/finalizar')

                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle" style="color: rgb(255, 240, 0);" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                    Carrinho

                    </a>

                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                    <div class="table-responsive">

                        <table class="table">

                            <thead>

                                <tr>

                                    <th>

                                        Nome

                                    </th>

                                    <th>

                                        Qtd

                                    </th>

                                    <th>

                                        Total

                                    </th>

                                    <th></th>

                                </tr>

                            </thead>

                            <tbody class="list-products">

                            </tbody>

                        </table>

                    </div>

                    <div class="dropdown-divider"></div>

                    <span class="dropdown-item" href="#">Total: <span id="total-carrinho"></span></span>

                    <div class="dropdown-divider"></div>

                    <a style="display: flex; align-items: center; justify-content: center;" href="/delivery/finalizar" title="finalizar pedido"><input type="button" value="Finalizar pedido" class="btn btn-success" /></a>                    

                </li>

                    @endif

                </ul>

                <span style="color: rgb(255, 240, 0); margin-right: 5px;">Já fez um pedido? Consulte-o aqui</span>

                <form style="float:right" class="form-inline my-2 my-lg-0">

                <input class="form-control mr-sm-2" type="email" id="email-pedido" placeholder="Digite seu Email..." aria-label="Email">

                <input type="button" class="btn btn-info my-2 my-sm-0" value="Pesquisar"  id="pesquisar-pedido" />

                </form>

            </div>

        </nav>

    </header>

    <div class="container-fluid">

    @yield("content")
    @foreach($configs as $config)
        {{ var_dump($config->config_date) }}
    @endforeach
    @yield("footer-scripts")

    </div>

    <footer style="background-color:#800b58; height: 156px; width: 100%; margin-top: 100px;">

    </footer>