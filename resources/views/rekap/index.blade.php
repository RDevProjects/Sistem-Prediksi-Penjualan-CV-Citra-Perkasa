@extends('include.layout')

@section('content')
    <div class="page-header">
        <h3 class="mb-3 fw-bold">Rekapitulasi Data Analisa</h3>
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
                <a href="{{ route('penjualan') }}">Rekapitulasi Data Analisa</a>
            </li>
        </ul>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-title">Rekapitulasi Data Analisa</div>
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
                    <form action="{{ route('rekap.detail') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="jumlah" class="me-2">Rekap Analisa</label>
                            <div class="d-flex justify-content-start align-items-center">
                                <select name="data" class="form-control me-2 w-50"> <!-- Mengatur lebar menjadi 50% -->
                                    <option value="" disabled selected>Pilih Tanggal Analisa</option>
                                    @foreach ($data as $item)
                                        <option value="{{ $item->created_at }}">{{ $item->created_at }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-success ms-2">Cari Data</button>
                            </div>
                        </div>
                    </form>
                    <hr>

                    @if (isset($structuredData) && count($structuredData) > 0)
                        <h5>Hasil Perhitungan</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered mt-4">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Bulan</th>
                                        <th>Tahun</th>
                                        <th>Data Aktual (At)</th>
                                        @foreach ($structuredData as $alpha => $values)
                                            <th>Nilai Prediksi (Ft) ({{ $alpha }})</th>
                                            <th>MAPE (%) ({{ $alpha }})</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $rowCount = count(current($structuredData)) - 1; // Minus 1 untuk 'total_mape'
                                    @endphp
                                    @for ($i = 0; $i < $rowCount; $i++)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $structuredData[array_key_first($structuredData)][$i]['bulan'] }}</td>
                                            <td>{{ $structuredData[array_key_first($structuredData)][$i]['tahun'] }}</td>
                                            <td>{{ $structuredData[array_key_first($structuredData)][$i]['At'] }}</td>
                                            @foreach ($structuredData as $alpha => $values)
                                                <td class="text-end">
                                                    {{ $i == 0 ? 0 : $values[$i]['Ft'] }}
                                                </td>
                                                <td class="text-end">
                                                    {{ $values[$i]['APE'] == 100 ? 0 : $values[$i]['APE'] }}%
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endfor
                                    <tr>
                                        <td colspan="4" class="text-center"><strong>MAPE</strong></td>
                                        @foreach ($structuredData as $alpha => $values)
                                            <td colspan="2" class="text-end">
                                                <strong>{{ $values['total_mape'] }}%</strong>
                                            </td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>


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

        @if (isset($structuredData) && count($structuredData) > 0)
            var ctx = document.getElementById("statisticsChart").getContext("2d");

            var datasets = [{
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
                @foreach ($structuredData as $alphaKey => $alphaData)
                    {
                        label: "Prediksi ({{ $alphaKey }})",
                        borderColor: getColor('{{ $alphaKey }}'), // Warna dinamis
                        pointBackgroundColor: getColor('{{ $alphaKey }}', 0.6),
                        pointRadius: 5,
                        backgroundColor: getColor('{{ $alphaKey }}', 0.4),
                        legendColor: getColor('{{ $alphaKey }}'),
                        fill: false,
                        borderWidth: 2,
                        data: @json(array_column($alphaData, 'Ft')),
                    },
                @endforeach
            ];

            var statisticsChart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: @json(array_column($structuredData['a0.1'], 'bulan')), // Gunakan alpha pertama sebagai referensi
                    datasets: datasets,
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
                                padding: 10,
                                // Sesuaikan skala agar lebih terlihat perbedaan
                                min: Math.min(...@json($dataPenjualan->pluck('jumlah'))) -
                                    10, // Tambahkan margin ke bawah
                                max: Math.max(...@json($dataPenjualan->pluck('jumlah'))) +
                                    10, // Tambahkan margin ke atas
                                stepSize: 10, // Atur step untuk memperjelas perbedaan antar nilai
                            },
                            gridLines: {
                                drawTicks: false,
                                display: true,
                                color: "rgba(0,0,0,0.1)" // Tambahkan grid untuk memperjelas posisi
                            },
                        }],
                        xAxes: [{
                            gridLines: {
                                zeroLineColor: "transparent",
                            },
                            ticks: {
                                padding: 10,
                                fontStyle: "500",
                            },
                        }],
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

            // Fungsi untuk menentukan warna berdasarkan alpha
            function getColor(alpha, opacity = 1) {
                const colors = {
                    'a0.1': `rgba(243, 84, 93, ${opacity})`,
                    'a0.3': `rgba(54, 162, 235, ${opacity})`,
                    'a0.5': `rgba(75, 192, 192, ${opacity})`,
                };
                return colors[alpha] || `rgba(201, 203, 207, ${opacity})`; // Default color
            }
        @endif

        myLegendContainer.innerHTML = statisticsChart.generateLegend();

        document.getElementById('saveForm').addEventListener('submit', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Jika Anda menyimpan, data penjualan yang dihitung akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, simpan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    </script>
@endpush
