<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class ActivityController extends Controller
{
    public function index()
    {
        try {

            $url = env('API_URL', 'https://dev.api.customerpay.me') . '/activity-web';
            $client = new Client();
            $headers = ['headers' => ['x-access-token' => Cookie::get('api_token')]];
            $response = $client->request('GET', $url, $headers);

            if ($response->getStatusCode() == 200) {
                $activities = json_decode($response->getBody())->data;
                // dd($activities);
                return view('backend.activity.index',compact('activities'));
            }
        } catch (RequestException $e) {
            //log error;
            Log::info('Catch error: activityController - ' . $e->getMessage());

            if ($e->getCode() == 401) {
                Session::flash('message', 'Session Expired, Please login again');
                return redirect()->route('logout');
            }

            // get response to catch 4 errors
            if ($e->hasResponse()) {
                $response = $e->getResponse()->getBody();
                $result = json_decode($response);
                Session::flash('message', $result->message);
                return view('backend.activity.index')->with('activities', []);
            }

            return view('errors.500');
        } catch (Exception $e) {

            //log error;
            if ($e->getCode() == 401) {
                return redirect()->route('logout');
            }

            Log::error('Catch error: activityController - ' . $e->getMessage());
            return view('errors.500');
        }
    }
}
