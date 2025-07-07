<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Tambahkan ini
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) { // Gunakan Auth::check() bukan auth()->check()
            if (Auth::user()->role == 'admin') {
                return redirect('/dashboard');
            } elseif (Auth::user()->role == 'owner') {
                return redirect('/owner/dashboard');
            }
        }

        return $next($request);
    }
}
