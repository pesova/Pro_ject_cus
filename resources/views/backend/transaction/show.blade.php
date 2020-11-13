@extends('layout.base')
@section("custom_css")
<link rel="stylesheet" href="{{ asset('/backend/assets/css/transac.css') }}">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
@stop
@section('content')

<div class="account-pages my-2">
    <div class="container-fluid">
        <div class="row-justify-content-center">
            @include('partials.alert.message')
            <div id="transaction_js">
                {{-- These are also found in the alert.message partial. I had to repeat it for the sake of JS see showAlertMessage() below--}}
            </div>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="row px-4 py-2 border-bottom align-items-center">
                                <div class="col-md-4">
                                    <h6 class="card-title">Transaction Overview - Created
                                        {{ app_format_date($transaction->date_recorded) }}</h6>
                                </div>
                                <div class="col-md-8 row text-center">
                                    @if($transaction->status != true && $transaction->type == 'debt')
                                    <a href="" data-toggle="modal" data-target="#sendReminderModal"
                                        class="col-md-3 offset-1 mt-1 btn btn-sm btn-warning">
                                        Send Reminder <i data-feather="send"></i>
                                    </a>
                                    @endif
                                    @if(Cookie::get('user_role') == 'store_admin')
                                    <a href="#" class="col-md-3 offset-1 mt-1 btn btn-sm btn-primary"
                                        data-toggle="modal" data-target="#editTransactionModal">
                                        Edit <i data-feather="edit-3"></i>
                                    </a>
                                    @if($transaction->type == 'paid')
                                    <a href="#" class="col-md-3 offset-1 mt-1 btn btn-sm btn-primary"
                                    data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"
                                    >

                                    Receipt <i data-feather="printer"></i>
                                    <div class="dropdown-menu">
                                        <button id="preview-receipt" class="dropdown-item notify-item">
                                            <i data-feather="film" class="icon-dual icon-xs mr-2"></i>
                                            <span>Preview</span>
                                        </button>
                                        <button id="download-receipt" class="dropdown-item notify-item">
                                            <i data-feather="download" class="icon-dual icon-xs mr-2"></i>
                                            <span>Download</span>
                                        </button>
                                        <button id="send-receipt" class="dropdown-item notify-item">
                                            <i data-feather="mail" class="icon-dual icon-xs mr-2"></i>
                                            <span>Send to Customer</span>
                                        </button>
                                    </div>
                                    </a>

                                <form  method="post" id="receipt-form">
                                     @csrf
                                     <input type="hidden" name="type" value="default" id="request-type">
                                     <input type="hidden" name="customer_email" value="{{$transaction->customer_ref->email}}">
                                     <input type="hidden" name="customer_name" value="{{$transaction->customer_ref->name}}">
                                     <input type="hidden" name="transaction_amount" value="{{ format_money($transaction->amount, $transaction->currency) }}">
                                     <input type="hidden" name="transaction_date" value="{{$transaction->date_recorded}}">
                                     <input type="hidden" name="transaction_description" value="{{$transaction->description}}">
                                </form>


                                    <a data-toggle="modal" data-target="#deleteModal" href=""
                                        class="col-md-3 offset-1 mt-1 btn btn-sm btn-danger">
                                        Delete <i data-feather="delete"></i>
                                    </a>
                                    @endif
                                    @endif
                                </div>
                            </div>
                            <div class="row p-3">
                                <div class="col-xl-3 col-sm-6">
                                    <!-- stat 1 -->
                                    <div class="media">
                                        <i data-feather="grid" class="align-self-center icon-dual icon-sm mr-2"></i>
                                        <div class="media-body">
                                            <h6 class="mt-0 mb-0">{{ $transaction->_id }}</h6>
                                            <span class="text-muted font-size-13">Transaction Reference code</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-sm-6">
                                    <!-- stat 2 -->
                                    <div class="media">
                                        <i data-feather="check-square"
                                            class="align-self-center icon-dual icon-sm mr-2"></i>
                                        <div class="media-body">
                                            <h6 class="mt-0 mb-0 text-capitalize">{{ $transaction->type }}</h6>
                                            <span class="text-muted">Transaction Type</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-sm-6">
                                    <!-- stat 3 -->
                                    <div class="media">
                                        <i data-feather="users" class="align-self-center icon-dual icon-sm mr-2"></i>
                                        <div class="media-body">
                                            <h6 class="m-0">
                                                <a
                                                    href="{{ route('customer.show', $transaction->store_ref_id.'-'.$transaction->customer_ref_id)}}">{{ $transaction->customer_ref->name }}
                                                </a>
                                            </h6>
                                            <span class="text-muted">Customer Name</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-sm-6">
                                    <!-- stat 3 -->
                                    <div class="media">
                                        <i data-feather="clock" class="align-self-center icon-dual icon-lg mr-2"></i>
                                        <div class="media-body">
                                            <h6 class="mt-0 mb-0">
                                                <h6 class="m-0">
                                                    <a href="tel:+{{ $transaction->customer_ref->phone_number }}">{{ $transaction->customer_ref->phone_number }}
                                                    </a>
                                                </h6>
                                            </h6>
                                            <span class="text-muted">Customer Phone Number</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end --}}

            <div class="col-xl-12 col-md-12 col-sm-12 pt-2">
                <div class="row">
                    <div class="col p-0">
                        <div class="card">

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 row">
                                        @if($transaction->type == 'debt')
                                        <div class="col-12">
                                            <span class="mb-0 font-size-18 font-weight-bolder">Expected Payment
                                                Date:</span>
                                            <span>
                                                {{ \Carbon\Carbon::parse($transaction->expected_pay_date)->format('Y-m-d') }}
                                                <span class="ml-2 font-size-16">{!!
                                                    app_format_date($transaction->expected_pay_date, true) !!}</span>
                                            </span>
                                        </div>
                                        @endif
                                        <div class=" col-12">
                                            <h6 class="mt-1">Description</h6>
                                            <textarea name="" readonly id="" cols="auto" rows="3" sty
                                                class="form-control w-100 flex-1">{{ $transaction->description }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row justify-content-between">
                                            <div class="list-group col-md-7">
                                                <h6 class="">Financial Details</h6>

                                                <div class="table-responsive">
                                                    <table class="table table-bordered mb-0">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">Amount</th>
                                                                <td colspan="2">
                                                                    {{ format_money($transaction->amount, $transaction->currency) }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Interest</th>
                                                                <td colspan="2">{{ $transaction->interest }} % / Yr</td>
                                                            </tr>
                                                            <tr class="font-weight-bolder">
                                                                <th scope="row">Total Amount</th>
                                                                <td colspan="2">
                                                                    {{ format_money($transaction->total_amount, $transaction->currency) }}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                            <div class="col-md-5 row">
                                                <div class="col-md-12">
                                                    <h6 class="">Business Name:</h6>
                                                    <p>
                                                        @if(Cookie::get('user_role') != 'store_assistant')
                                                        <a href="{{ route('store.show', $transaction->store_ref_id)}}"
                                                            class="mr-2 text-uppercase">
                                                            {{ $transaction->store_ref->store_name }}
                                                        </a>
                                                        @endif
                                                    </p>
                                                </div>
                                                @if($transaction->type == 'debt')
                                                <div class="col-md-12">
                                                    <h6 class="">Transaction Status:
                                                    </h6>
                                                    <label class="switch">
                                                        @if(Cookie::get('user_role') != 'store_assistant') disabled
                                                        <input type="checkbox" id="togBtn"
                                                            {{ $transaction->type == 'paid' ? 'checked' : '' }}
                                                            data-id="{{ $transaction->_id }}"
                                                            data-store="{{ $transaction->store_ref_id }}"
                                                            data-customer="{{ $transaction->customer_ref_id}}">
                                                        @else
                                                        <input type="checkbox" id="togBtn"
                                                            {{ $transaction->type == 'paid' ? 'checked' : '' }}
                                                            disabled>
                                                        @endif
                                                        <div class="slider round">
                                                            <span class="on">Paid</span><span class="off">Debt</span>
                                                        </div>
                                                    </label>
                                                    <div id="statusSpiner"
                                                        class="spinner-border spinner-border-sm text-primary d-none"
                                                        role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end --}}

            <div class="card mt-0">
                <div class="card-body">
                    <h6 class="">Debt Reminder History</h6>
                    <hr />
                    <div class="table-responsive table-data">
                        <table id="debtReminders" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Ref ID</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <th>Date Sent</th>
                                    @if($transaction->status != true)
                                    <th>Actions</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaction->debts as $index => $debt)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        {{ $debt->message }}
                                    </td>
                                    <td><span class="badge badge-success">{{ $debt->status }}</span></td>
                                    <td>{{ app_format_date($debt->createdAt) }}</td>
                                    @if($transaction->status != true)
                                    <td>
                                        <a href="" data-toggle="modal"
                                            onclick="return previousMessage('{{ $debt->message }}')"
                                            data-target="#ResendReminderModal" class="btn btn-primary btn-sm mt-2">
                                            Resend
                                        </a>
                                    </td>
                                    @endif
                                </tr>
                                {{-- Modal for resend reminder --}}
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- start of edit transaction modal --}}
            @include('partials.modal.editTransaction')

            {{-- Modal for send reminder --}}
            @include('partials.modal.sendReminder')

            {{-- Modal for resend reminder --}}
            @include('partials.modal.resendReminder')

            {{-- modal for delete transaction --}}
            @include('partials.modal.deleteTransaction')

        </div>
    </div>
