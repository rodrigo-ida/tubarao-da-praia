{{ csrf_field() }}
@if ($_SERVER['REQUEST_URI'] != '/admin/products/create')
@if ($product->hasImage())
<div>
    <img src="{{ $product->getImageURL() }}" style="max-width: 300px;" />
</div>
@endif
@endif
<div class="form-group">
    {{ Form::label('image', 'Imagem')}}
    {{ Form::file('image', ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('Nome', 'Nome')}}
    {{ Form::text('name_product', null,  ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('Descrição do Produto', 'Descrição do Produto')}}
    {{ Form::text('description_product', null,  ['class' => 'form-control']) }}
</div>
<div id="prod-preco" class="form-group">
    {{ Form::label('Preço do Produto', 'Preço do Produto')}}
    {{ Form::number('price_product', null,  ['class' => 'form-control', 'step' => 'any']) }}
    <p><strong>Se o produto for variavél, o preço acima será "à partir de".</p>
</div>
<div class="form-group">
    <label for="promotion_day">
        Dia de Promoção
        <!-- <select name='promotion_day' > -->
        {{ Form::select('promotion_day', 
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
        <!-- <option value="0">Domingo</option>
            <option value="1">Segunda-feira</option>
            <option value="2">Terça-feira</option>
            <option value="3">Quarta-feira</option>
            <option value="4">Quinta-feira</option>
            <option value="5">Sexta-feira</option>
            <option value="6">Sábado</option>
        </select> -->

    </label>
</div>
<div class="form-group">
    <label for="promotion_price">
        Preço de promoção
        {{ Form::number('promotion_price', null,  ['class' => 'form-control', 'step' => 'any']) }}

    </label>
</div>
<div class="form-group">
    {{ Form::label('Promoção ativa', 'Promoção ativa')}}
    {{ Form::radio('promotion_active', '1' , false) }} sim
    {{ Form::radio('promotion_active', '0' , true) }} não
</div>
<div class="form-group">
    {{ Form::label('Status', 'Status')}}
    <!-- <select name="status_product" id="status_product">
        
        <option value="1">publicado</option>
        <option value="0">pausado</option>
    </select> -->
    {{ Form::select('status_product', 
            array(
                '1' => 'Publicado', 
                '0' => 'Pausado'
                )) 
            }}
</div>
<div class="form-group">
    {{ Form::label('category_id', 'Categoria')}}
    {{ Form::select('category_id', $categories) }}
</div>
<div class="form-group">
    {{ Form::label('category_id', 'Lojas')}}
    <?php
    if (isset($product)) {

        $array_rep = str_replace('"', '', str_replace(']', '', str_replace('[', '', $product->product_lojas_id)));
        $array = explode(',', $array_rep);
    }
    ?>
    @foreach($lojas as $loja)
    @if(isset($product) && in_array($loja->id, $array))
    {{ Form::checkbox('product_lojas_id[]', $loja->id, true) }}

    {{ $loja->nome_loja }}
    @else
    {{ Form::checkbox('product_lojas_id[]', $loja->id, false) }}

    {{ $loja->nome_loja }}
    @endif
    @endforeach
</div>
<div class="form-group">
    {{ Form::label('product_type', 'Tipo')}}

    {{ Form::radio('product_type', '0') }} Comum

    {{ Form::radio('product_type', '1') }} Variável

    {{ Form::radio('product_type', '2') }} Com complemento

    {{ Form::radio('product_type', '3') }} Combo
</div>
<div class="form-group">

    {{ Form::label('Ordenação do Produto') }}

    {{ Form::number('product_order', null, ['class' => 'form-control']) }}

</div>
@if(isset($variations))
@if(isset($product->product_type) && $product->product_type == "1")
<div id="varTable" class="form-group">
    <div class="box-header with-border">
        <h3 class="box-title">
            Variações
        </h3>
        <input type="button" id="add-variation" class="btn btn-info" value="+">
    </div>
    <?php $total = 0; ?>
    @foreach($variations as $variation)
    @if($variation->prod_id == $product->id && $variation->prod_var_status != 2)
    <div id="{{ $variation->id }}" class="variation">
        <label for="prod_var_name">
            Nome:
            <input type="text" name="prod_var_name[]" id="prod_var_name" value="{{ $variation->prod_var_name }}">

        </label>

        <label for="prod_var_price">
            Preço:
            <input type="number" step="any" name="prod_var_price[]" id="prod_var_price" value="{{ $variation->prod_var_price }}">

        </label>

        <label for="prod_var_active">
            Promoção ativa:
            <!-- <select name="prod_var_active[]" id="prod_var_active">
                            <option value="0">Desativado</option>
                            <option value="1">Ativo</option>
                        </select> -->
            {{ Form::select('prod_var_active[]', 
                            array(
                                '0' => 'Desativado', 
                                '1' => 'Ativo',
                                
                                ), $variation->prod_var_active) 
                            }}

        </label>

        <label for="prod_var_promo_day">
            Dia de Promoção
            {{ Form::select('prod_var_promo_day[]', 
                        array(
                            '0' => 'Domingo', 
                            '1' => 'Segunda-feira',
                            '2' => 'Terça-feira',
                            '3' => 'Quarta-feira',
                            '4' => 'Quinta-feira',
                            '5' => 'Sexta-feira',
                            '6' => 'Sábado'
                            ), $variation->prod_var_promo_day) 
                        }}
            <!-- <select name='prod_var_promo_day[]' >
                            <option value="0">Domingo</option>
                            <option value="1">Segunda-feira</option>
                            <option value="2">Terça-feira</option>
                            <option value="3">Quarta-feira</option>
                            <option value="4">Quinta-feira</option>
                            <option value="5">Sexta-feira</option>
                            <option value="6">Sábado</option>
                        </select> -->

        </label>

        <label for="prod_var_promo_price">
            Preço de promoção
            <input type="number" step="any" name="prod_var_promo_price[]" id="prod_var_promo_price" value="{{$variation->prod_var_promo_price}}">

        </label>

        <label for="prod_var_status">
            Ativo:
            <!-- <select name="prod_var_status[]" id="prod_var_status">
                            <option value="0">Desativado</option>
                            <option value="1">Ativo</option>
                        </select> -->
            {{ Form::select('prod_var_status[]', 
                            array(

                                '0' => 'Desativado', 
                                '1' => 'Ativo',
                                
                                ), $variation->prod_var_active) 
                            }}

        </label>

        <input type="hidden" name="var_id[]" value="{{ $variation->id }}">

        <input type="button" id="excluir-variacao" data-id="{{ $variation->id }}" value="excluir" class="btn btn-danger">

        <hr>
    </div>
    <?php $total++; ?>
    @endif
    @endforeach
    @if($total == 0)
    <div class="variation" style="display: none;">
        <label for="prod_var_name">
            Nome:
            <input type="text" name="prod_var_name[]" id="prod_var_name" value="">

        </label>

        <label for="prod_var_price">
            Preço:
            <input type="number" step="any" name="prod_var_price[]" id="prod_var_price" value="">

        </label>

        <label for="prod_var_active">
            Promoção ativa:
            <!-- <select name="prod_var_active[]" id="prod_var_active">
                            <option value="0">Desativado</option>
                            <option value="1">Ativo</option>
                        </select> -->
            {{ Form::select('prod_var_active[]', 
                            array(
                                '0' => 'Desativado', 
                                '1' => 'Ativo',
                                
                                )) 
                            }}
        </label>

        <label for="prod_var_promo_day">
            Dia de Promoção:
            <!-- <select name='prod_var_promo_day[]' >
                            <option value="0">Domingo</option>
                            <option value="1">Segunda-feira</option>
                            <option value="2">Terça-feira</option>
                            <option value="3">Quarta-feira</option>
                            <option value="4">Quinta-feira</option>
                            <option value="5">Sexta-feira</option>
                            <option value="6">Sábado</option>
                        </select> -->
            {{ Form::select('prod_var_promo_day[]', 
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
        </label>

        <label for="prod_var_promo_price">
            Preço de promoção:
            <input type="number" step="any" name="prod_var_promo_price[]" id="prod_var_promo_price" value="">

        </label>

        <label for="prod_var_status">
            Ativo:
            <!-- <select name="prod_var_status[]" id="prod_var_status">
                            <option value="0">Desativado</option>
                            <option value="1">Ativo</option>
                        </select> -->
            {{ Form::select('prod_var_status[]', 
                            array(
                                '0' => 'Desativado', 
                                '1' => 'Ativo',
                                
                                )) 
                            }}
        </label>

        <!-- <input type="button" id="excluir-variacao" value="excluir" class="btn btn-danger"> -->

        <hr>
    </div>
    @endif
</div>
@endif
@endif

<div id="complementsUl" style="@if(isset($product->product_type) != '2' || isset($product->product_type) != '0') display: none; @else display: block; @endif " class="form-group">
    @if(isset($complements))

    @foreach($complements as $comp)

    @if(!empty($product->product_comps))

    @foreach(json_decode($product->product_comps) as $c)

    @if($c == $comp->id)


    {{ Form::checkbox('product_comps[]', $comp->id, true) }}

    {{ $comp->name_complement }}

    <?php
    $bool = true;
    ?>


    @else

    <?php
    $bool = false;
    ?>

    @endif

    @endforeach

    @else

    <?php $bool = false; ?>

    @endif

    @if(!$bool)
    {{ Form::checkbox('product_comps[]', $comp->id, false) }}

    {{ $comp->name_complement }}
    @endif

    @endforeach
    @endif

</div>
@if(isset($product) && $product->product_type == \App\Product::PROD_COMBO)
<?php $lastCat = 0; ?>
<div id="comboTable" class="form-group">

    <div class="box-header with-border">

        <h3 class="box-title">

            Combo Variações

        </h3>

        {{ Form::select('categoria_de_produto', $categories) }}
        Quantidade: <input type="number" id="qtd_perms_add">
        <input type="button" id="add-combo-category" class="btn btn-info" value="+">

    </div>
    @if(!empty($comboVars))
    @foreach($comboVars as $var)


    @if($var->First()->cat_id != $lastCat)
    <div cat="{{ $var->First()->cat_id }}" class="combo-category-variation">

        <h3>
            {{ $var->First()->getComboCategory->name_category }}
        </h3>

        <input type="button" id="add-combo-variation" cat="{{ $var->First()->getComboCategory->id }}" num="{{ $var->First()->num_esc }}" catname="{{ $var->First()->getComboCategory->name_category }}" class="btn btn-info" value="+">

        <ul id="combo-{{ $var->First()->getComboCategory->name_category }}-variation">
            @foreach($comboVars as $variation)
            @if($var->First()->cat_id == $variation->First()->cat_id)
            <li cat="{{ $var->First()->cat_id }}" v="{{ $variation->First()->id }}">
                <div class="combo-variation">

                    <label for="variation_name">

                        Nome:

                        <input type="text" name="variation_name[]" id="variation_name" value="{{ $variation->First()->variation_name }}">
                        <input type="button" cat="{{ $var->First()->cat_id }}" id="{{ $variation->First()->id }}" class="btn btn-danger btn-excluir-combo-var" value="Excluir">
                    </label>

                    <input type="hidden" name="var_id[]" value="{{ $variation->First()->id }}">
                    <input type="hidden" name="num_esc[]" value="{{ $var->First()->num_esc }}">
                    <input type="hidden" name="cat_id[]" value="{{ $var->First()->getComboCategory->id }}">

                    <hr>

                </div>
            </li>
            @endif
            @endforeach
        </ul>

        <hr>

    </div>
    <?php $lastCat = $var->First()->cat_id; ?>
    @endif

    @endforeach
    @endif

    @endif
</div>

<script>
    $(document.body).on('click', '.btn-excluir-combo-var', function() {
        var id = $(this).attr('id'),
            vars = [],
            comboVars = $('input[name="var_id[]"]').each(function(input) {

                vars.push($(this).val());

            }),
            prodId = <?= $product->id ?? '0' ?>,
            cat = $(this).attr('cat');

        if (window.confirm('Tem certeza que deseja excluir essa variação?')) {
            $.ajax({
                url: '/admin/products/combo-variation/exclude',
                data: {
                    _token: '<?= csrf_token() ?>',
                    id: id,
                    pId: prodId,
                    vars: comboVars
                },
                type: "POST",
                success: function(response) {

                    if (response.response == true) {

                        $('li[v="' + id + '"').remove();

                        if ($('li[cat="' + cat + '"').length == 0) {
                            $('.combo-category-variation[cat="' + cat + '"').remove();
                        }

                        return;
                    }

                    alert('Não foi possível excluir a variação');

                },
                error: function(response) {
                    alert('Não foi possível excluir a variação');
                }
            });

        }

    });
    $(document.body).on('click', '#product_type', function(event) {
        var html = `
        <div id="comboTable" class="form-group">

            <div class="box-header with-border">

            <h3 class="box-title">

                Combo Variações

            </h3>
                
                {{ Form::select('categoria_de_produto', $categories) }}
                Quantidade: <input type="number" id="qtd_perms_add">
                <input type="button" id="add-combo-category" class="btn btn-info" value="+">

            </div>

        </div>`;

        if ($('.combo-variation').length >= 1) {
            return;
        }

        if ($(this).val() == '3' && $('#comboTable').length == 0) {

            $('#complementsUl').hide();
            $('#varTable').remove();

            $(html).insertAfter('.form-group:last');

        }

    });

    $(document.body).on('click', '#add-combo-category', function() {

        var cat = $('select[name="categoria_de_produto"] option:selected').val();

        var num = $('#qtd_perms_add').val();

        var name = $('select[name="categoria_de_produto"] option:selected').text();

        if (cat && num && $('.combo-category-variation[cat="' + cat + '"').length == 0) {

            var cv = `<div class="combo-category-variation">
        
                <h3>
                    ${$('select[name="categoria_de_produto"] option:selected').text()}
                </h3>
        
                <input type="button" id="add-combo-variation" cat="${cat}" num="${num}" catname="${name}" class="btn btn-info" value="+">
    
                <ul id="combo-${$('select[name="categoria_de_produto"] option:selected').text()}-variation">
    
                </ul>
                
                <hr>
                
                </div>`;

            $(cv).insertAfter('#comboTable div.box-header');
            return;
        }

        alert('Impossível adicionar 2 categorias iguais para um combo.')

    });

    $(document.body).on('click', '#add-combo-variation', function() {

        var id = $(this).attr('cat');

        var num = $(this).attr('num');

        var n = $(this).attr('catname');

        var v = `<div class="combo-variation">
    
        <label for="variation_name">
        
            Nome:
        
            <input type="text" name="variation_name[]" id="variation_name">
        
        </label>
        
        <input type="hidden" name="num_esc[]" value="${num}">
        <input type="hidden" name="cat_id[]" value="${id}">
        <hr>
        
        </div>`;

        $(v).insertAfter('#combo-' + n + '-variation');
    });
</script>