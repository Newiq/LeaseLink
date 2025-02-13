<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandlordMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->role === 'landlord') {
            return $next($request);
        }

        return redirect()->route('rentals.index')
            ->with('error', 'Only landlords can access this feature.');
    }
} 