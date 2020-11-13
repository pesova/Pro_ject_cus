<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use stdClass;

class ComplaintController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $url = env('API_URL', 'https://dev.api.customerpay.me') . "/complaints";
        $url_s = env('API_URL', 'https://dev.api.customerpay.me') . "/complaints/all";
        $user_role = Cookie::get('user_role');

        try {
            $client = new Client();

            $headers = [
                'headers' => [
                    'x-access-token' => Cookie::get('api_token')
                ]
            ];
            if ($user_role == 'super_admin') {
                $response = $client->request('GET', $url_s, $headers);
            } else {
                $response = $client->request('GET', $url, $headers);
            }

            $statusCode = $response->getStatusCode();

            if ($statusCode == 200) {

                $body = $response->getBody()->getContents();
                $complaints = json_decode($body);
                return view('backend.complaints.index')->with('responses', $complaints);
            } elseif ($statusCode == 401) {

                return redirect()
                    ->route('login')
                    ->with('message', "Please Login Again");
            }
        } catch (RequestException $e) {
            // token expired
            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }

            // get response to catch 4 errors
            if ($e->hasResponse()) {
                $response = $e->getResponse()->getBody();
                $result = json_decode($response);
                Session::flash('message', isset($result->message) ? $result->message : $result->Message);
            }

            $complaints = new stdClass;
            $complaints->complaintCounts = new stdClass;
            if (is_super_admin()) {
                $complaints->data = [];
            } else {
                $complaints->data = new stdClass;
                $complaints->data->complaints = [];
            }
            $complaints->complaintCounts->resolved = 0;
            $complaints->complaintCounts->pending = 0;
            return view('backend.complaints.index')->with('responses', $complaints);
        } catch (Exception $e) {
            // token expired
            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }

            Log::error('Catch error: ComplaintController - ' . $e->getMessage());
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
        return view('backend.complaints.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|max:150|min:5',
            'message' => 'required|max:500|min:10'
        ]);

        $url = env('API_URL', 'https://dev.api.customerpay.me') . "/complaint/new";

        try {
            $client = new Client();
            $firstname = Cookie::get('first_name');
            $lastname = Cookie::get('last_name');
            $email = Cookie::get('email');
            $payload = [
                'headers' => [
                    'x-access-token' => Cookie::get('api_token')
                ],
                "form_params" => [
                    "message" => purify_input($request->input('message')),
                    "subject" => purify_input($request->input('subject')),
                    "name" => $firstname . " " . $lastname,
                    "email" => $email
                ]
            ];

            $req = $client->request('POST', $url, $payload);
            $statusCode = $req->getStatusCode();
            $response = json_decode($req->getBody()->getContents());

            if ($statusCode == 200) {

                $request->session()->flash('success', $response->message);

                return redirect()->route('complaint.index');
            } else {

                $message = isset($response->Message) ? $response->Message : $response->message;
                $request->session()->flash('message', $message);
                return back();
            }
        } catch (RequestException $e) {
            //log error;
            Log::info('Catch error: ComplaintController - ' . $e->getMessage());

            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }

            if ($e->hasResponse()) {
                $response = json_decode($e->getResponse()->getBody());
                $request->session()->flash('error', "Make sure all fields are filled .\n Make sure the description is more than 10 characters");
            }
            // check for 500 server error
            return back();
        } catch (Exception $e) {
            //log error;
            Log::error('Catch error: ComplaintController - ' . $e->getMessage());
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
        $url = env('API_URL', 'https://dev.api.customerpay.me') . "/complaint/" . $id;

        try {

            $client = new Client();

            $headers = [
                'headers' => [
                    'x-access-token' => Cookie::get('api_token')
                ]
            ];

            $response = $client->request('GET', $url, $headers);
            $statusCode = $response->getStatusCode();
            if ($statusCode == 200) {

                $body = $response->getBody()->getContents();
                $complaints = json_decode($body);

                return view('backend.complaints.show')->with('response', $complaints);
            }
        } catch (RequestException $e) {
            //log error;
            Log::info('Catch error: ComplaintController - ' . $e->getMessage());

            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }

            if ($e->hasResponse()) {
                // get response to catch 4xx errors
                $response = json_decode($e->getResponse()->getBody());
                Session::flash('error', isset($response->message) ? $response->message : $response->Message);
            }
            return back();
        } catch (Exception $e) {
            // token expired
            if ($e->getCode() == 401) {
                Session::flash('message', 'session expired');
                return redirect()->route('logout');
            }
            Log::error('Catch error: ComplaintController - ' . $e->getMessage());
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
        $url = env('API_URL', 'https://dev.api.customerpay.me') . "/complaint/" . $id;
        $user_id = Cookie::get('user_id');

        try {

            if (Cookie::get('user_role') == "super_admin") {

                $client = new Client();

                $headers = [
                    'headers' => [
                        'x-access-token' => Cookie::get('api_token')
                    ]
                ];

                $response = $client->request('GET', $url, $headers);
                $statusCode = $response->getStatusCode();
                if ($statusCode == 200) {

                    $body = $response->getBody()->getContents();
                    $complaints = json_decode($body);
                    return view('backend.complaints.status')->with('response', $complaints);
                }
                if ($statusCode == 500) {

                    return view('errors.500');
                }
            } else {

                Session::flash('error', 'You do not have access to do this');
                return back();
            }
        } catch (Exception $e) {
            Log::error('Catch error: ComplaintController - ' . $e->getMessage());
            return view('errors.500');
        }
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
        $url = env('API_URL', 'https://dev.api.customerpay.me') . "/complaint/update/" . $id;
        $request->validate([
            'status' => 'required',
        ]);

        try {
            $client = new Client();
            $payload = [
                'headers' => [
                    'x-access-token' => Cookie::get('api_token')
                ],
                "form_params" => [
                    "status" => $request->input('status')
                ]
            ];

            $req = $client->request('PUT', $url, $payload);
            $statusCode = $req->getStatusCode();

            if ($statusCode == 200) {
                Session::flash('alert-class', 'alert-success');
                Session::flash('message', "Update Successful");
                return redirect()->route('complaint.index');
            }
            return view('backend.complaintlog.update')->with('error', "Complaint not found");
        } catch (Exception $e) {
            if ($e->getCode() == 401) {
                return redirect()->route('logout');
            }

            Log::error('Catch error: ComplaintController - ' . $e->getMessage());
            return back()->withErrors(['Opps something went wrong. Please try again later']);/// view('errors.500');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $url = env('API_URL', 'https://dev.api.customerpay.me') . "/complaint/delete/" . $id;
        $headers = [
            'headers' => [
                'x-access-token' => Cookie::get('api_token')
            ]
        ];

        try {

            $client = new Client();
            $request = $client->delete($url, $headers);
            $statusCode = $request->getStatusCode();

            if ($statusCode == 200) {
                Session::flash('alert-class', 'alert-success');
                Session::flash('message', "Complaint Deleted Successfully");
                return redirect()->route('complaint.index');
            }
        } catch (RequestException $e) {
            //log error;
            Log::error('Catch error: ComplaintController - ' . $e->getMessage());

            if ($e->getCode() == 401) {
                return redirect()->route('logout');
            }

            if ($e->hasResponse()) {
                $response = json_decode($e->getResponse()->getBody());
                Session::flash('error', isset($response->message) ? $response->message : $response->Message);
            }
            return back();
        } catch (Exception $e) {

            if ($e->getCode() == 401) {
                return redirect()->route('logout');
            }

            Log::error('Catch error: ComplaintController - ' . $e->getMessage());
            return view('errors.500');
        }
    }

    public function get_messages(Request $request, $id)
    {
        if (!$request->ajax()) {
            return view('errors.404');
        }

        $url = env('API_URL', 'https://dev.api.customerpay.me') . "/complaint/feedbacks/" . $id;
        try {
            $client = new Client();
            $payload = ['headers' => ['x-access-token' => api_token()]];

            $response = $client->get($url, $payload);

            if ($response->getStatusCode() == 200) {
                $messages = json_decode($response->getBody())->data;
                return response()->json([
                    'status' => 'success',
                    'data'   => $messages,
                ], 200);
            }

            return response()->json(['status' => 'failed'], 201);
        } catch (RequestException $e) {
            Log::error('Catch error: ComplaintController - ' . $e->getMessage());
            return response()->json(['status' => 'failed'], 400);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed'], 500);
        }
    }

    public function post_message(Request $request, $id)
    {
        if (!$request->ajax()) {
            return view('errors.404');
        }

        $request->validate([
            'message' => ['required'],
        ]);

        $url = env('API_URL', 'https://dev.api.customerpay.me') . "/complaint/feedback/" . $id;
        $message = purify_input($request->input('message'));
        try {
            $client = new Client();
            $payload = [
                'headers' => ['x-access-token' => api_token()],
                "form_params" => ["messages" => $message]
            ];

            $response = $client->request('POST', $url, $payload);

            if ($response->getStatusCode() == 200) {
                return response()->json(['status' => 'success'], 200);
            }

            return response()->json(['status' => 'failed'], 201);
        } catch (RequestException $e) {
            Log::error('Catch error: ComplaintController - ' . $e->getMessage());
            return response()->json(['status' => 'failed'], 400);
        } catch (Exception $e) {
            return response()->json(['status' => 'failed'], 500);
        }
    }
}
