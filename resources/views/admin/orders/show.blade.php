@extends('admin.layouts.admin-layout')
@section('title', 'DETAILS - ORDERS - IMPEL JEWELLERS')
@section('content')

    {{-- Page Title --}}
    <div class="pagetitle">
        <h1>Orders</h1>
        <div class="row">
            <div class="col-md-8">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li class="breadcrumb-item "><a href="{{ route('orders.index') }}">Orders</a></li>
                        <li class="breadcrumb-item active">Details</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    {{-- Order Details Section --}}
    <section class="section dashboard">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-end">
                                <a href="" class="mb-2 btn btn-sm btn-info text-white"><strong>ACCEPT</strong> <i class="fa-solid fa-check-circle"></i></a>
                                <a href="" class="ms-1 mb-2 btn btn-sm btn-primary"><strong>PROCESS</strong> <i class="fa-solid fa-check-circle"></i></a>
                                <a href="" class="ms-1 mb-2 btn btn-sm btn-success"><strong>COMPLETE</strong> <i class="fa-solid fa-check-circle"></i></a>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4 mb-3">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th scope="col">Order No. : </th>
                                                        <td>{{ $order->id }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="col">Order Status : </th>
                                                        <td>
                                                            @if($order->order_status == 'pending')
                                                                <span class="badge bg-warning" style="font-size: 15px;">Pending.</span>
                                                            @elseif($order->order_status == 'accepted')
                                                                <span class="badge bg-info" style="font-size: 15px;">Accepted.</span>
                                                            @elseif($order->order_status == 'processing')
                                                                <span class="badge bg-primary" style="font-size: 15px;">Processing.</span>
                                                            @elseif($order->order_status == 'completed')
                                                                <span class="badge bg-success" style="font-size: 15px;">Completed.</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="col">Order Date : </th>
                                                        <td>{{ date('d-M-Y', strtotime($order->created_at)) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="col">Order Time : </th>
                                                        <td>{{ date('h:i:s A', strtotime($order->created_at)) }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th scope="col">Customer : </th>
                                                        <td>{{ $order->name }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="col">Email : </th>
                                                        <td>{{ $order->email }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th scope="col">Phone : </th>
                                                        <td>{{ $order->phone }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th width="80%" scope="col">Address : </th>
                                                        <td>{{ $order->address }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th width="80%" scope="col">City : </th>
                                                        <td>{{ (isset($order->City['name'])) ? $order->City['name'] : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th width="80%" scope="col">State : </th>
                                                        <td>{{ (isset($order->State['name'])) ? $order->State['name'] : '' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th width="80%" scope="col">Pincode : </th>
                                                        <td>{{ $order->pincode }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <div class="card mb-0">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                                                <thead class="text-uppercase">
                                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                                        <th scope="col">Image</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col">Code</th>
                                                        <th scope="col">Qty.</th>
                                                        <th scope="col">Gold Type</th>
                                                        <th scope="col">Gold Color</th>
                                                        <th scope="col">Net Weight</th>
                                                        <th scope="col">Metal Price</th>
                                                        <th scope="col">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-gray-600">
                                                    @if(isset($order->order_items) && count($order->order_items) > 0)
                                                        @foreach ($order->order_items as $order_item)
                                                            @php
                                                                $design_code = isset($order_item->design['code']) ? $order_item->design['code'] : '';
                                                            @endphp
                                                            <tr>
                                                                <td>
                                                                    @if(isset($order_item->design['image']) && !empty($order_item->design['image']) && file_exists('public/images/uploads/item_images/'.$design_code.'/'.$order_item->design['image']))
                                                                        <img src="{{ asset('public/images/uploads/item_images/'.$design_code.'/'.$order_item->design['image']) }}" style="width: 65px; height: 65px; border-radius: 5px; box-shadow: 2px 2px 3px #ccc" />
                                                                    @else
                                                                        <img src="{{ asset('public/images/default_images/not-found/no_img1.jpg') }}" style="width: 65px; height: 65px; border-radius: 5px; box-shadow: 2px 2px 3px #ccc" />
                                                                    @endif
                                                                </td>
                                                                <td>{{ $order_item['design_name'] }}</td>
                                                                <td>{{ (isset($design_code)) ? $design_code : '-' }}</td>
                                                                <td>{{ $order_item['quantity'] }}</td>
                                                                <td>{{ $order_item['gold_type'] }}</td>
                                                                <td>{{ $order_item['gold_color'] }}</td>
                                                                <td>{{ $order_item['net_weight'] }} gm.</td>
                                                                <td>₹ {{ $order_item['item_sub_total'] }}</td>
                                                                <td>₹ {{ $order_item['item_total'] }}</td>
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
    </section>

@endsection

@section('page-js')
<script type="text/javascript">


</script>
@endsection
