<?php

namespace App\Http\Controllers;

use App\Rules\DoNotAddIndianCountryCode;
use Exception;
use App\Rules\DoNotPutCountryCode;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class StoreController extends Controller
{
    protected $host;

    public function __construct()
    {
        $this->host = env('API_URL', 'https://dev.api.customerpay.me');
    }

    public function index(Request $request)
    {
        $storeUrl = $this->host . '/store';

        try {

            $client = new Client;
            $payload = ['headers' => ['x-access-token' => api_token()]];
            $response = $client->request("GET", $storeUrl, $payload);
            $statusCode = $response->getStatusCode();

            if ($statusCode == 200) {

                $stores_data = json_decode($response->getBody())->data->stores;
                // loop added because returns two nested arrays for superadmin. - doug
                if (is_super_admin()) {
                    $stores = [];
                    foreach ($stores_data as $stores_array) {
                        foreach ($stores_array as $store) {
                            $stores[] = $store;
                        }
                    }
                    $stores_data = $stores;
                }

                // start pagination
                $perPage = 12;
                $page = $request->get('page', 1);
                if ($page > count($stores_data) or $page < 1) {
                    $page = 1;
                }
                $offset = ($page * $perPage) - $perPage;

                $articles = array_slice($stores_data, $offset, $perPage);
                $stores = new Paginator($articles, count($stores_data), $perPage);

                return view('backend.stores.index')->with('stores', $stores->withPath('/' . $request->path()));
            } else if ($statusCode == 401) {
                return redirect()->route('login')->with('message', "Please Login Again");
            }
        } catch (RequestException $e) {
            
            if ($e->getCode() == 401) {
                $request->session()->flash('alert-class', 'alert-danger');
                Session::flash('message', "Your Session Has Expired, Please Login Again");
                return redirect()->route('logout');
            }

            Log::error('Catch error: StoreController - ' . $e->getMessage());
            return view('errors.500');
        } catch (\Exception $e) {
            //log error;
            Log::error('Catch error: StoreController - ' . $e->getMessage());
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
        return view('backend.stores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $url = $this->host . '/store/new';

        if ($request->isMethod('post')) {
            $request->validate([
                'store_name' => 'required|min:2|max:100',
                'phone_number' => ["required", "numeric", "digits_between:6,16", new DoNotAddIndianCountryCode, new DoNotPutCountryCode],
                'shop_address' => 'required|min:5|max:100',
                'tagline' => 'required|min:4|max:50'
            ]);

            try {

                $client = new Client();
                $payload = [
                    'headers' => ['x-access-token' => Cookie::get('api_token')],
                    'form_params' => [
                        'store_name' => purify_input($request->input('store_name')),
                        'shop_address' => purify_input($request->input('shop_address')),
                        'email' => $request->input('email'),
                        'tagline' => purify_input($request->input('tagline')),
                        'phone_number' => $request->input('phone_number')
                    ],
                ];

                $response = $client->request("POST", $url, $payload);

                $statusCode = $response->getStatusCode();
                $body = $response->getBody();
                $data = json_decode($body);
                if ($statusCode == 201 && $data->success) {
                    $request->session()->flash('alert-class', 'alert-success');
                    Session::flash('message', $data->message);
                    if ($request->has('first_user')) {
                        Cookie::queue("store_id", $data->data->store->_id);
                        Cookie::queue("store_name", $data->data->store->store_name);
                        return redirect()->route('dashboard');
                    }
                    return redirect()->route('store.index');
                } else if ($statusCode == 401) {
                    $request->session()->flash('alert-class', 'alert-danger');
                    Session::flash('message', "Your Session Has Expired, Please Login Again");
                    return redirect()->route('logout');
                } else {
                    $request->session()->flash('alert-class', 'alert-waring');
                    Session::flash('message', $data->message);
                    return back();
                }
            } catch (RequestException $e) {

                if ($statusCode == 500) {
                    $request->session()->flash('alert-class', 'alert-danger');
                    Session::flash('message', "Your Session Has Expired, Please Login Again");
                    return redirect()->route('logout');
                }

                if ($e->hasResponse()) {
                    $data = json_decode($response->getBody());
                    Session::flash('message', $data->message);
                }

                return back();
            } catch (Exception $e) {
                Log::error((string)$response->getBody());
                return view('errors.500');
            }
        }

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $url = $this->host . '/store/' . $id;
        $transactions_url = $this->host . '/transaction/store/' . $id;

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
            $transactions   = json_decode($transaction_response->getBody())->data->transactions;

            $data= prepare_store_data($store_data, $transactions);


            if ($store_status_code == 200 && $transaction_status_code == 200) {
                return view('backend.stores.show', $data)->with('number', 1);
            }
        } catch (RequestException $e) {
            Log::info('Catch error: LoginController - ' . $e->getMessage());
            if ($e->getCode() == 401) {
                $request->session()->flash('alert-class', 'alert-danger');
                Session::flash('message', "Your Session Has Expired, Please Login Again");
                return redirect()->route('logout');
            }

            // get response to catch 4xx errors
            $response = json_decode($e->getResponse()->getBody());
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $response->message);
            return redirect()->route('store.index', ['response' => []]);
        } catch (Exception $e) {
            Log::error('Catch error: StoreController - ' . $e->getMessage());
            return view('errors.500');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)

    {
        // return $request->input();
        $url = $this->host . '/store/update' . '/' . $id;

        $request->validate([
            'edit_store_name' => 'required|min:3',
            'edit_shop_address' => 'required',
            'edit_email' => "required|email",
            'edit_tagline' => 'required',
            'edit_phone_number' => ["required", "numeric", "digits_between:6,16", new DoNotAddIndianCountryCode, new DoNotPutCountryCode],
        ]);

        try {

            $client = new Client();
            $headers = ['headers' => ['x-access-token' => api_token()]];
            $data = [
                $headers,
                'form_params' => [
                    'token' => api_token(),
                    'store_name' => purify_input($request->input('edit_store_name')),
                    'shop_address' => purify_input($request->input('edit_shop_address')),
                    'phone_number' => $request->input('edit_phone_number'),
                    'email' => $request->input('edit_email'),
                    'tagline' => purify_input($request->input('edit_tagline'))
                ],
            ];

            $response = $client->request("PUT", $url, $data);
            $status = $response->getStatusCode();

            if ($status == 200 || $status == 201) {

                $request->session()->flash('alert-class', 'alert-success');
                if ($id == Cookie::get('store_id')) {
                    Cookie::queue("store_name", $request->input('edit_store_name'));
                }
                Session::flash('message', "Update Successful");
                return redirect()->route('store.index');
            } else {
                $request->session()->flash('alert-class', 'alert-success');
                Session::flash('message', "OOPS, Something Went Wrong");
                return redirect()->route('store.index');
            }
        } catch (Exception $e) {
            Log::error('Catch error: StoreController - ' . $e->getMessage());

            if ($e->getCode() == 401) {
                $request->session()->flash('alert-class', 'alert-danger');
                Session::flash('message', "Your Session Has Expired, Please Login Again");
                return redirect()->route('logout');
            }

            $request->session()->flash('alert-class', 'alert-danger');
            $request->session()->flash('message', 'An Error Occured. Please Try Again Later');
            return redirect()->route('store.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {

        $url = env('API_URL', 'https://dev.api.customerpay.me') . '/store/delete/' . $id;
        $client = new Client();
        $payload = [
            'headers' => [
                'x-access-token' => api_token()
            ],
            'form_params' => [
                'current_user' => Cookie::get('user_id'),
            ]
        ];
        try {

            if ($id == Cookie::get('store_id')) {
                $request->session()->flash('alert-class', 'alert-danger');
                Session::flash('message', "Sorry you can not delete selected store, please switch or create another store");
                return  back();
            }

            $delete = $client->delete($url, $payload);

            if ($delete->getStatusCode() == 200 || $delete->getStatusCode() == 201) {
                $request->session()->flash('alert-class', 'alert-success');
                Session::flash('message', "Store successfully deleted");
                return redirect()->route('store.index');
            } else if ($delete->getStatusCode() == 500) {
                $request->session()->flash('alert-class', 'alert-danger');
                Session::flash('message', "A server error encountered, please try again later");
                return redirect()->route('store.index');
            }
        } catch (Exception $e) {
            if ($e->getCode() == 401) {
                $request->session()->flash('alert-class', 'alert-danger');
                Session::flash('message', "Your Session Has Expired, Please Login Again");
                return redirect()->route('logout');
            }

            $request->session()->flash('alert-class', 'alert-danger');
            Session::flash('message', "A technical error occured, we are working to fix this.");
            return redirect()->route('store.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function debt(Request $request, $id)
    {

        $url = env('API_URL', 'https://dev.api.customerpay.me') . '/store/' . $id;
        $transactions_url = env('API_URL', 'https://dev.api.customerpay.me') . '/transaction/store/' . $id;
        try {
            $client = new Client;
            $payload = [
                'headers' => [
                    'x-access-token' => api_token()
                ]
            ];
            $response = $client->request("GET", $url, $payload);
            $transaction_response = $client->request("GET", $transactions_url, $payload);
            $statusCode = $response->getStatusCode();
            $transaction_statusCode = $transaction_response->getStatusCode();

            $transactions_body = $transaction_response->getBody();
            $store_transactions = json_decode($transactions_body)->data->transactions;
            $StoreData = json_decode($response->getBody())->data->store;
            $StoreData = [
                'storeData' => $StoreData,
                "transactions" => $store_transactions
            ];

            if ($statusCode == 200 && $transaction_statusCode == 200) {

                return view('backend.stores.show_debt')->with('response', $StoreData)->with('number', 1);
            }
        } catch (RequestException $e) {

            Log::info('Catch error: storeController - ' . $e->getMessage());

            if ($e->getCode() == 401) {
                $request->session()->flash('alert-class', 'alert-danger');
                Session::flash('message', "Your Session Has Expired, Please Login Again");
                return redirect()->route('logout');
            }

            // get response to catch 4xx errors
            $response = json_decode($e->getResponse()->getBody());
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $response->message);
            return redirect()->route('store.index', ['response' => []]);
        } catch (\Exception $e) {
            //log error;
            Log::error('Catch error: StoreController - ' . $e->getMessage());
            return view('errors.500');
        }
    }

    public function receivable(Request $request, $id)
    {
        $url = env('API_URL', 'https://dev.api.customerpay.me') . '/store/' . $id;
        $transactions_url = env('API_URL', 'https://dev.api.customerpay.me') . '/transaction/store/' . $id;
        try {
            $client = new Client;
            $payload = [
                'headers' => [
                    'x-access-token' => Cookie::get('api_token')
                ]
            ];
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

                return view('backend.stores.show_receivable')->with('response', $StoreData)->with('number', 1);
            }
        } catch (RequestException $e) {

            Log::info('Catch error: LoginController - ' . $e->getMessage());

            // check for 5xx server error
            if ($e->getResponse()->getStatusCode() >= 500) {
                return view('errors.500');
            } else if ($e->getResponse()->getStatusCode() == 401) {
                $request->session()->flash('alert-class', 'alert-danger');
                Session::flash('message', "Your Session Has Expired, Please Login Again");
                return redirect()->route('logout');
            }
            // get response to catch 4xx errors
            $response = json_decode($e->getResponse()->getBody());
            Session::flash('alert-class', 'alert-danger');

            Session::flash('message', $response->message);
            return redirect()->route('store.index', ['response' => []]);
        } catch (\Exception $e) {
            //log error;
            Log::error('Catch error: StoreController - ' . $e->getMessage());
            return view('errors.500');
        }
    }

    public function revenue(Request $request, $id)
    {
        $url = env('API_URL', 'https://dev.api.customerpay.me') . '/store/' . $id;
        $transactions_url = env('API_URL', 'https://dev.api.customerpay.me') . '/transaction/store/' . $id;
        try {
            $client = new Client;
            $payload = [
                'headers' => [
                    'x-access-token' => Cookie::get('api_token')
                ]
            ];
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

                return view('backend.stores.show_revenue')->with('response', $StoreData)->with('number', 1);
            }
        } catch (RequestException $e) {

            Log::info('Catch error: LoginController - ' . $e->getMessage());

            // check for 5xx server error
            if ($e->getResponse()->getStatusCode() == 401) {
                $request->session()->flash('alert-class', 'alert-danger');
                Session::flash('message', "Your Session Has Expired, Please Login Again");
                return redirect()->route('logout');
            }

            $response = json_decode($e->getResponse()->getBody());
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', $response->message);
            return redirect()->route('store.index', ['response' => []]);
        } catch (\Exception $e) {
            Log::error('Catch error: StoreController - ' . $e->getMessage());
            return view('errors.500');
        }
    }

    public function selectStore(Request $request)
    {
        Cookie::queue('store_id', $request->input('store_id'));
        Cookie::queue('store_name', $request->input('store_name'));
        return redirect()->route('dashboard');
    }
}
