@extends('layouts.admin')

@section('title', 'Usuários')

@section('content_header')
    <h1>Usuários</h1>
@stop

@section('content')
        <div class="box">
            <div class="form-group">
                {{ Form::label('Loja', 'Loja') }}
                {{ Form::select('loja_id', $lojas) }}
            <button id="users-search" class="btn btn-success">
                    <i class="fa fa-search"></i><span class="hidden-xs"> Pesquisar</span>
            </button>
            @if($_SERVER['REQUEST_URI'] != '/admin/users')
            <button id="users-limpar" class="btn btn-danger">
                <i class="fa fa-times-circle-o"></i><span class="hidden-xs"> limpar</span>
            </button>
            @endif
        </div>
        <div class="box-header with-border">
            <h3 class="box-title">
                <a href="{{ route('admin.users.create') }}" class="btn btn-info">Nova</a>
            </h3>
            <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
            @if(!$users->isEmpty())
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Permissão</th>
                        <th>Grupo de loja</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>             
                                  
                                {{ $user->id }}
                            
                            </td>
                            <td>
                                {{ $user->name }}
                            </td>
                            <td>
                                {{ $user->email }}
                            </td>
                            <td>
                                @if($user->role == 1)
                                 Admin
                                 @elseif($user->role == 0)
                                 Loja
                                 @else
                                 Cliente
                                @endif
                            </td>
                            <td>
                                @if($user->loja_id == 0)
                                    Não vinculado à loja
                                    @else
                                    {{$user->nome_loja}}
                                @endif
                            </td>
                            <td></td>
                            <td>
                                <a href="{{ route('admin.users.edit', ['id' => $user->id]) }}" class="btn btn-default">Editar</a>
                                <a href="{{ route('admin.users.destroy', ['id' => $user->id]) }}" class="btn btn-danger">Excluir</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="alert alert-info">Não há usuários para listar</p>
            @endif
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            @if(!$users->isEmpty())
            {{ $users->links(null, ['classes' => ['pagination-sm', 'no-margin', 'pull-right'], 'ariaLabel' => 'Paginação de resultados']) }}
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