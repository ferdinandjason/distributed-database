<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

class CheckPriviledge
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
        if(Auth('restaurant')->user() != NULL){
            if($request->is('admin/*')){
                abort(404);
            } else if($request->is('user/*')){
                abort(404);
            }
        } else if(Auth::user()->role == 1) {
            if($request->is('restaurant/*')){
                abort(404);
            } else if($request->is('user/*')){
                abort(404);
            }
        } else if(Auth::user()->role == 0) {
            if($request->is('restaurant/*')){
                abort(404);
            } else if($request->is('admin/*')){
                abort(404);
            }
        }
        return $next($request);
    }
}
