<?php

namespace App\Http\Controllers;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{
    protected $host;

    public function __construct()
    {
        $this->host = env('API_URL', 'https://dev.api.customerpay.me');
    }

    /** 
     * show payment page
     */
    public function index($currency, $tx_ref)
    {
        $transactionID = $tx_ref;
        $transactionURL = $this->host . '/transaction' . '/' . $transactionID;

        $client = new Client;
        try {

            $response = $client->get($transactionURL);

            if ($response->getStatusCode() == 200) {
                $transaction = json_decode($response->getBody())->data->transaction;
                return view('backend.payment_details.index', compact('transaction','currency'));
            }
        } catch (RequestException $e) {
            if ($e->getCode() == 404) {
                return view('backend.payment_details.form',compact('transactionID', 'currency'));
            }
            Log::info('Catch error: PaymentController - ' . $e->getMessage());
        }

        Session::flash('alert-class', 'alert-danger');
        Session::flash('message', 'Invalid Transaction Ref Code');
        return view('backend.payment_details.error');
    }

    /** 
     * show payment form
     */
    public function callback()
    {
        $data = request()->all();

        $status = $data['status'];
        $tx_ref = $data['tx_ref'];

        if (isset($data['transaction_id'])) {
            $transaction_id = $data['transaction_id'];
        } else {
            $transaction_id = $tx_ref;
        }

        try {
            if ($status == 'successful') {

                $client = new Client;

                $tranx_verification = $this->host . '/payment/new' . '/' . $transaction_id;

                $tranx_verification_response = $client->request("POST", $tranx_verification);
                $statusCode = $tranx_verification_response->getStatusCode();

                if ($statusCode == 200) {
                    return view('backend.payment_details.success');
                }
            } else {
                Session::flash('alert-class', 'alert-danger');
                Session::flash('message', $status);
                return view('backend.payment_details.error');
            }
        } catch (RequestException $e) {
            Session::flash('alert-class', 'alert-danger');

            if ($e->hasResponse()) {
                $message = json_decode($e->getResponse()->getBody())->message;
                Session::flash('message', $message);
                return view('backend.payment_details.error');
            }
            Log::info('Catch error: PaymentController - ' . $e->getMessage());
            Session::flash('message', 'OOPS something went wrong');
            return view('backend.payment_details.error');
        } catch (Exception $e) {
            Log::error('Catch error: PaymentController - ' . $e->getMessage());
            Session::flash('alert-class', 'alert-danger');
            Session::flash('message', 'OOPS something went wrong');
            return view('backend.payment_details.error');
        }
    }
}
