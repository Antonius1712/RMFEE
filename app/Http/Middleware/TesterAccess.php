<?php

namespace App\Http\Middleware;

use App\Enums\Nik;
use Closure;

class TesterAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if( !in_array(Auth()->user()->NIK, [Nik::ANTON]) ){
            abort(404);
        }
        return $next($request);
    }
}
