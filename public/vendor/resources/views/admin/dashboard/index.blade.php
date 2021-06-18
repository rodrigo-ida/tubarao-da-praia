@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')



    <div class="row">

        <!-- primeira coluna -->
        <div class="col-lg-5">

            <!-- estatisticas -->
            <div class="row">
                <!-- clientes cadastrados -->
                <div class="col-xs-12 col-sm-6 col-lg-12">
                    <!-- Apply any bg-* class to to the info-box to color it -->
                    <div class="info-box bg-green">
                        <span class="info-box-icon"><i class="fa fa-users"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Pessoas cadastradas</span>
                            <span class="info-box-number">{{ $clientTotal  }}</span>
                            <!-- The progress section is optional -->
                            {{--<div class="progress">
                                <div class="progress-bar" style="width: 70%"></div>
                            </div>
                            <span class="progress-description">
                                70% Increase in 30 Days
                            </span>--}}
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- emails validados -->
                <div class="col-xs-12 col-sm-6 col-lg-12">
                    <!-- Apply any bg-* class to to the info-box to color it -->
                    <div class="info-box bg-blue">
                        <span class="info-box-icon"><i class="fa fa-envelope"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">E-mails validados</span>
                            <span class="info-box-number">{{ $validatedEmails }}</span>
                            <!-- The progress section is optional -->
                            <div class="progress">
                                <div class="progress-bar" style="width: {{ number_format($percentualvalidatedEmails, 0) }}%"></div>
                            </div>
                            <span class="progress-description">
                                {{  number_format($percentualvalidatedEmails, 2, ',', '.') }}% do total
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- cupons -->
                <div class="col-xs-12 col-sm-6 col-lg-12">
                    <!-- Apply any bg-* class to to the info-box to color it -->
                    <div class="info-box bg-aqua">
                        <span class="info-box-icon"><i class="fa fa-ticket"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Cupons</span>
                            <span class="info-box-number">{{ $couponTotal }}</span>
                            <!-- The progress section is optional -->
                            
                            <div class="progress">
                                <div class="progress-bar" style="width: {{ number_format($percentualUsedCoupons, 0) }}%"></div>
                            </div>
                            <span class="progress-description">
                                {{ $usedCouponTotal }} utilizados = {{  number_format($percentualUsedCoupons, 2, ',', '.') }}% do total
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            </div>
            <!-- /.row -->

            <!-- cupons -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Cupons Gerados <small>(somente ofertas ativas)</small></h3>

                            <div class="box-tools pull-right">
                                {{--<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body no-padding">
                            <ul class="nav nav-pills nav-stacked">
                                @foreach($offers as $offer)
                                <li>
                                    <a href="{{ route('admin.offers.show', ['id' => $offer->id]) }}">
                                        {{ $offer->titulo }}
                                        <span class="pull-right">
                                            <span class="label label-success">{{ $offer->used_coupons }}</span> /
                                            <span class="label label-info">{{ $offer->coupons_count }}</span>
                                        </span>
                                    </a>
                                </li>
                                @endforeach


                            </ul>
                            {{--<div class="table-responsive">
                                <table class="table no-margin">
                                    <tbody>
                                        @foreach($offers as $offer)
                                        <tr>
                                            <td>{{ $offer->titulo }}</td>
                                            <td><span class="label label-info">{{ $offer->coupons_count }}</span></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>--}}
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix no-padding">
                            <ul class="nav nav-pills nav-stacked">
                                <li>
                                    <a>
                                        <b>Total gerados:</b>
                                        <span class="pull-right text-green">{{ $totalCupons }}</span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <b>Utilizados/% do total:</b>
                                        <span class="pull-right text-green">{{$totalUsedCupons}} / {{ $porcentagemUtilizada }}%</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /.box -->
                </div>
            </div>
            <!-- /.row -->

            <!-- grafico historico cadastros -->
            <div class="row">
                <div class="col-lg-12">
                    <!-- Bar chart -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <i class="fa fa-bar-chart-o"></i>

                            <h3 class="box-title">Cadastros nos últimos {{ $minDate->diffInDays($maxDate) }} dias</h3>

                            <div class="box-tools pull-right">
                                {{--<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="chart-tooltip-x-only" id="bar-chart" style="height: 300px;"></div>
                        </div>
                        <!-- /.box-body-->
                    </div>
                    <!-- /.box -->
                </div>
                <div class="col-lg-12">
                    <!-- Bar chart -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <i class="fa fa-bar-chart-o"></i>
                            <h3 class="box-title">Cupons</h3>
                            <div class="box-tools pull-right">
                                {{--<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>--}}
                            </div>
                        </div>
                        <div class="box-body">
                            <div class="chart-tooltip-x-only" id="coupons-statistics-chart" style="height: 300px;"></div>
                        </div>
                        <!-- /.box-body-->
                    </div>
                    <!-- /.box -->
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="box no-border">
                            <div class="box-header">
                                <h3 class="box-title">Horário</h3>
                            </div>
                            <div class="box-body">
                                <div class="chart-tooltip-x-only" id="donut-chart-5" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.row -->

        </div>

        <!-- segunda coluna -->
        <div class="col-lg-7">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Segmentação de cadastros</h3>
                    <div class="box-tools pull-right">
                        <!-- Buttons, labels, and many other things can be placed here! -->
                        <!-- Here is a label for example -->
                    </div>
                    <!-- /.box-tools -->
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box no-border">
                                <div class="box-header">
                                    <h3 class="box-title">Cidade</h3>
                                </div>
                                <div class="box-body">
                                    <div class="chart-tooltip-x-only" id="donut-chart" style="height: 300px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="box no-border">
                                <div class="box-header">
                                    <h3 class="box-title">Bairro</h3>
                                </div>
                                <div class="box-body">
                                    <div class="chart-tooltip-x-only" id="donut-chart-2" style="height: 300px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box no-border">
                                <div class="box-header">
                                    <h3 class="box-title">Sexo</h3>
                                </div>
                                <div class="box-body">
                                    <div class="chart-tooltip-x-only" id="donut-chart-3" style="height: 300px;"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="box no-border">
                                <div class="box-header">
                                    <h3 class="box-title">Faixa Etária</h3>
                                </div>
                                <div class="box-body">
                                    <div class="chart-tooltip-x-only" id="chart-age-range" style="height: 300px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="box no-border">
                                <div class="box-header">
                                    <h3 class="box-title">Horário</h3>
                                </div>
                                <div class="box-body">
                                    <div class="chart-tooltip-x-only" id="donut-chart-4" style="height: 300px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <!-- /.box-body -->
                {{--<div class="box-footer">
                </div>--}}
                <!-- box-footer -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection

@push('js')
    <!-- FLOT CHARTS -->
    <script src="{{ asset('vendor/adminlte/plugins/flot/jquery.flot.min.js') }}"></script>
    <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
    <script src="{{ asset('vendor/adminlte/plugins/flot/jquery.flot.resize.min.js') }}"></script>
    <!-- FLOT PIE PLUGIN - also used to draw donut charts -->
    <script src="{{ asset('vendor/adminlte/plugins/flot/jquery.flot.pie.min.js') }}"></script>
    <!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts -->
    <script src="{{ asset('vendor/adminlte/plugins/flot/jquery.flot.categories.min.js') }}"></script>
    <!-- FLOT TIME -->
    <script src="{{ asset('vendor/adminlte/plugins/flot/jquery.flot.time.min.js') }}"></script>
@endpush

@section('js')
    <script>
        $(function () {
            /*
            * BAR CHART
            * ---------
            */

            $.get('{{ route('admin.dashboard.data.coupon') }}').done(function(response){

                var data = response.data;
                var items = data.items;
                var createdCoupons = [], usedCoupons = [];

                $.each(items, function (idx, o) {
                    createdCoupons.push([
                        o.timestamp * 1000, o.totals.created
                    ]);

                    usedCoupons.push([
                        o.timestamp * 1000, o.totals.used
                    ])
                });

                var created_data = {
                    data: createdCoupons,
                    color: "#3c8dbc",
                    label: 'Gerados',
                }, used_data = {
                    data: usedCoupons,
                    color: "#ff1f2b",
                    label: 'Utilizados',
                };

                $.plot("#coupons-statistics-chart", [created_data, used_data], {
                    grid: {
                        borderWidth: 1,
                        borderColor: "#f3f3f3",
                        tickColor: "#f3f3f3",
                        hoverable: true,
                    },
                    xaxis: {
                        mode: "time",
                        tickSize: [1, "day"],
                        timeformat: "%d/%m",
                        min: (new Date((data.interval.start - (3600 * 12)) * 1000)).getTime(),
                        max: (new Date((data.interval.end + (3600 * 12)) * 1000)).getTime()
                    }
                });
            });

            var bar_data = {

                data: [
                    @foreach($ultimosCadastros as $cadastroPorDia)
                    ["{{ strtotime($cadastroPorDia->day) * 1000 }}", {{ $cadastroPorDia->count }}],
                    @endforeach
                ],
                color: "#3c8dbc"
            };

            $.plot("#bar-chart", [bar_data], {
                grid: {
                    borderWidth: 1,
                    borderColor: "#f3f3f3",
                    tickColor: "#f3f3f3",
                    hoverable: true,
                },
                series: {
                    bars: {
                        show: true,
                        barWidth: 12 * 60 * 60 * 1000,
                        align: "center"
                    }
                },
                xaxis: {
                    mode: "time",
                    tickSize: [1, "day"],
                    timeformat: "%d/%m",
                    min: (new Date({{ ($minDate->getTimestamp() - (3600 * 12)) * 1000 }})).getTime(),
                    max: (new Date({{ ($maxDate->getTimestamp() + (3600 * 12)) * 1000 }})).getTime()
                }
            });
            /* END BAR CHART */

            /*
             * DONUT CHART
             * -----------
             */

            var donutData = [
                @foreach($cidades as $cidade)
                {label: "{{ $cidade->label }}", data: {{ $cidade->count }} },
                @endforeach
            ];

            $.plot("#donut-chart", donutData, {
                series: {
                    pie: {
                        show: true,
                        radius: 1,
                        innerRadius: 0.5,
                        label: {
                            show: true,
                            radius: 2 / 3,
                            formatter: labelFormatter,
                            threshold: 0.05,
                            background: {
                                opacity: 0.5,
                                color: '#000'
                            }
                        }

                    }
                },
                legend: {
                    show: true
                },
                grid: {
                    hoverable: true,
                }
            });

            var donutData2 = [
                @foreach($bairros as $bairro)
                {label: "{{ $bairro->label }}", data: {{ $bairro->count }} },
                @endforeach
            ];
            $.plot("#donut-chart-2", donutData2, {
                series: {
                    pie: {
                        show: true,
                        radius: 1,
                        innerRadius: 0.5,
                        label: {
                            show: true,
                            radius: 2 / 3,
                            formatter: labelFormatter,
                            background: {
                                opacity: 0.5,
                                color: '#000'
                            }
                        }
                    }
                },
                legend: {
                    show: true
                },
                grid: {
                    hoverable: true,
                }
            });

            var donutData3 = [
                    @foreach($sexo as $s)
                {label: "{{ $s->label != "" ? $s->label : 'Não cadastrado'  }}", data: {{ $s->count }} },
                @endforeach
            ];
            $.plot("#donut-chart-3", donutData3, {
                series: {
                    pie: {
                        show: true,
                        radius: 1,
                        innerRadius: 0.5,
                        label: {
                            show: true,
                            radius: 2 / 3,
                            formatter: labelFormatter,
                            background: {
                                opacity: 0.5,
                                color: '#000'
                            }
                        }

                    }
                },
                legend: {
                    show: true
                },
                grid: {
                    hoverable: true,
                }
            });

            var ageRangeData = [
                @foreach($ageRange as $e)
                    @if ($e->count > 0)
                    {label: "{{ $e->label }}", data: {{ $e->count }} },
                    @endif
                @endforeach
            ];
            $.plot("#chart-age-range", ageRangeData, {
                series: {
                    pie: {
                        show: true,
                        radius: 1,
                        innerRadius: 0.5,
                        label: {
                            show: true,
                            radius: 2 / 3,
                            formatter: labelFormatter,
                            background: {
                                opacity: 0.5,
                                color: '#000'
                            }
                        }

                    }
                },
                legend: {
                    show: true
                },
                grid: {
                    hoverable: true,
                }
            });

            var donutData4 = [
                @foreach($horaCadastro as $hora)
                {label: "{{ $hora->label }}", data: {{ $hora->count }} },
                @endforeach
            ];
            $.plot("#donut-chart-4", donutData4, {
                series: {
                    pie: {
                        show: true,
                        radius: 1,
                        innerRadius: 0.5,
                        label: {
                            show: true,
                            radius: 2 / 3,
                            formatter: labelFormatter,
                            background: {
                                opacity: 0.5,
                                color: '#000'
                            }
                        }

                    }
                },
                legend: {
                    show: true
                },
                grid: {
                    hoverable: true,
                }
            });


            var donutData5 = [
                    @foreach($origem as $orige)
                {label: "{{ $orige->label }}", data: {{ $orige->count }} },
                @endforeach
            ];
            $.plot("#donut-chart-5", donutData5, {
                series: {
                    pie: {
                        show: true,
                        radius: 1,
                        innerRadius: 0.5,
                        label: {
                            show: true,
                            radius: 2 / 3,
                            formatter: labelFormatter,
                            background: {
                                opacity: 0.5,
                                color: '#000'
                            }
                        }

                    }
                },
                legend: {
                    show: true
                },
                grid: {
                    hoverable: true,
                }
            });
            /*
             * END DONUT CHART
             */

            /*
             * Custom Label formatter
             * ----------------------
             */
            function labelFormatter(label, series) {
                return '<div style="font-size:13px; text-align:center; padding:2px; color: #FFF; font-weight: 600;">'
                    + Math.round(series.percent) + "%</div>";
            }

            $("<div id='tooltip'></div>").css({
                position: "absolute",
                display: "none",
                border: "1px solid #fdd",
                padding: "2px",
                "background-color": "rgb(34, 45, 50)",
                opacity: 0.80,
                color: "#fff",
            }).appendTo("body");

            $(".chart-tooltip-x-only").bind("plothover", function (event, pos, item) {

                if (item) {
                    var x = item.series.data[item.dataIndex][1],
                        label = item.series.label,
                        tipContent;

                    if (label !== undefined) {
                        tipContent = label + " : " + x;
                    } else {
                        tipContent = x;
                    }

                    $("#tooltip").html(tipContent)
                        .css({top: pos.pageY + 15, left: pos.pageX + 15})
                        .fadeIn(200);
                } else {
                    $("#tooltip").hide();
                }
            });

        });
    </script>

@endsection