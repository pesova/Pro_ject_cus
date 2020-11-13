@extends('backend.payment_details.layout.app')

@section('content')
<div class="">
    <div class="d-flex">
        <div class="ml-2">
        </div>
    </div>
    <form action="https://checkout.flutterwave.com/v3/hosted/pay" method="POST">

        <div class="p-5 shadow-lg rounded">
            <h5 class="py-3 text-center text-uppercase">Make a Payment</h5>
            <div class="form-group">
                <label for="phone_number">Phone number</label>
                <input type="tel" class="form-control" name="customer[phone_number]" id="phone_number"
                    placeholder="please enter your Phone number">
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text font-weight-bold">{{ Str::upper($currency) }}</span>
                    </div>
                    <input type="number" class="form-control" name="amount" id="amount" placeholder="Enter amount">
                </div>

            </div>
        </div>
        <div class="">
            @csrf
            <input type="hidden" name="public_key" value="{{ env('FLUTTERWARE_PUB') }}" />
            <input type="hidden" name="customer[email]" value="{{ env('APP_EMAIL') }}" />
            <input type="hidden" name="customer[phone_number]" />
            <input type="hidden" name="tx_ref" value="{{ $transactionID }}" />
            <input type="hidden" name="currency" class="text-uppercase" value="{{ Str::upper($currency) }}" />
            <input type="hidden" name="redirect_url" value="{{ url('/payment/callback') }}" />
            <input type="hidden" name="country" value="NG" />
            <input type="hidden" name="logo" value="{{ url('/').'/frontend/assets/images/payment/logo.svg' }}" />
            <button type="submit" class="my-3 btn btn-lg btn-primary w-100 text-white font-weight-bold">Pay Now</button>
            <a href="" class="my-3 btn btn-lg border border-primary w-100 text-primary font-weight-bold">Remind Me
                Later</a>
        </div>
    </form>

    <div class="text-center p-3">
        <img src="{{ asset('frontend/assets/images/payment/check-circle.svg')}}" alt="Verified" />
        <p class="text-primary py-2 lead">Verified by myCustomer</p>
        <img src="{{ asset('frontend/assets/images/payment/android-button.svg')}}" alt="Google Play" />
    </div>
</div>

@endsection