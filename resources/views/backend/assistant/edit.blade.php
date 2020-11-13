@extends('layout.base')
@section("custom_css")

<link href="/backend/assets/build/css/intlTelInput.css" rel="stylesheet" type="text/css" />

@stop
@section('content')

<!-- Start Content-->
<div class="container-fluid h-100">
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <a href="/admin/assistants" class="btn btn-primary">Go Back</a>
            </nav>
            <h4 class="mb-1 mt-0"><i data-feather="users" style="font-size: 5px; margin-right: 7px"></i>Edit
                business assistant</h4>
        </div>
    </div>

    @include('partials.alert.message')

    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-lg-10 col-sm-12">
            <div class="card">
                <div class="card-body">
                    {{-- <h4 class="mb-3 header-title mt-0">Complaint Form</h4> --}}

                    <form action="{{ route('assistants.update', $response->_id) }}" method="POST" id="submitForm">
                        @csrf
                        @method('PUT')

                        <div class="form-group row mb-3">
                            <label for="name" class="col-md-2 col-sm-12 col-form-label my-label">Name:</label> <br>
                            <br>
                            <div class="col-md-10 col-sm-12">
                                <input name="name" type="text" class="form-control" id="name"
                                    placeholder="Enter name here" value="{{  old('name', $response->name) }}">
                            </div>
                        </div>
                        <br>
                        <!-- <div class="form-group row mb-3">
                                <label for="name" class="col-2 col-sm-3 col-form-label my-label">Store Name:</label> <br> <br>
                                <div class="col-10 col-sm-7">
                                    <input name="store_name" type="text" class="form-control" id="fullname" placeholder="Enter store name here">
                                </div>
                            </div> -->
                        {{-- <div class="form-group row mb-3">
                                <label for="role" class="col-2 col-sm-3 col-form-label my-label">Role:</label> <br>
                                <div class="col-10 col-sm-7">
                                    <input type="text" class="form-control" id="fullname" placeholder="Enter role">
                                </div>
                            </div>
                            <br>   --}}
                        <div class="form-group row mb-3">
                            <label for="address" class="col-md-2 col-sm-12 col-form-label my-label">Email:</label>
                            <br>
                            <div class="col-md-10 col-sm-12">
                                <input name="email" type="email" class="form-control" id="fullname"
                                    placeholder="Enter Address" value="{{ old('email', $response->email) }}">
                            </div>
                        </div>
                        <br>
                        <div class="form-group row mb-3">
                            <label for="number" class="col-md-2 col-sm-12 col-form-label my-label">Phone
                                Number:</label>
                            <br>
                            <div class="col-md-10 col-sm-12">
                                <input type="tel" id="phone" name="" class="form-control"
                                    value="{{ old('phone_number',$response->phone_number) }}" required>
                                <input type="hidden" name="phone_number" id="phone_number" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row mb-3">
                            <label for="number" class="col-md-2 col-sm-12 col-form-label my-label">Business:</label>
                            <br>
                            <div class="col-md-10 col-sm-12">
                                <select name="store_id" id="store_id" class="form-control">
                                    <option value=""> Select Business</option>
                                    @foreach($stores as $store)
                                    @if(is_array($store))
                                    <option value="{{$store[0]->_id}}"
                                        {{$store[0]->_id == $response->store_id? "selected":""}}>
                                        {{$store[0]->store_name}}</option>
                                    @else
                                    <option value="{{$store->_id}}"
                                        {{$store->_id ==$response->store_id? "selected":""}}>{{$store->store_name}}
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{--<br>
                            <div class="form-group row mb-3">
                                <label for="email" class="col-2 col-sm-3 col-form-label my-label">Password:</label> <br>
                                <div class="col-10 col-sm-7">
                                    <input name="password" type="password" class="form-control" id="fullname"
                                           placeholder="Enter password">
                                </div>
                            </div>
                            <br>--}}
                        <div class="form-group mb-0 justify-content-end row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary my-button">Save</button>
                            </div>
                        </div>
                    </form>

                </div> <!-- end card-body -->
            </div>
        </div>
        <!-- end col -->
    </div> <!-- container-fluid -->

    @endsection
    @section('javascript')
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

        test.setNumber("+" + ($("#phone").val()));

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
