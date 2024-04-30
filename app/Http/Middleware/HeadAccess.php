<?php

namespace App\Http\Middleware;

use Closure;

class HeadAccess
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
        $roles = Auth()->user()->getUserGroup->getGroup->GroupCode;
        if( $roles != 'USER_RMFEE' ) {
            return $next($request);
        } else {
            return abort(404);
        }
    }
}
