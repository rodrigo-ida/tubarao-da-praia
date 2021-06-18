@extends('layouts.admin')



@section('title', 'Tempos de troca de status')



@section('content_header')

    <h1>Tempos de troca de status</h1>

@stop

@section('content')

<div class="box">

<div class="box-body table-responsive">

    @if(!$times->isEmpty())

        <table class="table table-hover">

            <thead>

            <tr>

                <th>ID pedido</th>

                <th>Nome usuário</th>

                <th>Status</th>

                <th>Horário de atualização</th>

            </tr>

            </thead>

            <tbody>

            @foreach($times as $time)

                <tr>

                    <td>             

                        {{ $time->order_status_updated_id }}

                    </td>

                    <td>

                        {{ $time->getUser()->First()->name }}

                    </td>

                    <td>
                    
                        {{ $time->order_status_name }}
                    
                    </td>

                    <td>
                        
                        {{ date_format($time->created_at, 'd/m/Y H:i:s') }}
                
                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    @else

        <p class="alert alert-info">Não há taxas de entrega para listar</p>

    @endif

</div>

<!-- /.box-body -->

<div class="box-footer">

    @if(!$times->isEmpty())

    {{ $times->links(null, ['classes' => ['pagination-sm', 'no-margin', 'pull-right'], 'ariaLabel' => 'Paginação de resultados']) }}

    @endif

</div>

<!-- box-footer -->

</div>

@endsection