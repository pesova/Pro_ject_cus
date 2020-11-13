@extends('layout.sbase')
@section("custom_css")
    <link href="/backend/assets/build/css/intlTelInput.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
    <link rel="stylesheet" href="{{asset('backend/assets/css/store_list.css')}}">
@stop
@section('content')
    <div class="content">
        <!-- Start Content-->
        <div class="container">
            <div class="row">
                <div class="col-md-6 mr-auto ml-auto">
                    <div class="row page-title">
                        <div class="col-md-12 text-center">
                            <h4 class="mt-2">Create A Business</h4>
                        </div>
                    </div>
                    <div class="row">

                        @include('partials.alert.message')
                        <div class="card">
                            <div class="card-body">
                                <form id="submitForm" action="{{ route('store.store') }}" method="POST">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="store name">Business Name*</label>
                                            <input type="text" name="store_name" class="form-control"
                                                   value="{{ old('store_name') }}" placeholder="XYZ Stores" required
                                                   minlength="3"
                                                   maxlength="16">

                                            {{--determines if a newly registered user is submitting the form--}}
                                            <input type="hidden" name="first_user" value="1">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="inputTagline">Tagline*</label>
                                            <input type="text" name="tagline" class="form-control" id="inputTagline"
                                                   value="{{ old('tagline') }}" required minlength="4" maxlength="50">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-12">
                                            <label for="inputPhoneNumber">Phone Number*</label>
                                            <input type="tel" class="form-control" id="phone" placeholder="8127737643"
                                                   aria-describedby="helpPhone" name=""
                                                   value="{{ old('phone_number') }}"
                                                   required
                                                   pattern=".{6,16}"
                                                   title="Phone number must be between 6 to 16 characters">
                                            <input type="hidden" name="phone_number" id="phone_number"
                                                   class="form-control">
                                            <small id="helpPhone" class="form-text text-muted">Enter your number without
                                                country
                                                code
                                            </small>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="inputEmailAddress"> Email Address*</label>
                                            <input type="email" name="email" class="form-control" required
                                                   value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputAddress">Address*</label>
                                        <input type="text" name="shop_address" class="form-control"
                                               value="{{ old('shop_address') }}" required minlength="5" maxlength="50">
                                    </div>
                                    <button type="submit" class="btn btn-success text-white btn-block">
                                        Create Business
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section("javascript")
    <script src="/backend/assets/build/js/intlTelInput.js"></script>
    <script>
        var input = document.querySelector("#phone");
        var test = window.intlTelInput(input, {
            separateDialCode: true,
            initialCountry: "auto",
            geoIpLookup: function (success) {
                // Get your api-key at https://ipdata.co/
                fetch("https://ipinfo.io?token={{env('GEOLOCATION_API_KEY')}}")
                    .then(function (response) {
                        if (!response.ok) return success("");
                        return response.json();
                    })
                    .then(function (ipdata) {
                        success(ipdata.country);
                    }).catch(function () {
                    success("NG");
                });
            },
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.min.js",
        });

        $("#phone").keyup(() => {
            if ($("#phone").val().charAt(0) == 0) {
                $("#phone").val($("#phone").val().substring(1));
            }
        });

        $("#submitForm").submit((e) => {
            e.preventDefault();
            const dialCode = test.getSelectedCountryData().dialCode;
            if ($("#phone").val().charAt(0) == 0) {
                $("#phone").val($("#phone").val().substring(1));
            }
            $("#phone_number").val(dialCode + $("#phone").val());
            $("#submitForm").off('submit').submit();
        });

    </script>
@stop
