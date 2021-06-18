{{ csrf_field() }}


<div class="row">
    <div class="col-md-3 form-group add-image">
        @if ($_SERVER['REQUEST_URI'] != '/admin/products/create')
        @if ($product->hasImage())
        <img src="{{ $product->getImageURL() }}" id="Tela" Name="Tela" width="125px" height="125px"></img>
        @else

        <img src="{{ asset('img/image-default-prod.png  ') }}" id="Tela" Name="Tela" width="125px" height="125px"></img>

        @endif

        @else

        <img src="{{ asset('img/image-default-prod.png  ') }}" id="Tela" Name="Tela" width="125px" height="125px"></img>

        @endif
        <label for="image">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17" fill="#ECF0F5">
                <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z">
                </path>
            </svg>
            <span>Escolha a imagem</span> </label>

        <input class="form-control" name="image" type="file" id="image">

    </div>

    <script>
        function enviar_imagem(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#Tela').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#image").change(function() {
            enviar_imagem(this);
        });
    </script>
    <div class="col-md-9">
        <div class=" form-group">

            <label for="Status">Status</label>

            <!-- <select name="status_product" id="status_product">

        

        <option value="1">publicado</option>

        <option value="0">pausado</option>

    </select> -->

            {{ Form::select('status_product', 
                                    array(
                                        '1' => 'Publicado', 
                                        '0' => 'Pausado'
                                        ), ['class' => 'form-control']) 
                                    }}

        </div>

        <div class="form-group">

            {{ Form::label('category_id', 'Categoria')}}
            {{ Form::select('category_id', $categories, isset($product) ? $product->category_id : null, ['class' => 'form-control']) }}

        </div>

        <div class="form-group">

            {{ Form::label('category_id', 'Lojas') }}

            <?php
            if (isset($product)) {

                $array_rep = str_replace('"', '', str_replace(']', '', str_replace('[', '', $product->product_lojas_id)));
                $array = explode(',', $array_rep);
            }
            ?>

            @foreach($lojas as $loja)
            @if(isset($product) && in_array($loja->id, $array))
            <label class="checkbox-custom">

                {{ $loja->nome_loja }}
                {{ Form::checkbox('product_lojas_id[]', $loja->id, true) }}
                <span class="checkmark"></span>
            </label>
            @else
            <label class="checkbox-custom">
                {{ $loja->nome_loja }}
                {{ Form::checkbox('product_lojas_id[]', $loja->id, false, ['class' => 'checkbox-custom']) }}
                <span class="checkmark"></span>
            </label>
            @endif
            @endforeach

            <br>

        </div>
    </div>
</div>
<div class="form-group col-md-6">

    {{ Form::label('Nome', 'Nome')}}
    {{ Form::text('name_product', null,  ['class' => 'form-control']) }}

</div>
<div id="prod-preco" class="form-group  col-md-6">

    <label for="Preço do Produto">Preço (R$)</label>

    {{ Form::number('price_product', null,  ['class' => 'form-control', 'step' => 'any']) }}

    <!-- <p><strong>Se o produto for variavél, o preço acima será "à partir de".</strong></p><strong> -->

    </strong>
</div>
<div class="form-group col-md-12">

    {{ Form::label('Descrição do Produto', 'Descrição do Produto')}}
    {{ Form::text('description_product', null,  ['class' => 'form-control']) }}

</div>
<div class="form-group col-md-12">



    {{ Form::label('Ordenação do Produto') }}

    {{ Form::number('product_order', null, ['class' => 'form-control']) }}



    <br>
</div>



