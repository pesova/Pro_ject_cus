<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Rules\DoNotAddIndianCountryCode;
use App\Rules\DoNotPutCountryCode;
use App\Rules\NoZero;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;

// use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $host;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->host = env('API_URL', 'https://dev.api.customerpay.me');
    }

    public function index()
    {
        if (Cookie::get('api_token')) {
            return redirect()->route('dashboard');
        }
        return view('backend.auth.login');
    }

    public function authenticate(Request $request)
    {
        $this->validateUser($request);

        try {
            $client = new Client();
            $response = $client->post($this->host . '/login/user', [
                'form_params' => [
                    'phone_number' => $request->input('phone_number'),
                    'password' => $request->input('password')
                ]
            ]);

            if ($response->getStatusCode() == 200) {

                $response = json_decode($response->getBody());

                if (isset($response->success) && $response->success) {

                    $data = $response->data->user->local;

                    $image_path = $response->data->user->image->path;
                    $image = explode('/', $image_path);
                    $c = (count($image) - 1);

                    $profile_picture = "";
                    for ($j = 3; $j <= $c; $j++) {
                        $profile_picture .= $image[$j] . ' ';
                    }

                    // store data to cookie
                    Cookie::queue('api_token', $response->data->user->api_token);
                    Cookie::queue('user_role', $response->data->user->local->user_role);
                    Cookie::queue('first_name', isset($response->data->user->local->first_name) ? $response->data->user->local->first_name : $response->data->user->local->name);
                    Cookie::queue('email', $response->data->user->local->email);
                    Cookie::queue('last_name', isset($response->data->user->local->last_name) ? $response->data->user->local->last_name : $response->data->user->local->name);
                    Cookie::queue('is_active', $data->is_active);
                    Cookie::queue('phone_number', $data->phone_number);
                    Cookie::queue('user_id', $response->data->user->_id);
                    Cookie::queue('profile_picture', $profile_picture);
                    Cookie::queue('expires', strtotime('+ 1 day'));
                    Cookie::queue('is_first_time_user', false);

                    //Check for Store Assistant to set Name
                    $userRole = $response->data->user->local->user_role;
                    if ($userRole == 'store_assistant') {
                        Cookie::queue('name', isset($response->data->user->local->name) ? $response->data->user->local->name : '');
                    }
                    // Financial info 
                    $userRole = $response->data->user->local->user_role;
                    if ($userRole == 'store_admin') {
                        if (isset($response->data->user->bank_details)) {
                            $bank_details = $response->data->user->bank_details;
                            $accoun_name = isset($bank_details->account_name) ? $bank_details->account_name : '';
                            $account_number = isset($bank_details->account_number) ? $bank_details->account_number : '';
                            $bank = isset($bank_details->bank) ? $bank_details->bank : '';

                            Cookie::queue('account_name', $accoun_name);
                            Cookie::queue('account_number', $account_number);
                            Cookie::queue('account_bank', $bank);
                        } else {
                            Cookie::queue('account_name', '');
                            Cookie::queue('account_number', '');
                            Cookie::queue('account_bank', '');
                        }
                        Cookie::queue('currency', $response->data->user->currencyPreference);
                    } elseif ($userRole == 'store_assistant') {
                        Cookie::queue('currency', $response->data->user->currencyPreference);
                    }

                    //show success message
                    $request->session()->flash('alert-class', 'alert-success');
                    $request->session()->flash('message', "You are logged in successfully");

                    if ($userRole == 'store_admin') {
                        // we need to get the number of stores of store admin before letting him in. if request fails, we log him out
                        if (!$this->getStores($response->data->user->api_token)) {
                            return redirect()->route('logout', ['message' => 'An error occured. Please login again']);
                        }
                    }
                    
                    //check if active
                    if ($data->is_active == false) {
                        return redirect()->route('activate.index');
                    }

                } else {
                    $request->session()->flash('message', 'Invalid Credentials');
                    return redirect()->route('login');
                }
            }

            $request->session()->flash('message', 'Invalid Credentials');
            return redirect()->route('login');
        } catch (RequestException $e) {
            //log error;
            Log::error('Catch error: LoginController - ' . $e->getMessage());

            if ($e->hasResponse()) {
                if ($e->getResponse()->getStatusCode() >= 400) {
                    // get response to catch 4xx errors
                    $response = json_decode($e->getResponse()->getBody());
                    $request->session()->flash('alert-class', 'alert-danger');
                    $request->session()->flash('message', 'Invalid Credentials');
                    return redirect()->route('login');
                }
            }
            // check for 500 server error
            return view('errors.500');
        } catch (\Exception $e) {
            //log error;
            Log::error('Catch error: LoginController - ' . $e->getMessage());
            return view('errors.500');
        }
        return redirect()->route('login');
    }

    public function validateUser(Request $request)
    {

        $rules = [
            'phone_number' => ['required', 'min:6', 'max:16', new DoNotAddIndianCountryCode, new DoNotPutCountryCode],
            'password' => ['required', 'min:6']
        ];

        $messages = [
            'phone_number.*' => 'Invalid Credentials',
            'password.*' => 'Invalid Credentials',
        ];

        $this->validate($request, $rules, $messages);
    }

    /**
     * Get's all stores belonging to the store_admin, sets the first as selected store
     */
    private function getStores($api_token)
    {

        $storeUrl = $this->host . '/store';

        try {
            //code...

            // initiate new GuzzleHttp Client
            $client = new Client;

            // pass access token
            $payload = ['headers' => ['x-access-token' => $api_token]];

            // make Http request
            $response = $client->request("GET", $storeUrl, $payload);

            // get response from Http request
            $statusCode = $response->getStatusCode();

            if ($statusCode == 200) {
                // get data from respone
                $stores_data = json_decode($response->getBody())->data->stores;
                // loop added because returns two nested arrays for superadmin. - doug
                if (count($stores_data) > 0) {
                    Cookie::queue("store_id", $stores_data[0]->_id);
                    Cookie::queue("store_name", $stores_data[0]->store_name);
                }
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            //log error;
            Log::error('Catch error: StoreController - ' . $e->getMessage());
            return false;
        }
    }
}
