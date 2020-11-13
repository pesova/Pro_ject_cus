<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

// use Illuminate\Support\Facades\Http;

class LogoutController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        Cookie::queue(Cookie::forget('api_token'));
        Cookie::queue(Cookie::forget('is_active'));
        Cookie::queue(Cookie::forget('user_id'));
        Cookie::queue(Cookie::forget('phone_number'));
        Cookie::queue(Cookie::forget('first_name'));
        Cookie::queue(Cookie::forget('last_name'));
        Cookie::queue(Cookie::forget('email'));
        Cookie::queue(Cookie::forget('user_role'));
        Cookie::queue(Cookie::forget('expires'));
        Cookie::queue(Cookie::forget('is_first_time_user'));
        Cookie::queue(Cookie::forget('profile_picture'));
        Cookie::queue(Cookie::forget('store_id'));
        Cookie::queue(Cookie::forget('store_name'));

        $request->session()->invalidate();
        if ($request->has('message')) {
            Session::flash('message', $request->input('message'));
            Session::flash('alert-class', 'alert-danger');
        }
        return redirect()->route('login');
    }
}
