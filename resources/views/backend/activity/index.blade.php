@extends('layout.base')
@section("custom_css")
<link href="/backend/assets/build/css/intlTelInput.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
@stop
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="mb-0 d-flex justify-content-between align-items-center page-title bg-white">
            <div class="h6 mx-3">
                <i data-feather="file-text" class="icon-dual"></i> Activity Log
            </div>
        </div>
        @include('partials.alert.message')
        <div class="card mt-0">
            <div class="card-header">
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class='uil uil-file-alt mr-1'></i>Export
                        <i class="icon"><span data-feather="chevron-down"></span></i></button>
                    <div class="dropdown-menu dropdown-menu-right">
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
            <div class="card-body">
                <div class="table-responsive table-data">
                    <table id="activityTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Activity Ref ID</th>
                                <th>User</th>
                                <th>description</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($activities as $index => $activity)
                            {{-- {{ dd($activities) }} --}}
                            @php
                            $user = $activity->creator_ref->local;
                            @endphp
                            <tr>
                                <td>
                                    {{ $index + 1 }}
                                </td>
                                <td>
                                    {{ $activity->_id }}
                                </td>
                                <td>
                                    @if ($user->user_role == 'store_assistant')
                                    <a class="" href="{{ route('assistants.show', $activity->creator_ref->_id) }}">
                                        {{ $user->name  }}
                                    </a> <br />
                                    <span class="badge badge-warning"> {{ $user->user_role }} </span>
                                    @elseif($user->user_role == 'store_admin')
                                    <a class="" href="{{ route('users.show', $activity->creator_ref->_id) }}">
                                        {{ $user->first_name  }} {{ $user->last_name }}
                                    </a> <br />
                                    <span class="badge badge-success"> {{ $user->user_role }} </span>
                                    @else
                                    <a class="" href="{{ route('users.show', $activity->creator_ref->_id) }}">
                                        {{ $user->first_name  }} {{ $user->last_name }}
                                    </a> <br />
                                    <span class="badge badge-danger"> {{ $user->user_role }} </span>

                                    @endif
                                </td>
                                <td>
                                    {{ $activity->originalUrl }}
                                </td>
                                <td>
                                    {{ Carbon\Carbon::parse($activity->createdAt)->format('Y-m-d H:i:s') }}
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

@endsection

@section("javascript")
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/eonasdan-bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
</script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript"
    src="https://cdn.datatables.net/v/bs4/jq-3.3.1/jszip-2.5.0/dt-1.10.21/b-1.6.2/b-html5-1.6.2/datatables.min.js">
</script>
<script>
    $(document).ready(function () {
        var export_filename = 'CustomerPayme Activity Log';
        $('#activityTable').DataTable({
            dom: 'frtipB',
            buttons: [{
                extend: 'excel',
                className: 'd-none',
                title: export_filename,
            }, {
                extend: 'pdf',
                className: 'd-none',
                title: export_filename,
                extension: '.pdf'
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
@stop