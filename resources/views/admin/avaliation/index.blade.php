@extends('layouts.admin')

@section('title', 'Avaliações')

@section('content_header')
    <h1>Avaliações</h1>
@stop

@section('content')

    <div class="box">
        <div class="box-header with-border">
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
            @if(!$ava->isEmpty())
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Bairro</th>
                        <th>Cidade</th>
                        <th>Nota</th>
                        <th>Avaliação</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($ava as $a)
                        <tr>
                          
                            <td>
                                {{ $a->nome }}
                            </td>
                            <td>
                                {{ $a->bairro }}
                            </td>
                            <td>
                                {{ $a->cidade }}
                            </td>
                            <td>
                                {{ $a->avaliation_note }}
                            </td>
                            <td>
                                {{ $a->avaliation_desc }}
                            </td>
                            
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p class="alert alert-info">Não há lojas para listar</p>
            @endif
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
            @if(!$ava->isEmpty())
                
            @endif
        </div>
        <!-- box-footer -->
    </div>
    <!-- /.box -->
@endsection