<strong>
    <div class="col-md-6 ">
        <div class="content-promo">
            <svg fill="#D7E0EB" xmlns="http://www.w3.org/2000/svg" height="50px" viewBox="-41 0 480 480" width="50px">
                <path d="m199.101562 480c108.550782-.488281 196.894532-87.46875 199.0625-195.996094 2.171876-108.527344-82.621093-198.976562-191.0625-203.804687v-72.199219c0-4.417969-3.582031-8-8-8-4.417968 0-8 3.582031-8 8v72.199219c-108.441406 4.828125-193.234374 95.277343-191.0624995 203.804687 2.1718755 108.527344 90.5156255 195.507813 199.0624995 195.996094zm0-304c4.417969 0 8-3.582031 8-8v-5.777344c6.273438 3.621094 9.332032 11.003906 7.457032 18-1.875 6.992188-8.214844 11.859375-15.457032 11.859375-7.238281 0-13.578124-4.867187-15.453124-11.859375-1.875-6.996094 1.183593-14.378906 7.453124-18v5.777344c0 4.417969 3.582032 8 8 8zm-8-79.800781v48.9375c-15.601562 4.027343-25.773437 19.03125-23.742187 35.015625 2.027344 15.984375 15.628906 27.96875 31.742187 27.96875 16.117188 0 29.714844-11.984375 31.746094-27.96875s-8.140625-30.988282-23.746094-35.015625v-48.9375c99.96875 4.351562 178.132813 87.789062 175.957032 187.828125-2.175782 100.039062-83.894532 180-183.957032 180-100.058593 0-181.777343-79.960938-183.953124-180-2.175782-100.039063 75.988281-183.476563 175.953124-187.828125zm0 0" />
                <path d="m146.304688 398.398438c3.53125 2.652343 8.546874 1.9375 11.199218-1.597657l96-128c2.648438-3.535156 1.933594-8.550781-1.601562-11.199219-3.535156-2.652343-8.546875-1.9375-11.199219 1.597657l-96 128c-2.652344 3.535156-1.933594 8.550781 1.601563 11.199219zm0 0" />
                <path d="m159.101562 320c17.675782 0 32-14.328125 32-32s-14.324218-32-32-32c-17.671874 0-32 14.328125-32 32s14.328126 32 32 32zm0-48c8.839844 0 16 7.164062 16 16s-7.160156 16-16 16c-8.835937 0-16-7.164062-16-16s7.164063-16 16-16zm0 0" />
                <path d="m207.101562 368c0 17.671875 14.328126 32 32 32 17.675782 0 32-14.328125 32-32s-14.324218-32-32-32c-17.671874 0-32 14.328125-32 32zm48 0c0 8.835938-7.160156 16-16 16-8.835937 0-16-7.164062-16-16s7.164063-16 16-16c8.839844 0 16 7.164062 16 16zm0 0" />
            </svg>
            <h2>Promoção do Produto</h2>

            <div class="form-group ">
                <br>
                <label for="promotion_day">

                    Dia de Promoção

                    <? { {

                            if (isset($product)) {

                                echo $product->promotion_day;
                            }
                        }
                    } ?>
                    <!-- <select name='promotion_day' > -->

                    {{ Form::select('promotion_day', 
                                            array(
                                                '0' => 'Domingo', 
                                                '1' => 'Segunda-feira',
                                                '2' => 'Terça-feira',
                                                '3' => 'Quarta-feira',
                                                '4' => 'Quinta-feira',
                                                '5' => 'Sexta-feira',
                                                '6' => 'Sábado',
                                                '7' => 'Todos os dias'
                                                ), ['class' => 'form-control']) 
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

                    Preço promocional (R$)

                    {{ Form::number('promotion_price', null,  ['class' => 'form-control', 'step' => 'any']) }}

                </label>

            </div>

            <div class="form-group">

                <label for="Promoção ativa">Promoção ativa</label><br>
                <label class="radio-custom">
                    Sim
                    {{ Form::radio('promotion_active', '1' , false) }}
                    <span class="checkmark"></span>

                </label>
                <label class="radio-custom">Não

                    {{ Form::radio('promotion_active', '0' , true) }}

                    <span class="checkmark"></span>

                </label>

            </div>
        </div>
    </div>
    <div class="col-md-6">
    </div>

    <div class="col-md-12">

        <div class="form-group">
            <br>
            <h3>Tipo do Produto</h3><br>

            <label class="radio-custom">Comum

                {{ Form::radio('product_type', '0') }}
                <span class="checkmark"></span>
            </label>
            <label class="radio-custom">Variável
                {{ Form::radio('product_type', '1') }}

                <span class="checkmark"></span>
            </label>
            <label class="radio-custom">Com complemento
                {{ Form::radio('product_type', '2') }}

                <span class="checkmark"></span>
            </label>
            <label class="radio-custom">Combo

                {{ Form::radio('product_type', '3') }}
                <span class="checkmark"></span>
            </label>

        </div>

    </div>

    @if(isset($variations))
    @if(isset($product->product_type) && $product->product_type == "1")
    <div id="varTable" class="form-group col-md-12">
        <div class="box-header with-border">
            <input type="button" id="add-variation" class="btn btn-info" value="+ Adiciona Variação">
        </div>
        <?php $total = 0; ?>
        @foreach($variations as $variation)
        @if($variation->prod_id == $product->id && $variation->prod_var_status != 2)
        <div id="{{ $variation->id }}" class="variation row">
            <div class="form-group col-md-4">
                <label for="prod_var_name">
                    Nome:
                </label>
                <input type="text" name="prod_var_name[]" class="form-control" id="prod_var_name" value="{{ $variation->prod_var_name }}">

            </div>


            <div class="form-group col-md-4">
                <label for="prod_var_price">
                    Preço:
                </label>
                <input type="number" step="any" name="prod_var_price[]" class="form-control" id="prod_var_price" value="{{ $variation->prod_var_price }}">

            </div>

            <div class="form-group col-md-4">
                <label for="prod_var_active">
                    Promoção ativa:
                </label>
                <!-- <select name="prod_var_active[]" id="prod_var_active">
                                                        <option value="0">Desativado</option>
                                                        <option value="1">Ativo</option>
                                                    </select> -->
                {{ Form::select('prod_var_active[]', 
                                                        array(
                                                            '0' => 'Desativado', 
                                                            '1' => 'Ativo',
                                                            
                                                            ), $variation->prod_var_active, ['class' => 'form-control']) 
                                                        }}


            </div>

            <div class="form-group col-md-4">
                <label for="prod_var_promo_day">
                    Dia de Promoção
                </label>
                {{ Form::select('prod_var_promo_day[]', 
                                                    array(
                                                        '0' => 'Domingo', 
                                                        '1' => 'Segunda-feira',
                                                        '2' => 'Terça-feira',
                                                        '3' => 'Quarta-feira',
                                                        '4' => 'Quinta-feira',
                                                        '5' => 'Sexta-feira',
                                                        '6' => 'Sábado'
                                                        ), $variation->prod_var_promo_day, ['class' => 'form-control']) 
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

            </div>

            <div class="form-group col-md-4">

                <label for="prod_var_promo_price">
                    Preço de promoção
                </label>
                <input type="number" step="any" name="prod_var_promo_price[]" class="form-control" id="prod_var_promo_price" value="{{$variation->prod_var_promo_price}}">


            </div>

            <div class="form-group col-md-4">
                <label for="prod_var_status">
                    Ativo:
                </label>
                <!-- <select name="prod_var_status[]" id="prod_var_status">
                                                        <option value="0">Desativado</option>
                                                        <option value="1">Ativo</option>
                                                    </select> -->
                {{ Form::select('prod_var_status[]', 
                                                        array(

                                                            '0' => 'Desativado', 
                                                            '1' => 'Ativo',
                                                            
                                                            ), $variation->prod_var_active, ['class' => 'form-control']) 
                                                        }}

            </div>

            <input type="hidden" name="var_id[]" value="{{ $variation->id }}">

            <input type="button" id="excluir-variacao" data-id="{{ $variation->id }}" value="excluir" class="btn btn-danger">

            <hr>

        </div>
        <?php $total++; ?>
        @endif
        @endforeach
        @if($total == 0)
        <div class="variation row" style="display: none;">
            <div class="form-group col-md-4">
                <label for="prod_var_name">
                    Nome:
                </label>
                <input type="text" name="prod_var_name[]" class="form-control" id="prod_var_name" value="">

            </div>

            <div class="form-group col-md-4">

                <label for="prod_var_price">
                    Preço:
                </label>
                <input type="number" step="any" name="prod_var_price[]" class="form-control" id="prod_var_price" value="">


            </div>

            <div class="form-group col-md-4">
                <label for="prod_var_active">
                    Promoção ativa:
                </label>
                <!-- <select name="prod_var_active[]" id="prod_var_active">
                                                            <option value="0">Desativado</option>
                                                            <option value="1">Ativo</option>
                                                        </select> -->
                {{ Form::select('prod_var_active[]', 
                                                            array(
                                                                '0' => 'Desativado', 
                                                                '1' => 'Ativo',
                                                                
                                                                ), ['class' => 'form-control']) 
                                                            }}
            </div>

            <div class="form-group col-md-4">
                <label for="prod_var_promo_day">
                    Dia de Promoção:
                </label>
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
                                                            ), ['class' => 'form-control']) 
                                                        }}
            </div>

            <div class="form-group col-md-4">
                <label for="prod_var_promo_price">
                    Preço de promoção:
                </label>
                <input type="number" step="any" name="prod_var_promo_price[]" class="form-control" id="prod_var_promo_price" value="">

            </div>

            <div class="form-group col-md-4">
                <label for="prod_var_status">
                    Ativo:
                    <!-- <select name="prod_var_status[]" id="prod_var_status">
                                                            <option value="0">Desativado</option>
                                                            <option value="1">Ativo</option>
                                                        </select> -->
                </label>
                {{ Form::select('prod_var_status[]', 
                                                            array(
                                                                '0' => 'Desativado', 
                                                                '1' => 'Ativo',
                                                                
                                                                ), ['class' => 'form-control']) 
                                                            }}
            </div>

            <!-- <input type="button" id="excluir-variacao" value="excluir" class="btn btn-danger"> -->

            <hr>
        </div>
        @endif
    </div>
    @endif
    @endif

    <div class="col-md-12">
        <div id="complementsUl" style=" @if(isset($product) && $product->product_type == '2') display: block; @else display: none; @endif " class="form-group">
            @if(isset($complements))

            @foreach($complements as $comp)

            @if(!empty($product->product_comps))

            @foreach(json_decode($product->product_comps) as $c)

            @if($c == $comp->id)


            {{ Form::checkbox('product_comps[]', $comp->id, true) }}

            <label for="{{ $comp->name_complement }}">{{ $comp->name_complement }}</label>

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

            <label for="{{ $comp->name_complement }}">{{ $comp->name_complement }}</label>
            @endif

            @endforeach
            @endif

        </div>

    </div>
