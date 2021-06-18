@extends('layouts.admin')

@section('title', 'Relatórios')

@section('content_header')
    <h1>Relatórios</h1>
@stop

@section('content')

    <div class="box">
        <div class="box-header with-border">
            
            <div class="box-tools pull-right">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
            </div>
            <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
           
        <ul>
            <li style="display: inline-block; padding: 15px;"><div style="
            max-width: 18rem; 
            background-color: #28a745!important;
            color: #fff;
            display: flex;
            flex-direction: column;
            word-wrap: break-word;
            border: 1px solid rgba(0,0,0,.125);
            border-radius: .25rem;
            ">
                <div style="
                padding: .75rem 1.25rem;
                margin-bottom: 0;
                background-color: rgba(0,0,0,.03);
                border-bottom: 1px solid rgba(0,0,0,.125);
                ">Total de pedidos Concluídos</div>
                    <div class="card-body">
                    @foreach($totalOrders as $od)
                        @if($od->status_name == 'Concluído')
                            <p class="card-text" style="text-align: center; font-size: 24px;">{{ $od->total_orders }}</p>
                        @endif
                    @endforeach
                    </div>
            </div></li>
            <li style="display: inline-block; padding: 15px;"><div style="
            max-width: 18rem; 
            background-color: #dc3545!important;
            color: #fff;
            display: flex;
            flex-direction: column;
            word-wrap: break-word;
            border: 1px solid rgba(0,0,0,.125);
            border-radius: .25rem;
            ">
                <div style="
                padding: .75rem 1.25rem;
                margin-bottom: 0;
                background-color: #dc3545!important;
                color: #fff;
                word-wrap: break-word;
                border: 1px solid rgba(0,0,0,.125);
                border-radius: .25rem;
                ">Total de pedidos Cancelados</div>
                    <div class="card-body">
                    @foreach($totalOrders as $od)
                        @if($od->status_name == 'Cancelado')
                            <p class="card-text" style="text-align: center; font-size: 24px;">{{ $od->total_orders }}</p>
                        @endif
                    @endforeach
                    </div>
            </div></li>
        </ul>
        <div class="card-deck">
                <div class="card" style="border: 1px solid #f4f4f4; border-radius: 5px; margin-top: 50px;">
                    <div class="card-body">
                        <h3 class="card-title" style="padding: 10px;">Relatório: Ticket Total por Dia</h3>
                            <h4 style="text-align: center;">De <strong>{{ date('d/m/Y', strtotime($firstOrder))}}</strong> até <strong>Hoje</strong></h5>
                        <table class="table table-hover">
                            <thead>
                                <tr>

                                    <th>Dia</th>

                                    <th>Nº Pedidos</th>

                                    <th>Valor Total</th>

                                </tr>
                                <tbody>
                                @foreach($avgTotalPerDay as $avgT)
                                    <tr>

                                         <td>{{ date_format($avgT->created_at, 'Y-m-d') }}</td>

                                        <td>{{$avgT->orders}}</td>

                                        <td>R${{ number_format($avgT->total, 2, ',', '.') }}</td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        
        
        
        
            <div class="card-deck">
                <div class="card" style="border: 1px solid #f4f4f4; border-radius: 5px;">
                    <div class="card-body">
                        <h3 class="card-title" style="padding: 10px;">Relatório: Faturamento das lojas</h3>
                            <h4 style="text-align: center;">De <strong>{{ date('d/m/Y', strtotime($firstOrder))}}</strong> até <strong>Hoje</strong></h5>
                        <table class="table table-hover">
                            <thead>
                                <tr>

                                    <th>Loja</th>
                                    
                                    <th>Total Pedidos</th>

                                    <th>Sem taxa</th>

                                    <th>Com taxa</th>

                                </tr>
                                <tbody>
                                @foreach($withTaxReport as $with)
                                    @foreach($noTaxReport as $no)
                                        @if($with->nome_loja == $no->nome_loja)
                                            <tr>

                                                <td>{{ $with->nome_loja }}</td>

                                                <td>{{ $with->total_orders }}</td>

                                                <td>R${{ number_format($no->total, 2, ',', '.') }}</td>

                                                <td>R${{ number_format($with->total, 2, ',', '.') }}</td>

                                            </tr>
                                        @endif
                                    @endforeach
                                @endforeach
                                </tbody>
                            </thead>
                        </table>
                    </div>
                    <span style="float: right; padding: 10px; font-size: 20px;">Total com taxa: <strong>R${{ number_format($totalReport, 2, ',', '.') }}</strong></span>
                </div>
            </div>
            
             <div class="card-deck">
                <div class="card" style="border: 1px solid #f4f4f4; border-radius: 5px;">
                    <div class="card-body">
                        <h3 class="card-title" style="padding: 10px;">Relatório: Preferencia de Pagamento</h3>
                            <h4 style="text-align: center;">De <strong>{{ date('d/m/Y', strtotime($firstOrder))}}</strong> até <strong>Hoje</strong></h5>
                        <table class="table table-hover">
                            <thead>
                                <tr>

                                    <th>Metodo de Pagamento</th>
                                    
                                    <th>Total Pedidos</th>


                                    <th>Valor sem taxa</th>

                                </tr>
                                <tbody>
                                @foreach($preferPaymets as $prefer)
                                   
                                       
                                            <tr>

                                                <td>{{ $prefer->name_method }}</td>

                                                <td>{{ $prefer->total_orders }}</td>

                                                <td>R${{ number_format($prefer->total, 2, ',', '.') }}</td>

                                                

                                            </tr>
                                       
                                   
                                @endforeach
                                </tbody>
                            </thead>
                        </table>
                    </div>
                    <span style="float: right; padding: 10px; font-size: 20px;">Total com taxa: <strong>R${{ number_format($totalReport, 2, ',', '.') }}</strong></span>
                </div>
            </div>
        
        <div class="card-deck">
                <div class="card" style="border: 1px solid #f4f4f4; border-radius: 5px; margin-top: 50px;">
                    <div class="card-body">
                        <h3 class="card-title" style="padding: 10px;">Relatório: Faturamento por bairro</h3>
                            <h4 style="text-align: center;">De <strong>{{ date('d/m/Y', strtotime($firstOrder))}}</strong> até <strong>Hoje</strong></h5>
                        <table class="table table-hover">
                            <thead>
                                <tr>

                                    <th>Bairro</th>

                                    <th>Sem taxa</th>

                                    <th>Com taxa</th>

                                </tr>
                                <tbody>
                                <?php $totalNeigh = 0; ?>
                                @foreach($neighborhood as $nei)
                                    @foreach($neighNoTax as $neiNo)
                                        @if($nei->order_neighborhood == $neiNo->order_neighborhood)
                                            <tr>

                                                <td>{{ $nei->order_neighborhood }}</td>

                                                <td>R${{ number_format($neiNo->total, 2, ',', '.') }}</td>

                                                <td>R${{ number_format($nei->total, 2, ',', '.') }}</td>

                                            </tr>
                                            <?php $totalNeigh += $nei->total; ?>
                                        @endif
                                    @endforeach
                                @endforeach
                                </tbody>
                            </thead>
                        </table>
                    </div>
                    <span style="float: right; padding: 10px; font-size: 20px;">Total com taxa: <strong>R${{ number_format($totalNeigh, 2, ',', '.') }}</strong></span>
                </div>
            </div>

            <div class="card-deck">
                <div class="card" style="border: 1px solid #f4f4f4; border-radius: 5px; margin-top: 50px;">
                    <div class="card-body">
                        <h3 class="card-title" style="padding: 10px;">Relatório: Ticket médio por bairro</h3>
                            <h4 style="text-align: center;">De <strong>{{ date('d/m/Y', strtotime($firstOrder))}}</strong> até <strong>Hoje</strong></h5>
                        <table class="table table-hover">
                            <thead>
                                <tr>

                                    <th>Bairro</th>

                                    <th>Nº Pedidos</th>

                                    <th>Valor médio</th>

                                </tr>
                                <tbody>
                                @foreach($avgTotal as $avg)
                                    <tr>

                                        <td>{{ $avg->order_neighborhood }}</td>

                                        <td>{{$avg->orders}}</td>

                                        <td>R${{ number_format($avg->total, 2, ',', '.') }}</td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            </div>
        </div>
        <!-- box-footer -->
    </div>
    <!-- /.box -->
@endsection