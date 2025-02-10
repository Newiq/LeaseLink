<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LandlordMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'landlord') {
            return $next($request);
        }

        return redirect()->route('rentals.index')
            ->with('error', 'Only landlords can access this feature.');
    }
} 