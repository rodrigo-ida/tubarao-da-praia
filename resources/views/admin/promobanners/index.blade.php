@extends('layouts.admin')

@section('title', 'Banner de Promoção')

@section('content_header')
    <h1>Banner de Promoção</h1>
@stop

@section('content')
        <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                <a href="{{ route('admin.banner.create') }}" class="btn btn-info">Novo</a>
            </h3>
            <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
            @if(!$banners->isEmpty())
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Imagem</th>
                        <th>Produto</th>
                        <th>Dia</th>
                        <th>Loja</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($banners as $banner)
                        <tr>
                            <td>             
                                  
                                <img style="width: 60px; height: 60px;" src="{{ $banner->getImageURL() }}" />
                            
                            </td>
                            <td>

                                {{ $banner->getProduct()->First()->name_product }}

                            </td>
                            <td>
                                @if($banner->promo_banner_day == 0)
                                    Domingo
                                    @elseif($banner->promo_banner_day == 1)
                                    Segunda-feira
                                    @elseif($banner->promo_banner_day == 2)
                                    Terça-feira
                                    @elseif($banner->promo_banner_day == 3)
                                    Quarta-feira
                                    @elseif($banner->promo_banner_day == 4)
                                    Quinta-feira
                                    @elseif($banner->promo_banner_day == 5)
                                    Sexta-feira
                                    @elseif($banner->promo_banner_day == 6)
                                    Sábado
                                @endif
                            </td>
                            <td>
                                
                                {{ $banner->getLoja()->First()->nome_loja }}

                            </td>
                            <td>
                                <a href="{{ route('admin.banner.edit', ['id' => $banner->id]) }}" class="btn btn-default">Editar</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="alert alert-info">Não há banners de promoção para listar</p>
            @endif
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            @if(!$banners->isEmpty())
            {{ $banners->links(null, ['classes' => ['pagination-sm', 'no-margin', 'pull-right'], 'ariaLabel' => 'Paginação de resultados']) }}
            @endif
        </div>
        <!-- box-footer -->
    </div>
    <!-- /.box -->
@endsection

@section('js')
    <script>
        $(function () {
            $('#users-search').on('click', function(){
                var id = $('.form-group select option:selected').val();

                    window.location.href = '/admin/users/search/' + id;    //<---- Add this line
            });
        });

        $(function () {
            $('#users-limpar').on('click', function(){
                var id = $('.form-group select option:selected').val();

                    window.location.href = '/admin/users';    //<---- Add this line
            });
        });
    </script>
@endsection