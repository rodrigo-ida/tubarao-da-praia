
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
