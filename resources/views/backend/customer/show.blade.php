{{-- inherits base markup --}}
{{-- got my page working im so excited --}}
@extends('layout.base')
{{-- add in the basic styling : check the contents of these stylesheets later --}}
@section("custom_css")
<link rel="stylesheet" href="{{asset('backend/assets/css/singleCustomer.css')}}">
@stop


{{-- yield body content --}}

@section('content')
<div class="content">

    <div class="container-fluid">
        {{-- start of page title --}}
        @include('partials.alert.message')
        <div class="page-title">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="mb-1 mt-0 ">Customer Profile</h6>
                </div>
                <div>
{{--                   
                    @if(Cookie::get('user_role') == 'store_admin')
                    <a href="{{ route('customer.edit', $customer->storeId.'-'.$customer->customer->_id ) }}"
                        class="mr-2 btn btn-success btn-sm">
                        Edit Customer
                    </a>
                    @endif --}}
                    <a href="{{ URL::previous() }}" class="btn btn-primary btn-sm">
                        Go Back
                    </a>
                </div>
            </div>
        </div>
        {{-- end of page title --}}
        <div class="row">
            <div class="col-xl-4">
                {{-- <div class="card overflow-hidden">
                    <div class="bg-soft-primary">
                        <div class="row">
                            <div class="col-7">
                                <div class="text-primary p-3">
                                    @if(!is_store_assistant())
                                     <!--Checks are for super admin because vvariable naming is different from admin-->
                                    <h5 class="text-primary">
                                        <a
                                            href="{{ route('store.show', isset($customer->storeId) ? $customer->storeId : $customer->customer->store_ref_id) }}">
                                            {{ isset($customer->storeName) ? $customer->storeName : $customer->customer->store_name }}
                                        </a></h5>
                                    @else
                                    <h5 class="text-primary">{{ $customer->storeName }}</h5>
                                    @endif
                                    <p>Business Name</p>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="/backend/assets/images/profile-img.png" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="pt-4">

                                    <div class="row">
                                        <div class="col-6">
                                            <h5 class="font-size-15">{{ $result->transactions }}</h5>
                                            <p class="text-muted mb-0">Transactions</p>
                                        </div>
                                        <div class="col-6">
                                            <h5 class="font-size-15">
                                               <!--  doug - we need to specify currency concerned-->
                                                {{ format_money($result->total_revenue) }}</h5>
                                            <p class="text-muted mb-0">Payments</p>
                                        </div>
                                    </div>
                                    @if(is_store_admin())
                                    <div class="mt-4">
                                        <a href="#" data-toggle="modal" data-target="#DeleteModal"
                                            class="btn btn-danger btn-sm">Delete Customer
                                        </a>
                                        <div id="DeleteModal" class="modal fade bd-example-modal-sm" tabindex="-2"
                                            role="dialog" aria-labelledby="DeleteModal" aria-hidden="true">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="Title">
                                                            Delete Customer </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Do you want to delete {{$customer->customer->name}}?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form
                                                            action="{{ route('customer.destroy', $customer->customer->_id) }}"
                                                            method="POST" id="form">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button type="submit" class="btn btn-primary btn-danger">
                                                                Delete
                                                            </button>
                                                        </form>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Cancel
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <!-- end card -->

                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title mb-4">Personal Information</h6>
                        <div class="table-responsive">
                            <table class="table table-nowrap mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="row">Full Name :</th>
                                        <td>{{ucfirst($customer->customer->name)}}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Mobile :</a></th>
                                        <td>
                                            <a href="tel:+{{ $customer->customer->phone_number }}">{{ $customer->customer->phone_number }}
                                        </td>
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
                                    <div class="media-body" data-toggle="tooltip" data-placement="bottom"
                                        title="Total amount includes interest">
                                        <p class="text-muted font-weight-medium">Total Debts</p>
                                           <!--we need to calculate by currency-->
                                        <h4 class="mb-0">{{ format_money($result->total_debt ) }}</h4>
                                    </div>

                                    <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-warning">
                                        <span class="avatar-title">
                                            <i class="uil-atm-card font-size-14"></i>
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
                                        <p class="text-muted font-weight-medium">Total Payments</p>
                                         <!-- we need to calculate by currency -->
                                        <h4 class="mb-0">{{ format_money($result->total_revenue ) }}</h4>
                                    </div>

                                    <div class="avatar-sm align-self-center mini-stat-icon rounded-circle bg-success">
                                        <span class="avatar-title">
                                            <i class="uil-atm-card font-size-14"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- <div class="card">
                    <div class="card-body pb-5">
                        <h6 class="card-title mb-4 float-left">Transactions</h6>
                        <div class="clear"></div>
                        <div id="customer-chart" class="apex-charts mt-5" style="min-height: 365px;"></div>
                    </div>
                </div> --}}

            </div>
        </div>
        <!-- end row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-4">
                             <a href="#"
                                class="mr-2 btn btn-primary btn-sm float-right"
                                data-toggle="modal"
                                data-target="#debtModal"
                                
                                >
                                <i class='uil uil-money-insert'
                                ></i>
                                
                                Add Debt
                            </a>
                            <a href="#"
                            data-toggle="modal"
                            data-target="#paymentModal"
                                class="mr-2 btn btn-primary btn-sm float-right">
                                <i class='uil uil-money-withdraw'></i>
                                Add Payment
                            </a>
                        </div>
                        <h6 class="card-title mb-4">Recent Transactions</h6>
                        
                        
                        <div class="table-responsive">
                            <table class="table table-nowrap table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th scope="col">#Ref ID</th>
                                        <th scope="col">Transaction Type</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Status</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($customer->customer->transactions as $transaction)
                                    <tr>
                                        <th scope="row">{{ $transaction->_id }}</th>
                                        <td>{{ $transaction->type }}</td>
                                        <td>{{ format_money($transaction->total_amount, $transaction->currency) }}</td>
                                        <td>
                                            @if($transaction->status == false)
                                            <span class="badge badge-danger">Unpaid</span>
                                            @else
                                            <span class="badge badge-success">Paid</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a class="btn btn-info btn-sm py-1 px-2"
                                                href="{{ route('transaction.show', $transaction->_id.'-'.$transaction->store_ref_id.'-'.$transaction->customer_ref_id) }}">
                                                View More
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center"> No Recent Transactions</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="debtModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addTransactionModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h5 class="modal-title" id="addTransactionModalLabel">Add Debt</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" id="add-debt" method="POST"
                      action="{{ route('transaction.store') }}">
                    @csrf
                    <div class="form-group row mb-3">
                        @if(is_store_admin())
                            <input type="hidden" name="store" value="{{Cookie::get('store_id')}}">
                        @endif
                    <input type="hidden" name="customer" value="{{$customer->customer->_id}}">
                    </div>


                    <div class="form-group row mb-3">
                        <label for="amount" class="col-md-3 col-form-label">Amount</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control" id="amount" name="amount" placeholder="0000"
                                   required min="0" value="{{ old('amount') }}">
                        </div>
                    </div>
                    
                        <div class="form-group row mb-3">
                            <label for="interest" class="col-md-3 col-form-label">Interest</label>
                            <div class="col-md-9">
                                <input type="number" class="form-control" id="interest" name="interest" placeholder="0%"
                                       value="{{ old('interest') }}">
                            </div>
                        </div>
                    <div class="form-group row mb-3">
                        <label for="description" class="col-md-3 col-form-label">Description</label>
                        <div class="col-md-9">
                            <textarea name="description" class="counter form-control" id="description"
                                      placeholder="description..." maxlength="140">{{ old('description') }}</textarea>
                            <p class="charNum m-0 p-0 h6 text-capitalize"></p>
                        </div>
                    </div>
                        <div class="form-group row mb-3">
                            <label for="pay_date" class="col-md-3 col-form-label">Expected Pay Date</label>
                            <div class="col-md-9">
                                <input type="date" class="form-control" id="expected_pay_date" name="expected_pay_date"
                                       min="2019-02-06" value="{{ old('expected_pay_date') }}">
                            </div>
                        </div>
                        <input id="type" name="type" value="debt" type="hidden"/>
                   

                    <div class="form-group mb-0 justify-content-end row">
                        <div class="col-md-9">
                            <button type="submit" class="btn btn-primary btn-block ">Add Debt</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>


