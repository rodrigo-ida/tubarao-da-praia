@extends('layouts.admin')

@section('title', 'Clientes')

@section('content_header')
<h1>Clientes</h1>
@stop

@section('content')
<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">Visualização de Cadastro</h3>
        <div class="box-tools pull-right">
            <!-- Buttons, labels, and many other things can be placed here! -->
            <!-- Here is a label for example -->
            <a href="javascript:history.back()" class="btn btn-primary">Voltar</a>
        </div>
        <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive">
        <table class="table table-hover">
            <tbody>
                <tr>
                    <td><b>Nome</b></td>
                    <td>{{ $client->nome }}</td>
                </tr>
                <tr>
                    <td><b>E-mail</b></td>
                    <td>{{ $client->email }}</td>
                </tr>
                <tr>
                    <td><b>Whatsapp</b></td>
                    <td>{{ $client->whatsapp }}</td>
                </tr>
                <tr>
                    <td><b>CEP</b></td>
                    <td>{{ $client->cep}}</td>
                </tr>
                <tr>
                    <td><b>Estado</b></td>
                    <td>{{ $client->estado}}</td>
                </tr>
                <tr>
                    <td><b>Cidade</b></td>
                    <td>{{ $client->cidade}}</td>
                </tr>
                <tr>
                    <td><b>Bairro</b></td>
                    <td>{{ $client->bairro}}</td>
                </tr>
                <tr>
                    <td><b>Logradouro</b></td>
                    <td>{{ $client->logradouro}}</td>
                </tr>
                <tr>
                    <td><b>Número</b></td>
                    <td>{{ $client->numero}}</td>
                </tr>
                <tr>
                    <td><b>Complemento</b></td>
                    <td>{{ $client->complemento}}</td>
                </tr>

                <tr>
                    <td><b>Origem Campanha</b></td>
                    <td>{{ $client->origem}}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
    </div>
    <!-- box-footer -->
</div>
<!-- /.box -->
@endsection