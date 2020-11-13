<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Stevebauman\Purify\Facades\Purify;

if (!function_exists('is_super_admin')) {

    /**
     * Check if logged in user is a super admin
     *
     * @return boolean
     */
    function is_super_admin()
    {
        if (Cookie::get('user_role') == 'super_admin') {
            return true;
        }
        return false;
    }
}

if (!function_exists('has_selected_store')) {

    /**
     * Check if a user has selected a store
     *
     * @return boolean
     */
    function has_selected_store()
    {
        if (Cookie::get('store_id')) {
            return true;
        }
        return false;
    }
}

if (!function_exists('is_store_admin')) {

    /**
     * Check if logged in user is a store admin
     *
     * @return boolean
     */
    function is_store_admin()
    {
        if (Cookie::get('user_role') == 'store_admin') {
            return true;
        }
        return false;
    }
}

if (!function_exists('is_store_assistant')) {

    /**
     * Check if logged in user is a store assistant
     *
     * @return boolean
     */
    function is_store_assistant()
    {
        if (Cookie::get('user_role') == 'store_assistant') {
            return true;
        }
        return false;
    }
}

if (!function_exists('api_token')) {

    /**
     * gets logged in users api token from cookie
     *
     * @return string
     */
    function api_token()
    {
        return Cookie::get('api_token');
    }
}

if (!function_exists('get_full_name')) {

    /**
     * gets logged in users full name
     *
     * @return string
     */
    function get_full_name()
    {
        if (is_store_assistant()) {
            return Cookie::get('name');
        }
        return Cookie::get('first_name') . ' ' . Cookie::get('last_name');
    }
}

if (!function_exists('get_profile_picture')) {

    /**
     * gets logged in users profile picture
     *
     * @return string
     */
    function get_profile_picture()
    {
        $profile_picture = Cookie::get('profile_picture');
        $profile_picture = rtrim($profile_picture);
        $profile_picture_path = str_replace(" ", "/", $profile_picture);

        return 'https://res.cloudinary.com/' . $profile_picture_path;
    }
}


if (!function_exists('purify_input')) {

    /**
     * clean inputs before sending to API to prevent XSS
     *
     * @param string|array
     * @return string cleaned string
     */
    function purify_input($input)
    {
        $cleaned = Purify::clean($input);
        return $cleaned;
    }
}


if (!function_exists('app_format_date')) {

    /**
     * converts datetime to diffForhumans
     *
     * @param string $dateTime
     * @param boolean $html if to be returned with html formatted colors eg, success,warning,danger
     * @return string  human date
     */
    function app_format_date($dateTime, $style = false)
    {
        $formatted = Carbon::parse($dateTime)->diffForhumans();

        if (!$style) {
            return $formatted;
        }

        $styled = '<span class="badge badge-soft-';
        if (Carbon::parse($dateTime)->isPast()) {
            $styled .= 'danger">' . $formatted;
        } elseif (Carbon::parse($dateTime)->isToday()) {
            $styled .= 'warning">' . $formatted;
        } else {
            $styled .= 'success">' . $formatted;
        }
        $styled .= '</span>';

        return $styled;
    }
}

if (!function_exists('app_get_acronym')) {
    /**
     * Get acronym of string passed
     *
     * @param string
     * @return string cleaned string
     */
    function app_get_acronym($store_name)
    {
        $names = explode(" ", strtoupper($store_name));
        $acronym = "";
        foreach ($names as $name) {
            $acronym .= isset($name[0]) ? $name[0] : $name;
        }
        return $acronym;
    }
}

if (!function_exists('format_role_name')) {

    /**
     * Check the type of user logged in and assign a name to the user
     *
     * @return boolean
     */
    function format_role_name($user_role = "")
    {
        if ($user_role == "") {
            $user_role = Cookie::get('user_role');
        }
        if ($user_role == 'store_admin') {
            return 'Owner';
        } elseif ($user_role == 'super_admin') {
            return 'Super Admin';
        } else {
            return 'Assistant';
        }
    }

}