</strong>
@if(isset($product) && $product->product_type == \App\Product::PROD_COMBO)
<?php $lastCat = 0; ?>
<div id="comboTable" class="form-group">

    <div class="box-header with-border">

        <div class="form-group col-md-3">

            Categoria

            {{ Form::select('categoria_de_produto', $categories, ['class' => 'form-control', 'name' => 'categoria_de_produto']) }}
        </div>
        <div class="form-group col-md-3">

            Quantidade de produtos: <input class="form-control" type="number" id="qtd_perms_add">

        </div>
        <div class="col-md-4" style="margin-top: 19px;">
            <input type="button" id="add-combo-category" class="btn btn-info" value="Adicionar combo">
        </div>


    </div>

    @if(!empty($comboVars))
    @foreach($comboVars as $var)


    @if($var->First()->cat_id != $lastCat)
    <div cat="{{ $var->First()->cat_id }}" class="combo-category-variation">

        <h3>
            {{ $var->First()->getComboCategory->name_category }}
        </h3>

        <input type="button" id="add-combo-variation" cat="{{ $var->First()->getComboCategory->id }}" num="{{ $var->First()->num_esc }}" catname="{{ $var->First()->getComboCategory->name_category }}" class="btn btn-info" value="+">

        <ul id="combo-@php echo str_replace(" "," _",$var->First()->getComboCategory->name_category ); @endphp-variation" hidden>
            @foreach($comboVars as $key => $variation)

            @if($var->First()->cat_id == $variation->First()->cat_id)
            <li cat="{{ $var->First()->cat_id }}" v="{{ $variation->First()->id }}">
                <script>
                    $.ajax({
                        url: "https://pedidos.tubaraodapraia.com.br/admin/ajax-edit",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "id": "{{$var->First()->getComboCategory->id}}",
                            "num": "{{$var->First()->num_esc}}",
                            "varName": "{{$variation->First()->refer_product}},{{$variation->First()->variation_name}}",
                            "idProd": "{{$id}}",
                            "idProdCatPai": "{{$product->category_id}}",
                            "idComboId": "{{$variation->First()->id}}"


                        }
                    }).done(function(data) {

                        console.log("{{$var}},{{$var->First()->variation_name}}")
                        $(data).insertAfter('#combo-' + "{{$var->First()['getComboCategory']->name_category}}".replace(/ /g, '_') + '-variation');
                    });
                </script>
            </li>
            @endif
            @endforeach
        </ul>

        <hr>
    </div>
