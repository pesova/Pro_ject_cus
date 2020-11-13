@extends('layout.base')

@section("custom_css")
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" />

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
<style>
    .select2-container--classic .select2-selection--multiple .select2-selection__choice {
        background-color: #5369f8;
        border: 1px solid #5369f8;
    }

    .select2-container--classic .select2-selection--multiple .select2-selection__choice__remove {
        color: #fff;
    }
</style>
@stop

@section('content')
<div class="container-fluid">

    <div class="row page-title align-items-center">
        <div class="col-sm-4 col-xl-6" >
            <h4 class="mb-1 mt-0">Compose</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title mb-4">Compose Message</h3>
                    @include('partials.alert.message')
                    
                    
                    
                    <div class="d-flex justify-content-center">
                        <div class="row col-lg-7 col-md-12 ">
                            <form action="{{ route('broadcast.store') }}" method="post" class="col-12">
                                @csrf

                                @if ( \Cookie::get('user_role') == "super_admin")
                                <div class="form-group">
                                    <label>Business</label>
                                    <select class="form-control col-12" name="store" id="store" required>
                                        <option value="" selected disabled>None selected</option>
                                        @if ( \Cookie::get('user_role') == "super_admin")
                                        @foreach ($stores as $index => $store)
                                            <option value="{{$store->_id}}">{{$store->store_name}}</option>
                                        @endforeach
                                        @else
                                        @foreach ($stores as $index => $store)
                                            <option value="{{$store->_id}}">{{$store->store_name}}</option>
                                        @endforeach
                                        @endif
                                        
                                    </select>
                                </div>
                                @elseif( \Cookie::get('user_role') == "store_admin")
                                    <input type="hidden" value="{{$userData->_id}}" name="store">
                                @else
                                    <input type="hidden" value="{{$userData[0]->storeId}}" name="store">
                                @endif
                                <div class="form-group">
                                    <label>Send To</label>
                                    <select class="form-control col-12" name="send_to" id="send_to" required>
                                        <option value="1"> All Customers</option>
                                        <option value="2" selected> Selected Customers</option>
                                    </select>
                                </div>

                                @if ( \Cookie::get('user_role') == "super_admin")
                                <div class="form-group" id='customersGroup'>
                                    <label>Customer(s)</label>
                                    <select class="form-control col-12 jstags" multiple name="customer[]" id="customerNumbers">
                                    </select>
                                </div>
                                @else
                                <div class="form-group" id='customersGroup'>
                                    <label>Customer(s)</label>
                                    <select class="form-control col-12 jstags" multiple name="customer[]" id="customerNumbers">
                                    @foreach ($allCustomers as $customer)
                                        <option value="{{$customer->phone_number}}">{{$customer->name}}</option>
                                    @endforeach
                                    </select>
                                </div>
                                @endif

                                    
                                <div class="form-group">
                                    <label>Message</label>
                                    <select class="form-control col-12" name="message" id="msgselect" required>
                                        <option value="" selected disabled>None selected</option>
                                        <option value="Happy new year!">Happy new year!</option>
                                        <option value="We are now open!">We are now open!</option>
                                        <option value="New stocks just arrived!">New stocks just arrived!</option>
                                        <option value="Happy new Month">Happy new Month</option>
                                        <option value="Thank you for shopping with">Thank you for shopping with US!</option>
                                        <option value="other">Custom Message</option>
                                    </select>
                                </div>
                                <div class="form-group" id="txtarea">
                                    <label for="exampleFormControlTextarea1">Your Custom Message</label>
                                    <textarea class="form-control" name="txtmessage" rows="4"></textarea>
                                </div>
                                <button class="btn btn-primary" type="submit">Send &nbsp;<i class="fa fa-paper-plane my-float"></i>
                                </button>
                            
                        </form>
                        </div>
                    </div>
                  
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<div class="card mt-0">
    <div class="card-header">
        <div class="">History: Broadcast Messages</div>
    </div>
    <div class="card-body">
        <div class="table-responsive table-data">
            <table id="broadcastsTable"  class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>Ref ID</th>
                        <th>Number</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Time Sent</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                @isset($broadcasts)
                    @if (count($broadcasts) > 0)
                        @foreach ($broadcasts as $broadcast)
                            <tr>
                                <td>
                                {{$broadcast->_id}}
                                </td>
                                <td>
                                 
                                    @foreach ($broadcast->numbers as $index=>$numbers)
                                        
                                        @if (count($broadcast->numbers) !=  $index + 1)
                                             {{$numbers .","}}
                                        @else
                                            {{$numbers}}
                                        @endif
                                       
                                    @endforeach
                                    
                                    </td>
                                <td>
                                    {{$broadcast->message}}
                                </td>
                                <td>
                                    <span class="badge badge-{{$broadcast->status == "Sent" ? "success" : "danger"}}">
                                        {{$broadcast->status == "Sent" ? "Sent" : "Not Sent"}}
                                    </span></td>
                                <td>
                                {{\Carbon\Carbon::parse($broadcast->date)->diffForhumans()}}
                                </td>
                                <td>
                                    <div class="btn-group mt-2 mr-1">
                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions<i class="icon"><span data-feather="chevron-down"></span></i>
                                        </button>
                                    <div class="dropdown-menu dropdown-menu-right">


                                        <form class="form-horizontal" method="POST"
                                        action="{{ route('resend_broadcast', $broadcast->_id) }}" id="resend-{{$broadcast->_id}}">
                                           @csrf
                                        </form>
                                    <a href="#" 
                                    data-broadcast_id="{{$broadcast->_id}}"
                                    onclick="resendBroadcast(this)"
                                    class="dropdown-item" data-toggle="modal" 
                                    data-target="#ResendReminderModal">
                                        Resend
                                    </a>

                                    <a href="#" 
                                    
                                    onclick=" openModal(this)"
                                    class="dropdown-item" data-toggle="modal" 
                                    data-broadcast_id="{{$broadcast->_id}}"
                                    data-toggle="modal"
                                    data-target="#deleteModal">
                                        Delete
                                    </a>
                                     </div>
                                     <form class="form-horizontal" method="POST"
                                    action="{{ route('broadcast.destroy', $broadcast->_id) }}" id="delete-{{$broadcast->_id}}">
                                   
                                       @csrf
                                       @method('DELETE')
                                    </form>
                                </td>
                            </tr> 
                        @endforeach
                    @else
                        
                    @endif
                @endisset
                  
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1"
    role="dialog"
    aria-labelledby="storeDeleteLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
       <div class="modal-content">
           <div class="modal-header">
               <h5 class="modal-title" id="storeDeleteLabel">Delete Broadcast
               </h5>
               <button type="button" class="close" data-dismiss="modal"
                       aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
               <div class="modal-body">
                   <h6>Are you sure you want to
                       delete <span></span></h6>
               </div>
               <div class="modal-footer">
                   <div class="">
                       <button type="submit" class="btn btn-primary mr-3"
                               data-dismiss="modal"><i
                                   data-feather="x"></i>
                           Close
                       </button>
                       <button 
                       onclick="deleteBroadcast()"
                        class="btn btn-danger"><i
                                   data-feather="trash-2"></i> Delete
                       </button>
                   </div>
               </div>
       </div>
   </div>
