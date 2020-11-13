@extends('layout.base')

@section("custom_css")
    <link href="/backend/assets/build/css/intlTelInput.css" rel="stylesheet" type="text/css"/>

    <style>
        /*
    *
    * ==========================================
    * CUSTOM UTIL CLASSES
    * ==========================================
    *
    */
        #upload {
            opacity: 0;
        }

        #upload-label {
            position: absolute;
            top: 50%;
            left: 1rem;
            transform: translateY(-50%);
        }

        .image-area {
            border: 2px dashed rgba(0, 0, 0, 0.7);
            padding: 1rem;
            position: relative;
        }

        .image-area::before {
            content: 'Uploaded image result';
            color: #fff;
            font-weight: bold;
            text-transform: uppercase;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 0.8rem;
            z-index: 1;
        }

        .image-area img {
            z-index: 2;
            position: relative;
        }

        .line-head {
            border-bottom: solid 1px #dddddd;
            margin-top: 0 !important;
            margin-bottom: 15px;
        }

        .screen:not(.active) {
            visibility: hidden !important;
            opacity: 0;
            width: 0;
            padding: 0;
            height: 0;
            overflow: hidden;
            transition: opacity .3s ease-in-out;
        }

        .screen.active {
            opacity: 1;
            transition: opacity .3s ease-in-out;
        }

        .profile-form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

    </style>

@stop

