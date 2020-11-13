<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    protected $host;

    public function __construct()
    {
        $this->host = env('API_URL', 'https://dev.api.customerpay.me');
    }

    public function index()
    {
        // API updated
        if (is_super_admin()) {
            return $this->superAdminDashboard();
        } elseif (is_store_admin()) {
            return $this->storeAdminDashboard();
        } else {
            return $this->storeAssistantDashboard();
        }
    }

    public function notification()
    {
        // $phone_number = Cookie::get('phone_number');
        // $user = User::where('phone_number', $phone_number)->first();
        // return view('backend.dashboard.notification')->with([
        //     'notifications' => $user->notifications,
        //     'user' => $user
        // ]);
    }

    public function creditor()
    {
        return view('backend.dashboard.creditor');
    }

    public function analytics()
    {
        return view('backend.dashboard.analytics');
    }

    public function superAdminDashboard()
    {

        $allInfo_url = env('API_URL', 'https://dev.api.customerpay.me') . '/dashboard/all';
        try {
            $client = new Client;
            $payload = [
                'headers' => [
                    'x-access-token' => Cookie::get('api_token')
                ]
            ];
            // Transaction endpoint is having issues
            $allInfoResponse = $client->request('GET', $allInfo_url, $payload);

            // Transaction endpoint is having issues
            $status_code_all_info = $allInfoResponse->getStatusCode();

            if ($status_code_all_info == 200) {
                $response = json_decode($allInfoResponse->getBody())->data;;

                if ($response->totalDebt > 1000000) {
                    $response->totalDebt = sprintf("%0.2fM", $response->totalDebt / 1000000);
                } elseif ($response->totalDebt > 1000) {
                    $response->totalDebt = sprintf("%0.2fK", $response->totalDebt / 1000);
                }

                return view('backend.dashboard.index')->with('data', $response);
            }
        } catch (RequestException $e) {
            Log::info('Catch error: DashboardController - ' . $e->getMessage());

            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }

            Session::flash('error', "something went wrong, refresh after few minutes.");
            return view('errors.500');
        } catch (\Exception $e) {
            Log::error('Catch error:  DashboardController - ' . $e->getMessage());
            return view('errors.500');
        }
    }

    public function storeAdminDashboard()
    {
        $id = Cookie::get('store_id');
        // $url = env('API_URL', 'https://dev.api.customerpay.me') . '/dashboard/';
        $url = $this->host . '/store' . '/' . $id;

        $transactions_url = $this->host . '/transaction/store' . '/' . $id;

        try {
            $client = new Client;
            $payload = [
                'headers' => [
                    'x-access-token' => Cookie::get('api_token')
                ],
            ];
            $store_response = $client->request("GET", $url, $payload);
            $store_status_code = $store_response->getStatusCode();

            $transaction_response = $client->request("GET", $transactions_url, $payload);
            $transaction_status_code = $transaction_response->getStatusCode();


            $store_data = json_decode($store_response->getBody())->data;
            $transactions = json_decode($transaction_response->getBody())->data->transactions;

            $data = prepare_store_data($store_data, $transactions);

            Cookie::queue('store_name', $store_data->store->store_name);
            if ($store_status_code == 200 && $transaction_status_code == 200) {
                return view('backend.dashboard.index', $data)->with('number', 1);
            }
            $id = Cookie::get('store_id');
            return $id;
        } catch (RequestException $e) {
            Log::info('Catch error: DashboardController - ' . $e->getMessage());

            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }

            Session::flash('error', "something went wrong, refresh after few minutes.");
            return view('errors.500');
        } catch (\Exception $e) {
            Log::error('Catch error:  DashboardController - ' . $e->getMessage());
            return view('errors.500');
        }
    }

    public function storeAssistantDashboard()
    {
        try {
            // Get all stores first
            $url = env('API_URL', 'https://dev.api.customerpay.me') . '/dashboard/assistant/'; // . Cookie::get('user_id');
            $client = new Client();
            $headers = ['headers' => ['x-access-token' => Cookie::get('api_token')]];
            $response = $client->request("GET", $url, $headers);

            if ($response->getStatusCode() == 200) {
                $assistant = json_decode($response->getBody())->data;
                return view('backend.dashboard.index', compact('assistant'));
            }

            return view('errors.500');
        } catch (RequestException $e) {
            Log::info('Catch error: DashboardController - ' . $e->getMessage());

            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }

            Session::flash('error', "something went wrong, refresh after few minutes.");
            return view('errors.500');
        } catch (\Exception $e) {
            Log::error('Catch error:  DashboardController - ' . $e->getMessage());
            return view('errors.500');
        }
    }


    public function getAllStores()
    {
        $client = new Client;
        $payload = [
            'headers' => [
                'x-access-token' => Cookie::get('api_token')
            ],
        ];
        $all_stores_url = $this->host . '/store';

        $all_store_response = $client->request("GET", $all_stores_url, $payload);
        $all_stores_data = $all_store_response->getBody();
        $status_code = $all_store_response->getStatusCode();
        $stores = json_decode($all_stores_data)->data->stores;
        if ($status_code == 200) {
            return json_encode($stores);
        } else {
            return json_encode(array());
        }
    }
}
