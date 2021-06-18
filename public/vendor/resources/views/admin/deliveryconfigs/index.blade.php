@extends('layouts.admin')

@section('title', 'Configurações de Delivery')

@section('content_header')
    <h1>Configurações de Delivery</h1>
@stop

@section('content')

    <div class="box">
        <div class="box-header with-border">
        <a href="{{route('admin.lojadeliveryconfig.create')}}"  class="btn btn-primary">Novo</a>
            <h3 class="box-title">
            </h3>
            <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
            @if(!$configs->isEmpty())
                <table class="table table-hover">
                    <thead>
                    <tr>
                        
                        <th>Dia</th>
                        <th>Hora de abertura</th>
                        <th>Hora de fechamento</th>
                        <th>Loja</th>
                        <th>Status</th>
                        <th></th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($configs as $config)
                        <tr>
                        
                            <td>

                                {{ $config->config_date }}

                            </td>
                            <td>

                                {{ $config->config_time }}                                

                            </td>
                            <td>

                                {{ $config->config_time_end }}

                            </td>
                            <td>
                            
                                {{ $config->getLoja()->First()->nome_loja }}
                            
                            </td>
                            <td>
                                
                                @if($config->config_status == '1')
                                    Ativado
                                    @else
                                    Desativado
                                @endif

                            </td>
                            <td>
                            
                                <a href="{{route('admin.lojadeliveryconfig.edit', ['id' => $config->id])}}"  class="btn btn-info">Editar</a>

                            </td>
                            
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="alert alert-info">Não há horários para listar</p>
            @endif
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            @if(!$configs->isEmpty())
                {{ $configs->links(null, ['classes' => ['pagination-sm', 'no-margin', 'pull-right'], 'ariaLabel' => 'Paginação de resultados']) }}
            @endif
        </div>
        <!-- box-footer -->
    </div>
    <!-- /.box -->
@endsection