<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Penjualan;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $penjualanCount = Penjualan::count();

        $daftarPenjualan = Penjualan::latest()->get();

        return view('index', compact('userCount','penjualanCount','daftarPenjualan'));
    }
}