</div>
<?php $lastCat = $var->First()->cat_id; ?>
@endif

@endforeach
@endif

@endif
</div>

<script>
    var produtos = ['test'];
    var shiftVar = 0;
    $(document.body).on('click', '.btn-excluir-combo-var', function() {
        var id = $(this).attr('id'),
            vars = [],
            comboVars = $('input[name="var_id[]"]').each(function(input) {

                vars.push($(this).val());

            }),
            prodId = '<?= $product->id ?? '0' ?>',
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
    $(document.body).on('click', 'input[name="product_type"]', function(event) {
        var html = `
        <div id="comboTable" class="form-group">

            <div class="box-header with-border">

                <div class="form-group col-md-3">

                    Categoria
                    {{ Form::select('categoria_de_produto', $categories, ['class' => 'form-control', 'name' => 'categoria_de_produto']) }}

                </div>
                <div class="form-group col-md-3">

                    Quantidade de produtos: <input class="form-control" type="number" id="qtd_perms_add">

                </div>
                <div class="col-md-4" style="margin-top: 19px;">
                    <input type="button" id="add-combo-category" class="btn btn-info" value="Adicionar combo">
                </div>


            </div>

        </div>`;

        if ($('.combo-variation').length >= 1) {
            return;
        }

        if ($('#complementsUl').css('display') == 'block') {

            $('#complementsUl').hide();

        }

        if ($(this).val() == '3' && $('#comboTable').length == 0) {

            $('#varTable').remove();

            $(html).insertAfter('.form-group:last');

        }

    });

    $(document.body).on('click', '#add-combo-category', function() {

        var cat = $('select[name="categoria_de_produto"] option:selected').val();

        var num = $('#qtd_perms_add').val();

        var name = $('select[name="categoria_de_produto"] option:selected').text().replace(" ", "_");;



        if (cat && num && $('.combo-category-variation[cat="' + cat + '"').length == 0) {

            var cv = `<div class="combo-category-variation">
        
                <h3>
                    ${$('select[name="categoria_de_produto"] option:selected').text()}
                </h3>
        
                <input type="button" id="add-combo-variation" cat="${cat}" num="${num}" catname="${name}" class="btn btn-info" value="+">
    
                <ul id="combo-${$('select[name="categoria_de_produto"] option:selected').text().replace(" ", "_")}-variation">
    
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

        $.ajax({
            url: "https://pedidos.tubaraodapraia.com.br/admin/ajax-category",
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "id": id,
                "num": num,
                "n": n
            }
        }).done(function(data) {
            console.log(data);
            //colocar a logica de replace do item acima
            $(data).insertAfter('#combo-' + n.replace(/ /g, '_') + '-variation');
        });









    });
</script>