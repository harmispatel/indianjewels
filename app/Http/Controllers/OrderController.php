<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        if(Auth::guard('admin')->user()->can('orders.index')){
            return view('admin.orders.index');
        }else{
            return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
        }
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
                $orders->where('id', 'LIKE', "%{$search}%")->orWhere('name', 'LIKE', "%{$search}%")->orWhere('phone', 'LIKE', "%{$search}%")->orWhere('order_status', 'LIKE', "%{$search}%");
                $totalData = $totalData->where('id', 'LIKE', "%{$search}%")->orWhere('name', 'LIKE', "%{$search}%")->orWhere('phone', 'LIKE', "%{$search}%")->orWhere('order_status', 'LIKE', "%{$search}%");
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
                    if(Auth::guard('admin')->user()->can('orders.show')){
                        $action_html .= '<a href="'.route('orders.show',encrypt($order->id)).'" class="btn btn-sm custom-btn"><i class="fa-solid fa-eye"></i></a>';
                    }else{
                        $action_html .= '-';
                    }
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

    // Display the specified resource.
    public function show($id)
    {
        try {
            if(Auth::guard('admin')->user()->can('orders.show')){
                $order = Order::with(['order_items'])->find(decrypt($id));
                return view('admin.orders.show', compact(['order']));
            }else{
                return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Oops, Something went wrong!');
        }
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

    // Processing order by specific status
    public function orderProcess(Request $request)
    {
        try {
            $order_id = $request->id;
            $order_status = $request->status;
            $order = Order::find($order_id);

            if(isset($order->id)){

                $order->order_status = $order_status;
                $order->update();

                $message = "";
                if($order_status == 'accepted'){
                    $message = "Order has been Accepted.";
                }elseif($order_status == 'processing'){
                    $message = "Order has been Send to Processing.";
                }elseif($order_status == 'completed'){
                    $message = "Order has been Completed.";
                }

                return response()->json([
                    'success' => true,
                    'message' => $message,
                ]);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => '404, Order Not Found!',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => 'Oops, Something went wrong!',
            ]);
        }
    }


    // Proccessing Order Commission
    public function processOrderCommission(Request $request)
    {
        $request->validate([
            'labour_value' => 'required',
            'bill_date' => 'required',
            'bill_number' => 'required|unique:orders,bill_number',
        ]);

        try {
            $order_id = $request->order_id;
            $labour_value = $request->labour_value;
            $bill_date = $request->bill_date;
            $bill_number = $request->bill_number;

            $order = Order::find($order_id);
            if(isset($order->id) && $order_id != ''){
                $dealer = (isset($order->dealer)) ? $order->dealer : '';
                if(isset($dealer->id) && !empty($dealer->id)){
                    $commission_type = $dealer->commission_type;
                    $commission_value = $dealer->commission_value;
                    $commission_days = $dealer->commission_days;

                    $commission_amount = 0;
                    if($commission_type == 'percentage'){ // percentage
                        $commission_amount = $labour_value * $commission_value / 100;
                    }else{ // fixed
                        $commission_amount = $commission_value;
                    }

                    // Get End Date using bill Date
                    $commission_pay_date = Carbon::parse($bill_date)->addDays($commission_days);

                    $order->dealer_commission_type = $commission_type;
                    $order->dealer_commission_value = $commission_value;
                    $order->dealer_commission = $commission_amount;
                    $order->commission_status = 0;
                    $order->bill_date = $bill_date;
                    $order->bill_number = $bill_number;
                    $order->labour_value = $labour_value;
                    $order->commission_date = $commission_pay_date;
                    $order->update();

                    return response()->json([
                        'success' => 1,
                        'message' => 'Commission has been Applied.',
                    ]);

                }else{
                    return response()->json([
                        'success' => 0,
                        'message' => 'Oops, Dealer not found!',
                    ]);
                }
            }else{
                return response()->json([
                    'success' => 0,
                    'message' => 'Oops, Order not found!',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => 'Oops, Something went wrong!',
            ]);
        }
    }


    // Pay Order Commission
    public function payOrderCommission(Request $request)
    {
        $request->validate([
            'payment_date' => 'required',
            'transaction_id' => 'required|unique:orders,transaction_id',
        ]);

        try {
            $order_id = $request->order_id;
            $transaction_id = $request->transaction_id;
            $payment_date = $request->payment_date;

            $order = Order::find($order_id);
            if(isset($order->id) && $order_id != ''){
                $dealer = (isset($order->dealer)) ? $order->dealer : '';
                if(isset($dealer->id) && !empty($dealer->id)){
                    $order->transaction_id = $transaction_id;
                    $order->commission_payment_date = $payment_date;
                    $order->commission_status = 1;
                    $order->update();

                    return response()->json([
                        'success' => 1,
                        'message' => 'Commission has been Paid SuccessFully.',
                    ]);

                }else{
                    return response()->json([
                        'success' => 0,
                        'message' => 'Oops, Dealer not found!',
                    ]);
                }
            }else{
                return response()->json([
                    'success' => 0,
                    'message' => 'Oops, Order not found!',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => 'Oops, Something went wrong!',
            ]);
        }
    }
}
