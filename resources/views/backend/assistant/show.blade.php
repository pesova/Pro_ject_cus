{{-- inherits base markup --}}
{{-- got my page working im so excited --}}
{{-- {{dd($assistant)}} --}}
@extends('layout.base')
{{-- add in the basic styling : check the contents of these stylesheets later --}}
@section("custom_css")
<link rel="stylesheet" href="{{asset('backend/assets/css/singleCustomer.css')}}">
<link href="/backend/assets/build/css/intlTelInput.css" rel="stylesheet" type="text/css" />

<style>
    #edit_phone{
        padding-left: 89px !important;
    }
</style>
@stop


{{-- yield body content --}}

@section('content')
<div class="content">
    @include('partials.alert.message')
    <div class="container-fluid">
        {{-- start of page title --}}
        <div class="row page-title">
            <div class="col-md-12">
                <h4 class="mb-1 mt-0 float-left">Profile</h4>
                <a href="{{ url()->previous() }}" class="btn btn-primary float-right btn-sm">
                    Go Back
                </a>
                <a href="#" 
                data-toggle="modal"
                 data-target="#editAssistant" 
                 onclick="open_edit_assistant(this)"
                 data-store_id="{{$assistant->user->store_id}}"
                 data-assistant_id="{{ $assistant->_id }}"
                 data-assistant_name="{{$assistant->user->name }}"
                 data-assistant_email="{{$assistant->email }}"
                 data-assistant_phone="{{$assistant->phone_number}}"
                 class="mr-3 btn btn-success float-right btn-sm">
                    Edit Assistant
                </a>
            </div>
        </div>

        {{-- edit assitant modal --}}
        @include('backend.assistant.modals.editAssistant')

        @include('partials.dashboard.store_assistant')
    </div>
</div>
@endsection
