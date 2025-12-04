<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Jika belum login → redirect ke login dengan pesan
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu untuk mengakses halaman admin.');
        }

        // Jika sudah login tapi bukan admin → forbidden + pesan toast-friendly
        if (!auth()->user()->is_admin) {
            // Bisa pake abort(403) atau redirect, saya sarankan redirect biar lebih user-friendly
            return redirect()->route('dashboard')
                ->with('error', 'Akses ditolak! Anda tidak memiliki izin admin.');
            // Atau kalau mau keras: abort(403, 'Unauthorized action.');
        }

        // Kalau admin → lanjut
        return $next($request);
    }
}