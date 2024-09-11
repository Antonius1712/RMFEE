<?php

namespace App\Http\Middleware;

use App\Enums\Nik;
use Closure;
use Illuminate\Http\Response;

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
        /* See on Model/LGIGlobal_User */
        $Validate = Auth()->User()->isThisTimmie();
        if( $Validate ) {
            return $next($request);
        } else {
            return abort(Response::HTTP_FORBIDDEN);
            // return abort(404);
        }
    }
}