</div>
@endsection

@section("javascript")
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.3.1/jszip-2.5.0/dt-1.10.21/b-1.6.2/b-html5-1.6.2/datatables.min.js">
</script>

<!-- App js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<script>
    jQuery(function($) {
        const token = "{{Cookie::get('api_token')}}"
        const host = "{{ env('API_URL', 'https://dev.api.customerpay.me') }}";

        $('select[name="store"]').on('change', function() {
            var storeID = $(this).val();
            var host = "{{ env('API_URL', 'https://dev.api.customerpay.me') }}";

            if (storeID) {
                $('select[name="customer[]"]').empty();
                jQuery.ajax({
                    url: host + "/store/" + encodeURI(storeID),
                    type: "GET",
                    dataType: "json",
                    contentType: 'json',
                    headers: {
                        'x-access-token': token
                    },
                    success: function(data) {
                        var new_data = data.data.store.customers;
                        var i;
                        new_data.forEach(customer => {
                            $('select[name="customer[]"]').append('<option multiple value="' +
                                customer.phone_number + '">' +
                                customer.name + '</option>');
                        });
                    }
                });
            } else {
                $('select[name="store"]').empty();
            }
        });

    });

    $(document).ready(function() {
    $('#broadcastsTable').DataTable({
        dom: 'frtipB',
        "ordering": false,
    }
    );
} );

</script>
<script>
    $("#txtarea").hide();
    $("#msgselect").change(function() {
        var val = $("#msgselect").val();
        if (val == "other") {
            $("#txtarea").show();
        } else {
            $("#txtarea").hide();
        }
    });

    $('#send_to').change(function() {
        if ($(this).val() == 2) {
            $('#customersGroup').removeClass('d-none');
            $('#customerNumbers').attr("required", true);
        } else {
            $('#customersGroup').addClass('d-none');
            $('#customerNumbers').attr("required", false);
        }
    });


    let broadcast_id;
    function openModal(element){
        broadcast_id = element.dataset.broadcast_id;
        // $('#deleteModal').modal('show');
    }

    function resendBroadcast(element){
        broadcast_id = element.dataset.broadcast_id;
        $(`#resend-${broadcast_id}`).submit();
    }

    function deleteBroadcast(){
        $(`#delete-${broadcast_id}`).submit();
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(".jstags").select2({
        theme: "classic",
        tags: true,
    });
</script>
 {{-- @if ( Cookie::get('is_first_time_user') == true) --}}
  {{-- <script>
        var broadcast_intro_shown = localStorage.getItem('broadcast_intro_shown');

        if (!broadcast_intro_shown) {

            const tour = new Shepherd.Tour({
                defaults: {
                    classes: "shepherd-theme-arrows"
                }
            });

            tour.addStep("step", {
                text: "Welcome to Broadcast Page, here you can send messages to your customers",
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
            localStorage.setItem('broadcast_intro_shown', 1);
        }
    </script> --}}
    {{-- @endif --}}
@stop