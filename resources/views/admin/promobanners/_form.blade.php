{{ csrf_field() }}
@if ($_SERVER['REQUEST_URI'] != '/admin/promotion/banner/create')
@if ($banner->hasImage())
<div>
    <img src="{{ $banner->getImageURL() }}" style="max-width: 300px;" />
</div>
@endif
@endif
<div class="form-group">
    {{ Form::label('image', 'Imagem')}}
    {{ Form::file('image', ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('promo_banner_product_id', 'Produto') }}
    {{ Form::select('promo_banner_prod_id', $products) }}
</div>
<div class="form-group">
    {{ Form::label('promo_banner_day', 'Dia')}}
    {{ Form::select('promo_banner_day', 
            array(
                '0' => 'Domingo', 
                '1' => 'Segunda-feira',
                '2' => 'Terça-feira',
                '3' => 'Quarta-feira',
                '4' => 'Quinta-feira',
                '5' => 'Sexta-feira',
                '6' => 'Sábado'
                )) 
            }}
</div>
<div class="form-group">
    {{ Form::label('Loja', 'Loja') }}
    {{ Form::select('promo_banner_loja_id', $lojas) }}
</div>
<div class="form-group">
    {{ Form::label('Banner Home', 'Banner Home') }}
    {{ Form::radio('promo_banner_home', '0') }} Nâo
    {{ Form::radio('promo_banner_home', '1') }} Sim
</div>