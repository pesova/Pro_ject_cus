<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ThemeController extends Controller
{
    public function changeTheme($theme)
    {
        Cookie::queue("theme", $theme);
        return back();
    }
}
