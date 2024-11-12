<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class isLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Mengecek apakah user sudah login
        if (Auth::check()) {
            return $next($request); // Lanjutkan ke request berikutnya
        }

        // Jika belum login, redirect ke halaman login
        return redirect()->route('login')->with('error', 'Anda harus masuk untuk mengakses halaman ini.');
    }
}
