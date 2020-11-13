@extends('layout.base')
@section("custom_css")
    <link href="/backend/assets/build/css/intlTelInput.css" rel="stylesheet" type="text/css"/>
    {{-- custom style --}}
<style>
.img-size-32 {
    height: auto;
  }
  
  .img-size-32 {
 width: 32px;   
  }
</style>
@stop
@section('content')
    <div class="content">
        <div class="container-fluid">
    {{-- page title --}}
            <div class="row page-title">
                <div class="col-md-12">
                    <h4 class="mb-1 mt-0">Notifications</h4>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 col-xl-6">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="media p-3">
                                <div class="media-body">
                                    <span class="text-muted text-uppercase font-size-12 font-weight-bold">Total Notifications</span>
                                    <h2 class="mb-0">{{$notifications->count()}}</h2>
                                </div>
                                <div class="align-self-center">
                                    <span class="text-info font-weight-bold font-size-13"> 
                                        <i class='uil uil-bell  font-weight-bold font-size-20'></i>  
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="col-md-6 col-xl-6">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="media p-3">
                                <div class="media-body">
                                    <span class="text-muted text-uppercase font-size-12 font-weight-bold">
                                        New notifications</span>
                                    <h2 class="mb-0">{{$user->unreadNotifications->count()}}</i></h2>
                                </div>
                                <div class="align-self-center">
                                    <span class="text-danger font-weight-bold font-size-13"> 
                                        <i class='uil uil-bell  font-weight-bold font-size-20'></i>  
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
        
                
                
            </div>  
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {{-- <h4 class="header-title mt-0 mb-1">Basic Data Table</h4> --}}
                            <p class="sub-header">
                                {{$user->unreadNotifications->count()}} new notifications

                                <a href="{{route('read.all')}}" type="button" class="btn btn-primary float-right btn-sm" aria-expanded="false">
                                    <i class='uil uil-check ml-1'></i> Mark all as read 
                                </a><br>                                   
                            </p>
                         
                            {{-- Table designing --}}
                            <div class="table-responsive">
                                <table class="table mb-0" id="basic-datatable">
                                    <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                       
                                    </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($notifications as $notification)
                                            <tr>
                                        <th scope="row">1</th>

                                        <td>
                                            <p>{{$notification->data['message']}}</p> 
                                        </td>

                                        <td>
                                            <p class="text-danger align-self-center">
                                                {{(is_null($notification->read_at)) ? 'Unread' : 'Read'}}
                                            </p>
                                        </td>

                                        <td>
                                            <p>{{date_diff($notification->created_at, now())->format("%h hrs %i mins %s secs")}}</p>
                                        </td>
                                    </tr>
                                        @endforeach
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div>

        </div>
    </div>

@endsection


@section("javascript")
    <script src="/backend/assets/build/js/intlTelInput.js"></script>
    <script>
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            // any initialisation options go here
        });
    </script>
@stop
