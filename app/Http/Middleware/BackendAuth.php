<?php

namespace App\Http\Middleware;

use App\Http\Controllers\redirect;
use Closure;

class BackendAuth
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
        $expires = $request->cookie('expires');
        $expires = intval($expires);

        if ($request->cookie('api_token') && $expires > time()) {

            // Uncomment below when sms verification is working
            if (!$request->cookie('is_active') && $request->path() != 'app/activate') {
                return redirect()->route('activate.index');
            }

            if (is_store_admin()) {

                // $request->url() and route() returns same link but route() returns link with https while $request->url() does not.
                $request_url = str_replace('https://', 'http://', $request->url());
                $store_create_url = str_replace('https://', 'http://', route('store.create'));
                $store_save_url = str_replace('https://', 'http://', route('store.store'));
                // makes sure a store admin selects a store before seeing the dashboard
                if (!has_selected_store() && $request_url !== $store_create_url && $request_url !== $store_save_url) {
                    return redirect()->route('store.create');
                }
            }
            return $next($request);
        }
        return redirect()->route('logout')->with('message', 'Permission Denied!!! You need to login first.');
    }
}
