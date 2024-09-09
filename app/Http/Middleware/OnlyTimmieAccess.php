<?php

namespace App\Http\Middleware;

use Closure;

class OnlyTimmieAccess
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
        $Validate = Auth()->User()->NIK == '2006041565';
        if( $Validate ) {
            return $next($request);
        } else {
            return abort(404);
        }
    }
}
