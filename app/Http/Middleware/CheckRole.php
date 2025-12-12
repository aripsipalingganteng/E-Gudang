<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek jika user belum login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Jika tidak ada role yang ditentukan, lanjutkan
        if (empty($roles)) {
            return $next($request);
        }

        // Cek setiap role
        foreach ($roles as $role) {
            if ($user->hasRole(trim($role))) {
                return $next($request);
            }
        }

        // Jika tidak memiliki role yang diperlukan, redirect ke dashboard biasa
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }
        
        return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
    }
}