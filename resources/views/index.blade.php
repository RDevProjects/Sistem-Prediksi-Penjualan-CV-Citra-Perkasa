<!DOCTYPE html>
<html lang="en">

@include('include.meta')

<body>
    <div class="wrapper">
        @include('include.sidebar')

        <div class="main-panel">
            @include('include.topnav')

            <div class="container">
                <div class="page-inner">
                    <div class="pt-2 pb-4 d-flex align-items-left align-items-md-center flex-column flex-md-row">
                        <div>
                            <h3 class=" fw-bold">Dashboard</h3>
                            <h6 class="mb-2 op-7">Selamat Datang ke
                                {{ env('APP_NAME') }}</h6>
                        </div>
                        {{-- <div class="py-2 ms-md-auto py-md-0">
                            <a href="#" class="btn btn-label-info btn-round me-2">Manage</a>
                            <a href="#" class="btn btn-primary btn-round">Add Customer</a>
                        </div> --}}
                    </div>
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
                                                <h4 class="card-title">1303</h4>
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
                                                <h4 class="card-title">Rp 1,345</h4>
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
                        <div class="col-md-8">
                            <div class="card card-round">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">User Statistics</div>
                                        <div class="card-tools">
                                            <a href="#" class="btn btn-label-success btn-round btn-sm me-2">
                                                <span class="btn-label">
                                                    <i class="fa fa-pencil"></i>
                                                </span>
                                                Export
                                            </a>
                                            <a href="#" class="btn btn-label-info btn-round btn-sm">
                                                <span class="btn-label">
                                                    <i class="fa fa-print"></i>
                                                </span>
                                                Print
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="chart-container" style="min-height: 375px">
                                        <canvas id="statisticsChart"></canvas>
                                    </div>
                                    <div id="myChartLegend"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-primary card-round">
                                <div class="card-header">
                                    <div class="card-head-row">
                                        <div class="card-title">Daily Sales</div>
                                        <div class="card-tools">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-label-light dropdown-toggle"
                                                    type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    Export
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#">Action</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-category">March 25 - April 02</div>
                                </div>
                                <div class="pb-0 card-body">
                                    <div class="mt-2 mb-4">
                                        <h1>$4,578.58</h1>
                                    </div>
                                    <div class="pull-in">
                                        <canvas id="dailySalesChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-round">
                                <div class="pb-0 card-body">
                                    <div class="h1 fw-bold float-end text-primary">+5%</div>
                                    <h2 class="mb-2">17</h2>
                                    <p class="text-muted">Users online</p>
                                    <div class="pull-in sparkline-fix">
                                        <div id="lineChart3"></div>
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
                                        <div class="card-title">Transaction History</div>
                                        <div class="card-tools">
                                            <div class="dropdown">
                                                <button class="btn btn-icon btn-clean me-0" type="button"
                                                    id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-h"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#">Action</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-0 card-body">
                                    <div class="table-responsive">
                                        <!-- Projects table -->
                                        <table class="table mb-0 align-items-center">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th scope="col">Payment Number</th>
                                                    <th scope="col" class="text-end">Date & Time</th>
                                                    <th scope="col" class="text-end">Amount</th>
                                                    <th scope="col" class="text-end">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">
                                                        <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                        Payment from #10231
                                                    </th>
                                                    <td class="text-end">
                                                        Mar 19, 2020, 2.45pm
                                                    </td>
                                                    <td class="text-end">
                                                        $250.00
                                                    </td>
                                                    <td class="text-end">
                                                        <span class="badge badge-success">Completed</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                        Payment from #10231
                                                    </th>
                                                    <td class="text-end">
                                                        Mar 19, 2020, 2.45pm
                                                    </td>
                                                    <td class="text-end">
                                                        $250.00
                                                    </td>
                                                    <td class="text-end">
                                                        <span class="badge badge-success">Completed</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                        Payment from #10231
                                                    </th>
                                                    <td class="text-end">
                                                        Mar 19, 2020, 2.45pm
                                                    </td>
                                                    <td class="text-end">
                                                        $250.00
                                                    </td>
                                                    <td class="text-end">
                                                        <span class="badge badge-success">Completed</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                        Payment from #10231
                                                    </th>
                                                    <td class="text-end">
                                                        Mar 19, 2020, 2.45pm
                                                    </td>
                                                    <td class="text-end">
                                                        $250.00
                                                    </td>
                                                    <td class="text-end">
                                                        <span class="badge badge-success">Completed</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                        Payment from #10231
                                                    </th>
                                                    <td class="text-end">
                                                        Mar 19, 2020, 2.45pm
                                                    </td>
                                                    <td class="text-end">
                                                        $250.00
                                                    </td>
                                                    <td class="text-end">
                                                        <span class="badge badge-success">Completed</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                        Payment from #10231
                                                    </th>
                                                    <td class="text-end">
                                                        Mar 19, 2020, 2.45pm
                                                    </td>
                                                    <td class="text-end">
                                                        $250.00
                                                    </td>
                                                    <td class="text-end">
                                                        <span class="badge badge-success">Completed</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">
                                                        <button class="btn btn-icon btn-round btn-success btn-sm me-2">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                        Payment from #10231
                                                    </th>
                                                    <td class="text-end">
                                                        Mar 19, 2020, 2.45pm
                                                    </td>
                                                    <td class="text-end">
                                                        $250.00
                                                    </td>
                                                    <td class="text-end">
                                                        <span class="badge badge-success">Completed</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="footer">
                <div class="container-fluid">
                    <nav class="pull-left">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('home') }}">
                                    {{ env('APP_NAME') }} | {{ env('AUTHORS') }}
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </footer>
        </div>

    </div>
    @include('include.script')
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script>
        $('#lineChart').sparkline([102, 109, 120, 99, 110, 105, 115], {
            type: 'line',
            height: '70',
            width: '100%',
            lineWidth: '2',
            lineColor: '#177dff',
            fillColor: 'rgba(23, 125, 255, 0.14)'
        });

        $('#lineChart2').sparkline([99, 125, 122, 105, 110, 124, 115], {
            type: 'line',
            height: '70',
            width: '100%',
            lineWidth: '2',
            lineColor: '#f3545d',
            fillColor: 'rgba(243, 84, 93, .14)'
        });

        $('#lineChart3').sparkline([105, 103, 123, 100, 95, 105, 115], {
            type: 'line',
            height: '70',
            width: '100%',
            lineWidth: '2',
            lineColor: '#ffa534',
            fillColor: 'rgba(255, 165, 52, .14)'
        });
    </script>
</body>

</html>
