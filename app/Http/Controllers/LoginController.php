<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        Auth::logout();

        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('home');
        }

        return redirect()->route('login')->with('error', 'Data tidak ada di database');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login')->with('success', 'Berhasil Keluar');
    }
}
