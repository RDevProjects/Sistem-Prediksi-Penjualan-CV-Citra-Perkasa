<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Penjualan;

class AnalisaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data dari tabel penjualan
        $penjualan = Penjualan::all();

        // Daftar alpha yang tersedia
        $alphas = [0.3, 0.6, 0.8, 0.9];

        return view('analisa.index', compact('penjualan', 'alphas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storePenjualan(Request $request)
    {
        $request->validate([
            'jumlah' => 'required',
        ]);

        $alpha = $request->jumlah;

        // Ambil data penjualan
        $penjualan = Penjualan::orderBy('tahun')->orderBy('bulan')->get();

        // Perhitungan Ft dan APE
        $dataPerhitungan = [];
        $ft = null; // Nilai Ft sebelumnya
        foreach ($penjualan as $key => $data) {
            $actual = $data->jumlah;
            if ($key == 0) {
                $ft = $actual; // Ft awal sama dengan data aktual pertama
            } else {
                $ft = $ft + $alpha * ($actual - $ft); // Perhitungan Ft
            }
            $ape = $actual > 0 ? abs(($actual - $ft) / $actual) * 100 : 0; // Perhitungan APE

            $dataPerhitungan[] = [
                'bulan' => $data->bulan,
                'tahun' => $data->tahun,
                'actual' => $actual,
                'ft' => $ft,
                'ape' => $ape,
            ];
        }

        // Prediksi bulan depan (Januari 2025)
        $lastFt = $ft; // Ft terakhir
        $predictedMonth = 'Januari';
        $predictedYear = 2025;

        $dataPerhitungan[] = [
            'bulan' => $predictedMonth,
            'tahun' => $predictedYear,
            'actual' => null,
            'ft' => $lastFt,
            'ape' => null, // Tidak ada APE untuk data prediksi
        ];

        return view('analisa.index', [
            'penjualan' => $penjualan,
            'alphas' => [0.3, 0.6, 0.8, 0.9], // Tambahkan alpha lain jika perlu
            'dataPerhitungan' => $dataPerhitungan, // Kirim hasil perhitungan ke view
        ])->with('success', 'Perhitungan berhasil dilakukan.');
    }

    public function calculate(Request $request)
    {
        $alphas = $request->input('jumlah'); // Nilai alpha dari dropdown
        $dataPenjualan = Penjualan::orderBy('tahun', 'asc')->orderBy('bulan', 'asc')->get();

        $dataPerhitungan = [];
        $previousFt = null; // Ft sebelumnya
        $previousAt = null; // At sebelumnya

        foreach ($dataPenjualan as $index => $penjualan) {
            $currentAt = $penjualan->jumlah;

            if ($index == 0) {
                // Ft pertama adalah At pertama
                $Ft = $currentAt;
                $APE = 0;
            } else {
                // Hitung Ft berdasarkan rumus
                $Ft = ($alphas * $previousAt) + ((1 - $alphas) * $previousFt);
                // Hitung APE
                $APE = abs(($currentAt - $Ft) / $currentAt) * 100;
            }

            $dataPerhitungan[] = [
                'bulan' => $penjualan->bulan,
                'tahun' => $penjualan->tahun,
                'At' => $currentAt,
                'Ft' => round($Ft, 2),
                'APE' => round($APE, 2),
            ];

            // Simpan nilai sebelumnya untuk iterasi berikutnya
            $previousFt = $Ft;
            $previousAt = $currentAt;
        }

        // Prediksi bulan berikutnya
        $prediksiFt = ($alphas * $previousAt) + ((1 - $alphas) * $previousFt);
        $dataPerhitungan[] = [
            'bulan' => 'Januari',
            'tahun' => 2025,
            'At' => 0, // Tidak ada data aktual
            'Ft' => round($prediksiFt, 2),
            'APE' => 0, // Tidak ada APE untuk prediksi
        ];

        return view('analisa.index', [
            'dataPerhitungan' => $dataPerhitungan,
            'alphas' => [0.3, 0.6, 0.8, 0.9],
        ]);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
