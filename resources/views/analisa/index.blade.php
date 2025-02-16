@extends('include.layout')

@section('content')
    <div class="page-header">
        <h3 class="mb-3 fw-bold">Data Peramalan</h3>
        <ul class="mb-3 breadcrumbs">
            <li class="nav-home">
                <a href="#">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="{{ route('penjualan') }}">Data Peramalan</a>
            </li>
        </ul>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-title">Data Peramalan</div>
                        <div>
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('store.penjualan') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="jumlah" class="me-2">Pilih Alpha</label>
                            <div class="d-flex align-items-center">
                                <div class="col-6">
                                    <select class="form-control me-2" id="jumlah" name="jumlah">
                                        <option value="">Pilih Alpha</option>
                                        @foreach ($alphas as $alpha)
                                            <option value="{{ $alpha }}"
                                                {{ old('jumlah') == $alpha ? 'selected' : '' }}>Alpha {{ $alpha }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6 mx-3">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                    <button type="button" class="btn btn-warning" onclick="resetJumlah()">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form action="{{ route('storeAll.penjualan') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary">Post All</button>
                    </form>
                    <hr>

                    @if (isset($dataPerhitungan) && count($dataPerhitungan) > 0)
                        <h5>Hasil Perhitungan</h5>
                        <table class="table table-bordered mt-4">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Bulan</th>
                                    <th>Tahun</th>
                                    <th>Data Aktual (At)</th>
                                    <th>Forecast (Ft)</th>
                                    <th>APE (%)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataPerhitungan as $index => $row)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $row['bulan'] }}</td>
                                        <td>{{ $row['tahun'] }}</td>
                                        <td>{{ $row['At'] }}</td>
                                        <td>{{ $row['Ft'] }}</td>
                                        <td>{{ $row['APE'] }}%</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5" class="text-center"><strong>MAPE</strong></td>
                                    <td><strong>{{ $mape }}%</strong></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="card-body">
                            <div class="chart-container" style="min-height: 300px">
                                <canvas id="statisticsChart"></canvas>
                            </div>
                            <div id="myChartLegend"></div>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection

@push('script')
    <!-- Include jQuery and DataTables JS & CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#penjualanTable').DataTable({
                "paging": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "responsive": true,
                "pageLength": 5
            });
        });

        function resetJumlah() {
            document.getElementById('jumlah').value = '';
        }

        @if (isset($dataPerhitungan) && count($dataPerhitungan) > 0)
            var ctx = document.getElementById("statisticsChart").getContext("2d");

            var statisticsChart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: @json(array_column($dataPerhitungan, 'bulan')),
                    datasets: [{
                            label: "Aktual",
                            borderColor: "#fdaf4b",
                            pointBackgroundColor: "rgba(253, 175, 75, 0.6)",
                            pointRadius: 5,
                            backgroundColor: "rgba(253, 175, 75, 0.4)",
                            legendColor: "#fdaf4b",
                            fill: false,
                            borderWidth: 2,
                            data: @json($dataPenjualan->pluck('jumlah')),
                        },
                        {
                            label: "Prediksi",
                            borderColor: "#f3545d",
                            pointBackgroundColor: "rgba(243, 84, 93, 0.6)",
                            pointRadius: 5,
                            backgroundColor: "rgba(243, 84, 93, 0.4)",
                            legendColor: "#f3545d",
                            fill: false,
                            borderWidth: 2,
                            data: @json(array_column($dataPerhitungan, 'Ft'))
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    legend: {
                        display: false,
                    },
                    tooltips: {
                        bodySpacing: 4,
                        mode: "nearest",
                        intersect: 0,
                        position: "nearest",
                        xPadding: 10,
                        yPadding: 10,
                        caretPadding: 10,
                    },
                    layout: {
                        padding: {
                            left: 5,
                            right: 5,
                            top: 15,
                            bottom: 15
                        },
                    },
                    scales: {
                        yAxes: [{
                            ticks: {
                                fontStyle: "500",
                                beginAtZero: true,
                                maxTicksLimit: 5,
                                padding: 10,
                            },
                            gridLines: {
                                drawTicks: false,
                                display: false,
                            },
                        }, ],
                        xAxes: [{
                            gridLines: {
                                zeroLineColor: "transparent",
                            },
                            ticks: {
                                padding: 10,
                                fontStyle: "500",
                            },
                        }, ],
                    },
                    legendCallback: function(chart) {
                        var text = [];
                        text.push('<ul class="' + chart.id + '-legend html-legend">');
                        for (var i = 0; i < chart.data.datasets.length; i++) {
                            text.push(
                                '<li><span style="background-color:' +
                                chart.data.datasets[i].legendColor +
                                '"></span>'
                            );
                            if (chart.data.datasets[i].label) {
                                text.push(chart.data.datasets[i].label);
                            }
                            text.push("</li>");
                        }
                        text.push("</ul>");
                        return text.join("");
                    },
                },
            });

            var myLegendContainer = document.getElementById("myChartLegend");

            myLegendContainer.innerHTML = statisticsChart.generateLegend();
        @endif
        myLegendContainer.innerHTML = statisticsChart.generateLegend();
    </script>
@endpush
