@extends('layouts.admin')

@section('title', 'Clientes')

@section('content_header')
    <h1>Oferta</h1>
@stop

@section('content')

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">{{ $offer->titulo }}<br />
                <small>{{ $offer->descricao }}</small>
            </h3>
            <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
                <a href="javascript:history.back()" class="btn btn-primary">Voltar</a>
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
            <p class="lead">
                <span class="label label-info">Cupons Gerados: {{ $offer->coupons->count() }}</span><br/>
                <span class="label label-success">Cupons Utilizados: {{ $offer->used_coupons_count }}</span>
            </p>
            @if(!$coupons->isEmpty())
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Cadastro Cliente/th>
                    <th>Gerado em:</th>
                    <th>Utilizado em:</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($coupons as $coupon)
                    <tr>
                        <td>{{ $coupon->client->nome }}</td>
                        <td>{{ Carbon\Carbon::parse($coupon->client->created_at)->format('d/m/Y | H:i:s') }}

                            </td>
                        <td>{{ Carbon\Carbon::parse($coupon->created_at)->format('d/m/Y | H:i:s') }}</td>
                        <td>
                            @if (!is_null($coupon->validation_date))
                            {{ Carbon\Carbon::parse($coupon->validation_date)->format('d/m/Y | H:i:s') }}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <p class="alert alert-info">Não há nenhum Cupom para listar</p>
            @endif
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            @if(!$coupons->isEmpty())
            {{ $coupons->links(null, ['classes' => ['pagination-sm', 'no-margin', 'pull-right'], 'ariaLabel' => 'Paginação de resultados']) }}
            @endif
        </div>
        <!-- box-footer -->
    </div>
    <!-- /.box -->
@endsection