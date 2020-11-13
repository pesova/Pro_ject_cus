<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;
// use function GuzzleHttp\json_encode;
// use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;
use GuzzleHttp\Exception\RequestException;
// use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
class SettingsController extends Controller
{
    protected $host;
    protected $api_token;
    public $headers;
    public $user_id;

    public function __construct()
    {
        $this->user_id = Cookie::get('user_id');
        $this->host = env('API_URL', 'https://dev.api.customerpay.me');
    }

    // Controller action to display settings page.
    public function index()
    {
        // User Data
        $user_details = [];
        $user_details['id'] = Cookie::get('user_id');
        $user_details['email'] = Cookie::get('email');
        $user_details['first_name'] = Cookie::get('first_name');
        $user_details['name'] = Cookie::get('name');
        $user_details['last_name'] = Cookie::get('last_name');
        $user_details['account_name'] = Cookie::get('account_name');
        $user_details['account_number'] = Cookie::get('account_number');
        $user_details['account_bank'] = Cookie::get('account_bank');
        $user_details['currency'] = Cookie::get('currency');
        $user_details['phone_number'] = Cookie::get('phone_number');
        $user_details['is_active'] = Cookie::get('is_active');
        $user_details['profile_picture'] = Cookie::get('profile_picture');

        $url = env('API_URL', 'https://dev.api.customerpay.me') . '/banks/list';
        try {
            $client = new Client();
            $headers = ['headers' => ['x-access-token' => Cookie::get('api_token')]];
            $bank_list = $client->request('GET', $url, $headers);
            $statusCode = $bank_list->getStatusCode();

            if ($statusCode == 200) {
                $bank_list = json_decode($bank_list->getBody())->data;
                usort($bank_list, function ($a, $b) {
                    return strcasecmp($a->name, $b->name);
                });
            } else {
                $bank_list = [];
            }
        } catch (RequestException $e) {
            Log::info('Catch error: settingsController - ' . $e->getMessage());
            // token expired
            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }
            // get response to catch 4 errors
            if ($e->hasResponse()) {
                $response = $e->getResponse()->getBody();
                $result = json_decode($response);
                Session::flash('message', 'could not retrieve bank list');
                return back();
            }
            $bank_list = [];
        } catch (Exception $e) {
            // token expired
            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }
            Log::error('Catch error: seetingsController - ' . $e->getMessage());
            return view('errors.500');
        }

        return view('backend.settings.settings', compact('user_details', 'bank_list'));
    }

    // Controller action to update user details.
    public function update(Request $request)
    {
        if(is_store_assistant()){
            return $this->update_store_assistant($request);
        } 
        else{
        try {
            // check if all fields are available
            if ($request->all()) {
                $control = $request->input('control', '');

                if ($control == 'profile_update') {

                    $url = env('API_URL', 'https://dev.api.customerpay.me') . '/store-admin/update';
                    $client = new Client();
                    $data = [
                        "first_name" => $request->input('first_name'),
                        "last_name" => $request->input('last_name'),
                        "email" => $request->input('email'),
                    ];
                    // make an api call to update the user_details
                    $this->headers = ['headers' => ['x-access-token' => Cookie::get('api_token')], 'form_params' => $data];
                    $response = $client->request('PUT', $url, $this->headers);
                } elseif ($control == 'password_change') {
                    $request->validate([
                        'current_password' => 'required|min:6',
                        'new_password' => 'required|min:6|confirmed',
                    ]);
                    return $this->change_password($request);
                } elseif ($control == 'finance_update') {
                    return $this->update_bank($request);
                } else {
                    return view('errors.404');
                }
                if ($response->getStatusCode() == 200) {
                    $request->session()->flash('alert-class', 'alert-success');
                    if ($control != 'password_change') {
                        $user_detail_res = json_decode($response->getBody(), true);
                        $filtered_user_detail = $user_detail_res['data']['store_admin']['local'];
                        Cookie::queue('phone_number', $filtered_user_detail['phone_number']);
                        Cookie::queue('first_name', $filtered_user_detail['first_name']);
                        Cookie::queue('email', $filtered_user_detail['email']);
                        Cookie::queue('last_name', $filtered_user_detail['last_name']);
                        $request->session()->flash('message', "Profile details updated successfully");
                        return back();
                    }
                    return back();
                }
            } else {
                return redirect()->route('setting');
            }
        } catch (RequestException $e) {

            if ($e->hasResponse()) {
                $response = json_decode($e->getResponse()->getBody());
                $request->session()->flash('alert-class', 'alert-danger');
                $request->session()->flash('message', $response->message);
            }
            return redirect()->route('setting');
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return view('errors.500');
        }
    }
}

    public function change_password(Request $request)
    {
        $url = env('API_URL', 'https://dev.api.customerpay.me') . '/store-admin/update/password';

        try {
            $client = new Client();
            $data = [
                "old_password" => $request->input('current_password'),
                "new_password" => $request->input('new_password'),
                "confirm_password" => $request->input('new_password_confirmation')
            ];

            $payload = ['headers' => ['x-access-token' => Cookie::get('api_token')], 'form_params' => $data];
            $response = $client->request('POST', $url, $payload);
            if ($response->getStatusCode() == 200) {
                $request->session()->flash('alert-class', "alert-success");
                $request->session()->flash('message', "password Updated successfully");
            }
            return redirect()->route('setting');
        } catch (RequestException $e) {
            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }
            if ($e->hasResponse()) {
                $response = json_decode($e->getResponse()->getBody());
                $request->session()->flash('alert-class', 'alert-danger');
                $request->session()->flash('message', 'previous password  is incorrect');
            }
            return redirect()->route('setting');
        } catch (Exception $e) {
            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }
            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }
            Log::error('Catch error: settingsController - ' . $e->getMessage());
            return view('errors.500');
        }
    }
    
    public function update_store_assistant(Request $request){
        try{
            if ($request->all()) {
                $control = $request->input('control', '');
            if ($control == 'profile_update') {
    
                $url = env('API_URL', 'https://dev.api.customerpay.me') . '/assistant/update';
                $client = new Client();
                $data = [
                    "name" => $request->input('name'),
                    "email" => $request->input('email'),
                ];
                // make an api call to update the user_details
                $this->headers = ['headers' => ['x-access-token' => Cookie::get('api_token')], 'form_params' => $data];
                $response = $client->request('PUT', $url, $this->headers);
            } elseif ($control == 'password_change') {
                $request->validate([
                    'current_password' => 'required|min:6',
                    'new_password' => 'required|min:6|confirmed',
                ]);
                return $this->change_password($request);
            } elseif ($control == 'finance_update') {
                return $this->update_bank($request);
            } else {
                return view('errors.404');
            }
            if ($response->getStatusCode() == 201) {
                $request->session()->flash('alert-class', 'alert-success');
                if ($control != 'password_change') {
                    $user_detail_res = json_decode($response->getBody(), true);
                    $filtered_user_detail = $user_detail_res['data']['store_assistant'];
                    Cookie::queue('phone_number', $filtered_user_detail['phone_number']);
                    Cookie::queue('email', $filtered_user_detail['email']);
                    Cookie::queue('name', $filtered_user_detail['name']);
                    $request->session()->flash('message', "Profile details updated successfully");
                    return back();
                }
                return back();
            }
            else {
                return redirect()->route('setting');
            }
        }  
        }catch(RequestException $e){
            // check if token expired
            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }
            if ($e->hasResponse()) {
                $response = json_decode($e->getResponse()->getBody());
                $request->session()->flash('alert-class', 'alert-danger');
                $request->session()->flash('message', $response->message);
            }
            return redirect()->route('setting');
        }catch(\Exception $e){
            Log::error($e->getMessage());
            return view('errors.500');
        }
    }

    public function upload_image(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|mimes:jpeg,bmp,jpg,png|max:1000',
        ]);

        if ($request->hasFile('profile_picture') && $request->file('profile_picture')->isValid()){
            try {
                // code... 
                // upload url
                $upload_url = $this->host . '/update-image';

                // initate Guzzle client
                $client = new Client();

                // prepare payload for upload
                $upload_response = $client->request('PUT', $upload_url, [
                    'headers' => [
                        'x-access-token' => Cookie::get('api_token'),
                    ],
                    'multipart' => [
                        [
                            'name' => 'image',
                            'contents' => fopen($request->file('profile_picture')->path(), 'r'),
                        ],
                    ],
                ]);

                // get response status code
                $upload_status_code = $upload_response->getStatusCode();

                // on success
                if($upload_status_code == 200){
                    $upload_data = json_decode($upload_response->getBody());
                    
                    // get image path
                    $image_path =  $upload_data->data->image;
                    $image = explode('/', $image_path);

                    // this is so the path can be stored in cookie
                    $profile_picture = "";
                    for ($j = 3; $j <= 8; $j++){
                        $profile_picture .= $image[$j]. ' ';
                    }
                    
                    // update cookie value for profile picture and redirect to setting
                    Cookie::queue('profile_picture', $profile_picture);
                    Session::flash('alert-class', 'alert-success');
                    Session::flash('message', $upload_data->message);
                    return redirect()->back();
                }

            } catch (RequestException $e) {
                if ($e->getCode() == 401) {
                    Session::flash('message', 'session expired');
                    return redirect()->route('logout');
                }
                if ($e->hasResponse()) {
                    $response = json_decode($e->getResponse()->getBody());
                    $request->session()->flash('alert-class', 'alert-danger');
                    $request->session()->flash('message', $response->message);
                }
                return redirect()->route('setting');
            } catch (Exception $e) {
                if ($e->getCode() == 401) {
                    Session::flash('message', 'session expired');
                    return redirect()->route('logout');
                }
                Log::error('Catch error: settingsController - ' . $e->getMessage());
                return view('errors.500');
            }           
        }

    }
    public function update_bank(Request $request)
    {
        $url = env('API_URL', 'https://dev.api.customerpay.me') . '/bank-details';
        try {
            $client = new Client();

            $data = [
                "account_number" => $request->input('account_number'),
                "account_name" => $request->input('account_name'),
                "bank" => $request->input('bank'),
                "currencyPreference" => $request->input('currency'),
            ];

            $payload = ['headers' => ['x-access-token' => Cookie::get('api_token')], 'form_params' => $data];
            $response = $client->request('PUT', $url, $payload);
            if ($response->getStatusCode() == 200) {
                $result = json_decode($response->getBody())->data->user;
                $bank_details = $result->bank_details;
                Cookie::queue('account_name', $bank_details->account_name);
                Cookie::queue('account_number', $bank_details->account_number);
                Cookie::queue('account_bank', $bank_details->bank);
                Cookie::queue('currency', $result->currencyPreference);
                $request->session()->flash('alert-class', "alert-success");
                $request->session()->flash('message', "Finacial information updated successfully");
            }
            return redirect()->route('setting');
        } catch (RequestException $e) {
            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }
            if ($e->hasResponse()) {
                $response = json_decode($e->getResponse()->getBody());
                $request->session()->flash('alert-class', 'alert-danger');
                $request->session()->flash('message', $response->message);
            }
            return redirect()->route('setting');
        } catch (Exception $e) {
            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }
            Log::error('Catch error: settingsController - ' . $e->getMessage());
            return view('errors.500');
        }
    }

    public function verify_bank(Request $request)
    {
        $url = env('API_URL', 'https://dev.api.customerpay.me') . '/account/verify';
        try {
            $client = new Client();
            $headers = [
                'headers' => ['x-access-token' => Cookie::get('api_token')],
                'form_params' => $request->all(),
            ];
            $response = $client->request('POST', $url, $headers);
            $statusCode = $response->getStatusCode();

            if ($statusCode == 200) {
                $result = json_decode($response->getBody());
                if ($result->status == 'success') {
                    return response()->json([
                        'status'  => 'success',
                        'message' => 'verified successfully',
                        'data'    => $result->data,
                    ], 200);
                } else {
                    return response()->json([
                        'status'  => false,
                        'message' => $result->message,
                        'data'    => $result->data,
                    ], 201);
                }
            }
            return response()->json(['status' => false, 'message' => 'invalid account details'], 400);
        } catch (RequestException $e) {
            Log::info('Catch error: settingsController - ' . $e->getMessage());
            // token expired
            return response()->json(['status' => false, 'message' => 'invalid account details'], 400);
        } catch (Exception $e) {
            Log::error('Catch error: seetingsController - ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => 'internal error'], 400);
        }
    }
}
