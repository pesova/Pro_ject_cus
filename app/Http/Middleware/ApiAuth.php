<?php

namespace App\Http\Middleware;

use App\Models\Admins;
use App\Models\Assistants;
use Closure;

class ApiAuth
{
    private $unauthorizedResponse =  [
        'status' => false,
        'message' => 'access denied',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->headers->has('x-access-token')) {
            $api_token = $request->header('x-access-token');
        } elseif ($request->cookies->has('api_token')) {
            $api_token = $request->cookie('api_token');
        } else {
            return response()->json($this->unauthorizedResponse, 401);
        }

        $user = Admins::where('api_token', $api_token)->firstor(function () use ($api_token) {
            return Assistants::where('api_token', $api_token)->first();
        });

        if (!$user) {
            return response()->json($this->unauthorizedResponse, 401);
        }

        $request->merge([
            'request_user_id' => $user->_id,
            'request_user_role' => $user->local['user_role'],
        ]);

        return $next($request);
    }
}
