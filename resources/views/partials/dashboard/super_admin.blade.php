<div class="row">
    <div class="col-xl-4">
        <div class="card overflow-hidden">
            <div class="bg-soft-primary">
                <div class="row">
                    <div class="col-7">
                        <div class="text-primary p-3">
                            <h5 class="text-primary">
                                Welcome Super Admin</h5>
                        </div>
                    </div>
                    <div class="col-5 align-self-end">
                        <img src="/backend/assets/images/profile-img.png" alt="" class="img-fluid">
                    </div>
                </div>
            </div>

            <div class="card-body pt-0">
                <div class="row">

                    <div class="col-sm-8">
                        <div class="pt-4">

                            <div class="row">
                                <div class="col-6">
                                    <h5 class="font-size-15">{{ $data->usersCount }}</h5>
                                    <p class="text-muted mb-0">User(s)</p>
                                </div>
                                <div class="col-6">
                                    <h5 class="font-size-15">{{ $data->storesCount }}</h5>
                                    <p class="text-muted mb-0">Business(es)</p>
                                </div>
                            </div>
                            <div class="mt-4">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8">
        <div class="row">
            <div class="col-md-4"><a href="{{ route('store.index') }}">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Business Admin</p>
                                    <h4 class="mb-0">{{$data->storeAdminCount}}</h4>
                                </div>

                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary align-self-center">
                            <span class="avatar-title">
                                <i class="uil-atm-card font-size-14"></i>
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4"><a href="{{ route('assistants.index') }}">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Assistants</p>
                                    <h4 class="mb-0">{{$data->assistantsCount}}</h4>
                                </div>

                                <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-primary">
                                <i class="uil-atm-card font-size-14"></i>
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

            </div>
            <div class="col-md-4"><a href="{{ route('customer.index') }}">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Customers</p>
                                    <h4 class="mb-0">{{$data->customerCount}}</h4>
                                </div>

                                <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-primary">
                                <i class="uil-atm-card font-size-14"></i>
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4"><a href="{{ route('debtor.index') }}">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Debts</p>
                                    <h4 class="mb-0">{{$data->totalDebt}}</h4>
                                </div>

                                <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-primary">
                                <i class="uil-atm-card font-size-14"></i>
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4"><a href="{{ route('transaction.index') }}">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Transactions</p>
                                    <h4 class="mb-0">{{$data->transactionCount}}</h4>
                                </div>

                                <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-primary">
                                <i class="uil-atm-card font-size-14"></i>
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4"><a href="{{ route('complaint.index') }}">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted font-weight-medium">Complaints</p>
                                    <h4 class="mb-0">{{$data->complaintCount}}</h4>
                                </div>

                                <div class="avatar-sm rounded-circle bg-primary align-self-center mini-stat-icon">
                            <span class="avatar-title rounded-circle bg-primary">
                                <i class="uil-atm-card font-size-14"></i>
                            </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <!-- end row -->

    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-4 float-sm-left">Net Income {{date('Y')}}</h6>
                <div class="clearfix"></div>
                <div id="revenueChart"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-4 float-sm-left">Transaction Overview {{date('Y')}}</h6>
                <div class="clearfix"></div>
                <div id="transactionchart"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-sm-12">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-4 float-sm-left">Users Registered {{date('Y')}}</h6>
                <div class="clearfix"></div>
                <div id="usersChart"></div>
            </div>
        </div>
    </div>
</div>


<!-- products -->
<div class="row">

    <div class="col-12">
        <div class="card">
            <div class="card-body pt-2">
                <h5 class="mb-4 header-title">Latest Debts</h5>
                <div style="display:flex; justify-content:center; text-align:center; width:100%"
                     class='mt-2 mb-3 debts-error'>
                </div>

                <div class="debts-table">
                    <table id="debtorsTable" class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Transaction Ref ID</th>
                            <th>Status</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($data->latestDebt) > 0)
                            @foreach ($data->latestDebt as $index => $debtor )
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <a class=""
                                           href="{{ route('debtor.show', $debtor->_id) }}">
                                            {{ $debtor->_id }}
                                        </a>
                                    </td>
                                    </td>
                                    <td>
                                        @if($debtor->status == false)
                                            <span class="badge badge-danger">Unpaid</span>
                                        @else
                                            <span class="badge badge-success">Paid</span>
                                        @endif
                                    </td>
                                    <td>{{ $debtor->description }}</td>
                                    <td>{{ format_money($debtor->total_amount, $debtor->currency) }}</td>
                                    <td> {!! app_format_date($debtor->date_recorded) !!}</td>
                                    <td>
                                        <a class="btn btn-info btn-small py-1 px-2"
                                           href="{{ route('debtor.show', $debtor->_id) }}">
                                            More
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4" class="text-center">No Recent Debts</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->

