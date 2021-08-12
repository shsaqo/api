<?php

namespace App\Http\Middleware;

use App\Http\Traits\ResponseJson;
use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->id != 1) return ResponseJson::response([], '403', 'permission denied');
        return $next($request);
    }
}
