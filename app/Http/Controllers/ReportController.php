<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Google\Service\ServiceControl\Auth;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function summaryReport()
    {
        return view('admin.reports.summary_report');
    }


    public function starReport()
    {
        return view('admin.reports.star_report');
    }


    public function schemeReport()
    {
        return view('admin.reports.scheme_report');
    }


    public function performanceReport()
    {
        $dealers = User::where('user_type', 1)->get();
        return view('admin.reports.performance_report', compact(['dealers']));
    }


    public function loadPerformanceReport(Request $request)
    {
        if ($request->ajax()){

            $columns = array(
                0 => 'id',
            );

            $limit = $request->request->get('length');
            $start = $request->request->get('start');
            $order = 'created_at';
            $dir = 'DESC';
            $search = $request->input('search.value');
            $dealer_id = $request->dealer_id;

            if($dealer_id != ''){
                $totalData = Order::where('dealer_id', '=', $dealer_id);
                $orders = Order::where('dealer_id', '=', $dealer_id);
            }else{
                $totalData = Order::where('dealer_id', '!=', '');
                $orders = Order::where('dealer_id', '!=', '');
            }

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
                    $item['commission'] = (isset($order['dealer_commission']) && !empty($order['dealer_commission'])) ? $order['dealer_commission'] : '-';

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

                    // Commission Status
                    $commission_status_html = '';
                    if($order['commission_status'] == 0){
                        $commission_status_html .= '<span class="badge bg-danger">Unpaid.</span>';
                    }elseif($order['commission_status'] == 1){
                        $commission_status_html .= '<span class="badge bg-success">Paid.</span>';
                    }else{
                        $commission_status_html .= '-';
                    }
                    $item['commission_status'] = $commission_status_html;

                    $action_html = '-';
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
}
