<?php

namespace App\Http\Middleware;

use Closure;

class SuperAdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {


        if ($request->cookie('user_role') == 'super_admin') {

            return $next($request);
        }
        return redirect()->route('dashboard');
    }
}
