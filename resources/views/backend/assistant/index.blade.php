@extends('layout.base')
@section("custom_css")
<link href="/backend/assets/build/css/intlTelInput.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
<link rel="stylesheet" href="/backend/assets/build/css/all_users.css">

<style>
    #edit_phone,#phone{
        padding-left: 89px !important;
    }
</style>
@stop

{{-- {{dd($assistants)}} --}}
@section('content')
<div class="content">
    @include('partials.alert.message')

    <div class="container-fluid">
        <div class="page-title d-flex justify-content-between align-items-center">
            <div>
                <h4 class="">Assistants</h4>
            </div>
            <div>
                <button class=" btn btn-primary btn-sm" data-toggle="modal">
                    <a href="" data-toggle="modal" data-target="#addAssistantModal" class="text-white">
                        New Assistant <i class="fa fa-plus add-new-icon"></i>
                    </a>
                </button>
            </div>
        </div>

        <div class="container-fluid card">
            <div class="row card-body">
                <label class="form-control-label">Search Assistants</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="search-assistant">
                            <i class="icon-dual icon-xs" data-feather="search"></i>
                        </span>
                    </div>
                    <input type="search" class="form-control" id="assistant-name" placeholder="Search"
                        aria-label="search-assistant" aria-describedby="search-assistant">
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row row-eq-height my-2">
                @foreach ($assistants as $assistant)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div id="idd" class="card text-center full-div">
                        <div class="card-body">
                            <div class="avatar-sm mx-auto mb-4">
                                <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-16">
                                    @php
                                    $names = explode(" ", strtoupper($assistant->name));
                                    $ch = "";
                                    foreach ($names as $name) {
                                    $ch .= $name[0];
    
                                    }
                                    echo $ch;
                                    @endphp
                                </span>
                            </div>
                            <h5 class="font-size-15"><a href="{{ route('assistants.show', $assistant->_id) }}"
                                    class="text-dark">{{$assistant->name }}</a></h5>
                            <p class="text-muted">{{$assistant->phone_number}} | {{$assistant->email ?? ''}}</p>
    
                            <div>
                                @if ($assistant->user_role == "store_admin")
                                @endif
                                @if($assistant->is_active)
                                <span class="badge badge-success">Activated</span>
    
                                @else
                                <span class="badge badge-secondary">Not activated</span>
    
                                @endif
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-top">
                            <div class="contact-links d-flex font-size-20">
                                <div class="flex-fill">
                                    <a href="{{ route('assistants.show', $assistant->_id) }}" data-toggle="tooltip"
                                        data-placement="top" title="" data-original-title="View User"><i
                                            data-feather="eye"></i></a>
                                </div>
                                
                                @if (Cookie::get('user_role') == "store_admin")

                                    <div class="flex-fill">
                                        <a href="#" data-toggle="modal" 
                                        onclick="open_edit_assistant(this)"
                                        data-store_id="{{$assistant->store_id}}"
                                        data-assistant_id="{{ $assistant->_id }}"
                                        data-assistant_name="{{$assistant->name }}"
                                        data-assistant_email="{{$assistant->email }}"
                                        data-assistant_phone="{{$assistant->phone_number}}"
                                        data-target="#editAssistant">
                                            <i data-feather="edit"></i>
                                        </a>
                                    </div>
        
                                    <div class="flex-fill">
                                        <a class="" href="#" 
                                        data-toggle="modal" 
                                        onclick="deleteAssistant(this)"
                                        data-assistant_id="{{$assistant->_id}}"
                                        data-assistant_name="{{$assistant->name}}"
                                        data-target="#deleteModal">
                                            <i data-feather="trash-2"></i></a>
                                    </div>

                                @endif

                               
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- delete assitant modal --}}
               
                @endforeach
            </div>
        </div>
    </div>
    {{-- Add assitant modal --}}
    @include('backend.assistant.modals.addAssistant')
    {{-- edit assitant modal --}}
    @include('backend.assistant.modals.editAssistant')
    @include('backend.assistant.modals.deleteAssistant')
