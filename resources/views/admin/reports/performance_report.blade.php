@extends('admin.layouts.admin-layout')
@section('title', 'DEALER PERFORMANCE - REPORT - IMPEL JEWELLERS')
@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Dealer Performance Report</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Dealer Performance Report</li>
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
                <select name="dealer" id="dealer" class="form-select">
                    <option value="">Select Dealer</option>
                    @if(count($dealers) > 0)
                        @foreach ($dealers as $dealer)
                            <option value="{{ $dealer->id }}">{{ $dealer->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive p-3">
                            <table class="table nowrap" id="dealerPerformance">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Customer</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Dealer</th>
                                        <th scope="col">Commission</th>
                                        <th scope="col">Commission Status</th>
                                        <th scope="col">Order Status</th>
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

    function loadRecords(dealerId = null){
        $('#dealerPerformance').DataTable().destroy();
        // Load All Reports
        var table = $('#dealerPerformance').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 100,
            ajax: {
                url: "{{ route('reports.performance.load') }}",
                type: "GET",
                data: {
                    dealer_id: dealerId,
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'customer',
                    name: 'customer',
                    searchable: true
                },
                {
                    data: 'phone',
                    name: 'phone',
                    searchable: true
                },
                {
                    data: 'dealer',
                    name: 'dealer',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'commission',
                    name: 'commission',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'commission_status',
                    name: 'commission_status',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'order_status',
                    name: 'order_status',
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
    
    $('#dealer').on('change', function(){
        loadRecords($(this).val());
    });

</script>
@endsection
