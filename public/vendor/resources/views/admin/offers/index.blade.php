@extends('layouts.admin')

@section('title', 'Clientes')

@section('content_header')
    <h1>Ofertas</h1>
@stop

@section('content')

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                <a href="{{ route('admin.offers.create') }}" class="btn btn-info">Nova</a>
            </h3>
            <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
            @if(!$result->isEmpty())
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Inicia em</th>
                        <th>Expira em</th>
                        <th>Ativo</th>
                        <th>
                            Cupons
                            <small class="text-muted" style="font-style: normal; font-weight: normal;">
                                (utilizados/gerados)
                            </small>
                        </th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($result as $offer)
                        <tr>
                            <td>
                                <a href="{{route('admin.offers.show', ['id' => $offer->id ])}}">
                                    {{ $offer->titulo }}
                                </a>
                            </td>
                            <td>
                                @if(! is_null($offer->begins_at))
                                    <span>{{ Carbon\Carbon::parse($offer->begins_at)->format('d/m/Y') }}</span>
                                @else
                                    <span></span>
                                @endif
                            </td>
                            <td>
                                @if(! is_null($offer->expires_at))
                                    <span>{{ Carbon\Carbon::parse($offer->expires_at)->format('d/m/Y') }}</span>
                                @else
                                    <span></span>
                                @endif
                            </td>
                            <td>
                                @if($offer->active)
                                <i class="fa fa-check"></i>
                                @endif
                            </td>
                            <td>{{ $offer->used_coupons_count }} / {{ $offer->coupons_count }}</td>
                            <td>
                                <a href="{{ route('admin.offers.edit', ['id' => $offer->id]) }}" class="btn btn-default">Editar</a>
                                <a href="{{ route('admin.offers.show', ['id' => $offer->id]) }}" class="btn btn-default">Ver</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="alert alert-info">Não há nenhuma Oferta para listar</p>
            @endif
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            @if(!$result->isEmpty())
                {{ $result->links(null, ['classes' => ['pagination-sm', 'no-margin', 'pull-right'], 'ariaLabel' => 'Paginação de resultados']) }}
            @endif
        </div>
        <!-- box-footer -->
    </div>
    <!-- /.box -->
@endsection