@extends('layouts.admin')

@section('title', 'Lojas')

@section('content_header')
    <h1>Lojas</h1>
@stop

@section('content')

    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                <a href="{{ route('admin.lojas.index')}}" class="btn btn-info">Voltar</a>
            </h3>
            <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">       
            @if(!empty($loja))
                        <ul class="list-group">    
                            <h1>{{ $loja->nome_loja }}</h1>
                            <li class="list-group-item">
                                <h2>Logradouro</h2>
                            </li>             
                            <li class="list-group-item">
                             <span><strong>Rua/Av</strong></span>
                            </li>
                            <li class="list-group-item">
                            @if(!empty($loja->logradouro_loja))
                             {{ $loja->logradouro_loja }}
                             @else
                              -
                            @endif
                            </li>       
                            <li class="list-group-item">
                             <span><strong>Número</strong></span>
                            </li>
                            <li class="list-group-item">
                            @if(!empty($loja->numero_loja))
                             {{ $loja->numero_loja }}
                             @else
                              -
                            @endif
                            </li>
                            <li class="list-group-item">
                             <span><strong>Bairro</strong></span>
                            </li>
                            <li class="list-group-item">
                             @if(!empty($loja->bairro_loja))
                                {{ $loja->bairro_loja }}
                             @else
                                -
                             @endif
                            </li>
                            <li class="list-group-item">
                             <span><strong>Cidade</strong></span>
                            </li>
                            <li class="list-group-item">
                             @if(!empty($loja->cidade_loja))
                                {{ $loja->cidade_loja }}
                             @else
                                -
                             @endif
                            </li>
                            <li class="list-group-item">
                             <span><strong>Estado</strong></span>
                            </li>
                            <li class="list-group-item">
                            @if(!empty($loja->estado_loja))
                             {{ $loja->estado_loja }}
                             @else
                              -
                            @endif
                            </li>
                            <li class="list-group-item">
                             <span><strong>Cep</strong></span>
                            </li>
                            <li class="list-group-item">
                            @if(!empty($loja->cep_loja))
                             {{ $loja->cep_loja }}
                             @else
                              -
                            @endif
                            </li>
                            <li class="list-group-item">
                                <h2>Contatos</h2>
                            </li>
                            <li class="list-group-item">
                             <span><strong>Telefone</strong></span>
                            </li>
                            <li class="list-group-item">
                             @if(!empty($loja->telefone_loja))
                                {{ $loja->telefone_loja }}
                             @else
                                -
                             @endif
                            </li>
                            <li class="list-group-item">
                             <span><strong>Whatsapp</strong></span>
                            </li>
                            <li class="list-group-item">
                            @if(!empty($loja->whatsapp_loja))
                             {{ $loja->whatsapp_loja }}
                             @else
                              -
                            @endif
                            </li>
                            <li class="list-group-item">
                             <span><strong>Email</strong></span>
                            </li>
                            <li class="list-group-item">
                            @if(!empty($loja->email_loja))
                             {{ $loja->email_loja }}
                             @else
                              -
                            @endif
                            </li>
                            <li class="list-group-item">
                             <span><strong>Site</strong></span>
                            </li>
                            <li class="list-group-item">
                             @if(!empty($loja->site_loja)) 
                                <a href="https://{{ $loja->site_loja }}">{{ $loja->site_loja }}</a>
                             @else
                                -
                             @endif
                            </li>
                            <li class="list-group-item">
                             <span><strong>Facebook</strong></span>
                            </li>
                            <li class="list-group-item">
                             @if(!empty($loja->facebook_loja))
                                <a href="https://{{ $loja->facebook_loja }}">{{ $loja->facebook_loja }}</a>
                             @else
                                -
                             @endif
                            </li>
                        </ul>
            @else
                <p class="alert alert-danger">Erro ao listar a loja.</p>
            @endif
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
        </div>
        <!-- box-footer -->
    </div>
    <!-- /.box -->
@endsection