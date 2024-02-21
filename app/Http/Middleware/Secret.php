<?php

namespace App\Http\Middleware;

use Closure;

class Secret
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
        if( Auth()->user()->id == '2018113907' ){
            return $next($request);
        }else{
            return abort(404);
        }
    }
}
