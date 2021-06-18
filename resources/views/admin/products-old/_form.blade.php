{{ csrf_field() }}
@if ($_SERVER['REQUEST_URI'] != '/admin/products/create')
    @if ($product->hasImage())
        <div>
            <img src="{{ $product->getImageURL() }}" style="max-width: 300px;"/>
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

    @foreach($lojas as $loja)
        
            {{ Form::checkbox('product_lojas_id[]', $loja->id) }} 

            {{ $loja->nome_loja }}

    @endforeach
</div>
<div class="form-group">
    {{ Form::label('product_type', 'Tipo')}}

    {{ Form::radio('product_type', '0') }} Comum 

    {{ Form::radio('product_type', '1') }} Variável

    {{ Form::radio('product_type', '2') }} Com complemento

</div>
<div class="form-group">

    {{ Form::label('Ordenação do Produto') }}

    {{ Form::number('product_order', null, ['class' => 'form-control']) }}

</div>
@if(isset($variations))
    @if(isset($product->product_type) == "1")
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
                        <input type="number" step="any" name="prod_var_promo_price" id="prod_var_promo_price" value="{{$variation->prod_var_promo_price}}">

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
            <div class="variation">
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

<div id="complementsUl" style="@if(isset($product->product_type) != '2') display: none; @else display: block; @endif " class="form-group">

@foreach($complements as $comp)

    @if(!empty(isset($product->product_comps)))
        @foreach(json_decode(isset($product->product_comps)) as $c)

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

</div>