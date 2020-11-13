@extends('layout.base')

@section("custom_css")
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="css/icons.min.css" rel="stylesheet" type="text/css" />
<link href="css/app.min.css" rel="stylesheet" type="text/css" />
<link href="/backend/assets/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="/backend/assets/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="/backend/assets/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="/backend/assets/css/select.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@stop

@section('content')
<div class="container-fluid">
    <div class="content">
        <div class="container-fluid">
            @include('partials.alert.message')
           
            @if (is_super_admin())
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Tickets</p>
                                    <h4 class="mb-0">{{count($responses->data)}}</h4>
                                </div>

                                <div class="mini-stat-icon avatar-sm align-self-center rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="uil-notes font-size-14"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body" data-toggle="tooltip" data-placement="bottom" title="Total amount includes interest">
                                    <p class="text-muted font-weight-medium">Pending</p>
                                    <h4 class="mb-0">
                                        {{$responses->complaintCounts->pending}}
                                    </h4>
                                </div>

                                <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="uil-notes font-size-14"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Solved</p>
                                    <h4 class="mb-0">{{$responses->complaintCounts->resolved}}</h4>
                                </div>

                                <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                    <span class="avatar-title">
                                        <i class="uil-notes font-size-14"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- end row -->
    @endif
            <div class="card" style="margin-top: 10px;">
                <div id="wrapper">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">

                                <div class="card-body">

                                    <a href="{{ route('complaint.create') }}" class="btn btn-primary float-right">
                                        new Ticket &nbsp;<i class="fa fa-plus my-float"></i>
                                    </a>
                                    <h4 class="header-title mt-0 mb-1">Tickets Submitted</h4>
                                    <p class="sub-header">
                                        This is the list of all tickets submitted:
                                    </p>
                                    <table id="basic-datatable" class="table dt-responsive">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th style="max-width: 120px;">Ticket ID</th>
                                                <th>Subject</th>
                                                <th>Status</th>
                                                <th style="min-width: 90px;">Date</th>
                                                @if (is_super_admin())
                                                <th>Action</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (is_super_admin())
                                            
                                            @foreach($responses->data as $index => $response)
                                            
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><a href="{{ route('complaint.show', $response->_id) }}">{{ $response->_id}}</a>
                                                </td>
                                                <td>{{ $response->subject}}</td>
                                                <td>
                                                    @if ( $response->status == 'New' )
                                                    <div class="badge badge-pill badge-secondary">New</div>
                                                    @elseif ( $response->status == 'Pending' )
                                                    <div class="badge badge-pill badge-primary">Pending</div>
                                                    @elseif ( $response->status == 'Resolved' )
                                                    <div class="badge badge-pill badge-success">Resolved</div>
                                                    @elseif ( $response->status == 'Closed' )
                                                    <div class="badge badge-pill badge-dark">Closed</div>
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($response->date)->diffForHumans() }}</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a id="downloadLink" href="{{ route('complaint.edit', $response->_id) }}" class=" dropdown-item notify-item">
                                                                <span>Update Status</span>
                                                            </a>
                                                            <a  href="#" data-toggle="modal"
                                                               data-target="#deleteModal-{{$response->_id}}" class="text-danger dropdown-item notify-item">
                                                                <span>Delete</span>
                                                            </a>
                                                        </div>
                                                        @include('partials.modal.complaint.deleteComplaint')
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            @foreach($responses->data->complaints as $index => $response)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><a href="{{ route('complaint.show', $response->_id) }}">{{ $response->_id}}</a>
                                                </td>
                                                <td>{{ $response->subject}}</td>
                                                <td>
                                                    @if ( $response->status == 'New' )
                                                    <div class="badge badge-pill badge-secondary">New</div>
                                                    @elseif ( $response->status == 'Pending' )
                                                    <div class="badge badge-pill badge-primary">Pending</div>
                                                    @elseif ( $response->status == 'Resolved' )
                                                    <div class="badge badge-pill badge-success">Resolved</div>
                                                    @elseif ( $response->status == 'Closed' )
                                                    <div class="badge badge-pill badge-dark">Closed</div>
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($response->date)->diffForHumans() }}</td>
                                            </tr>
                                            @endforeach
                                            @endif
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
</div>
@endsection


@section("javascript")

<!-- datatable js -->
<script src="/backend/assets/libs/datatables/jquery.dataTables.min.js"></script>
<script src="/backend/assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
<script src="/backend/assets/libs/datatables/dataTables.responsive.min.js"></script>
<script src="/backend/assets/libs/datatables/responsive.bootstrap4.min.js"></script>

<script src="/backend/assets/libs/datatables/dataTables.buttons.min.js"></script>
<script src="/backend/assets/libs/datatables/buttons.bootstrap4.min.js"></script>
<script src="/backend/assets/libs/datatables/buttons.html5.min.js"></script>
<script src="/backend/assets/libs/datatables/buttons.flash.min.js"></script>
<script src="/backend/assets/libs/datatables/buttons.print.min.js"></script>

<script src="/backend/assets/libs/datatables/dataTables.keyTable.min.js"></script>
<script src="/backend/assets/libs/datatables/dataTables.select.min.js"></script>

<!-- Datatables init -->
<script src="/backend/assets/js/pages/datatables.init.js"></script>
{{-- @if (\Illuminate\Support\Facades\Cookie::get('is_first_time_user') == true) --}}
{{-- <script>
    var complaints_intro_shown = localStorage.getItem('complaints_intro_shown');

    if (!complaints_intro_shown) {

        const tour = new Shepherd.Tour({
            defaults: {
                classes: "shepherd-theme-arrows"
            }
        });

        tour.addStep("step", {
            text: "Welcome to Complaints Page, here you can make your complaints",
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
        localStorage.setItem('complaints_intro_shown', 1);
    }
</script> --}}
{{-- @else --}}
@stop