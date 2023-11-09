<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\View;

class BreadCrumbs
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    
    protected $Segments;
    public function handle($request, Closure $next)
    {
        $this->Segments = [];
        $SegmentCount = count(Request()->segments());
        
        if( $SegmentCount > 0 ){
            for( $segment = 1; $segment <= $SegmentCount; $segment++ ){
                $this->Segments[] = ucwords(str_replace('-', ' ', Request()->segment($segment)));
            }
        }
        
        View::share('Segments', $this->Segments);
        return $next($request);
    }
}