</div>
@endsection


@section("javascript")

<script src="/backend/assets/build/js/intlTelInput.js"></script>
<script>
    var input = document.querySelector("#phone");
    var test = window.intlTelInput(input, {
        separateDialCode: true,
        initialCountry: "auto",
        placeholder: true,
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

    if ($("#phone").val().trim() != '')
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

    let assistantName = $('#assistant-name');
    let assistantEmail = $('#assistant-email');
    let assistantPhone = $('#assistant-phone');

    //add input event listener
    assistantName.on('keyup', (e) => {
        assistantEmail.val('');
        assistantPhone.val('');
        const assistants = $('.assistant-name');
        const filterText = e.target.value.toLowerCase();

        assistants.each(function (i, item) {
            if ($(this).html().toLowerCase().indexOf(filterText) !== -1) {
                $(this).parent().css('display', 'table-row');

            } else {
                $(this).parent().css('display', 'none');
            }

        });
    });
    assistantEmail.on('keyup', (e) => {
        assistantPhone.val('');
        assistantName.val('');
        const assistants = $('.assistant-email');
        const filterText = e.target.value.toLowerCase();

        assistants.each(function (i, item) {
            if ($(this).html().toLowerCase().indexOf(filterText) !== -1) {
                $(this).parent().css('display', 'table-row');

            } else {
                $(this).parent().css('display', 'none');

            }

        });
    });
    assistantPhone.on('keyup', (e) => {
        assistantEmail.val('');
        assistantName.val('');
        const assistants = $('.assistant-phone');
        const filterText = e.target.value.toLowerCase();

        assistants.each(function (i, item) {
            if ($(this).html().toLowerCase().indexOf(filterText) !== -1) {
                $(this).parent().css('display', 'table-row');

            } else {
                $(this).parent().css('display', 'none');

            }

        });
    });

</script>
<script>
    //for search bar
    let userText = document.querySelector('#assistant-name')
    let rows = document.querySelectorAll('#idd')

    //add input event listener
    userText.addEventListener('keyup', showFilterResults)

    function showFilterResults(e) {
        const users = rows;
        const filterText = e.target.value.toLowerCase();

        users.forEach(function (item) {
            if (item.textContent.toLowerCase().indexOf(filterText) !== -1) {
                item.parentElement.style.display = 'table-row'

            } else {
                item.parentElement.style.display = 'none'

            };
        });
    };

</script>
<script>
    var nombrePage = $("#idd").length;

    showPage = function (pagination) {
        if (pagination < 2 || pagination >= nombrePage) return;

        $("#idd").hide().eq(pagination).show();
        $("#pagin li").removeClass("active").eq(pagination).addClass("active");
    };

    showPage(0);

</script>
{{-- @if (\Illuminate\Support\Facades\Cookie::get('is_first_time_user') == true) --}}
{{-- <script>
    var assistant_intro_shown = localStorage.getItem('assistant_intro_shown');

    if (!assistant_intro_shown) {

        const tour = new Shepherd.Tour({
            defaults: {
                classes: "shepherd-theme-arrows"
            }
        });

        tour.addStep("step", {
            text: "Welcome to Assistants Page, here you can add your assistants to manage your stores",
            buttons: [{
                text: "Next",
                action: tour.next
            }]
        });

        // tour.addStep("step2", {
        //     text: "First thing you do is create a store",
        //     attachTo: { element: ".second", on: "right" },
        //     buttons: [
        //         {
        //             text: "Next",
        //             action: tour.next
        //         }
        //     ],
        //     beforeShowPromise: function() {
        //         document.body.className += ' sidebar-enable';
        //         document.getElementById('sidebar-menu').style.height = 'auto';
        //     },
        // });
        tour.start();
        localStorage.setItem('assistant_intro_shown', 1);
    }

</script> --}}
{{-- @else --}}

@include('backend.assistant.script.editAssistant')

@include('backend.assistant.script.deleteAssistant')


@stop