<div id="paymentModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addTransactionModalLabel"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <h5 class="modal-title" >Add Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" id="add-payment" method="POST"
                      action="{{ route('transaction.store') }}">
                    @csrf
                    <div class="form-group row mb-3">
                        @if(is_store_admin())
                            <input type="hidden" name="store" value="{{Cookie::get('store_id')}}">
                        @endif
                    <input type="hidden" name="customer" value="{{$customer->customer->_id}}">
                    </div>


                    <div class="form-group row mb-3">
                        <label for="amount" class="col-md-3 col-form-label">Amount</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control" id="amount" name="amount" placeholder="0000"
                                   required min="0" value="{{ old('amount') }}">
                        </div>
                    </div>
                
                    <div class="form-group row mb-3">
                        <label for="description" class="col-md-3 col-form-label">Description</label>
                        <div class="col-md-9">
                            <textarea name="description" class="counter form-control" id="description"
                                      placeholder="description..." maxlength="140">{{ old('description') }}</textarea>
                            <p class="charNum m-0 p-0 h6 text-capitalize"></p>
                        </div>
                    </div>

                        <input id="type" name="type" value="paid" type="hidden"/>
                   

                    <div class="form-group mb-0 justify-content-end row">
                        <div class="col-md-9">
                            <button type="submit" class="btn btn-primary btn-block ">Add Payment</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

@endsection
@section('javascript')
<script>
    // var chartData = @json($chartData) ;
    //     var options = {
    //         series: [{
    //             name: 'amount',
    //             data: chartData,
    //         },],
    //         chart: {
    //             height: 350,
    //             type: 'area'
    //         },
    //         dataLabels: {
    //             enabled: false
    //         },
    //         stroke: {
    //             curve: 'smooth'
    //         },
    //         xaxis: {
    //             type: 'datetime',
    //         },
    //         toolbar: {
    //             show: true,
    //             offsetX: 0,
    //             offsetY: 0,
    //             tools: {
    //                 download: true,
    //             }
               
    //         }
            
            
    //     };

    //     var chart = new ApexCharts(document.querySelector("#customer-chart"), options);
    //     chart.render();
</script>
@endsection