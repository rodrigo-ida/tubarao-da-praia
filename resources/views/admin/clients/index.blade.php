@extends('layouts.admin')

@section('title', 'Clientes')

@section('content_header')
<h1>Clientes</h1>
@stop

@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"></h3>
        <div class="col-md-2">

            <span class="label label-primary">Total: {{ $paginator->total() }}</span>

        </div>
        <div class="box-tools pull-right">

            <input type="button" class="btn btn-info" id="export-csv" value="exportar CSV">

            <!-- Buttons, labels, and many other things can be placed here! -->
            <!-- Here is a label for example -->
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <form id="client-search-form">
            <div class="input-group">
                @if ($searchTerm != '')
                <div class="input-group-btn">
                    <button class="btn btn-danger" onclick="document.getElementsByName('search')[0].value = '';">
                        <i class="fa fa-remove"></i><span class="hidden-xs"> Limpar</span>
                    </button>
                </div>
                @endif
                <input name="search" id="client-search-term-input" type="text" class="form-control" placeholder="Digite para pesquisar por nome, email ou whatsapp" value="{!! $searchTerm !!}">
                <div class="input-group-btn">
                    <button class="btn btn-info">
                        <i class="fa fa-search"></i><span class="hidden-xs"> Pesquisar</span>
                    </button>
                </div>
            </div>
        </form>
        @if(!$paginator->isEmpty())
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Whatsapp</th>
                        <th>Origem</th>
                        <th>Data Cadastro</th>
                        <th>Último Login</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client)
                    <tr>
                        <td><a href="{{route('admin.clients.show', ['id' => $client->id ])}}">{{ $client->nome }}</a></td>
                        <td>{{ $client->email }}</td>
                        <td>{{ $client->whatsapp }}</td>
                        <td>{{ $client->origem }}</td>
                        <td>{{ $client->created_at }}</td>
                        <td>{{ $client->last_login }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="alert alert-info">Não há nenhum Cliente para listar</p>
        @endif
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        @if(!$paginator->isEmpty())
        {{ $paginator->links(null, ['classes' => ['pagination-sm', 'no-margin', 'pull-right'], 'ariaLabel' => 'Paginação de resultados']) }}
        @endif
    </div>
    <!-- box-footer -->
</div>
<!-- /.box -->
@endsection

@section('js')
<script>
    $(function() {
        $('#client-search').on('keypress', function() {
            if (e.which == 13) {
                $('form#client-search-form').submit();
                return false; //<---- Add this line
            }
        });

        $('#export-csv').on('click', function() {
            window.open('{{ route("admin.export-csv") }}');
        });

    });
</script>
@endsection