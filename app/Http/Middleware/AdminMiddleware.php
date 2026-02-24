<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }
        
        
        if (Auth::user()->role != 2) {
            return redirect('/')->with('error', 'У вас нет доступа к этой странице');
        }
        
        return $next($request);
    }
}