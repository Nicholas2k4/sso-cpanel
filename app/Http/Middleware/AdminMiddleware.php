<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->global_role != 'admin') {
            return redirect()->route('index')->with('error', 'Unauthorized');
        }
        
        return $next($request);
    }
}
