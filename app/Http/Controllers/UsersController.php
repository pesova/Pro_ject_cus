<?php

namespace App\Http\Controllers;

use App\Rules\DoNotAddIndianCountryCode;
use App\Rules\DoNotPutCountryCode;
use Exception;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        try {

            $url = env('API_URL', 'https://dev.api.customerpay.me') . '/users/all';
            $client = new Client();
            $headers = ['headers' => ['x-access-token' => Cookie::get('api_token')]];
            $user_response = $client->request('GET', $url, $headers);

            if ($user_response->getStatusCode() == 200) {
                $users_data = json_decode($user_response->getBody());
                $users_data = $users_data->data;

                $perPage = 12;
                $page = $request->get('page', 1);
                if ($page > count($users_data) or $page < 1) {
                    $page = 1;
                }
                $offset = ($page * $perPage) - $perPage;
                $articles = array_slice($users_data, $offset, $perPage);
                $users = new Paginator($articles, count($users_data), $perPage);
                return view('backend.user.index')->with('users', $users->withPath('/' . $request->path()));
            }
            if ($user_response->getStatusCode() == 500) {
                return view('errors.500');
            }
        } catch (RequestException $e) {
            //log error;
            Log::info('Catch error: UserController - ' . $e->getMessage());

            if ($e->getCode() == 401) {
                return redirect()->route('logout');
            }
            // get response to catch 4 errors
            if ($e->hasResponse()) {
                $response = $e->getResponse()->getBody();
                $result = json_decode($response);
                Session::flash('message', $result->message);
                return view('backend.user.index')->with('users', []);
            }
            return view('errors.500');
        } catch (Exception $e) {
            //log error;
            if ($e->getCode() == 401) {
                return redirect()->route('logout');
            }
            Log::error('Catch error: UserController - ' . $e->getMessage());
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $url = env('API_URL', 'https://dev.api.customerpay.me') . '/register/user';
        $request->validate([
            'phone_number' => ['required', 'min:6', 'max:16', new DoNotAddIndianCountryCode, new DoNotPutCountryCode],
            'password' => ['required', 'min:6', 'confirmed']
        ]);

        try {
            $client = new Client();
            $payload = [
                'headers' => ['x-access-token' => Cookie::get('api_token')],
                'form_params' => [
                    'phone_number' => $request->input('phone_number'),
                    'password' => $request->input('password'),
                ],
            ];
            $response = $client->post($url, $payload);

            $statusCode = $response->getStatusCode();
            $data = json_decode($response->getBody());

            if ($statusCode == 201 && $data->success) {
                $request->session()->flash('alert-class', 'alert-success');
                Session::flash('message', $data->message);
                return back();
            } else {
                $request->session()->flash('alert-class', 'alert-waring');
                Session::flash('message', $data->message);
                return back();
            }
        } catch (RequestException $e) {
            Log::info('RequestException error: userController - ' . $e->getMessage());

            // token expired
            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }

            // get response to catch 4 errors
            if ($e->hasResponse()) {
                $response = $e->getResponse()->getBody();
                $result = json_decode($response);
                $message = isset($result->message) ? $result->message : (isset($result->Message) ? $result->Message : $result->error->error);
                Session::flash('message', $message);
            }
            return back();
        } catch (Exception $e) {
            // token expired
            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }
            Log::error('Catch error: userController - ' . $e->getMessage());
            return view('errors.500');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $url = env('API_URL', 'https://dev.api.customerpay.me') . '/store_admin/' . $id;


        try {
            $client = new Client;
            $payload = [
                'headers' => [
                    'x-access-token' => Cookie::get('api_token')
                ]
            ];

            $response = $client->request('GET', $url, $payload);


            if ($response->getStatusCode() == 200) {
                $data = json_decode($response->getBody());
                $data = $data->data;
                $data->_id = $data->user->_id;

                //dd($data);
                $thisMonth = $data->amountForCurrentMonth;
                $lastMonth = $data->amountForPreviousMonth;
                $diff = $thisMonth - $lastMonth;
                // (Current period's revenue - prior period's revenue) ÷ by prior period's revenue x 100
                $profit = ($thisMonth > $lastMonth) ? true : false;
                $percentage = ($lastMonth == 0) ? '-' : sprintf("%.2f", ($diff / $lastMonth) * 100);

                return view('backend.user.show')->withData($data)->withProfit(['profit' => $profit, 'percentage' => $percentage]);
            }
        } catch (RequestException $e) {
            Log::info('Catch error: DashboardController - ' . $e->getMessage());
            // check for 5xx server error
            if ($e->getResponse()->getStatusCode() >= 500) {
                return view('errors.500');
            } else {
                return redirect()->route('logout');
            }
        } catch (\Exception $e) {
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // return view('backend.dashboard.index');
        $host = env('API_URL', 'https://dev.api.customerpay.me');
        $url = $host . "/user/delete/$id";
        // return $url;
        try {
            $client = new Client();
            $headers = ['headers' => ['x-access-token' => Cookie::get('api_token')]];
            $response = $client->request('GET', $url, $headers);
            $statusCode = $response->getStatusCode();
            if ($statusCode == 200) {
                $body = $response->getBody()->getContents();
                $users = json_decode($body);
                return view('backend.dashboard.index')->with('response', $users);
            }
            if ($statusCode == 500) {
                return view('errors.500');
            }
            if ($statusCode == 401) {
                return view('backend.dashboard.index')->with('error', "Unauthoized toke");
            }
            if ($statusCode == 404) {
                return view('backend.dashboard.index')->with('error', "User not found");
            }
        } catch (\Exception $e) {
            // return view('errors.500');
            return view('backend.dashboard.index')->with('error', "Unable to connect to server");
        }
    }

    public function deactivate(Request $request, $phone)
    {
        $url = env('API_URL', 'https://dev.api.customerpay.me') . '/store-admin/deactivate/' . $phone;


        try {
            $client = new Client;
            $payload = [
                'headers' => [
                    'x-access-token' => Cookie::get('api_token')
                ]
            ];

            $response = $client->request('PATCH', $url, $payload);


            if ($response->getStatusCode() == 200) {
                $request->session()->flash('alert-class', 'alert-success');
                Session::flash('message', 'User deactivated');
                return back();
            }
        } catch (\Exception $e) {
            if ($e->getCode() == 401) {
                return redirect()->route('logout');
            }
            Log::error('Catch error: StoreController - ' . $e->getMessage());
            return view('errors.500');
        }
    }

    public function activate(Request $request, $phone)
    {
        $url = env('API_URL', 'https://dev.api.customerpay.me') . '/store-admin/activate/' . $phone;


        try {
            $client = new Client;
            $payload = [
                'headers' => [
                    'x-access-token' => Cookie::get('api_token')
                ]
            ];

            $response = $client->request('PATCH', $url, $payload);


            if ($response->getStatusCode() == 200) {
                $request->session()->flash('alert-class', 'alert-success');
                Session::flash('message', 'User activated');
                return back();
            }
        } catch (\Exception $e) {
            dd($e);
            if ($e->getCode() == 401) {
                return redirect()->route('logout');
            }
            Log::error('Catch error: StoreController - ' . $e->getMessage());
            return view('errors.500');
        }
    }
}
