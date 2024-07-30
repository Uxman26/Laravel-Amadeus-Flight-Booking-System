<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AgentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->role == 2) {
            if ($request->user()->status == false) {
                Auth::logout();
                return redirect()->route('login')->withErrors("Account not Active");
            } else {
                return $next($request);
            }
        } elseif (auth()->user()->role == 1) {
            return redirect()->route('admin.dashboard.index');
        }
    }
}
