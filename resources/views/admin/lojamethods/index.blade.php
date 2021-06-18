@extends('layouts.admin')

@section('title', 'Métodos de Pagamento por Loja')

@section('content_header')

<h1>Métodos de Pagamento por Loja</h1>

@stop

@section('content')

<div class="box">

    <div class="box-header with-border">

        <h3 class="box-title">

            <a href="{{ route('admin.lojapaymentmethod.create') }}" class="btn btn-info">Novo</a>

        </h3>

        <div class="box-tools pull-right">

            <!-- Buttons, labels, and many other things can be placed here! -->

            <!-- Here is a label for example -->

        </div>

        <!-- /.box-tools -->

    </div>

    <!-- /.box-header -->

    <div class="box-body table-responsive">

        @if(!$methods->isEmpty())

        <table class="table table-hover">

            <thead>

                <tr>

                    <th>#</th>

                    <th>Nome da loja</th>

                    <th>Métodos de Pagamento</th>

                    <!-- <th></th> -->

                </tr>

            </thead>

            <tbody>

                @foreach($methods as $method)

                <tr>

                    <td>

                        {{ $method->id }}

                    </td>

                    <td>
                        {{ $method->nome_loja }}

                    </td>

                    <td>

                        {{ $method->name_method}}

                    </td>

                    <!-- <td>

                                <a href="{{ route('admin.lojapaymentmethod.destroy', ['id' => $method->id]) }}" class="btn btn-danger">Excluir</a>

                            </td> -->

                </tr>

                @endforeach

            </tbody>

        </table>

        @else

        <p class="alert alert-info">Não há métodos de pagamento para listar</p>

        @endif

    </div>

    <!-- /.box-body -->

    <div class="box-footer">

        @if(!$methods->isEmpty())

        {{ $methods->links(null, ['classes' => ['pagination-sm', 'no-margin', 'pull-right'], 'ariaLabel' => 'Paginação de resultados']) }}

        @endif

    </div>

    <!-- box-footer -->

</div>

<!-- /.box -->

@endsection