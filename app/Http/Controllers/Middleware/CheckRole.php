<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            // Jika belum login, arahkan ke rute 'login'
            return redirect('login'); 
        }

        $user = Auth::user();

        // Cek apakah user memiliki salah satu role yang diizinkan
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika tidak ada role yang cocok, tolak akses (403 Forbidden)
        abort(403, 'Akses Ditolak. Anda tidak memiliki hak akses untuk halaman ini.');
    }
}