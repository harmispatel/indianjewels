<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\{DealerCollection, Design, Order, User};

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


    public function loadStarReport(Request $request)
    {
        if ($request->ajax()){

            $limit = $request->request->get('length');
            $start = $request->request->get('start');
            $search = $request->input('search.value');

            $designes = Design::withCount(['dealer_collections']);

            if (!empty($search)) {
                $designes->where(function ($query) use ($search) {
                    $query->where('code', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%");
                });
            }

            // Filter designs with dealer_collections_count greater than 0
            $designes = $designes->get()->filter(function ($design) {
                return $design->dealer_collections_count > 0;
            });

            // Order designs by dealer_collections_count in descending order
            $designes = $designes->sortByDesc('dealer_collections_count')->values();

            $totalData = clone $designes;
            $totalFiltered = $totalData->count();
            $totalData = $totalData->count();

            // Apply offset and limit after filtering
            $designes = $designes->slice($start)->take($limit);

            $all_items = [];

            if(count($designes) > 0){
                $srno = 1;
                foreach($designes as $design){
                    $item = [
                        'id' => $srno,
                        'code' => $design->code ?? '',
                        'name' => $design->name ?? '',
                        'stars' => "<strong>$design->dealer_collections_count</strong>" ?? 0,
                        'actions' => '<a href="'.route('reports.star.details', $design->id).'" class="btn btn-sm btn-primary"><i class="fa-solid fa-info-circle"></i></a>',
                    ];

                    $all_items[] = $item;
                    $srno++;
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


    public function starReportDetails($id)
    {
        try {
            $design = Design::where('id', $id)->first();
            return view('admin.reports.star_report_details', compact(['design']));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Oops, Something went wrong!');
        }
    }


    public function loadStarReportDetails(Request $request)
    {
        if ($request->ajax()){

            $limit = $request->request->get('length');
            $start = $request->request->get('start');
            $search = $request->input('search.value');
            $design_id = $request->design_id;
            $dealer_collections = DealerCollection::with(['dealer'])->where('design_id', $design_id);

            if (!empty($search)) {
                $dealer_collections->whereHas('dealer',function ($query) use ($search) {
                    $query->where('dealer_code', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->orWhere('phone', 'LIKE', "%{$search}%")
                    ->orWhereHas('company_city', function ($subquery) use ($search) {
                        $subquery->where('name', 'LIKE', "%{$search}%");
                    });
                });
            }

            $totalData = clone $dealer_collections;
            $totalFiltered = $totalData->count();
            $totalData = $totalData->count();
            $dealer_collections = $dealer_collections->offset($start)->limit($limit)->latest()->get();

            $all_items = [];

            if(count($dealer_collections) > 0){
                $srno = 1;
                foreach($dealer_collections as $dealer_collection){
                    $item = [
                        'id' => $srno,
                        'dealer_code' => $dealer_collection->dealer->dealer_code ?? '',
                        'dealer_name' => $dealer_collection->dealer->name ?? '',
                        'dealer_contact' => $dealer_collection->dealer->phone ?? '',
                        'dealer_city' => $dealer_collection->dealer->company_city->name ?? '',
                    ];

                    $all_items[] = $item;
                    $srno++;
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


    public function schemeReport()
    {
        return view('admin.reports.scheme_report');
    }


    public function performanceReport()
    {
        return view('admin.reports.performance_report');
    }


    public function loadPerformanceReport(Request $request)
    {
        if ($request->ajax()){

            $limit = $request->request->get('length');
            $start = $request->request->get('start');
            $search = $request->input('search.value');
            $start_date = $request->start_date;
            $end_date = $request->end_date;

            $dealers = User::where('user_type', 1);

            if (!empty($search)) {
                $dealers->where(function ($query) use ($search) {
                    $query->where('dealer_code', 'LIKE', "%{$search}%")
                        ->orWhere('name', 'LIKE', "%{$search}%")
                        ->orWhere('phone', 'LIKE', "%{$search}%");
                });
            }

            // Apply date range condition
            if (!empty($start_date) && !empty($end_date)) {
                $dealers->whereHas('orders', function ($subquery) use ($start_date, $end_date) {
                    $subquery->whereBetween('created_at', [$start_date, $end_date]);
                });
            }

            $dealers->with('orders');
            $totalData = clone $dealers;
            $totalFiltered = $totalData->count();
            $totalData = $totalData->count();
            $dealers = $dealers->offset($start)->limit($limit)->get();
            $dealers = $dealers->sortByDesc(function ($dealer) {
                return $dealer->orders->where('commission_status', 1)->sum('dealer_commission');
            });

            $all_items = [];

            if(count($dealers) > 0){
                $srno = 1;
                foreach($dealers as $dealer){
                    $complete_commission = $dealer->orders->where('commission_status', 1)->sum('dealer_commission');
                    $pending_commission = $dealer->orders->where('commission_status', 0)->sum('dealer_commission');

                    $item = [
                        'id' => $srno,
                        'code' => $dealer->dealer_code ?? '',
                        'name' => $dealer->name ?? '',
                        'phone' => $dealer->phone ?? '',
                        'complete_commission' => number_format($complete_commission, 2),
                        'pending_commission' => number_format($pending_commission, 2),
                        'actions' => '<a href="'.route('reports.performance.details', $dealer->id).'" class="btn btn-sm btn-primary"><i class="fa-solid fa-info-circle"></i></a>',
                    ];

                    $all_items[] = $item;
                    $srno++;
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


    public function performanceReportDetails($id)
    {
        try {
            $dealer = User::where('id', $id)->where('user_type', 1)->first();
            return view('admin.reports.performance_report_details', compact(['dealer']));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Oops, Something went wrong!');
        }
    }

    public function loadPerformanceReportDetails(Request $request)
    {
        if ($request->ajax()){

            $current_date = strtotime(Carbon::now());
            $limit = $request->request->get('length');
            $start = $request->request->get('start');
            $search = $request->input('search.value');
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $dealer_id = $request->dealer_id;
            $orders = Order::where('dealer_id', $dealer_id);

            if(!empty($start_date) && !empty($end_date)){
                $orders = $orders->whereBetween('created_at', [$start_date, $end_date]);
            }

            if (!empty($search)) {
                $orders->where(function ($query) use ($search) {
                    $query->where('id', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%");
                });
            }

            $totalData = clone $orders;
            $totalFiltered = $totalData->count();
            $totalData = $totalData->count();
            $orders = $orders->offset($start)->limit($limit)->get();

            $all_items = [];

            if(count($orders) > 0){
                $srno = 1;
                foreach($orders as $order){
                    $commission_date = strtotime($order->commission_date);
                    $item = [
                        'id' => $srno,
                        'orderno' => $order->id ?? '',
                        'customer' => $order->name ?? '',
                        'bill_amount' => number_format($order->total, 2) ?? 0.00,
                        'labour_amount' => number_format($order->charges, 2) ?? 0.00,
                        'complete_commission' => ($current_date >= $commission_date) ? $order->dealer_commission : 0,
                        'pending_commission' => ($current_date < $commission_date) ? $order->dealer_commission : 0,
                        'actions' => ($order->commission_status == 0) ? '<a onclick="payCommission('.$order->id.')" class="btn btn-sm btn-success"><i class="fa-solid fa-check-circle"></i></a>' : '<button class="btn btn-sm btn-success" disabled>PAID</button>',
                    ];

                    $all_items[] = $item;
                    $srno++;
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
