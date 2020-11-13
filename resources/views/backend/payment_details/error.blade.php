@extends('backend.payment_details.layout.app')

@section('content')
<div class="text-center py-5">
    @include('partials.alert.message')

    <img src="{{ asset('frontend/assets/images/payment/cancel.svg')}}" alt="Verified" />

    <h1 class="">Something Went Wrong!</h1>
    <p class="lead">Please try again after a while.</p>
    <p>
        Having trouble? <a href="{{ route('contact') }}">Contact us</a>
    </p>
    <hr>
    <div class="text-center p-3">
        <p class="text-primary py-2 lead">Verified by myCustomer</p>
        <img src="{{ asset('frontend/assets/images/payment/android-button.svg')}}" alt="Google Play" />
    </div>
</div>

@endsection
