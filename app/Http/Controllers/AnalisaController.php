<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\DataAnalisa;
use App\Models\HistoryPenjualan;

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

    public function indexAll()
    {
        // Ambil data dari tabel penjualan
        $penjualan = Penjualan::all();

        // Daftar alpha yang tersedia
        $alphas = [0.3, 0.6, 0.8, 0.9];

        return view('analisa.indexAll', compact('penjualan', 'alphas'));
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
        $penjualan = Penjualan::orderBy('tahun', 'asc')->orderBy('bulan', 'asc')->get();

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

        // Prediksi bulan depan
        $lastFt = $ft; // Ft terakhir
        $lastData = $penjualan->last(); // Ambil data terakhir
        if ($lastData) {
            $lastMonth = $lastData->bulan;
            $lastYear = $lastData->tahun;

            // Mapping bulan ke angka
            $months = [
                'Januari' => 1,
                'Februari' => 2,
                'Maret' => 3,
                'April' => 4,
                'Mei' => 5,
                'Juni' => 6,
                'Juli' => 7,
                'Agustus' => 8,
                'September' => 9,
                'Oktober' => 10,
                'November' => 11,
                'Desember' => 12
            ];

            // Konversi bulan terakhir ke angka
            $lastMonthNumber = $months[$lastMonth];

            // Hitung bulan berikutnya
            $nextMonthNumber = $lastMonthNumber + 1;
            $nextYear = $lastYear;
            if ($nextMonthNumber > 12) {
                $nextMonthNumber = 1; // Reset ke Januari
                $nextYear++; // Tambah tahun
            }

            // Konversi angka bulan kembali ke nama bulan
            $predictedMonth = array_search($nextMonthNumber, $months);
            $predictedYear = $nextYear;
        } else {
            // Jika tidak ada data, gunakan default (opsional)
            $predictedMonth = 'Januari';
            $predictedYear = date('Y'); // Tahun saat ini
        }

        $dataPerhitungan[] = [
            'bulan' => $predictedMonth,
            'tahun' => $predictedYear,
            'actual' => null,
            'ft' => $lastFt,
            'ape' => null, // Tidak ada APE untuk data prediksi
        ];

        return view('analisa.index', [
            'penjualan' => $penjualan,
            'alphas' => [0.3, 0.6, 0.8, 0.9],
            'dataPerhitungan' => $dataPerhitungan,
        ])->with('success', 'Perhitungan berhasil dilakukan.');
    }

    public function calculate(Request $request)
    {
        $daftarPenjualan = Penjualan::all();
        $alphas = $request->input('jumlah'); // Nilai alpha dari dropdown
        $dataPenjualan = Penjualan::orderBy('tahun', 'asc')->orderBy('bulan', 'asc')->get();

        $dataPerhitungan = [];
        $previousFt = null; // Ft sebelumnya
        $previousAt = null; // At sebelumnya
        $totalAPE = 0; // Total APE
        $n = 0; // Counter jumlah data

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
                $totalAPE += $APE; // Tambahkan ke total APE
                $n++; // Increment jumlah data
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
        $lastData = $dataPenjualan->last(); // Ambil data terakhir
        if ($lastData) {
            $lastMonth = $lastData->bulan;
            $lastYear = $lastData->tahun;

            // Mapping bulan ke angka
            $months = [
                'Januari' => 1,
                'Februari' => 2,
                'Maret' => 3,
                'April' => 4,
                'Mei' => 5,
                'Juni' => 6,
                'Juli' => 7,
                'Agustus' => 8,
                'September' => 9,
                'Oktober' => 10,
                'November' => 11,
                'Desember' => 12
            ];

            // Konversi bulan terakhir ke angka
            $lastMonthNumber = $months[$lastMonth];

            // Hitung bulan berikutnya
            $nextMonthNumber = $lastMonthNumber + 1;
            $nextYear = $lastYear;
            if ($nextMonthNumber > 12) {
                $nextMonthNumber = 1; // Reset ke Januari
                $nextYear++; // Tambah tahun
            }

            // Konversi angka bulan kembali ke nama bulan
            $predictedMonth = array_search($nextMonthNumber, $months);
            $predictedYear = $nextYear;
        } else {
            // Jika tidak ada data, gunakan default (opsional)
            $predictedMonth = 'Januari';
            $predictedYear = date('Y'); // Tahun saat ini
        }

        $dataPerhitungan[] = [
            'bulan' => $predictedMonth,
            'tahun' => $predictedYear,
            'At' => 0, // Tidak ada data aktual
            'Ft' => round($prediksiFt, 2),
            'APE' => 0, // Tidak ada APE untuk prediksi
        ];

        // Hitung total MAPE
        $mape = $n > 0 ? $totalAPE / $n : 0;

        return view('analisa.index', [
            'dataPerhitungan' => $dataPerhitungan,
            'alphas' => [0.3, 0.6, 0.8, 0.9],
            'mape' => round($mape, 2), // Kirim MAPE ke view
            'dataPenjualan' => $daftarPenjualan,
        ]);
    }

    public function calculateAll(Request $request)
    {
        $daftarPenjualan = Penjualan::all();
        if ($daftarPenjualan->isEmpty()) {
            return view('analisa.indexAll')->with('error', 'Tidak bisa melakukan Forecasting dikarenakan "data penjualan kosong".');
        }

        $alphas = [0.1, 0.3, 0.5]; // Daftar alpha yang tersedia
        $dataPenjualan = Penjualan::orderBy('tahun', 'asc')->orderBy('bulan', 'asc')->get();

        $dataPerhitungan = [];
        $months = [
            'Januari' => 1,
            'Februari' => 2,
            'Maret' => 3,
            'April' => 4,
            'Mei' => 5,
            'Juni' => 6,
            'Juli' => 7,
            'Agustus' => 8,
            'September' => 9,
            'Oktober' => 10,
            'November' => 11,
            'Desember' => 12
        ];

        foreach ($alphas as $alpha) {
            $previousFt = null; // Ft sebelumnya
            $previousAt = null; // At sebelumnya
            $totalAPE = 0; // Total APE
            $n = 0; // Counter jumlah data

            foreach ($dataPenjualan as $index => $penjualan) {
                $currentAt = $penjualan->jumlah;

                if ($index == 0) {
                    // Ft pertama adalah At pertama
                    $Ft = $currentAt;
                    $APE = 0;
                } else {
                    // Hitung Ft berdasarkan rumus
                    $Ft = ($alpha * $previousAt) + ((1 - $alpha) * $previousFt);
                    // Hitung APE
                    $APE = $currentAt > 0 ? abs(($currentAt - $Ft) / $currentAt) * 100 : 0;
                    $totalAPE += $APE; // Tambahkan ke total APE
                    $n++; // Increment jumlah data
                }

                $dataPerhitungan['a' . $alpha][] = [
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
            $lastData = $dataPenjualan->last();
            if ($lastData) {
                $lastMonth = $lastData->bulan;
                $lastYear = $lastData->tahun;

                // Konversi bulan terakhir ke angka
                $lastMonthNumber = $months[$lastMonth];

                // Hitung bulan berikutnya
                $nextMonthNumber = $lastMonthNumber + 1;
                $nextYear = $lastYear;
                if ($nextMonthNumber > 12) {
                    $nextMonthNumber = 1; // Reset ke Januari
                    $nextYear++; // Tambah tahun
                }

                // Konversi angka bulan kembali ke nama bulan
                $predictedMonth = array_search($nextMonthNumber, $months);
                $predictedYear = $nextYear;

                // Prediksi Ft untuk bulan berikutnya
                $prediksiFt = ($alpha * $previousAt) + ((1 - $alpha) * $previousFt);
                $dataPerhitungan['a' . $alpha][] = [
                    'bulan' => $predictedMonth,
                    'tahun' => $predictedYear,
                    'At' => 0, // Tidak ada data aktual
                    'Ft' => round($prediksiFt, 2),
                    'APE' => 0, // Tidak ada APE untuk prediksi
                ];
            }

            // Hitung total MAPE
            $mape[$alpha] = $n > 0 ? $totalAPE / $n : 0;
            $dataPerhitungan['a' . $alpha]['total_mape'] = round($mape[$alpha], 2);
        }

        return view('analisa.indexAll', [
            'dataPerhitungan' => $dataPerhitungan,
            'alphas' => $alphas,
            'dataPenjualan' => $daftarPenjualan,
        ]);
    }

    public function storeDataCalculated(Request $request)
    {
        $data = json_decode($request->input('dataPerhitungan'), true);
        if (!$data) {
            return redirect()->route('rekap')->with('error', 'Data perhitungan tidak valid.');
        }

        // Ambil timestamp saat ini sekali saja
        $currentTimestamp = now();

        // Mulai transaksi database untuk memastikan data konsisten
        DB::beginTransaction();
        try {
            // Simpan data analisa
            $dataAnalisa = [];
            foreach ($data as $key => $months) {
                $totalMAPE = $months['total_mape'] ?? 0;

                foreach ($months as $index => $dataItem) {
                    if (is_numeric($index)) {
                        $dataAnalisa[] = [
                            'key' => $key,
                            'bulan' => $dataItem['bulan'],
                            'tahun' => $dataItem['tahun'],
                            'At' => $dataItem['At'],
                            'Ft' => $dataItem['Ft'],
                            'APE' => $dataItem['APE'],
                            'total_mape' => $totalMAPE,
                            'created_at' => $currentTimestamp,
                            'updated_at' => $currentTimestamp,
                        ];
                    }
                }
            }

            // Batch insert data analisa
            DataAnalisa::insert($dataAnalisa);

            // Pindahkan data dari Penjualan ke HistoryPenjualan
            $penjualanData = Penjualan::all();
            $historyPenjualan = [];
            foreach ($penjualanData as $penjualan) {
                $historyPenjualan[] = [
                    'bulan' => $penjualan->bulan,
                    'tahun' => $penjualan->tahun,
                    'jumlah' => $penjualan->jumlah,
                    'created_at' => $currentTimestamp,
                    'updated_at' => $currentTimestamp,
                ];
            }

            // Batch insert data history penjualan
            if (!empty($historyPenjualan)) {
                HistoryPenjualan::insert($historyPenjualan);
            }

            // Hapus semua data dari Penjualan
            // Penjualan::truncate();

            DB::commit();
            return redirect()->route('rekap')->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('rekap')->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }

    public function rekap()
    {
        // Mengambil nilai created_at yang unik
        $data = DataAnalisa::select('created_at')
            ->distinct()
            ->orderBy('created_at') // Mengurutkan hasil berdasarkan created_at
            ->get();

        return view('rekap.index', compact('data'));
    }

    public function findRekap($timestamp)
    {
        // Ambil data berdasarkan timestamp
        $data = DataAnalisa::where('created_at', $timestamp)->get();
        dd($data);
        return view('rekap.index', compact('data'));
    }

    public function rekapDetail(Request $request)
    {
        // Mengambil nilai created_at yang unik
        $data = DataAnalisa::select('created_at')
            ->distinct()
            ->orderBy('created_at') // Mengurutkan hasil berdasarkan created_at
            ->get();

        $timestamp = $request->input('data');
        $dataPerhitungan = DataAnalisa::where('created_at', $timestamp)->get();

        // Struktur data yang diinginkan
        $structuredData = [];
        foreach ($dataPerhitungan as $item) {
            $key = $item->key;
            if (!isset($structuredData[$key])) {
                $structuredData[$key] = [];
            }
            $structuredData[$key][] = [
                'bulan' => $item->bulan,
                'tahun' => $item->tahun,
                'At' => $item->At,
                'Ft' => $item->Ft,
                'APE' => $item->APE,
            ];
            $structuredData[$key]['total_mape'] = $item->total_mape;
        }

        $dataPenjualan = HistoryPenjualan::where('created_at', $timestamp)->orderBy('tahun', 'asc')->orderBy('bulan', 'asc')->get();
        // return response()->json([
        //     // 'data' => $data,
        //     'structuredData' => $structuredData,
        //     'dataPenjualan' => $dataPenjualan,
        // ]);
        return view('rekap.index', compact('data', 'structuredData', 'dataPenjualan'));
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
