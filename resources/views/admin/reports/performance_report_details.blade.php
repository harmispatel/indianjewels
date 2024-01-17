@extends('admin.layouts.admin-layout')
@section('title', 'DEALER PERFORMANCE - REPORT DETAILS - IMPEL JEWELLERS')
@section('content')

    <input type="hidden" name="dealer_id" id="dealer_id" value="{{ (isset($dealer->id)) ? $dealer->id : '' }}">

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Dealer Performance Report Details</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('reports.performance') }}">Dealer Performance Report</a></li>
                        <li class="breadcrumb-item active">Dealer Performance Report Details</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Page Content --}}
    <section class="section dealer_performance">
        <div class="row">
            <div class="col-md-4 mb-3"></div>
            <div class="col-md-4 mb-3"></div>
            <div class="col-md-4 mb-3">
                <input type="text" name="datetimes" id="dateRangePicker" class="form-control" />
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive p-3">
                            <table class="table nowrap" id="orderDetails">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Order No.</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Bill Amount</th>
                                        <th scope="col">Labour Amount</th>
                                        <th scope="col">Complete Commission</th>
                                        <th scope="col">Pending Commission</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('page-js')
<script type="text/javascript">

    loadRecords();

    function loadRecords(startDate = null, endDate = null){
        $('#orderDetails').DataTable().destroy();
        // Load All Order Details
        var table = $('#orderDetails').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 100,
            ajax: {
                url: "{{ route('reports.performance.details.load') }}",
                type: "GET",
                data: {
                    'dealer_id' : $('#dealer_id').val(),
                    start_date: startDate,
                    end_date: endDate,
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'orderno',
                    name: 'orderno',
                    searchable: true,
                    orderable: false,
                },
                {
                    data: 'customer',
                    name: 'customer',
                    searchable: true,
                    orderable: false,
                },
                {
                    data: 'bill_amount',
                    name: 'bill_amount',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'labour_amount',
                    name: 'labour_amount',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'complete_commission',
                    name: 'complete_commission',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'pending_commission',
                    name: 'pending_commission',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    }

    $("input[name='datetimes']").daterangepicker(
        {},
        function (start, end, label) {
            let startDate = start.format("YYYY-MM-DD").toString();
            let endDate = end.format("YYYY-MM-DD").toString();
            loadRecords(startDate, endDate);
        }
    );

    function payCommission(id){
        $.ajax({
            type: "POST",
            url: "{{ route('orders.pay-commission') }}",
            data: {
                "_token" : "{{ csrf_token() }}",
                "id" : id,
            },
            dataType: "JSON",
            success: function (response) {
                if(response.success == 1){
                    toastr.success(response.message);
                    loadRecords();
                }else{
                    toastr.success(response.message);
                }
            }
        });
    }

</script>
@endsection
