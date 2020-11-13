<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    public function sendViaEmail(Request $request) {
        try {
            $request->validate([
                'subject' => 'required',
                'body' => 'required',
                'sender' => 'required',
                'recipient' =>  'required',
                'cc' => '',
                'bcc' => ''
            ]);

            $data = [
                'subject' => purify_input($request->input('subject')),
                'body' => purify_input($request->input('body')),
                'sender' => $request->input('sender'),
                'recipient' => $request->input('recipient'),
                'cc' => $request->input('cc'),
                'bcc' => $request->input('bcc')
            ];

			$client = new Client();
    		$url = 'https://email.microapi.dev/v1/sendmail/';
            $payload = [
                'headers' => ['x-access-token' => Cookie::get('api_token')],
                'form_params' => $data
            ];

            $send = $client->post($url, $payload);
            $statusCode = $send->getStatusCode();

        	if($statusCode == 200 || $statusCode == 201)
        	{
        	    $resp = [
        	    	'message' => 'Email sent successfully'
        	    ];
        	    return response()->json($resp);
        	}
        	else if($statusCode == 401)
        	{
        	    $resp = [
        	    	'message' => 'You are not authorized to use this feature, Login to continue'
        	    ];
        	    return response()->json($resp);
        	}
        	else if($statusCode == 500)
        	{
        	    $resp = [
        	    	'message' => 'A server error encountered, please try again later'
        	    ];
        	    return response()->json($resp);
        	}
        }
        catch(RequestException $e) {
        	$resp = [
    	    	'message' => 'A technical error occured, please try again later',
    	    	'error' => $e
    	    ];
    	    return response()->json($resp);
        }
    }
}
