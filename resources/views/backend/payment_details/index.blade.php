@extends('backend.payment_details.layout.app')

@section('content')
<div class="">
    <div class="d-flex">
        <h4>From:</h4>
        <div class="ml-2">
            <h5 class="text-primary">{{ $transaction->store_ref->store_name }}</h5>
            <h5 class="text-grey">{{ $transaction->store_ref->phone_number }}</h5>
        </div>
    </div>

    {{-- <div class="text-center py-3">
        <h5 class="lead">Mollit exercitation consectetur dolor occaecat sit elit fugiat ullamco duis non magna cupidatat.</h5>
    </div> --}}

    <div class="p-5 text-center shadow-lg rounded">
        <h5 class="py-3 text-uppercase">Payment Reminder</h5>
        <h5 class="py-3 text-danger">NGN
            {{ (($transaction->interest / 100) * $transaction->amount) + $transaction->amount }}</h5>
        <p class="lead">{{ $transaction->description }}</p>
    </div>
    <div class="">
        <form action="https://checkout.flutterwave.com/v3/hosted/pay" method="POST">
            @csrf
            <input type="hidden" name="public_key" value="{{ env('FLUTTERWARE_PUB') }}" />
            <input type="hidden" name="customer[email]" value="{{ $transaction->store_ref->email }}" />
            <input type="hidden" name="customer[phone_number]" value="{{ $transaction->customer_ref->phone_number }}" />
            <input type="hidden" name="customer[name]" value="{{ $transaction->customer_ref->name }}" />
            <input type="hidden" name="tx_ref" value="{{ $transaction->_id }}" />
            <input type="hidden" name="amount"
                value="{{ (($transaction->interest / 100) * $transaction->amount) + $transaction->amount }}" />
            <input type="hidden" name="currency" class="text-uppercase" value="{{ strtoupper($transaction->currency) }}" />
            <input type="hidden" name="store_name" class="text-uppercase"
                value="{{ $transaction->store_ref->store_name}}" />
            <input type="hidden" name="meta[token]" value="54" />
            <input type="hidden" name="redirect_url" value="{{ url('/payment/callback') }}" />
            <input type="hidden" name="title" value="{{ $transaction->type }}" />
            <input type="hidden" name="country" value="NG" />
            <input type="hidden" name="logo" value="{{ url('/').'/frontend/assets/images/payment/logo.svg' }}" />

            <button type="submit" class="my-3 btn btn-lg btn-primary w-100 text-white font-weight-bold">Pay Now</button>
        </form>

        <a href="" class="my-3 btn btn-lg border border-primary w-100 text-primary font-weight-bold">Remind Me Later</a>
    </div>

    <div class="text-center p-3">
        <img src="{{ asset('frontend/assets/images/payment/check-circle.svg')}}" alt="Verified" />
        <p class="text-primary py-2 lead">Verified by myCustomer</p>
        <img src="{{ asset('frontend/assets/images/payment/android-button.svg')}}" alt="Google Play" />
    </div>
</div>

@endsection