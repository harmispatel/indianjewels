<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        return view('admin.orders.index');
    }

    // Load all orders helping with AJAX Datatable
    public function load(Request $request)
    {
        if ($request->ajax()){

            $columns = array(
                0 => 'id',
            );

            $limit = $request->request->get('length');
            $start = $request->request->get('start');
            // $order = $columns[$request->input('order.0.column')];
            $order = 'created_at';
            // $dir = $request->input('order.0.dir');
            $dir = 'DESC';
            $search = $request->input('search.value');

            $totalData = Order::query();
            $orders = Order::query();

            if(!empty($search)){
                // $orders->where('name', 'LIKE', "%{$search}%")->orWhere('code', 'LIKE', "%{$search}%");
                // $totalData = $totalData->where('name', 'LIKE', "%{$search}%")->orWhere('code', 'LIKE', "%{$search}%");
            }

            $totalData = $totalData->count();
            $totalFiltered = $totalData;
            $orders = $orders->offset($start)->orderBy($order, $dir)->limit($limit)->get();

            $item = array();
            $all_items = array();

            if(count($orders) > 0){
                foreach ($orders as $order) {
                    $item['id'] = $order->id;
                    $item['customer'] = (isset($order['name']) && !empty($order['name'])) ? $order['name'] : '';
                    $item['phone'] = (isset($order['phone'])) ? $order['phone'] : '';
                    $item['dealer'] = (isset($order->dealer['name'])) ? $order->dealer['name'] : '-';
                    $item['dealer_code'] = (isset($order['dealer_code']) && !empty($order['dealer_code'])) ? $order['dealer_code'] : '-';

                    // Order Status
                    $order_status_html = '';
                    if($order['order_status'] == 'pending'){
                        $order_status_html .= '<span class="badge bg-warning">Pending.</span>';
                    }elseif($order['order_status'] == 'accepted'){
                        $order_status_html .= '<span class="badge bg-info">Accepted.</span>';
                    }elseif($order['order_status'] == 'processing'){
                        $order_status_html .= '<span class="badge bg-primary">Processing.</span>';
                    }elseif($order['order_status'] == 'completed'){
                        $order_status_html .= '<span class="badge bg-success">Completed.</span>';
                    }
                    $item['order_status'] = $order_status_html;

                    $action_html = '';
                    $action_html .= '<a class="btn btn-sm custom-btn"><i class="fa-solid fa-eye"></a>';
                    $item['actions'] = $action_html;

                    $all_items[] = $item;
                }
            }

            return response()->json([
                "draw"            => intval($request->request->get('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval(isset($totalFiltered) ? $totalFiltered : ''),
                "data"            => $all_items
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
