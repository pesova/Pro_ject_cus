@extends('layout.sbase')
@section("custom_css")
    <link href="/backend/assets/build/css/intlTelInput.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('backend/assets/css/store_list.css') }}">

    <style>
        #editphone, #phone {
            padding-left: 89px !important;
        }

        .content {
            padding-top: 80px !important;
        }
       .card.text-center{
            
            cursor: pointer;
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
        }


        .col-xl-3.col-sm-6.new{
            position: relative;
        }

       .card.text-center:hover{
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
        }

        .store-links{
            display: block;
        }
    </style>

@stop
@section('content')
    <div class="content">
        <!-- Start Content-->
        @include('partials.alert.message')
        <div class="container-fluid">

            <div class="row" style="margin-top:20px;">
                @foreach ($stores as $store)
                <a class="col-xl-3 col-sm-6"  href="{{ route('store.select', ['store_id'=>$store->_id]) }}">
                    <div  style="margin-bottom: 20px;
                    max-height:225px;">

                        <div class="card text-center">


                            <div class="card-body">

                                <div class="avatar-sm mx-auto mb-4">
                            <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-16">
                                {{ app_get_acronym($store->store_name) }}
                            </span>
                                </div>
                                <h5 class="font-size-15">{{ $store->store_name  }}
                                </h5>
                                <p class="text-muted">{{ $store->email ?? ''}}</p>
                                <p class="text-muted">{{ $store->shop_address ?? ''}}</p>

                            </div>

                        </div>

                    </div>
                </a>
                @endforeach
              
                {{-- Pagination link --}}
                <div class="ml-auto mx-2">
                    {{$stores->links()}}
                </div>
            </div>


        </div>
    </div>
@section("javascript")
    <script src="/backend/assets/build/js/intlTelInput.js"></script>
    <script>
        //for search bar
        let storeName = $('#store-name');

        //add input event listener
        storeName.on('keyup', (e) => {
            const users = $('.search-name');
            const filterText = e.target.value.toLowerCase();

            users.each(function (i, item) {
                // console.log($(this).html());
                if ($(this).html().toLowerCase().indexOf(filterText) !== -1) {
                    $(this).parent().parent().parent().css('display', 'block');

                } else {
                    $(this).parent().parent().parent().css('display', 'none');
                }

            });
        });

    </script>

    {{-- add store js --}}
    <script>
        //phone Number format
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

    {{-- Edit store Js --}}

    @include('backend.stores.scripts.editStore')
@stop