<div class="row">
    <div class="col-xl-4">
        <div class="card overflow-hidden">
            <div class="bg-soft-primary">
                <div class="row">
                    <div class="col-7">
                        <div class="text-primary p-3">
                            <h5 class="text-primary">{{ $assistant->storeName }}</h5>
                            <p>{{ $assistant->storeAddress }}</p>
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
                                    <h5 class="font-size-15">{{ $assistant->customerCount }}</h5>
                                    <p class="text-muted mb-0">Customers</p>
                                </div>

                            </div>
                            @if(\Cookie::get('user_role') != 'store_assistant')
                            <div class="mt-4">
                                <a href="#" 
                                class="btn btn-danger waves-effect waves-light btn-sm" 
                                data-toggle="modal"
                                data-assistant_id="{{$assistant->_id}}"
                                onclick="deleteAssistant(this)"
                                data-assistant_name="{{$assistant->user->name}}"
                                data-target="#deleteModal">Delete Assistant
                                </a>
                            </div>
                            {{-- delete assitant modal --}}
                            @include('backend.assistant.modals.deleteAssistant')
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end card -->

        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-4">Personal Information</h6>
                <div class="table-responsive">
                    <table class="table table-nowrap mb-0">
                        <tbody>
                            <tr>
                                <th scope="row">Full Name :</th>
                                <td>{{$assistant->user->name}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Mobile :</th>
                                <td>{{$assistant->user->phone_number}}</td>
                            </tr>
                            <tr>
                                <th scope="row">E-mail :</th>
                                <td>{{$assistant->user->email}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- end card -->

    </div>

    <div class="col-xl-8">
        <div class="row">

            <div class="col-md-4">
                <div class="card mini-stats-wid">
                    <div class="card-body">
                        <div class="media">
                            <div class="media-body">
                                <p class="text-muted font-weight-medium">Debt</p>
                                <h4 class="mb-0">{{format_money($assistant->debtAmount)}}</h4>
                            </div>

                            <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-primary">
                                <span class="avatar-title">
                                    <i class="uil-atm-card font-size-14"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-4">Total Transactions {{date('Y')}}</h6>
                <div id="transactionchart"></div>
            </div>
        </div>

    </div>
</div>
<!-- end row -->

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-4">Recent Transactions</h6>
                <div class="table-responsive">
                    <table class="table table-nowrap table-hover mb-0">
                        <thead>
                            <tr>
                                <th scope="col">#Ref ID</th>
                                <th scope="col">Customer Name</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Status</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($assistant->recentTransactions) == 0)
                            <tr>
                                <td colspan="4" class="text-center"> No Recent Transactions</td>
                            </tr>
                            @else
                            @foreach($assistant->recentTransactions as $transaction)

                            <tr>
                                <th scope="row">{{$transaction->_id}}</th>
                                <td>Customer Name <br> <span class="font-size-14">
                                        {{$transaction->customer_ref_id}}</span></td>
                                <td>{{ format_money($transaction->total_amount), $transaction->currency }}</td>
                                <td>Debt</td>
                                <td>
                                    <div class="btn-group mt-2 mr-1">
                                        <button type="button" class="btn btn-info dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions<i class="icon"><span data-feather="chevron-down"></span></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="">Send debt reminder</a>
                                            <a class="dropdown-item" href="">View Transaction</a>
                                        </div>
                                    </div>

                                </td>
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

@section("javascript")
<script src="/backend/assets/build/js/intlTelInput.js"></script>

{{-- <script src="/backend/assets/js/pages/dashboard.js"></script> --}}
<script>
    $(document).ready(function () {
        // start of transaction charts
        var options = {
            series: [{
                name: 'Transaction',
                data: {{json_encode($assistant->chart)}},
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

@if (Cookie::get('user_role') == "store_admin")
@include('backend.assistant.script.editAssistant');
@include('backend.assistant.script.deleteAssistant')
@endif

@endsection
