<div id="loading" class="load-layer hide" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: rgba(0,0,0,0.8)">
    <div class="load-layer-container">
        <i class="glyphicon glyphicon-refresh glyphicon-refresh-animate load-layer-icon"></i>
        <p class="load-layer-text">@if (isset($loading_layer_text)) {{ $loading_layer_text }} @else {{'Por favor, aguarde...'}} @endif</p>
    </div>
</div>

@section('footer-scripts')
    <script>
        $.loadingLayer = function (param) {
            switch (param) {
                case 'show':
                    $('.load-layer').removeClass('hide');
                    break;
                case 'hide':
                    $('.load-layer').addClass('hide');
                    break;
            }
        };
    </script>
@append