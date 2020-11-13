@extends('layout.base')

@section("custom_css")
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
<link rel="stylesheet" href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="/backend/assets/css/datatablestyle.css">
@stop

@if(\Illuminate\Support\Facades\Cookie::get('user_role') == 'store_assistant')

@section('content')
<div class="container-fluid">

    <div class="mt-5">
        <div class="card">
            <div class="card-body p-2">
                <div class="d-flex justify-content-between px-4 py-2 border-bottom align-items-center">
                    <div>
                        <h4 class="card-title">Business Assistant Dashboard</h4>
                    </div>
                </div>
                <div class="d-flex justify-content-between p-3">
                    <div class="">
                        <div class="media">
                            <i data-feather="grid" class="align-self-center icon-dual icon-sm mr-2"></i>
                            <div class="media-body">
                                <h5 class="mt-0 mb-0">{{ $assistant->store->store_name }}</h5>
                                <span class="text-muted font-size-13">Business</span>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="media">
                            <i data-feather="tag" class="align-self-center icon-dual icon-sm mr-2"></i>
                            <div class="media-body">
                                <h5 class="mt-0 mb-0">{{ $assistant->store->tagline }}</h5>
                                <span class="text-muted font-size-13">Tagline</span>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="media">
                            <i data-feather="check-square" class="align-self-center icon-dual icon-sm mr-2"></i>
                            <div class="media-body">
                                <h5 class="mt-0 mb-0">{{ $assistant->store->shop_address }}</h5>
                                <span class="text-muted">Address</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="content">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-header mb-1 mt-0 h5">List of Registered Customers</h4>

            <a href="#" class="btn btn-primary " data-toggle="modal" data-target="#CustomerModal">
                New &nbsp;<i class="fa fa-plus my-float"></i>
            </a>

        </div>

        <div class="card-body p-1 card">
            <div class="table-responsive table-data" style="padding: 10px">
                <table id="assistant-datatable" class="table dt-responsive nowrap table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Date Created</th>
                            <th>Transactions</th>
                        </tr>
                    </thead>
                    @foreach ($assistant->store->customers as $index => $customer)
                    <tr>
                        <td>{{ $index +1 }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone_number }}</td>
                        <td> {{ \Carbon\Carbon::parse($customer->createdAt)->diffForhumans() }}</td>
                        <td>
                            <a class="btn btn-soft-primary" href="#" data-toggle="modal"
                                data-target="#CustomerTransactionModal-{{ $customer->_id }}">
                                Transactions
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="CustomerTransactionModal-{{ $customer->_id }}" tabindex="-1" role="dialog"
    aria-labelledby="CustomerTransactionModallLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myExtraLargeModalLabel">Transactions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive table-data">
                    <table id="assistant-customer-transactions" class="table table-striped table-bordered"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Amount</th>
                                <th>Interest</th>
                                <th>Total</th>
                                <th>Type</th>
                                <th>Due</th>
                                <th>Created</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customer->transactions as $index => $transaction )
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $transaction->amount }}</td>
                                <td>{{ $transaction->interest }} %</td>
                                <td>
                                    {{ floor($transaction->amount/100+12 * $transaction->interest + $transaction->amount) }}
                                </td>
                                <td>{{ $transaction->type }}</td>

                                <td>
                                    @if(\Carbon\Carbon::parse($transaction->expected_pay_date)->isPast())
                                    <span
                                        class="badge badge-soft-danger">{{ \Carbon\Carbon::parse($transaction->expected_pay_date)->diffForhumans() }}</span>
                                    @else
                                    @if(\Carbon\Carbon::parse($transaction->expected_pay_date)->isToday())
                                    <span
                                        class="badge badge-soft-warning">{{ \Carbon\Carbon::parse($transaction->expected_pay_date)->diffForhumans() }}</span>
                                    @endif
                                    <span
                                        class="badge badge-soft-success">{{ \Carbon\Carbon::parse($transaction->expected_pay_date)->diffForhumans() }}</span>
                                    @endif
                                </td>
                                <td> {{ \Carbon\Carbon::parse($transaction->createdAt)->diffForhumans() }}
                                </td>
                                <td>
                                    @if ($transaction->status === false)
                                    <span class="badge badge-warning badge-pill">Pending</span>
                                    @else
                                    <span class="badge badge-success badge-pill">Paid</span>
                                    @endif

                                </td>
                                <td>
                                    <a class="btn btn-info btn-small py-1 px-2" href="javascript:void(0)">
                                        View More
                                    </a>
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

<div id="CustomerModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Add New Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form class="form-horizontal" method="POST" action="{{ route('customer.store') }}" id="submitForm">
                    @csrf
                    <div class="form-group row mb-3">
                        <label for="inputphone" class="col-3 col-form-label">Phone Number</label>
                        <div class="col-9">
                            <input type="tel" class="form-control" id="phone" placeholder="Phone Number"
                                aria-describedby="helpPhone" name="" required pattern=".{6,16}"
                                title="Phone number must be between 6 to 16 characters">
                            <input type="hidden" name="phone_number" id="phone_number" class="form-control">
                            <small id="helpPhone" class="form-text text-muted">Enter your number without the starting 0,
                                eg 813012345</small>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="inputPassword3" class="col-3 col-form-label">Customer Name</label>
                        <div class="col-9">
                            <input type="text" class="form-control" id="inputPassword3" placeholder="Customer name"
                                name="name" required pattern=".{5,30}"
                                title="Customer name must be at least 5 characters and not more than 30 characters">
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label for="inputPassword3" class="col-3 col-form-label">Business Name</label>
                        <div class="col-9">
                            <!-- <input type="text" class="form-control" id="inputPassword3" placeholder="Store name"
                                name="store_name"> -->
                            <select name="store_id" class="form-control" required>
                                <option disabled selected value="{{ $assistant->store->_id }}">
                                    {{ $assistant->store->store_name }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group mb-0 justify-content-end row">
                        <div class="col-9">
                            <button type="submit" class="btn btn-primary btn-block ">Create Customer</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@endsection

@section("javascript")
<script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#assistant-datatable').DataTable({
        });
        $('#assistant-customer-transactions').DataTable({
        });
    });

</script>
@stop
@endif
