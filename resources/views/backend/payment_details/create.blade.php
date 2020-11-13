@extends('backend.payment_details.layout.app')

@section('content')
<div>
    <h4 class="font-weight-bold text-center">Payment</h4>

    <div class="py-3">
        <div class="lead d-flex justify-content-between align-items-center">
            <span>Total</span>
            <span>$6,700</span>
        </div>
        <div class="row p-2 text-center">
            <a href="" aria-disabled="true" disabled class="col w-1/2 rounded-left py-3 bg-primary text-white">
                <img src="{{ asset('frontend/assets/images/payment/vector.svg')}}" alt="" class="inline"> Pay with
                Card</a>
            <a href="" class="col w-1/2 rounded-right py-3 btn-light text-dark">Pay with Transfer</a>
        </div>
    </div>

    <form action="{{ route('pay') }}" class="parsley-examples" method="POST">
        @csrf
        <div class="form-group mb-2">
            <label for="card_number" class="m-0 px-2">Card Number<span class="text-danger">*</span></label>
            <input type="number" name="card_number" parsley-trigger="change" required placeholder="0000 0000 0000 0000"
                class="form-control form-control-lg" id="card_number">
        </div>
        <div class="form-group mb-2">
            <label for="card_holder_name" class="m-0 px-2">Card Holder's Name<span class="text-danger">*</span></label>
            <input type="text" name="card_holder_name" parsley-trigger="change" required placeholder=""
                class="form-control form-control-lg" id="card_holder_name">
        </div>
        <div class="row">
            <div class="col-8">
                <label for="card_expiry_month" class="m-0 px-2">Expiry Date<span class="text-danger">*</span></label>
                <div class="d-flex">
                    <div class="form-group">
                        <input id="card_expiry_month" type="number" data-parsley-maxlength="2" name="card_expiry_month" placeholder="MM"
                            required class="form-control form-control-lg">
                    </div>
                    <div class="form-group">
                        <input id="card_expiry_year" type="number" data-parsley-minlength="4" data-parsley-maxlength="4" name="card_expiry_year" placeholder="YYYY"
                            required class="form-control form-control-lg">
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="">
                    <div class="form-group">
                        <label for="card_cvv_number" class="m-0 px-2">CVV <span class="text-danger">*</span></label>
                        <input name="card_cvv_number" id="card_cvv_number" data-parsley-minlength="3" data-parsley-maxlength="3" type="password" required placeholder="cvv"
                            class="form-control form-control-lg" id="card_cvv_number">
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group mt-5 mb-0">
            <button class="btn btn-primary btn-lg w-100" type="submit">
                Pay $6,700
            </button>
        </div>

    </form>
</div>
@endsection
