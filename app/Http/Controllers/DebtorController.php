<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class DebtorController extends Controller
{
    protected $host;
    protected $api_token;

    public function __construct()
    {
        $this->host = env('API_URL', 'https://dev.api.customerpay.me');
        $this->api_token = Cookie::get('api_token');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $store_id = Cookie::get('store_id');
        $user_role = Cookie::get('user_role');
        if(is_store_admin()){
            $url = $this->host . '/store' . '/' . $store_id;
            $transactions_url = $this->host . '/transaction/store/' . $store_id;
        }elseif(is_store_assistant()){
            $storeUrl = $this->host . '/store';
            $debtorUrl = $this->host . '/debt';

            if ($request->has('store_id')) {
                $storeID = $request->store_id;
                $debtorUrl = $this->host . '/debt' . '/' . $storeID;
            }
        }else{
            $storeUrl = $this->host . '/store/all';
            $debtorUrl = $this->host . '/transaction/all';
        }

        try {
            $client = new Client();
            $payload = ['headers' => ['x-access-token' => Cookie::get('api_token')]];
            if(is_store_admin()){
                $response = $client->request("GET", $url, $payload);
            $transaction_response = $client->request("GET", $transactions_url, $payload);
            $statusCode = $response->getStatusCode();
            $transaction_statusCode = $transaction_response->getStatusCode();
            $body = $response->getBody();
            $transactions_body = $transaction_response->getBody();
            $store_transactions = json_decode($transactions_body)->data->transactions;
            $StoreData = json_decode($body)->data->store;
            $StoreData = [
                'storeData' => $StoreData,
                "transactions" => $store_transactions
            ];

            if ($statusCode == 200 && $transaction_statusCode == 200) {

                return view('backend.stores.show_debt')->with('response', $StoreData)->with('number', 1);
            }
            }else{
                // fetch all stores
            $storeResponse = $client->request("GET", $storeUrl, $payload);
            $storeStatusCode = $storeResponse->getStatusCode();

            // fetch debtors
            $debtorResponse = $client->request("GET", $debtorUrl, $payload);
            $debtorStatusCode = $debtorResponse->getStatusCode();

            if ($storeStatusCode == 200 && $debtorStatusCode == 200) {
                $stores = json_decode($storeResponse->getBody())->data->stores;
                if (Cookie::get('user_role') != 'super_admin') {
                    $debtors = json_decode($debtorResponse->getBody())->data->debts;
                } else {
                    $debtors = [];
                    $transactions = json_decode($debtorResponse->getBody())->data->transactions;

                    foreach ($transactions as $transaction) {

                        if ($transaction->type == 'debt' || $transaction->type == 'Debt') {
                            $debtors[] = $transaction;
                        }
                    }
                }
                return view('backend.debtor.index', compact('debtors', 'stores'));
            } else if ($storeStatusCode == 401 && $debtorStatusCode == 401) {
                return redirect()->route('login')->with('message', "Please Login Again");
            }
            Session::flash('message', "Temporarily unable to get all stores");
            return view('backend.debtor.index', []);
            }
        }catch (RequestException $e) {
            Log::info('Catch error: DebtorController - ' . $e->getMessage());
            if ($e->hasResponse()) {
                $response = $e->getResponse()->getBody();
                $result = json_decode($response);
                Session::flash('message', $result->message);
                $debtors = [];
                $stores = [];
                return view('backend.debtor.index',  compact('debtors', 'stores'));
            }
            //5xx server error
            return view('errors.500');
        } catch (\Exception $e) {
            Log::error('Catch error: DebtorController - ' . $e->getMessage());
            return view('errors.500');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $store_url = env('API_URL', 'https://dev.api.customerpay.me') . '/store';
        $transaction_url = env('API_URL', 'https://dev.api.customerpay.me') . '/transaction';

        $cl = new Client;
        $cl2 = new Client;

        $payloader = ['headers' => ['x-access-token' => Cookie::get('api_token')]];

        $resp = $cl->request("GET", $store_url, $payloader);
        $response = $cl2->request("GET", $transaction_url, $payloader);

        $statsCode = $resp->getStatusCode();
        $statsCode2 = $response->getStatusCode();

        $body_response = $resp->getBody();
        $body_response2 = $response->getBody();

        $Stores = json_decode($body_response);
        $transaction = json_decode($body_response2);

        if ($statsCode == 200) {
            return view('backend.debtor.create', compact('transaction'))->with('response', $Stores->data->stores);
        } else if ($statsCode == 500) {
            return view('errors.500');
        }
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return view('backend.customer.show');
        if (!$id || empty($id)) {
            return redirect()->route('debtors.index');
        }

        // display all stores
        $storeUrl = $this->host . '/store';

        // debtors list
        $debtorUrl = $this->host . '/debt/single/' . $id;

        try {
            $client = new Client();
            $payload = ['headers' => ['x-access-token' => Cookie::get('api_token')]];

            // fetch all stores
            $storeResponse = $client->request("GET", $storeUrl, $payload);
            $storeStatusCode = $storeResponse->getStatusCode();

            // fetch debtors
            $debtorResponse = $client->request("GET", $debtorUrl, $payload);
            $debtorStatusCode = $debtorResponse->getStatusCode();

            if ($storeStatusCode == 200 && $debtorStatusCode == 200) {
                $stores = json_decode($storeResponse->getBody())->data->stores;
                $debtor = json_decode($debtorResponse->getBody())->data->debt;
                return view('backend.debtor.show', compact('debtor', 'stores'));
            } else if ($storeStatusCode == 401 && $debtorStatusCode == 401) {
                return redirect()->route('login')->with('message', "Please Login Again");
            }
            Session::flash('message', "Temporarily unable to get all stores");
            return redirect()->route('debtor.index');
        } catch (RequestException $e) {
            Log::info('Catch error: DebtorController - ' . $e->getMessage());
            if ($e->hasResponse()) {
                $response = $e->getResponse()->getBody();
                $result = json_decode($response);
                Session::flash('message', $result->message);
                return redirect()->route('debtor.index');
            }
            //5xx server error
            return view('errors.500');
        } catch (\Exception $e) {
            Log::error('Catch error: DebtorController - ' . $e->getMessage());
            return view('errors.500');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        return view('backend.debtor.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
    }

    public function sendReminder(Request $request)
    {

        $request->validate([
            'store_id' => 'required',
            'customer_id' => 'required',
            'transaction_id' => 'required',
            'message' => 'required|min:10|max:140',
        ]);

        $storeID = $request->store_id;
        $customerID = $request->customer_id;
        $transactionID = $request->transaction_id;

        $url = env('API_URL', 'https://dev.api.customerpay.me') . '/debt' . '/send' . '/' . $storeID . '/' . $customerID . '/' . $transactionID;

        try {
            $client =  new Client();
            $payload = [
                'headers' => ['x-access-token' => Cookie::get('api_token')],
                'form_params' => [
                    'transaction_id' => $transactionID,
                    'message' => purify_input($request->message),
                ],
            ];

            $response = $client->request("POST", $url, $payload);

            $statusCode = $response->getStatusCode();
            $data = json_decode($response->getBody());
            if ($statusCode == 200 && $data->success == true) {
                Session::flash('alert-class', 'alert-success');
                Session::flash('message', $data->message);
                return redirect()->back();
            } else {
                Session::flash('alert-class', 'alert-warning');
                Session::flash('message', $data->message);
                return redirect()->back();
            }
        } catch (RequestException $e) {
            Log::info('Catch error: DebtorController - ' . $e->getMessage());

            if ($e->hasResponse()) {
                if ($e->getCode() == 401) {
                    Session::flash('message', 'session expired');
                    return redirect()->route('logout');
                }
            }

            $response = $e->getResponse()->getBody();
            $result = json_decode($response);
            Session::flash('message', isset($result->message) ? $result->message : $result->Message);
            return redirect()->back();
            //5xx server error
            return view('errors.500');
        } catch (\Exception $e) {
            Session::flash('message', $e->getMessage());
            Log::error(' ' . $e->getMessage());
            return view('errors.500');
        }
    }

    public function sheduleReminder(Request $request)
    {

        $request->validate([
            'time' =>  'required|date_format:H:i',
            'store_id' => 'required',
            'customer_id' => 'required',
            'scheduleDate' => 'required|date_format:Y-m-d',
            'transaction_id' => 'required',
        ]);

        $storeID = $request->store_id;
        $customerId = $request->customer_id;
        $transactionID = $request->transaction_id;

        $url = env('API_URL', 'https://dev.api.customerpay.me') . '/debt/schedule' . '/' . $storeID . '/' . $customerId . '/' . $transactionID;

        try {
            $client =  new Client();
            $payload = [
                'headers' => ['x-access-token' => Cookie::get('api_token')],
                'form_params' => [
                    'scheduleDate' => $request->scheduleDate,
                    'time' => $request->time,
                    'message' => purify_input($request->message),
                ],
            ];

            $response = $client->request("POST", $url, $payload);

            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            $data = json_decode($body);

            if ($statusCode == 200  && $data->success) {
                $request->session()->flash('alert-class', 'alert-success');
                Session::flash('message', $data->Message);
                return back();
            } else {
                $request->session()->flash('alert-class', 'alert-success');
                Session::flash('message', $data->Message);
                return redirect()->back();
            }
        } catch (RequestException $e) {
            Log::info('Catch error: DebtorController - ' . $e->getMessage());

            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }

            if ($e->hasResponse()) {
                $response = $e->getResponse()->getBody();
                $result = json_decode($response);
                $message = isset($result->Message) ? $result->Message : $result->message;
                Session::flash('message', $message);
                $debtors = [];
                $stores = [];
                return view('backend.debtor.index',  compact('debtors', 'stores'));
            }

            //5xx server error
            return view('errors.500');
        } catch (\Exception $e) {
            Session::flash('message', $e->getMessage());
            Log::error(' ' . $e->getMessage());
            return view('errors.500');
        }
    }

    public function markPaid(Request $request, $id)
    {

        $url = env('API_URL', 'https://dev.api.customerpay.me') . '/debt' . '/update/' . $id;

        try {
            $client =  new Client();
            $payload = [
                'headers' => ['x-access-token' => Cookie::get('api_token')],
            ];

            $response = $client->request("PUT", $url, $payload);

            $statusCode = $response->getStatusCode();
            $body = $response->getBody();
            $data = json_decode($body);

            if (($statusCode == 200 || $statusCode == 201)) {
                $request->session()->flash('alert-class', 'alert-success');
                $request->session()->flash('message', 'updated successfully');
                return back();
            } else {
                $request->session()->flash('alert-class', 'alert-warning');
                Session::flash('message', $data->message);
                return redirect()->back();
            }
        } catch (RequestException $e) {
            Log::info('Catch error: DebtorController - ' . $e->getMessage());

            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }

            if ($e->hasResponse()) {
                $response = $e->getResponse()->getBody();
                $result = json_decode($response);
                Session::flash('message', $result->message);
                return view('backend.debtor.index', []);
            }

            //5xx server error
            return view('errors.500');
        } catch (\Exception $e) {
            Session::flash('message', $e->getMessage());
            Log::error(' ' . $e->getMessage());
            return view('errors.500');
        }
    }
}
