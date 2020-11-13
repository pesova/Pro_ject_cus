@extends('backend.payment_details.layout.app')

@section('content')
<div class="text-center py-5">

    {{-- <img src="{{ asset('frontend/assets/images/payment/cancel.svg')}}" alt="Verified" /> --}}
    <img src="{{ asset('frontend/assets/images/payment/success.svg')}}" alt="Verified" />

    <h1 class="display-3">Thank You!</h1>
    <p class="lead">You'll get a confirmation message shortly.</p>

    @isset($tranx_message)
        {{ $tranx_message }}
    @endisset

    <hr>
    <div class="text-center p-3">
        <p class="text-primary py-2 lead">Verified by myCustomer</p>
        <img src="{{ asset('frontend/assets/images/payment/android-button.svg')}}" alt="Google Play" />
    </div>
    <p>
        Having trouble? <a href="{{ route('contact') }}">Contact us</a>
    </p>
</div>

@endsection
