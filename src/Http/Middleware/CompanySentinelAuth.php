<?php

namespace Dataview\IOCompany\Http\Middleware;

use Closure;
use App\Facades\CompanySentinel;

class CompanySentinelAuth
{
    public function handle($request, Closure $next)
    {
        if(!CompanySentinel::check())
            return redirect('empresa/login')->with('error', 'You must be logged in!');
      
        return $next($request);
    }
}
