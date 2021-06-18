<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if ($_SERVER['REQUEST_URI'] == '/delivery/finalizar') {

    $bool = true;
} else {

    $bool = false;
}


?>

<!DOCTYPE html>

<html>

<head>
    <meta http-equiv="cache-control" content="max-age=0" />

    <meta http-equiv="cache-control" content="no-cache" />

    <meta http-equiv="expires" content="0" />

    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />

    <meta http-equiv="pragma" content="no-cache" />

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, minimum-scale=1.0">

    <meta name="theme-color" content="#6d1357">

    <!-- CSRF Token -->

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('/img/favicon-delivery.png') }}" sizes="32x32">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/deliveryman.css') }}">
    <!-- <link rel="stylesheet" href="{{ mix('/css/style.css') }}" type="text/css">

    <script

    src="https://code.jquery.com/jquery-3.3.1.slim.js"

    integrity="sha256-fNXJFIlca05BIO2Y5zh1xrShK3ME+/lYZ0j+ChxX2DA="

    crossorigin="anonymous"> -->

    <noscript>

        <meta http-equiv="Refresh" content="1;   url=/">

    </noscript>

    <script src="{{ asset('/js/jquery-3.2.1.min.js') }}"></script>

    <!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous">
    </script> -->


    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-P6QLJZP');
    </script>

    <!-- <script src="{{ asset('/css/bootstrap/js/popper.js') }}"></script>

    <script src="{{ asset('/css/bootstrap/js/bootstrap.min.js') }}"></script> -->

    <title>@yield('title', 'Tubarão da Praia - Área do Entregador ')</title>
</head>

@yield('head-scripts')

@yield('head-styles')

<body>

    <header class="container-fluid">
        <nav class="row justify-content-between">
            <a href=""><img src="{{ asset('img/tubarao-entregador.svg') }}" alt="Tubarão da Praia"></a>
            <span>
                <form method="POST" action="{{ route('logout') }}">
                    {{ csrf_field() }}
                    <a class="@if($deliveryManLogged->First()->deliveryman_online == 1)status-on @else status-off @endif btn-status" data-id-user="{{ $deliveryManLogged->First()->id }}" href="#">Olá, {{ $deliveryManLogged->First()->name }}! <span class="status-border">
                        </span></a>
                    <a href="#"><input class="logout" type="submit" value="SAIR"></a>
                </form>
            </span>
        </nav>
    </header>

    @yield("content")

</body>
@yield("footer-scripts")

</div>
</body>

</html>