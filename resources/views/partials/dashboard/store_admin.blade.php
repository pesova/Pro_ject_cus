@extends('layout.base')

@section('content')

<!-- Start Content-->
{{-- <div class="row page-title align-items-center">
    <div class="col-sm-4 col-xl-6">
        <h4 class="mb-1 mt-0">Dashboard</h4>
    </div>
</div> --}}
@include('partials.alert.message')
{{-- <div id="transaction_js"> --}}
    {{-- These are also found in the alert.message partial. I had to repeat it for the sake of JS see showAlertMessage() below--}}
{{-- </div> --}}

<div class="row my-4">
    {{-- <div class="col-xl-4">
        <div class=" card bg-soft-primary">
            <div class="row">
                <div class="col-7">
                    <div class="text-primary pl-3">
                        <h5 class="text-primary" id="store-name">{{ ucfirst($store->store_name) }} - Dashboard</h5>
                        <ul class="pl-3 mb-0">
                            <li class="py-1">Assistants: {{ $total_assistants }}</li>
                            <li class="pt-1">Customers: {{ $total_customers }}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-5 align-self-end">
                    <img src="/backend/assets/images/profile-img.png" alt="" class="img-fluid">
                </div>
            </div>
        </div>
    </div> --}}

    <div class="col-xl-8">
        <div class="row">
            <div class="col-sm-6">
                <a href="{{ route('store_debt', $store->_id) }}" class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted font-weight-medium">Total Debts</p>
                                <h4 class="mb-0">{{ format_money($total_debts, $currency) }}
                            </div>

                            <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                <span class="avatar-title">
                                    <i class="uil-atm-card font-size-14"></i>
                                </span>
                            </div>
                        </div>
                        <br>
                        <div class="d-flex">
                            <span class="badge badge-soft-primary font-size-12">
                                {{ $interest_debts }}%
                            </span>
                            <span class="ml-2 text-truncate text-primary">
                                total interest
                            </span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-6">
                <a href="{{ route('store_revenue', $store->_id) }}" class="card">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted font-weight-medium">Total Payments</p>
                                <h4 class="mb-0">{{ format_money($total_revenues, $currency) }}
                            </div>

                            <div class="mini-stat-icon avatar-sm align-self-center rounded-circle bg-primary">
                                <span class="avatar-title">
                                    <i class="uil-atm-card font-size-14"></i>
                                </span>
                            </div>
                        </div>
                        <br>
                        <div class="d-flex">
                            <span class="badge badge-soft-primary font-size-12">
                                {{ $interest_revenues }}%
                            </span>
                            <span class="ml-2 text-truncate text-primary">
                                total interest
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

{{-- <div class="row mb-4">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body px-3 ">
                <div class="text-center">
                    <h6>Business Card</h6>
                </div>
                <div class="row" id="gallery" data-toggle="modal" data-target="#businessCard1">
                    <div class="col-6 col-md-4 col-lg-12">
                        <img class="w-100" src="{{ asset('backend/assets/images/card_v2.PNG' )}}"
                            data-target=”#business_card data-slide-to="0">
                    </div>
                    <div class="col-6 col-md-4 col-lg-12">
                        <img class="w-100" src="{{ asset('backend/assets/images/card_vv1.PNG' )}}"
                            data-target=”#business_card data-slide-to="1">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="clearfix"></div>
                <h6 class="card-title mb-4 float-sm-left">Transaction Overview {{date('Y')}}</h6>
                <div id="transactionchart"></div>
            </div>
        </div>
    </div>
</div> --}}

<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-body">
                <div class="btn-group float-right">
                    <button type="button" class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown"
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
                <h4 class="card-title">{{ ucfirst($store->store_name) }} Transaction Overview</h4>
                <br>
                <div class="table-responsive table-data">
                    <table id="transactionTable" class="table table-striped table-bordered" style="width:100%">

                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Customer Name </th>
                                <th>Phone Number </th>
                                <th>Transaction Type</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th style="display: none">Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $index => $transaction)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <th>{{ $transaction->customer_ref->name }}<span class="co-name">
                                </th>
                                <td class="font-light">{{  $transaction->customer_ref->phone_number}}</td>
                                <td id="transaction-status">
                                    @if ($transaction->type == 'paid')
                                    Paid
                                    @elseif($transaction->type == 'debt')
                                    Debt
                                    @endif
                                </td>
                                <td>{{format_money($transaction->amount, $currency, $currency)}}</td>
                                <td>
                                    <label class="switch">
                                        @if(Cookie::get('user_role') != 'store_assistant') disabled
                                        <input class="togBtn" type="checkbox" id="togBtn"
                                            {{ $transaction->type == 'paid' ? 'checked' : '' }}
                                            data-id="{{ $transaction->_id }}"
                                            data-store="{{ $transaction->store_ref_id }}"
                                            data-customer="{{ $transaction->customer_ref_id}}">
                                        @else
                                        <input type="checkbox" id="togBtn"
                                            {{ $transaction->type == 'paid' ? 'checked': '' }} disabled>
                                        @endif
                                        <div class="slider round">
                                            <span class="on">Paid</span><span class="off">Pending</span>
                                        </div>
                                    </label>
                                    <div id="statusSpiner" class="spinner-border spinner-border-sm text-primary d-none"
                                        role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                </td>
                                <td style="display: none">
                                    {{ $transaction->status == true ? 'paid' : 'pending' }}
                                </td>
                                <td> <a href="{{ route('transaction.show', $transaction->_id.'-'.$transaction->store_ref_id.'-'.$transaction->customer_ref_id) }}"
                                        class="btn btn-primary waves-effect waves-light btn-sm"> View</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


            </div>
        </div>

    </div>
