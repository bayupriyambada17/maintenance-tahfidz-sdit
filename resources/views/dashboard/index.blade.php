@extends('layouts.dashboard')
@section('isi')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="far fa-chart-bar mr-2"></i>
                            Persentase Target
                        </h3>
                        <form action="{{ url('/dashboard') }}" method="GET">
                            <div class="float-right">
                                <div class="input-group">
                                    <select class="form-control @error('tahun') is-invalid @enderror" id="tahun" name="tahun" data-live-search="true">
                                        @for ($i = 2000; $i <= (date('Y')+10); $i++)
                                            @if(request('tahun', date('Y')) == $i)
                                                <option value="{{{ $i }}}" selected>{{ $i }}</option>
                                            @else
                                                <option value="{{{ $i }}}">{{ $i }}</option>
                                            @endif
                                        @endfor
                                    </select>
                                    @error('tahun')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body">
                        <div id="bar-chart" style="height: 300px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Chart</h3>

                        <div class="card-tools" style="color: rgb(140, 177, 128)">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                        </div>
                    </div>
                <div class="card-body">
                    <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <script src="{{ url('/adminlte/plugins/flot/jquery.flot.js') }}"></script>
        <script src="{{ url('/adminlte/plugins/flot/plugins/jquery.flot.resize.js') }}"></script>
        <script>
            $(function () {
                var kelasPersen = {!! json_encode($kelasPersen) !!};
                var kelasName = {!! json_encode($kelasName) !!};
                var targetName = {!! json_encode($targetName) !!};
                var targetPersen = {!! json_encode($targetPersen) !!};
                var bar_data = {
                    data : kelasPersen,
                    bars: { show: true }
                }

                $.plot('#bar-chart', [bar_data], {
                    grid  : {
                        borderWidth: 1,
                        borderColor: '#f3f3f3',
                        tickColor  : '#f3f3f3'
                    },
                    series: {
                        bars: {
                        show: true, barWidth: 0.5, align: 'center',
                        },
                    },
                    colors: ['#3c8dbc'],
                    xaxis : {
                        ticks: kelasName
                    }
                })


                var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
                var pieData        = {
                labels: targetName,
                datasets: [
                    {
                    data: targetPersen,
                    backgroundColor: [
                        "#f56954",
                        "#00a65a",
                        "#f39c12",
                        "#00c0ef",
                        "#3c8dbc",
                        "#d2d6de",
                        "rgb(230, 89, 89)",
                        "rgb(56, 74, 79)",
                        "rgb(140, 177, 128)",
                    ],
                    },
                ],
                };
                var pieOptions     = {
                maintainAspectRatio : false,
                responsive : true,
                }

                new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions
                })
            });

        </script>
    @endpush
@endsection
