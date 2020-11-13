<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReceiptMail;
use PDF;

use SnappyImage;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class ReceiptController extends Controller
{
    //

    public function preview(Request $request,$id){
       
        try{
            $transaction_details =[
                'customer_name' => $request->input('customer_name'),
                'customer_email' => $request->input('customer_email'),
                'transaction_amount' => $request->input('transaction_amount'),
                'transaction_date' => $request->input('transaction_date'),
                'transaction_description' => $request->input('transaction_description'),
                'transaction_id' => $id
            ];

            if($request->input('type') == 'default'){
                $image = SnappyImage::loadView('backend.transaction.receipt',[
                    "transaction" =>$transaction_details
                ] );  
                return $image->inline('transaction_receipt.jpg');
            }

            if($request->input('type') == 'download'){
                $pdf = PDF::loadView('backend.transaction.receipt',[
                    "transaction" =>$transaction_details
                ]);  
                return $pdf->download('transaction_receipt.pdf');
            }
            
           
        }catch(Exception $e){
            $request->session()->flash('alert-class', 'alert-danger');
            $request->session()->flash('message', 'Oops! something went wrong, Try Again');
            return back();
        }
        
    }

    public function send(Request $request,$id){

    try{
        $transaction_details =[
            'customer_name' => $request->input('customer_name'),
            'email' => $request->input('customer_email'),
            'transaction_amount' => $request->input('transaction_amount'),
            'transaction_date' => $request->input('transaction_date'),
            'transaction_description' => $request->input('transaction_description'),
            'transaction_id' => $id
        ];
        if($transaction_details['email'] == '' || $transaction_details['email'] == 'Not Set'){
            $request->session()->flash('alert-class', 'alert-danger');
            $request->session()->flash('message', 'Sorry can not send receipt to customer without a valid email');
            return back();
        }
        $data = [
            'name' => $request->input('customer_name'),
            'store_name' => Cookie::get('store_name')
        ];
        $pdf = PDF::loadView('backend.transaction.receipt',[
            "transaction" =>$transaction_details
        ]);
        $pdf_data = $pdf->output();
        Mail::to($transaction_details['email'])->send(new ReceiptMail($pdf_data,$data));
        $request->session()->flash('alert-class', 'alert-success');
        $request->session()->flash('message', 'sent to customer mail');
        return back();
    }catch(Exception $e){
        $request->session()->flash('alert-class', 'alert-danger');
        $request->session()->flash('message', 'Oops! something went wrong, Try Again');
        return back();
    }
    }
    
}
