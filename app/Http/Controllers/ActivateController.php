<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Response;

class ActivateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Cookie::get('is_active')) {
            return redirect()->route('dashboard');
        }

        try {
            $url = env('API_URL', 'https://api.customerpay.me') . '/otp/send';
            $client = new Client();
            $response = $client->post($url, [
                'form_params' => [
                    'phone_number' => Cookie::get('phone_number'),
                ]
            ]);
            
            if ($response->success) {
                // set alert
                $request->session()->flash('alert-class', 'alert-success');
                $request->session()->flash('message', 'Kindly check your Phone for verification code');
            } else {
                $message = $response->message;
                $request->session()->flash('message', $message);
            }
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = json_decode($e->getResponse()->getBody());
                Session::flash('message', $response->message);
            }
        } catch (Exception $e) {
            if ($e->getCode() == 401) {
                return redirect()->route('logout');
            }
            Log::error($e->getMessage());
        }

        return view('backend.user.activate')->with([
            'apiToken' => Cookie::get('api_token'),
            'phoneNumber' => Cookie::get('phone_number')
        ]);
    }

    public function activate(Request $request)
    {

        if ($request->has('skip')) {
            Cookie::queue('is_active', true);
            return redirect()->route('dashboard');
        }

        try {
            $url = env('API_URL', 'https://api.customerpay.me') . '/otp/verify';
            $client = new Client();
            $response = $client->post($url, [
                'form_params' => [
                    'phone_number' => Cookie::get('phone_number'),
                    'verify' => $request->input('verify'),
                ]
            ]);

            if ($response->getStatusCode() == 200) {
                Cookie::queue('is_active', true);
                return response()->json('activated', 200);
            } else {
                return response()->json(['message' => 'The verification code you have entered is incorrect. please try again'], 400);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'The verification code you have entered is incorrect. please try again'], 400);
        }

    }

    public function sendOTP(Request $request)
    {
        try {
            $url = env('API_URL', 'https://api.customerpay.me') . '/otp/send';
            $client = new Client();
            $response = $client->post($url, [
                'form_params' => [
                    'phone_number' => Cookie::get('phone_number'),
                ]
            ]);

            if ($response->getStatusCode() == 200) {
                $response = json_decode($response->getBody());
                $data = $response->data;
                return response()->json($data, 200);
            } else {
                return response()->json(['message' => 'An error occured. Please try again later'], 400);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'An error occured. Please try again later'], 400);
        }
    }
}
