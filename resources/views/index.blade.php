@extends('include.layout')
@section('content')
    <div class="pt-2 pb-4 d-flex align-items-left align-items-md-center flex-column flex-md-row">
        <div>
            <h3 class=" fw-bold">Dashboard</h3>
            <h6 class="mb-2 op-7">Selamat Datang ke
                {{ env('APP_NAME') }}</h6>
        </div>
    </div>
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
    <div class="row">
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="text-center icon-big icon-info bubble-shadow-small">
                                <i class="fas fa-money-bill-wave-alt"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Data Transaksi</p>
                                <h4 class="card-title">{{ $penjualanCount ?? '-' }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="text-center icon-big icon-success bubble-shadow-small">
                                <i class="fas fa-luggage-cart"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Penjualan</p>
                                <h4 class="card-title">
                                    {{ number_format($daftarPenjualan->sum('jumlah') ?? 0, 0, ',', '.') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="text-center icon-big icon-primary bubble-shadow-small">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category">Users Admin</p>
                                <h4 class="card-title">{{ $userCount ?? '-' }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Dashboard</div>
                    </div>
                </div>
                <div class="p-0 card-body">
                    <div class="d-flex justify-content-center text-center">
                        <span class="text-uppercase fw-bold fs-3 w-75 my-4">aplikasi prediksi penjualan produk apar di
                            cv citra perkasa dengan
                            metode peramalan exponential smoothing</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card card-round">
                <div class="card-header">
                    <div class="card-head-row card-tools-still-right">
                        <div class="card-title">Riwayat Transaksi</div>
                    </div>
                </div>
                <div class="p-0 card-body">
                    <div class="table-responsive">
                        <!-- Projects table -->
                        <table class="table mb-0 align-items-center">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Payment Number</th>
                                    <th scope="col">Bulan</th>
                                    <th scope="col" class="text-end">Tahun</th>
                                    <th scope="col" class="text-end">Jumlah Penjualan</th>
                                    <th scope="col" class="text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($daftarPenjualan as $penjualan)
                                    <tr>
                                        <th scope="row">
                                            {{ $penjualan->id }}
                                        </th>
                                        <td>
                                            {{ $penjualan->bulan }}
                                        </td>
                                        <td class="text-end">
                                            {{ $penjualan->tahun }}
                                        </td>
                                        <td class="text-end">
                                            {{ number_format($penjualan->jumlah, 0, ',', '.') }}
                                        </td>
                                        <td class="text-end">
                                            <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                                                <i class="fa fa-check"></i>
                                            </button>{{ $penjualan->payment_number }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-primary card-round">
                <div class="card-header">
                    <div class="card-head-row">
                        <div class="card-title">Rata-Rata Penjualan Perbulan</div>
                    </div>
                    <div class="card-category">{{ $daftarPenjualan->first()->bulan ?? 'Belum ada data penjualan' }}
                        {{ $daftarPenjualan->first()->tahun ?? '' }}
                        -
                        {{ $daftarPenjualan->last()->bulan ?? '' }} {{ $daftarPenjualan->last()->tahun ?? '' }}
                    </div>
                </div>
                <div class="pb-0 card-body">
                    <div class="mt-2 mb-4">
                        <h1>{{ number_format($daftarPenjualan->sum('jumlah') ?? 0, 0, ',', '.') }}</h1>
                    </div>
                    <div class="pull-in" style="min-height: 250px">
                        <canvas id="dailySalesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        var dailySalesChart = document
            .getElementById("dailySalesChart")
            .getContext("2d");

        var myDailySalesChart = new Chart(dailySalesChart, {
            type: "line",
            data: {
                labels: [
                    "Januari",
                    "Februari",
                    "Maret",
                    "April",
                    "Mei",
                    "Juni",
                    "Juli",
                    "Agustus",
                    "September",
                ],
                datasets: [{
                    label: "Sales Analytics",
                    fill: !0,
                    backgroundColor: "rgba(255,255,255,0.2)",
                    borderColor: "#fff",
                    borderCapStyle: "butt",
                    borderDash: [],
                    borderDashOffset: 0,
                    pointBorderColor: "#fff",
                    pointBackgroundColor: "#fff",
                    pointBorderWidth: 1,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "#fff",
                    pointHoverBorderWidth: 1,
                    pointRadius: 1,
                    pointHitRadius: 5,
                    data: @json($daftarPenjualan->pluck('jumlah')),
                }, ],
            },
            options: {
                maintainAspectRatio: !1,
                legend: {
                    display: !1,
                },
                animation: {
                    easing: "easeInOutBack",
                },
                scales: {
                    yAxes: [{
                        display: !1,
                        ticks: {
                            fontColor: "rgba(0,0,0,0.5)",
                            fontStyle: "bold",
                            beginAtZero: !0,
                            maxTicksLimit: 10,
                            padding: 0,
                        },
                        gridLines: {
                            drawTicks: !1,
                            display: !1,
                        },
                    }, ],
                    xAxes: [{
                        display: !1,
                        gridLines: {
                            zeroLineColor: "transparent",
                        },
                        ticks: {
                            padding: -20,
                            fontColor: "rgba(255,255,255,0.2)",
                            fontStyle: "bold",
                        },
                    }, ],
                },
            },
        });
    </script>
@endpush
