<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;

class PenjualanController extends Controller
{
    public function index()
    {
        $dataPenjualan = Penjualan::latest()->get();
        return view('penjualan.index', compact('dataPenjualan'));
    }

    public function create()
    {
        return view('penjualan.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'bulan' => 'required',
            'tahun' => 'required',
            'jumlah' => 'required',
        ]);

        Penjualan::create([
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->route('penjualan')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $dataPenjualan = Penjualan::find($id);
        return view('penjualan.edit', compact('dataPenjualan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'bulan' => 'required',
            'tahun' => 'required',
            'jumlah' => 'required',
        ]);

        Penjualan::find($id)->update([
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->route('penjualan')->with('success', 'Data penjualan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Penjualan::find($id)->delete();
        return redirect()->route('penjualan')->with('success', 'Data penjualan berhasil dihapus.');
    }
}
