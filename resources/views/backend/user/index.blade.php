@extends('layout.base')
@section("custom_css")
<link href="/backend/assets/build/css/intlTelInput.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
<link rel="stylesheet" href="backend/assets/css/all_users.css">
<link href="/backend/assets/build/css/intlTelInput.css" rel="stylesheet" type="text/css" />
@stop
@section('content')
<div class="content">

    <div class="container-fluid">
        <div class="row page-title">
            <div class="col-md-12">
                <h4 class="mb-1 mt-0">All Users</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @include('partials.alert.message')
                        <div class="row">
                            <div class="col">
                                <p class="sub-header">
                                    Find Users
                                </p>
                            </div>
                            <div class="col ">
                                <button href="#" class="btn btn-primary float-right" data-toggle="modal" data-target="#myModal">
                                    new User <i class="fa fa-plus my-float"></i>
                                </button>
                            </div>
                        </div>
                        <div class="container-fluid">

                            <div class="row">
                                <div class="form-group col-lg-12 mt-4">
                                    <div class="row">
                                        <label class="form-control-label">Search Users</label>
                                        <div class="input-group input-group-merge">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="icon-dual" data-feather="search"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control" id="user-name">
                                        </div>
                                    </div>
                                </div>

                            </div>


                        </div>

                    </div> <!-- end card body-->
                </div> <!-- end card -->
            </div><!-- end col-->
        </div>

        <div class="row">
            @foreach ($users as $user)
            <div class="col-xl-3 col-sm-6">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="avatar-sm mx-auto mb-4">
                            <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-16">
                                @php
                                $names = explode(" ", strtoupper($user->local->first_name));
                                $ch = "";
                                foreach ($names as $name) {
                                $ch .= $name[0];

                                }
                                echo $ch;
                                @endphp
                            </span>
                        </div>
                        <h5 class="font-size-15 text-dark search-name">{{$user->local->first_name }}
                        </h5>
                        <p class="text-muted">{{$user->local->phone_number?? ''}}
                            | {{$user->local->email ?? ''}}</p>

                        <div>
                            @if ($user->local->user_role == "store_admin")
                            <span class="badge badge-primary">owner</span>
                            @elseif ($user->local->user_role == "store_assistant")
                            <span class="badge badge-secondray">assistant</span>
                            @else
                            <span class="badge badge-info">No role</span>
                            @endif
                            @if($user->local->is_active)
                            <span class="badge badge-success">Activated</span>

                            @else
                            <span class="badge badge-secondary">Not activated</span>

                            @endif
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-top">
                        <div class="contact-links d-flex font-size-20">
                            <div class="flex-fill">
                                <a href="{{route('users.show',$user->_id)}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="View User"><i data-feather="eye"></i></a>
                            </div>

                            {{--<div class="flex-fill">
                                        <a href="#" data-toggle="tooltip"
                                           data-placement="top" title="" data-original-title="Edit"><i
                                                    data-feather="edit"></i></a>
                                    </div>--}}

                            @if($user->local->is_active)
                            <div class="flex-fill">
                                <a class="text-danger" href="#"  data-toggle="modal" data-target="#deactivateModal-{{$user->_id}}"><i data-feather="user-x"></i></a>

                                @include('partials.modal.user.deactivateUser',['user',$user])

                            </div>

                            @else

                            <div class="flex-fill">
                                <a class="" href="#" data-toggle="modal" data-target="#activateModal-{{$user->_id}}"><i data-feather="user-check"></i></a>

                                @include('partials.modal.user.activateUser',['user',$user])

                            </div>

                            @endif

                        </div>
                    </div>
                </div>

            </div>
            @endforeach
        </div>
        @if(!empty($user))
        <div class="row">
            <div class="col-12 align-items-center">
                {{$users->links()}}
            </div>
        </div>
        @endif
        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Create New User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('users.store') }}" method="POST" class="form-horizontal" id="submitForm">
                            @csrf
                            <div class="form-group row mb-3">
                                <label for="inputphone" class="col-md-3 col-form-label">Phone Number</label>
                                <div class="col-md-9">
                                    <input type="tel" class="form-control" id="phone" placeholder="Phone Number" aria-describedby="helpPhone" name="" required pattern=".{6,16}" title="Phone number must be between 6 to 16 characters">
                                    <input type="hidden" name="phone_number" id="phone_number" class="form-control">
                                    <small id="helpPhone" class="form-text text-muted">Enter your number without the
                                        starting 0, eg 813012345
                                    </small>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="password" class="col-md-3 col-form-label">Password</label>
                                <div class="col-md-9">
                                    <input type="password" name="password" class="form-control" id="password" placeholder="Password" minlength="6" required>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="passwordr" class="col-md-3 col-form-label">Confirm
                                    Password</label>
                                <div class="col-md-9">
                                    <input type="password" name="password_confirmation" class="form-control" id="passwordr" placeholder="Retype Password" required>
                                    <div class="invalid-feedback">
                                        Password and password confirmation must be the same
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-0 justify-content-end row">
                                <div class="col-9">
                                    <button type="submit" id="submitNewUser" class="btn btn-primary btn-block ">Create
                                        User
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                    </div>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
</div>
@endsection


@section("javascript")
<script src="/backend/assets/build/js/intlTelInput.js"></script>
<script>
    let userName = $('#user-name');

    //add input event listener
    userName.on('keyup', (e) => {
        const users = $('.search-name');
        const filterText = e.target.value.toLowerCase();

        users.each(function(i, item) {
            console.log($(this).html());
            if ($(this).html().toLowerCase().indexOf(filterText) !== -1) {
                $(this).parent().parent().parent().css('display', 'block');

            } else {
                $(this).parent().parent().parent().css('display', 'none');
            }

        });
    });

    $(function() {
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
            const pw = $('#password').val();
            const pwr = $('#passwordr').val();
            // If Not same return False.
            if (pw != pwr) {
                e.preventDefault();
                return false;
            }
            if ($("#phone").val().charAt(0) == 0) {
                $("#phone").val($("#phone").val().substring(1));
            }
            $("#phone_number").val(dialCode + $("#phone").val());
            $("#submitForm").off('submit').submit();
        });

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
    });
</script>
@endsection
