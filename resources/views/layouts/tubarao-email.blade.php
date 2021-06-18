<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0">
    <meta name="theme-color" content="#6d1357" >
    <title>@yield('title', 'Ganhe descontos')</title>
    @yield('head-styles')
</head>
<body>

<div class="header">
    <div>
        <img src="{{ $message->embed(public_path('/img/logo.png')) }}" />
    </div>
</div>

<div class="container">
    @yield("content")
</div>

<div class="bottom">
    <span>Tubarão da Praia | 2020 Todos os Direitos Reservados | Desenvolvido por <a href="https://www.otimaideia.com.br">Ótima Ideia</a></span>
    <div class="bar"></div>
</div>

@yield('footer-styles')
</body>
</html>