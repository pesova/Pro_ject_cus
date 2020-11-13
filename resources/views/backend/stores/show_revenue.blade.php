@extends('layout.base')
@section("custom_css")
<link href="/backend/assets/build/css/intlTelInput.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
<link rel="stylesheet" href="{{ asset('backend/assets/css/store_list.css') }}">
<link href="/backend/assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="/backend/assets/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="/backend/assets/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="/backend/assets/css/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@stop

@section('content')

<!-- Start Content-->

<div class="row page-title">
    <div class="col-md-12">
        <h4 class="mt-2">My Business</h4>
        <div class="btn-group dropdown float-right">
            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                <i class='uil uil-file-alt mr-1'></i>Export
                <i class="icon"><span data-feather="chevron-down"></span></i></button>
            <div class="dropdown-menu">
                <button id="ExportReporttoExcel" class="dropdown-item notify-item">
                    <i data-feather="file" class="icon-dual icon-xs mr-2"></i>
                    <span>Excel</span>
                </button>
                <button id="ExportReporttoPdf" class="dropdown-item notify-item">
                    <i data-feather="file" class="icon-dual icon-xs mr-2"></i>
                    <span>PDF</span>
                </button>
            </div>
        </div>
        
    </div>
</div>

@include('partials.alert.message')

<div class="row">
    <div class="col-12">
        <div class="card ">
            <div class="card-body">
                <h5 class="card-title"><span id="store-name">{{ucfirst($response['storeData']->store_name) }}</span>  Revenue Overview</h5>
                
                <div class="clear-fix"></div>
                    <div class="table-responsive table-data">
                        @if(!is_store_assistant())
                    <a href="#" class="btn btn-primary float-left btn-sm" data-toggle="modal" data-target="#addTransactionModal">
                        New &nbsp;<i class="fa fa-plus my-float"></i>
                    </a>
                    @include('partials.modal.addTransaction',['title'=>'Add New
                    Payment','type'=>'transaction','buttonText'=>'Add Payment'])
                @endif
                        <table id="revenueTable" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Customer Name </th>
                                            <th data-priority="1">Amount</th>
                                            <th data-priority="3">Transaction Type</th>
                                            <th>Due</th>
                                            <th data-priority="3">Created</th>
                                            <th data-priority="3"> </th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                        @foreach ($response['storeData']->customers as $customers)
                                        
                                        @foreach ($customers->transactions as $index => $transaction)  
                                        @if ($transaction->type == "paid" || $transaction->type == "Paid")
                                        
                                        <tr>{{-- <a
                                        href="{{ route('customer.show', $customers->store_ref_id .'-' .$customers->customer_ref_id) }}">
                                        {{ $customers->name }}</a> --}}
                                            <td>{{ $index }}</td>
                                            <th><a
                                        href="{{ route('customer.show', $customers->store_ref_id .'-' .$transaction->customer_ref_id) }}">
                                        {{ $customers->name }}</a><span class="co-name"></span>
                                            </th>
                                            <td>{{ format_money($transaction->amount, $transaction->currency) }}</td>
                                            <td>{{ $transaction->type }}</td>
                                            <td>{!! app_format_date($transaction->expected_pay_date, true) !!}</td>
                                            <td>{{ app_format_date($transaction->date_recorded) }}</td>
                                            <td><a class="btn btn-primary btn-sm py-1 px-2"
                                        href="{{ route('transaction.show', $transaction->_id.'-'.$transaction->store_ref_id.'-'.$transaction->customer_ref_id) }}">
                                        View
                                         </a></td>
                                        </tr> 
                                        @endif
                                        @endforeach
                                        @endforeach
                                        </tbody>
                                    </table>
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
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="/backend/assets/build/js/intlTelInput.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript"
    src="https://cdn.datatables.net/v/bs4/jq-3.3.1/jszip-2.5.0/dt-1.10.21/b-1.6.2/b-html5-1.6.2/datatables.min.js">
</script>
@if(is_store_admin())
    <script>
        jQuery(function ($) {
            get_customers("{{Cookie::get('store_id')}}");
        });
    </script>
@endif
<script>
    function get_customers(storeID) {
        const token = "{{Cookie::get('api_token')}}";
        const host = "{{ env('API_URL', 'https://dev.api.customerpay.me') }}";
        jQuery.ajax({
            url: host + "/store/" + encodeURI(storeID),
            type: "GET",
            dataType: "json",
            contentType: 'json',
            headers: {
                'x-access-token': token
            },
            success: function (data) {
                var new_data = data.data.store.customers;
                var i;
                new_data.forEach(customer => {
                    $('select[name="customer"]').append('<option value="' +
                        customer._id + '">' +
                        customer.name + '</option>');
                });
            }
        });
    }
</script>
<script>
   $(document).ready(function() {
        let store_name = $("#store-name").text().trim();
        var export_filename = `${store_name} Revenue`;
        $('#revenueTable').DataTable({
            dom: 'frtipB',
            buttons: [{
                    extend: 'excel',
                    className: 'd-none',
                    title: export_filename,
                },
                {
                    extend: 'pdf',
                    className: 'd-none',
                    title: export_filename,
                    extension: '.pdf'
                    // exportOptions: {
                    //     columns: [0, 1, 2, 3, 4]
                    // }
            }]
        });
        $("#ExportReporttoExcel").on("click", function() {
            $('.buttons-excel').trigger('click');
        });
        $("#ExportReporttoPdf").on("click", function() {

            $('.buttons-pdf').trigger('click');
        });
    });
   
</script>
@stop