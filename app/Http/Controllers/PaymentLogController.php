<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PaymentLogController extends Controller
{
    public function index()
    {
        try {

            $url = env('API_URL', 'https://dev.api.customerpay.me') . '/payments/all';
            $client = new Client();
            $headers = ['headers' => ['x-access-token' => Cookie::get('api_token')]];
            $response = $client->request('GET', $url, $headers);

            if ($response->getStatusCode() == 200) {
                $PaymentLogs = json_decode($response->getBody())->data->payments;
                 //dd($PaymentLogs);
                return view('backend.PaymentLog.index',compact('PaymentLogs'));
            }
        } catch (RequestException $e) {
            //log error;
            Log::info('Catch error: PaymentLogController - ' . $e->getMessage());

            if ($e->getCode() == 401) {
                Session::flash('message', 'Session Expired, Please login again');
                return redirect()->route('logout');
            }

            // get response to catch 4 errors
            if ($e->hasResponse()) {
                $response = $e->getResponse()->getBody();
                $result = json_decode($response);
                Session::flash('message', $result->message);
                return view('backend.PaymentLog.index')->with('PaymentLogs', []);
            }

            return view('errors.500');
        } catch (Exception $e) {

            //log error;
            if ($e->getCode() == 401) {
                return redirect()->route('logout');
            }

            Log::error('Catch error: PaymentLogController - ' . $e->getMessage());
            return view('errors.500');
        }
    }
}
