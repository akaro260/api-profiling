<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    // Ubah parameter agar bisa menerima string role yang dipisah koma (contoh: 'admin,guru,osis')
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        // Cek apakah user login dan apakah rolenya ada di dalam daftar yang diizinkan
        if (!$user || !in_array($user->role, $roles)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized. Akses ditolak untuk role ini.'
            ], 403);
        }

        return $next($request);
    }
}   