</div>



@endsection

@section('javascript')
<script type="text/javascript"
    src="https://cdn.datatables.net/v/bs4/jq-3.3.1/jszip-2.5.0/dt-1.10.21/b-1.6.2/b-html5-1.6.2/datatables.min.js">
</script>

<script src="{{ asset('/backend/assets/js/textCounter.js')}}"></script>

<script>
    jQuery(function ($) {
        const token = "{{Cookie::get('api_token')}}"
        const host = "{{ env('API_URL', 'https://dev.api.customerpay.me') }}";

        $('#togBtn').change(function () {
            $(this).attr("disabled", true);
            $('#statusSpiner').removeClass('d-none');

            var id = $(this).data('id');
            var store = $(this).data('store');
            let _status = $(this).is(':checked') ? 1 : 0;
            let _type = $(this).is(':checked') ? 'paid' : 'debt';
            let _customer_id = $(this).data('customer');

            $.ajax({
                url: `${host}/transaction/update/${id}`,
                headers: {
                    'x-access-token': token
                },
                data: {
                    store_id: store,
                    status: _status,
                    type: _type,
                    customer_id: _customer_id,
                },
                type: 'PATCH',
            }).done(response => {
                if (response.success != true) {
                    $(this).prop("checked", !this.checked);
                    $('#error').show();
                    //alert("Oops! something went wrong.");
                    showAlertMessage('danger', 'Oops! something went wrong');
                }
                //alert("Operation Successful.");
                showAlertMessage('success', 'Operation successful');
                $(this).removeAttr("disabled")
                $('#statusSpiner').addClass('d-none');
            }).fail(e => {
                $(this).removeAttr("disabled")
                $(this).prop("checked", !this.checked);
                $('#statusSpiner').addClass('d-none');
               // alert("Oops! something went wrong.");
                showAlertMessage('danger', 'Oops! something went wrong');
            });
        });

        function removeAlertMessage() {
            setTimeout(function () {
                $(".alert").remove();
            }, 2000);
        }

        function showAlertMessage(type, message) {
            const alertMessage = ' <div id="transaction_js_alert" class="alert alert-' + type + ' show" role="alert">\n' +
                '                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                '                        <span aria-hidden="true" class="">&times;</span>\n' +
                '                    </button>\n' +
                '                    <strong class="">' + message + '</strong>\n' +
                '                </div>';
            $("#transaction_js").html(alertMessage);
            removeAlertMessage();
        }
    });

</script>

<script>
    // copy resend debt message

    function previousMessage(message) {
        $('#R_debtMessage').val(message);
    }

    // pagination for debts
    $(() => {
        $('#debtReminders').DataTable({

        });
    });



</script>
@if(Cookie::get('user_role') == 'store_admin')
<script>
    $("#send-receipt").click(function(){

        $("#receipt-form").attr("action","{{route('send_receipt',$transaction->_id)}}")
        $("#receipt-form").submit();
    })

    $("#preview-receipt").click(function(){
        $("#request-type").val('default');
        $("#receipt-form").attr("action","{{route('preview_receipt',$transaction->_id)}}")
        $("#receipt-form").submit();
    })


    $("#download-receipt").click(function(){
        $("#request-type").val('download');
        $("#receipt-form").attr("action","{{route('preview_receipt',$transaction->_id)}}")
        $("#receipt-form").submit();
    })

</script>
@endif

@endsection