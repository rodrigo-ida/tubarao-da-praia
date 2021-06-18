<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0">
    <meta name="theme-color" content="#6d1357">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ mix('/css/bootstrap.custom.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ mix('/css/style.css') }}" type="text/css">
    <link rel="icon" href="/img/favicon.png" />
    <title>@yield('title', 'Clube do Desconto Tubarão da Praia - Parceria ACEPG ')</title>
    @yield('head-scripts')
    @yield('head-styles')
    
    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-P6QLJZP');</script>
<!-- End Google Tag Manager -->
</head>
<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P6QLJZP"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<img src="/img/acepg-parceria-tubarao-da-praia.jpg" alt="Tubarão da Praia e Acepg" width="100%" style="margin:0;padding: 0;"/>
<!--<header>

    <span class="header">

        <img src="/img/logo.png" alt="Tubarão da Praia e Acepg"/>
    </span>
</header>-->
<div class="container">
    @yield("content")
</div>
<div class="bottom">
    <span>Tubarão da Praia | 2020 Todos os Direitos Reservados | Desenvolvido por <a href="https://www.otimaideia.com.br">Ótima Ideia</a></span>
    <div class="bar"></div>
</div>
<script type="text/javascript" src="{{ mix('/js/main.js') }}"></script>
@yield('footer-scripts')
@yield('footer-styles')
</body>
</html>