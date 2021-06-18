@extends('layouts.admin')

@section('title', 'Cupons Validados')

@section('content_header')
    <h1>Cupons Validados</h1>
@stop

@section('content')
<div class="box">
    <div class="form-group">
        {{ Form::label('usuario', 'Usuario') }}
        {{ Form::select('id', $users) }}
    <button id="users-search" class="btn btn-success">
            <i class="fa fa-search"></i><span class="hidden-xs"> Pesquisar</span>
    </button>
    @if($_SERVER['REQUEST_URI'] != '/admin/cupom/validates')
    <button id="users-limpar" class="btn btn-danger">
            <i class="fa fa-times-circle-o"></i><span class="hidden-xs"> limpar</span>
    </button>
    @endif
</div>
    <div class="box">
        <div class="box-header with-border">
            <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
            @if(!$coupons->isEmpty())
                <table class="table table-hover">
                    <thead>
                    <tr>        
                        <th>Nome Cliente</th>
                        <th>Email Cliente</th>              
                        <th>Cupom</th>
                        <th>Usuário que validou</th>
                        <th>Loja</th>
                    </tr>
                    </thead>
                    <tbody>
                    
                    @foreach($coupons as $coupon)
                        <tr>
                            <td>
                                {{ $coupon->nome }}
                            </td>
                            <td>
                                {{ $coupon->email }}
                            </td>
                            <td>
                                {{ $coupon->validation_token }}
                            </td>
                            <td>
                                {{ $coupon->coupon_validation_user_name }}
                            </td>
                            <td>
                                {{ $coupon->nome_loja }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="alert alert-info">Não há cupons para listar</p>
            @endif
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
        @if(!$users->isEmpty())
            {{ $coupons->links(null, ['classes' => ['pagination-sm', 'no-margin', 'pull-right'], 'ariaLabel' => 'Paginação de resultados']) }}
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

                    window.location.href = '/admin/cupom/validated/search/' + id;    //<---- Add this line
            });
        });

        $(function () {
            $('#users-limpar').on('click', function(){
                var id = $('.form-group select option:selected').val();

                    window.location.href = '/admin/cupom/validated';    //<---- Add this line
            });
        });
    </script>
@endsection