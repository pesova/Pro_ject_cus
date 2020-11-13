<?php

namespace App\Http\Middleware;

use Closure;

class StoreAssistant
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
        $expires = $request->cookie('expires');
        $expires = intval($expires);

        if ($request->cookie('api_token') && $expires > time()) {

            // Uncomment below when sms verification is working
             if (!$request->cookie('is_active') && $request->path() != 'admin/activate') {
                 return redirect()->route('activate.index');
             }

             if($request->cookie('user_role') != 'store_assistant'){
                 return redirect()->route('login.assistant');
             }

            return $next($request);
        }
        return redirect()->route('logout')->with('message', 'Permission Denied!!! You need to login first.');

    }
}
