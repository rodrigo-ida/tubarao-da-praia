<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0">
    <meta name="theme-color" content="#6d1357" >
    <title>@yield('title', 'Pedido realizado com sucesso!')</title>
    @yield('head-styles')
</head>
<body>

<div class="header" style="background-color: #800b58; color: #fdec01;">
    <div>
        
    </div>
</div>

<div class="container" style="background-color: #6d1357; max-width: 600px; margin: 0 auto; border-radius: 3px; box-shadow: 8px 8px 26px -5px rgba(0,0,0,0.4);">
    @yield("content")
</div>

<div class="bottom" style="background-color: #800b58; color: #fdec01;">
    <span style="text-align: center;">Tubarão da Praia Delivery | 2018 Todos os Direitos Reservados | Desenvolvido por Ótima Ideia</span>
    <div class="bar"></div>
</div>

@yield('footer-styles')
</body>
</html>