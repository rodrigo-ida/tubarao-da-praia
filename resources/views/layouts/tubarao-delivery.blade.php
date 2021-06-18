<!DOCTYPE html>

<html>
@push('scripts')
<script src="{{ asset('/js/jquery-3.2.1.min.js') }}"></script>

<script src="{{ asset('/js/base64js.min.js') }}"></script>

<script src="{{ asset('/js/delivery.js') }}"></script>

<script src="{{ asset('/js/delivery-first.js') }}"></script>

<script src="{{ asset('/js/recu-email.js') }}"></script>

<script src="{{ asset('/js/jquery.mask.min.js') }}"></script>

<script src="{{ asset('/js/delivery-scripts.js') }}"></script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('/css/style-delivery.css') }}">
@endpush

<head>
    @stack('scripts')
    @stack('styles')
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, minimum-scale=1.0">

    <meta name="theme-color" content="#6d1357">

    <!-- CSRF Token -->

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('/img/favicon-delivery.png') }}" sizes="32x32">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">

    <!-- <link rel="stylesheet" href="{{ mix('/css/style.css') }}" type="text/css">

    <script

    src="https://code.jquery.com/jquery-3.3.1.slim.js"

    integrity="sha256-fNXJFIlca05BIO2Y5zh1xrShK3ME+/lYZ0j+ChxX2DA="

    crossorigin="anonymous"> -->

    <noscript>

        <meta http-equiv="Refresh" content="1;   url=/">

    </noscript>
    <!-- <script src="{{ asset('/js/jquery-3.2.1.min.js') }}"></script> -->

    <!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous">
    </script> -->

    <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-P6QLJZP');</script>
<!-- End Google Tag Manager -->

    <!-- <script src="{{ asset('/css/bootstrap/js/popper.js') }}"></script>

    <script src="{{ asset('/css/bootstrap/js/bootstrap.min.js') }}"></script> -->

    <link rel="stylesheet" href="{{ asset('/css/style-delivery.css') }}">

    <!-- <script src="{{ asset('/js/base64js.min.js') }}"></script>

    <script src="{{ asset('/js/delivery.js') }}"></script>


    <script src="{{ asset('/js/delivery-first.js') }}"></script>

    <script src="{{ asset('/js/recu-email.js') }}"></script>

    <script src="{{ asset('/js/jquery.mask.min.js') }}"></script>

    <script src="{{ asset('/js/delivery-scripts.js') }}"></script> -->

<script>
        jQuery(document).ready(function() {
            jQuery('.pesquisa-pedido').click(function() {
                jQuery('.pesquisa-pedido div').addClass('ativo');
                jQuery('.pesquisa-pedido label').addClass('ativo');
            });

            jQuery("body").on("click", function(e) {
                var search = jQuery('.pesquisa-pedido');
                if (search.has(e.target).length || e.target == search[0])
                    return;

                jQuery('.pesquisa-pedido div').removeClass('ativo');
                jQuery('.pesquisa-pedido label').removeClass('ativo');
            });
        });
    </script>
    <title>@yield('title', 'Tubarão da Praia - Delivery ')</title>
    
    
 

   
    
    

</head>


<body>
    
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P6QLJZP"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->


    <header class="clearfix">
  
        <div class="container">
            <h1>
                <a href="/" style="background-image: url({{ asset('/img/logo-beta.png') }});">
                    <span>Tubarão da Praia</span>
                </a>
            </h1>

            
           <div class="pesquisa-produtos clearfix">
                <input placeholder="Pesquisar..." type="text" id="produtos" />

                {{-- <input class="enviar" type="button" value="Pesquisar" id='botaoPesquisarIndex' style="background-image: url({{ asset('/img/search.png') }});"> --}}
                {{-- <ul class="pesquisa-resultado" style="display: none;" onclick="kitetsu()"></ul> --}}
            </div>
    
        <script>    

          function pesquisa(){

            let formulario = document.querySelector('#produtos');

            formulario.addEventListener('input', function (e) {
                let produtos = document.querySelectorAll('.item-p')
                let subtitle = document.querySelectorAll('h2')

                if(formulario.value.length > 0){

                subtitle.forEach( e => e.style.display = 'none')

                produtos.forEach((el, i)=>{
                    
                    el.style.display = 'none'

                    if(el.getAttribute('pesquisa').includes(formulario.value))
                        el.style.display = 'flex'

                })

                }
                else{

                    subtitle.forEach( e => e.style.display = 'block')
                    produtos.forEach((el, i)=>{

                        el.style.display = 'flex'
                    })



                }

                    // console.log(e)

            })
        }

        pesquisa();



        
        
        </script>

            <div class="pesquisa-pedido clearfix">
                @if(!preg_match('/loja-/', $_SERVER['REQUEST_URI']))
                @if(Session::get('client_id') && Session::get('login_client_token') && $_SERVER['REQUEST_URI'] != '/client/area-do-cliente')
                <!-- <form action="/delivery/pedido/pesquisa" method="POST">
                <label for="pesquisa">Já fez um pedido? Consulte-o aqui!</label>
                <div class="clearfix">
                
                    {{ csrf_field() }}
                    <input placeholder="Digite seu email.." name="email" id="email" type="text"/>
                    <input class="enviar" id="pesquisar-pedido" type="submit" value="Pesquisar">
                    <a href="#" id="recu-email-show"><span class="recuperar-email">Esqueceu seu e-mail?</span></a>
                    
                </div>
            </form> -->
                <span class="profile">
                    <span class="profile-img">
                        <?php
                        $useragent = $_SERVER['HTTP_USER_AGENT'];

                        ?>

                        @if(!empty(Session::get('client_name')))
                        <span class="profile-msg">Olá, {{ Session::get('client_name') }}!</span>
                        @endif
                        <img src="{{ asset('/img/sem-foto.png') }}" height="46" width="46" alt="Foto Perfil" title="Foto Perfil">
                    </span>
                    <ul class="profile-dropdown">
                        <li>
                            <a href="{{ route('clientes.address') }}" title="Meu Perfil">
                                Alterar Endereço
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('clientes.userdata') }}" title="Meus Endereços">
                                Meus Dados
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('clientes.order') }}" title="Meu Perfil">
                                Acompanhar Pedido
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('clientes.orders') }}" title="Meu Perfil">
                                Histórico de Pedidos
                            </a>
                        </li> <br>
                        <li>
                            <a href="{{ route('clientes.logout') }}" title="Sair"><img src="{{ asset('/img/sign-out.svg') }}" alt="">
                                Sair
                            </a>
                        </li>
                    </ul>
                </span>
            </div>

            @elseif($_SERVER['REQUEST_URI'] != '/client/area-do-cliente')

            <a href="/client/area-do-cliente"><button class="nav-login">Faça <strong>login</strong> ou <strong>cadastre-se!</strong></button></a>

            @endif
            @endif
        </div>
    </header>
    <div style="display:none;" id="div-loading" class="loading"><span>
            <div class="loader"></div>
        </span></div>
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P6QLJZP" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

    @yield("content")

</body>
@yield("footer-scripts")

</div>

<footer>
    Desenvolvido pela <a href="https://www.otimaideia.com.br">Ótima Ideia</a>
</footer>
</body>

</html>