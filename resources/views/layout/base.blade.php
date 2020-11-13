<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8" />
    <title>CustomerPayMe - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta
        content="An easy to use web app that helps you record and track daily transactions, Send debt reminders and send offers to your customers"
        name="description" />
    <meta content="CustomerPayMe" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="/frontend/assets/favicon1.ico">

    <!-- plugins -->
    <link href="/backend/assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{{asset('backend/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('backend/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('backend/assets/css/app.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('backend/assets/css/custom.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/shepherd/2.0.0-beta.1/css/shepherd-theme-arrows.css" />
    <link href="{{asset('backend/assets/css/tourguide.css')}}" rel="stylesheet" type="text/css">
    @if(\Cookie::get('theme') == 'dark')
    <link href="{{asset('backend/assets/css/dark-css.css')}}" rel="stylesheet" type="text/css">
    @endif
    <style>
        .dissapear {
            display: none !important;
        }

        #active-store{
        border-left: 3px solid #5369f8;
        color: #5369f8;
    }
        .pointer { 
            cursor: pointer; 
            }

            #store_list_spinner.invisible{
                display: none !important;
            }

    </style>

    <!-- Other Style CSS -->
    @yield('custom_css')


</head>

<body>

    <!-- Begin page -->
    <div id="wrapper">
        @include('partials.bsidebar')

        <!--====================  heaer area ====================-->
        @include('partials.bheader')
        <!--====================  End of heaer area  ====================-->
        <div class="content-page">
            <div class="content">

                @yield('content')

            </div>

            @include('partials.modal.change_profile_pic_modal')

            <!--====================  footer area ====================-->
            @include('partials.bfooter')
            <!--====================  End of footer area  ====================-->
        </div>



    </div>

    <!-- JS============================================ -->

    <!-- Vendor js -->
    <script src="/backend/assets/js/vendor.min.js"></script>

    <!-- optional plugins -->
    <script src="/backend/assets/libs/moment/moment.min.js"></script>
    <script src="/backend/assets/libs/apexcharts/apexcharts.min.js"></script>
    <script src="/backend/assets/libs/flatpickr/flatpickr.min.js"></script>

    <!-- page js -->
    {{-- <script src="/backend/assets/js/pages/dashboard.init.js"></script> --}}
    <script src="/backend/assets/js/pages/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/shepherd/2.0.0-beta.1/js/shepherd.js"></script>


    <!-- App js -->
    <script src="/backend/assets/js/app.min.js"></script>
    <script src="/backend/assets/js/alert.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>


    {{-- Checks if a store is selected --}}

    @if (is_store_admin())
            @if(Cookie::get('store_id') !== null)
                <script>
                    let store_list = document.getElementById('store_lists');
                    let stores;
                    if(store_list){
                        if(!localStorage.getItem('stores')){
                            $('#store_list_spinner').removeClass('invisible');
                            $.ajax({
                                method:"GET",
                                url: "{{route('businesses')}}",
                            })
                            .done(function(data){
                                localStorage.setItem('stores',data);
                                stores = JSON.parse(data);
                                populate_store_list(stores);
                            })
                        }else{
                            stores = JSON.parse(localStorage.getItem('stores')); 
                            populate_store_list(stores);
                        }
                      
                   
                        
                    }

                    $("#logout-btn").click(function(){
                        localStorage.removeItem('stores');
                    })

                    function populate_store_list(stores){
                        let list = '';
                    if(stores.length > 0){
                            stores.forEach(element => {
                            let url = "{{ route('store.select', ['store_id'=>1, 'store_name' =>'store-name']) }}";
                            let formatted_url = url.replace('1',element._id);
                            formatted_url = formatted_url.replace('store-name',element.store_name);

                            let current_store = "{{Cookie::get('store_id')}}"
                            if(element._id == current_store){
                                    list += `
                                        <li>
                                            <a href="${formatted_url}" id="active-store">
                                            ${element.store_name}</a>
                                        </li>
                                        `
                            }else{
                                list += `
                                <li>
                                    <a href="${formatted_url}">
                                    ${element.store_name}</a>
                                </li>
                                ` 
                            }
                            
                            
                        });
                    }else{
                        list ="<p>No store to display</p>"
                    }
                                
                                $('#store_list_spinner').addClass('invisible');
                                $("#store_lists").text('');
                                $("#store_lists").append(list);
                    }
                </script>
        @endif
    @endif

    
   
    @yield('javascript')
</body>

</html>