</div>

{{-- business card preview modal --}}
@include('backend.stores.modals.businessCard')

{{-- business card download modal --}}
@include('backend.stores.modals.downloadBusinessCard')

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
<script src="{{ asset('/backend/assets/js/textCounter.js')}}"></script>
<script src="{{ asset('/backend/assets/js/toggleStatus.js')}}"></script>

<script>
    $(document).ready(function () {
        // start of transaction charts
        var options = {
            series: [{
                name: 'Transaction',
                data: {{json_encode($chart)}},
            }],
            chart: {
                height: 350,
                type: 'line',
            },
            stroke: {
                width: 7,
                curve: 'smooth'
            },
            xaxis: {
                type: 'text',
                categories: ['JAN', 'FEB', 'MARCH', 'APRIL', 'MAY', 'JUNE', 'JULY', 'AUG',
                    'SEPT', 'OCT', 'NOV', 'DEC'
                ],
            },
            title: {
                text: '',
                align: 'left',
                style: {
                    fontSize: "16px",
                    color: '#666'
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    gradientToColors: ['#FDD835'],
                    shadeIntensity: 1,
                    type: 'horizontal',
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 100, 100, 100]
                },
            },
            markers: {
                size: 4,
                colors: ["#FFA41B"],
                strokeColors: "#fff",
                strokeWidth: 2,
                hover: {
                    size: 7,
                }
            },
            yaxis: {
                //min: -10,
                // max: 40,
                title: {
                    text: 'Transaction',
                },
            }
        };

        var chart = new ApexCharts(document.querySelector("#transactionchart"), options);
        chart.render();

    });
</script>

<script>
    $(document).ready(function () {
        let store_name = $("#store-name").text().trim();
        var export_filename = `${store_name} Transactions`;
        $('#transactionTable').DataTable({
            dom: 'frtipB',
            buttons: [{
                extend: 'excel',
                className: 'd-none',
                title: export_filename,
            }, {
                extend: 'pdf',
                className: 'd-none',
                title: export_filename,
                extension: '.pdf',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 6]
                }
            }]
        });
        $("#ExportReporttoExcel").on("click", function () {
            $('.buttons-excel').trigger('click');
        });
        $("#ExportReporttoPdf").on("click", function () {

            $('.buttons-pdf').trigger('click');
        });
    });

</script>

<script>
    jQuery(function ($) {
        const token = "{{Cookie::get('api_token')}}"
        const host = "{{ env('API_URL', 'https://dev.api.customerpay.me') }}";

        $('.togBtn').change(function () {
            $(this).attr("disabled", true);
            $('#statusSpiner').removeClass('d-none');

            var id = $(this).data('id');
            var store = $(this).data('store');
            let _status = $(this).is(':checked') ? 1 : 0;
            let _customer_id = $(this).data('customer');
            let _type = $(this).is(':checked') ? 'paid' : 'debt';
            let tr = $(this).parents('tr').find('#transaction-status');

            $(this).is(':checked') ? tr.html('Paid') : tr.html('Debt');

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
                showAlertMessage('success', 'Operation Successful.');
                $(this).removeAttr("disabled")
                $('#statusSpiner').addClass('d-none');
            }).fail(e => {
                $(this).removeAttr("disabled")
                $(this).prop("checked", !this.checked);
                $('#statusSpiner').addClass('d-none');
                showAlertMessage('danger', 'Oops! something went wrong');
                // alert("Oops! something went wrong.");
            });
        });

        function removeAlertMessage() {
            setTimeout(function () {
                $(".alert").remove();
            }, 2000);
        }

        function showAlertMessage(type, message) {
            const alertMessage = ' <div id="transaction_js_alert" class="alert alert-' + type +
                ' show" role="alert">\n' +
                '                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
                '                        <span aria-hidden="true" class="">&times;</span>\n' +
                '                    </button>\n' +
                '                    <strong class="">' + message + '</strong>\n' +
                '                </div>';
            $("#transaction_js").html(alertMessage);
            removeAlertMessage();
        }
    });

    $("#first_download_button").click(function () {
        $("#close-light-box").click();
    })

    $('#previewBtn').click(function () {
        console.log(1);
        let activeSlide = $(".carousel-item.active");
        let version = activeSlide.data('version');
        $(".version").val(version);
        $("#preview-form").submit();
    })

    $('#download').click(function () {
        let activeSlide = $(".carousel-item.active");
        let version = activeSlide.data('version');
        $(".version").val(version);
        $("#download-form").submit();
        $("#close-download-options").click();
    })

</script>

@if (is_super_admin())
@include('backend.stores.scripts.editStore')
@endif
@stop