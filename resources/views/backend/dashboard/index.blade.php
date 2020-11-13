@extends('layout.base')

@section("custom_css")

@if (is_store_admin())
 <link href="/backend/assets/build/css/intlTelInput.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ asset('/backend/assets/css/transac.css') }}">   
<link rel="stylesheet" href="{{asset('backend/assets/css/store_list.css')}}">
<link href="/backend/assets/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="/backend/assets/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="/backend/assets/css/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
@endif

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">

    
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
    .profile-form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    #editphone{
        padding-left: 89px !important;
    }

    #active-store{
        border-left: 3px solid #5369f8;
        color: #5369f8;
    }

</style>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row page-title align-items-center">
            <div class="col-sm-4 col-xl-6">
                <h4 class="mb-1 mt-0">Dashboard</h4>
            </div>
        </div>
        @include('partials.alert.message')
        @if(\Illuminate\Support\Facades\Cookie::get('user_role') == 'store_admin')
            @include('partials.dashboard.store_admin')
        @endif

        @if(\Illuminate\Support\Facades\Cookie::get('user_role') == 'store_assistant')
            @include('partials.dashboard.store_assistant')
        @endif

        @if(\Illuminate\Support\Facades\Cookie::get('user_role') == 'super_admin')
            @include('partials.dashboard.super_admin')
        @endif
    </div>
@endsection


{{-- @section("javascript")


@endsection --}}

