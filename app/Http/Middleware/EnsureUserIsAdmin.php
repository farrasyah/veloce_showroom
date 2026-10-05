<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Hanya izinkan user dengan role "admin" untuk mengelola data mobil.
     * User biasa yang sudah login tapi bukan admin akan ditolak (403).
     * Tamu yang belum login akan diarahkan ke halaman login (via middleware auth).
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->isAdmin()) {
            abort(403, 'Halaman ini khusus untuk admin.');
        }

        return $next($request);
    }
}
