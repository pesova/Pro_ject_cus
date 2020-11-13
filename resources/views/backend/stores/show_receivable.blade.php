@extends('layout.base')
@section("custom_css")
<link href="/backend/assets/build/css/intlTelInput.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
<link rel="stylesheet" href="{{asset('backend/assets/css/store_list.css')}}">
<link href="/backend/assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="/backend/assets/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="/backend/assets/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="/backend/assets/css/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@stop

@section('content')

<!-- Start Content-->

<div class="row page-title">
    <div class="col-md-12">
        <nav aria-label="breadcrumb" class="float-right mt-1">
            <a href="{{ url()->previous() }}" class="btn btn-primary go-back">Go Back</a>
        </nav>
        <h4 class="mt-2">My Business</h4>
    </div>
</div>

@include('partials.alert.message')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"> <span id="store-name">{{ucfirst($response['storeData']->store_name) }}</span> Receivable
                    Overview</h5>
                <div class="btn-group dropdown float-left">
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
                <div class="clear-fix"></div>
                <div class="table-responsive table-data">
                    <table id="receivableTable" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Customer Name </th>
                                <th data-priority="1">Amount</th>
                                <th data-priority="3">Transaction Type</th>
                                <th data-priority="3">Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($response['storeData']->customers as $customers)
                            @foreach ($customers->transactions as $index => $transaction)
                            @if ($transaction->type == "receivables" || $transaction->type == "Receivables")
                            <tr>
                                <td>{{ $index }}</td>
                                <th>{{ $customers->name }}<span class="co-name"></span>
                                    <br> <span class="font-light">{{$customers->phone_number}}</span>
                                </th>
                                <td>{{ format_money($transaction->amount, $transaction->currency) }}</td>
                                <td>{{ $transaction->type }}</td>
                                <td>{{ app_format_date($transaction->date_recorded) }}</td>
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
</div> <!-- end col -->
</div> <!-- end row -->

@endsection

@section("javascript")
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="/backend/assets/build/js/intlTelInput.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jq-3.3.1/jszip-2.5.0/dt-1.10.21/b-1.6.2/b-html5-1.6.2/datatables.min.js">
</script>
<script>
    $(document).ready(function() {
        let store_name = $("#store-name").text().trim();
        var export_filename = `${store_name} Receivables`;
        $('#receivableTable').DataTable({
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
                    columns: [0, 1, 2, 3, 4]
                }
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