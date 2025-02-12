<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfUnauthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'error' => 'Unauthenticated.',
                    'should_login' => true
                ], 401);
            }
            
            // 将当前URL存储在session中
            session(['intended_url' => $request->url()]);
            
            // 返回带有打开登录模态框指令的响应
            return redirect()->route('home')->with('open_login', true);
        }

        return $next($request);
    }
} 