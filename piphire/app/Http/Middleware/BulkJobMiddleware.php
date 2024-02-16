<?php

namespace App\Http\Middleware;

use Closure;

class BulkJobMiddleware
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

        if ($request->user() && $request->user()->organization->plan->id != 1){
            
            return $next($request);

        }
        return redirect('/profiledatabase');

    }
}