@section('content')

    <div class="account-pages my-5">
        <div class="container-fluid">
            @include('partials.alert.message')

            <div class="row-justify-content-center">
                <div>
                    <h4 class=""><i data-feather="user" class="icon-dual"></i> Edit Profile</h4>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card p-3">
                            <h4 class="line-head h5 pb-2"></h4>
                            <div class="profile-content">
                                <div class="row">
                                    <div class="col-12">
                                        <ul class="nav nav-tabs flex-column">
                                            <li class="nav-item">
                                                <a class="nav-link hash-candidate active edit-profile"
                                                   href="#edit-profile">Edit
                                                    Profile Info</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link hash-candidate change-password"
                                                   href="#change-password">Change
                                                    Password</a>
                                            </li>
                                            @if(Cookie::get('user_role') == 'store_admin')
                                                <li class="nav-item">
                                                    <a class="nav-link hash-candidate finance"
                                                       href="#finance">Finance</a>
                                                </li>
                                            @endif
                                            <li class="nav-item">
                                                <a class="nav-link hash-candidate displaypicture"
                                                   href="#displaypicture">Display
                                                    Picture</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="card p-3">

                            <div class="content pt-3">
                                <div id="edit-profile" class="screen hash-candidate active">
                                    <form method="POST" action="{{ route('setting') }}" class="profile-form">
                                        @csrf
                                        <div class="row mb-12" style="width: 100%;">
                                            <div class="col-md-8 offset-2">
                                                @if(is_store_admin())
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>First Name</label>
                                                            <input class="form-control" type="text" name="first_name"
                                                                   value="{{ $user_details['first_name'] == 'Not set' ? '':$user_details['first_name'] ?? '' }}"
                                                                   placeholder="Enter your first name">
                                                        </div>
                                                    </div>
                                                    <div class="clearfix"></div><br>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>Last Name</label>
                                                            <input class="form-control" type="text" name="last_name"
                                                                   value="{{ $user_details['last_name'] == 'Not set' ? '': $user_details['last_name'] ?? '' }}"
                                                                   placeholder="Enter your last name">
                                                        </div>
                                                    </div>
                                                @endif
                                                @if(is_store_assistant())
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>Your Name</label>
                                                            <input class="form-control" type="text" name="name"
                                                                   value="{{ $user_details['name'] ?? '' }}"
                                                                   placeholder="Doe">
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="clearfix"></div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>Email</label>
                                                        <input class="form-control" type="email" name="email"
                                                               value="{{ $user_details['email'] == 'Not set' ? '': $user_details['email'] ?? '' }}"
                                                               placeholder="Enter your email">
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label>Phone Number</label>
                                                        <input class="form-control" type="text" id="phone"
                                                               name="phone_number"
                                                               value="{{ $user_details['phone_number'] ?? "" }}"
                                                               readonly>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <br>
                                                <input type="text" value="profile_update" name="control" hidden>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row mb-12">
                                            <div class="col-md-12">
                                                <button class="btn btn-primary" type="submit"><i
                                                            class="fa fa-fw fa-lg fa-check-circle"></i> Save
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div id="change-password" class="hash-candidate screen">
                                    <form action="{{ route('setting') }}" method="POST"
                                          onSubmit="return checkPassword(this)">
                                        {{ csrf_field() }}
                                        <div class="col-8 offset-2">

                                            <label class=" control-label">Current Password</label>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                                    class=" fa fa-lock"></i></span></div>
                                                    <input class="form-control" name="current_password" type="password"
                                                           required>
                                                </div>
                                            </div>
                                            <label class="control-label">New Password</label>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                                    class=" fa fa-lock"></i></span></div>
                                                    <input id="password" class="form-control" name="new_password"
                                                           type="password" required minlength="6">
                                                </div>
                                            </div>
                                            <label class="control-label">Confirm New Password</label>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <div class="input-group-prepend"><span class="input-group-text"><i
                                                                    class=" fa fa-lock"></i></span></div>
                                                    <input id="passwordr" class="form-control"
                                                           name="new_password_confirmation" type="password" required
                                                           minlength="6">
                                                </div>
                                                <div class="invalid-feedback">
                                                    New Password and confirm new password must be the same
                                                </div>
                                            </div>
                                            <input type="hidden" name="control" value="password_change">
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button class="btn btn-primary" type="submit">Update Password</button>
                                        </div>
                                    </form>
                                </div>
                                @if(Cookie::get('user_role') == 'store_admin')
                                    <div id="finance" class="hash-candidate screen">
                                        <form method="POST" action="{{ route('setting') }}">
                                            @csrf
                                            <div class="col-md-8 offset-md-2">
                                                <div class="form-group">
                                                    <label for="currency_select">Currency</label>
                                                    <select class="form-control" id="currency_select" name="currency"
                                                            required>
                                                        <option value='NGN' @if(strtolower($user_details['currency'])=='ngn' )
                                                            {{ 'selected' }} @endif>NGN
                                                        </option>
                                                        <option value='USD' @if(strtolower($user_details['currency'])=='usd' )
                                                            {{ 'selected' }} @endif>USD
                                                        </option>
                                                        <option value='INR' @if(strtolower($user_details['currency'])=='inr' )
                                                            {{ 'selected' }} @endif>INR
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="currency_select">Bank Name</label>
                                                    <select class="form-control" id="bank_select" name="bank" required>
                                                        @foreach($bank_list as $bank)
                                                            <option value='{{ $bank->code }}'
                                                                    {{ $bank->code == $user_details['account_bank'] ? 'selected' : ''}}>
                                                                {{ $bank->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Account number</label>
                                                    <input class="form-control" type="number" id="account_number"
                                                           name="account_number"
                                                           value="{{ $user_details['account_number'] ?? '' }}" value=""
                                                           placeholder="0123456789" min="1" max="9999999999" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Account Name</label>
                                                    <span id="statusSpiner"
                                                          class="spinner-border spinner-border-sm text-primary d-none"
                                                          role="status">
                                                <span class="sr-only">Loading...</span>
                                            </span>
                                                    <input class="form-control" type="text" id="account_name"
                                                           name="account_name"
                                                           value="{{ $user_details['account_name'] ?? '' }}"
                                                           placeholder="Account Name" aria-describedby="ac_nameHelp"
                                                           readonly
                                                           required>
                                                    <small id="ac_nameHelp" class="form-text text-muted">will be auto
                                                        filled
                                                        when you enter Account nummber and bank
                                                    </small>
                                                </div>
                                                <input type="hidden" value="finance_update" name="control">
                                                <div class=" text-center">
                                                    <button class="btn btn-primary" id='financeButton' type="submit"><i
                                                                class="fa fa-fw fa-lg fa-check-circle"></i> Save
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                                <div id="displaypicture" class="hash-candidate screen">
                                    <form method="POST" action="{{ route('upload_image') }}"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <div class="row py-4">
                                            <div class="col-lg-6 mx-auto">

                                                <!-- Upload image input-->
                                                <div class="input-group mb-3 px-2 py-2 rounded-pill bg-white shadow-sm">
                                                    <input id="upload" type="file" onchange="readURL(this);"
                                                           name="profile_picture" class="form-control border-0">
                                                    <label id="upload-label" for="upload"
                                                           class="font-weight-light text-muted">Choose Picture</label>
                                                    <div class="input-group-append">
                                                        <label for="upload" class="btn btn-light m-0 rounded-pill px-4">
                                                            <i class="fa fa-cloud-upload mr-2 text-muted"></i>
                                                            <small class="text-uppercase font-weight-bold text-muted">
                                                                Choose
                                                                file
                                                            </small>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="image-area mt-4"><img id="imageResult" src="#" alt=""
                                                                                  class="img-fluid rounded shadow-sm mx-auto d-block">
                                                </div>

                                            </div>
                                        </div>
                                        <div class=" text-center">
                                            <button class="btn btn-primary" id='financeButton' type="submit"><i
                                                        class="fa fa-fw fa-lg fa-check-circle"></i> Save
                                            </button>
                                        </div>
                                    </form>
                                </div>

                            </div>
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
    <script>
        var navigation = () => {
            var locationHash = window.location.hash || "#edit-profile";
            $(".hash-candidate").removeClass("active");
            $(locationHash).addClass("active");
            if (locationHash === "#change-password") {
                $(".change-password").addClass("active");
            } else if (locationHash === "#finance") {
                $(".finance").addClass("active");
            } else if (locationHash === "#displaypicture") {
                $(".displaypicture").addClass("active");
            } else {
                $(".edit-profile").addClass("active");
            }
        };
        window.onhashchange = navigation;
        navigation();

        // Function to check Whether both passwords
        function checkPassword(form) {
            password1 = form.new_password.value;
            password2 = form.new_password_confirmation.value;
            // If Not same return False.
            if (password1 != password2) {
                return false;
            }
            // If same return True.
            else {
                return true;
            }
        }

        $('#password').keyup(() => {
            let pw = $('#password').val();
            let pwr = $('#passwordr').val();
            if (pw == pwr) {
                $('#passwordr').removeClass('is-invalid');
                $('.invalid-feedback').hide();

            } else {
                $('#passwordr').addClass('is-invalid');
                $('.invalid-feedback').show();
            }
        })

        $('#passwordr').keyup(() => {
            let pw = $('#password').val();
            let pwr = $('#passwordr').val();
            if (pw == pwr) {
                $('#passwordr').removeClass('is-invalid');
                $('.invalid-feedback').hide();

            } else {
                $('#passwordr').addClass('is-invalid');
                $('.invalid-feedback').show();
            }
        })

    </script>
    @if(Cookie::get('user_role') == 'store_admin')
        <script>
            $(function () {
                var currentRequest = null;
                const url = "{{ route('verify.bank') }}";
                $('#account_number').keyup(function () {
                    $('#statusSpiner').removeClass('d-none');
                    $('#financeButton').attr("disabled", true);
                    $(this).attr("required", true);

                    var number = $(this).val();
                    number = number.trim();
                    const bank = $('#bank_select').val();

                    if (number.length == 0) {
                        $('#account_name').val('');
                        $(this).attr("required", false);
                        $('#financeButton').attr("disabled", false);
                        $('#statusSpiner').addClass('d-none');
                        $(this).removeClass('is-invalid');
                        return false;
                    } else if (number.length != 10) {
                        $('#statusSpiner').addClass('d-none');
                        $(this).addClass('is-invalid');
                        $('#financeButton').attr("disabled", true);
                        $('#statusSpiner').addClass('d-none');
                        $('#account_name').val('');
                        return false;
                    }
                    $(this).removeClass('is-invalid');
                    $(this).removeClass('is-valid');
                    $('#statusSpiner').removeClass('d-none');
                    currentRequest = $.ajax({
                        url: url,
                        data: {
                            "_token": "{{ csrf_token() }}",
                            account_number: number,
                            account_bank: bank,
                        },
                        type: 'POST',
                        beforeSend: function () {
                            if (currentRequest != null) {
                                $('#this').removeClass('is-valid');
                                $('#account_name').removeClass('is-valid');
                                $('#account_number').removeClass('is-valid');
                                $('#financeButton').attr("disabled", true);
                                $('#statusSpiner').removeClass('d-none');
                                currentRequest.abort();
                            }
                        },
                    }).done(response => {
                        if (response.status == 'success') {
                            $('#account_name').val(response.data.account_name);
                            $('#account_name').addClass('is-valid');
                            $('#account_number').addClass('is-valid');
                            $('#statusSpiner').addClass('d-none');
                            $('#account_number').removeClass('is-invalid');
                            $('#financeButton').removeAttr("disabled")
                            // $('#account_name').val('');
                            return true;
                        }
                        $('#account_number').removeClass('is-valid');
                        $('#account_name').removeClass('is-valid');
                        $('#financeButton').attr("disabled", true);
                        $(this).addClass('is-invalid');
                        $('#statusSpiner').addClass('d-none');
                        $('#account_name').val('');
                        $(this).attr("required", true);

                    }).fail(e => {
                        $(this).addClass('is-invalid');
                        $(this).removeClass('is-valid');
                        $('#statusSpiner').addClass('d-none');
                        $('#account_name').removeClass('is-valid');
                        $('#account_name').val('');
                        $('#financeButton').attr("disabled", true);
                        $(this).attr("required", true);
                    });
                });

                $('#bank_select').change(function () {
                    $('#financeButton').attr("disabled", true);
                    $('#account_name').val('');
                });

            });

        </script>
    @endif
    <script>
        /*  ==========================================
        SHOW UPLOADED IMAGE
    * ========================================== */
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#imageResult')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $(function () {
            $('#upload').on('change', function () {
                readURL(input);
            });
        });

        /*  ==========================================
            SHOW UPLOADED IMAGE NAME
        * ========================================== */
        var input = document.getElementById('upload');
        var infoArea = document.getElementById('upload-label');

        input.addEventListener('change', showFileName);

        function showFileName(event) {
            var input = event.srcElement;
            var fileName = input.files[0].name;
            infoArea.textContent = fileName;
        }

    </script>
@stop
