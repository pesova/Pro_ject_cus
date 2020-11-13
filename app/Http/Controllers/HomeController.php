<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\contactMail;
use Exception;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function home()
    {
        return view('home');
    }

    public function about()
    {
        return view('about');
    }

    public function faq()
    {
        return view('faq');
    }

    public function contact(Request $request)
    {
        if (!$request->isMethod('POST')) {
            return view('contact');
        }

        $this->validateForm($request);

        $data = purify_input($request->only(['name', 'email', 'message']));
        $details = [
            'title' => 'Customerpay.me Contact Form',
            'name' => $data['name'],
            'email' => $data['email'],
            'message' => $data['message'],
        ];

        $to = env('MAIL_TO_ADDRESS','hello@customerpay.me');
        try {
            Mail::to($to)->send(new contactMail($details));
            Session::flash('alert-class', 'success');
            Session::flash('message', 'message sent successfully, we will get in touch soon');
        } catch (Exception $e) {
            Session::flash('alert-class', 'danger');
            Session::flash('message', 'Something went wrong, try again');
        }
        return view('contact');

    }

    public function privacy()
    {
        return view('privacy');
    }

    public function blog()
    {
        return view('blog');
    }

    public function validateForm(Request $request)
    {

        $rules = [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'message' => ['required', 'string'],
            'g-recaptcha-response' => ['required','captcha'],
        ];

        $messages = [
            'name' => 'Please enter your Full Name',
            'message' => 'Please enter your message',
            'email.*' => 'Please enter a valid email address',
            'g-recaptcha-response.required' => 'Please verify that you are not a robot.',
            'g-recaptcha-response.captcha' => 'reCaptcha error! try again later or contact site admin.',
        ];

        return $this->validate($request, $rules, $messages);
    }
}
