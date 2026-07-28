<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('user')->user();

        if (!$user || $user->role !== 'customer') {
            session()->put('url.intended', $request->fullUrl());
            return redirect()->route('customer.login')->with('error', 'Please login to continue.');
        }

        return $next($request);
    }
}
