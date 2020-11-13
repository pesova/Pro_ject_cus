<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class NotificationsController extends Controller
{
    public function readAll() {
        $user = User::where('phone_number', Cookie::get('phone_number'))->first();

        $user->unreadNotifications->markAsRead();

        return redirect()->route('notification');
    }
}
