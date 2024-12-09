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
                                    <select class="form-control me-2" id="jumlah" name="jumlah" required>
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
                                        <td>{{ $row['APE'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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

        function deletePeramalan(id) {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Kamu tidak akan bisa mengembalikannya!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
@endpush