@section("javascript")
    {{-- <script src="/backend/assets/js/pages/dashboard.js"></script> --}}
    <script type="text/javascript"
            src="https://cdn.datatables.net/v/bs4/jq-3.3.1/jszip-2.5.0/dt-1.10.21/b-1.6.2/b-html5-1.6.2/datatables.min.js">
    </script>
    <script>
        $(document).ready(function () {
            let income_per_month = <?php echo json_encode($data->incomePerMonth);?>;
            let users_per_month = <?php echo json_encode($data->usersPerMonth);?>;
            let transactions_per_month = <?php echo json_encode($data->transactionsPerMonth);?> ;
            let calendar_months_abbreviated = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                'Nov', 'Dec'
            ]

            // start of transaction charts
            var options = {
                series: [{
                    name: 'Transaction',
                    data: transactions_per_month,
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
                    categories: calendar_months_abbreviated,
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

            var transactionChart = new ApexCharts(document.querySelector("#transactionchart"), options);
            transactionChart.render();

            var usersOptions = {
                series: [{
                    name: "Users",
                    data: users_per_month
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: true
                },
                stroke: {
                    curve: 'smooth'
                },
                title: {
                    text: '',
                    align: 'left'
                },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: calendar_months_abbreviated,
                }
            };

            var usersChart = new ApexCharts(document.querySelector("#usersChart"), usersOptions);

            usersChart.render();
            var revenueOptions = {
                series: [{
                    name: "Revenue",
                    data: income_per_month
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                title: {
                    text: '',
                    align: 'left'
                },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: calendar_months_abbreviated,
                }
            };

            var revenueChart = new ApexCharts(document.querySelector("#revenueChart"), revenueOptions);
            revenueChart.render();

            var export_filename = 'Mycustomerdebts';
            $('#debtorsTable').DataTable({
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

    {{-- @if ( Cookie::get('is_first_time_user') == true) --}}
    {{-- <script>
        var dashboard_intro_shown = localStorage.getItem('dashboard_intro_shown');

        if (!dashboard_intro_shown) {

            const tour = new Shepherd.Tour({
                defaults: {
                    classes: "shepherd-theme-arrows"
                }
            });

            tour.addStep("step", {
                text: "Welcome to mycustomer web app.",
                buttons: [{
                    text: "Next",
                    action: tour.next
                }]
            });

            tour.addStep("step2", {
                text: "first, create a store",
                attachTo: {
                    element: ".second",
                    on: "left"
                },
                buttons: [{
                    text: "Next",
                    action: tour.next
                }],

                beforeShowPromise: function () {
                    document.body.className += ' sidebar-enable';
                    document.getElementById('sidebar-menu').style.height = 'auto';
                },
            });
            tour.addStep("step3", {
                text: "Then create a customer",
                attachTo: {
                    element: ".third",
                    on: "left"
                },
                buttons: [{
                    text: "Next",
                    action: tour.next
                }]
            });
            tour.addStep("step4", {
                text: "create your transaction",
                attachTo: {
                    element: ".fourth",
                    on: "left"
                },
                buttons: [{
                    text: "Next",
                    action: tour.next
                }]
            });
            tour.addStep("step5", {
                text: "Send broadcast messages here",
                attachTo: {
                    element: ".fifth",
                    on: "left"
                },
                buttons: [{
                    text: "Next",
                    action: tour.next
                }]
            });
            tour.addStep("step6", {
                text: "make your complaints here",
                attachTo: {
                    element: ".sixth",
                    on: "left"
                },
                buttons: [{
                    text: "Next",
                    action: tour.next
                }]
            });

            // tour.addStep("step7", {
            //     text: "manage your stores",
            //     attachTo: {element: ".seventh", on: "right"},
            //     buttons: [
            //         {
            //             text: "Next",
            //             action: tour.next
            //         }
            //     ]
            // });

            tour.start();
            localStorage.setItem('dashboard_intro_shown', 1);
        }

    </script> --}}

    <script>
        /*  ==========================================
        SHOW UPLOADED IMAGE
    * ========================================== */
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#imageResult')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $(function () {
            $('#upload').on('change', function () {
                readURL(input);
            });
        });

        /*  ==========================================
            SHOW UPLOADED IMAGE NAME
        * ========================================== */
        var input = document.getElementById('upload');
        var infoArea = document.getElementById('upload-label');

        input.addEventListener('change', showFileName);

        function showFileName(event) {
            var input = event.srcElement;
            var fileName = input.files[0].name;
            infoArea.textContent = fileName;
        }

    </script>


    {{--@endif--}}

@endsection