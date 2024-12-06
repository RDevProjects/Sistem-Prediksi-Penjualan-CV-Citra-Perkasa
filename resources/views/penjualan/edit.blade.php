@extends('include.layout')
@section('content')
    <div class="page-header">
        <h3 class="mb-3 fw-bold">Data Penjualan</h3>
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
                <a href="{{ route('penjualan') }}">Data Penjualan</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="">Edit Data Penjualan</a>
            </li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Tambah Penjualan</div>
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
                <div class="card-body">
                    <form action="{{ route('update.penjualan', $dataPenjualan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="bulan">Bulan</label>
                            <select class="form-control" id="bulan" name="bulan" required>
                                <option value="" disabled selected>Pilih Bulan</option>
                                @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $bulan)
                                    <option value="{{ $bulan }}"
                                        {{ old('bulan', $dataPenjualan->bulan) == $bulan ? 'selected' : '' }}>
                                        {{ $bulan }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tahun">Tahun</label>
                            <select class="form-control" id="tahun" name="tahun" required>
                                <option value="" disabled selected>Pilih Tahun</option>
                                @foreach (range(date('Y'), date('Y') - 10) as $tahun)
                                    <option value="{{ $tahun }}"
                                        {{ old('tahun', $dataPenjualan->tahun) == $tahun ? 'selected' : '' }}>
                                        {{ $tahun }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah"
                                placeholder="Enter Jumlah" value="{{ old('jumlah', $dataPenjualan->jumlah) }}" required />
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success w-100">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
