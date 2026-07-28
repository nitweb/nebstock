<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class GuestCustomerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Already logged in থাকলে dashboard এ redirect
        if (Auth::guard('user')->check() && Auth::guard('user')->user()->role === 'customer') {
            return redirect()->route('customer.dashboard');
        }

        return $next($request);
    }
}
