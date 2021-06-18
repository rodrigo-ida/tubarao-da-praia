
        {{ csrf_field() }}
@if ($_SERVER['REQUEST_URI'] != '/admin/pcategories/create')
    @if ($categorie->hasImage())
        <div>
            <img src="{{ $categorie->getImageURL() }}" style="max-width: 300px;"/>
        </div>
    @endif
@endif
<div class="form-group">
    {{ Form::label('image', 'Imagem')}}
    {{ Form::file('image', ['class' => 'form-control']) }}
</div>
<div class="form-group">
    {{ Form::label('Nome', 'Nome')}}
    {{ Form::text('name_category', null,  ['class' => 'form-control']) }}
</div>
<div class="form-group">

    {{ Form::label('Ordenação do Categoria') }}

    {{ Form::number('category_order', null, ['class' => 'form-control']) }}

</div>