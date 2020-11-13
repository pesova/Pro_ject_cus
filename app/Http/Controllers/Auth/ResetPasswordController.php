<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\redirect;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    public function __construct()
    {
        $this->host = env('API_URL', 'https://dev.api.customerpay.me');
    }

    public function index(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
            'password' => 'required|min:6|confirmed'
        ]);

        try {
            $client =  new Client();
            $response = $client->post($this->host . '/reset', [
                'form_params' => [
                    'password' => $request->input('password'),
                    'token' => $request->input('otp')
                    ]
            ]);

            if($response->getStatusCode() == 200) {
                $request->session()->flash('alert-class', 'alert-success');
                $request->session()->flash('message', 'Your password has been reset');

                return redirect()->route('dashboard');
            }

        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::info('Catch Error: ResetPasswordController - ' . $e->getMessage());

            if ($e->hasResponse()) {
                $response = json_decode($e->getResponse()->getBody());
                $request->session()->flash('message', $response->message);
                return redirect()->route('password');
            }
        }
    }
}
