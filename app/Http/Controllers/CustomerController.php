<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\City;
use App\Models\RoleHasPermissions;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:dealers|dealers.create|dealers.edit|dealers.destroy', ['only' => ['index','store']]);
        // $this->middleware('permission:dealers.create', ['only' => ['create','store']]);
        // $this->middleware('permission:dealers.edit', ['only' => ['edit','update']]);
        // $this->middleware('permission:dealers.destroy', ['only' => ['destroy']]);
    }


    // Display a listing of the resource.
    public function index()
    {
        return view('admin.customers.customers');
    }


    // Function for Get all Customers
    public function loadCustomers(Request $request)
    {
        if ($request->ajax())
        {
            $verification_filter = (isset($request->verification_filter)) ? $request->verification_filter : '';

            // Get all Customers
            $customers = User::where('user_type',2);
            if(!empty($verification_filter)){
                $customers = $customers->where('verification', $verification_filter);
            }
            $customers = $customers->orderBy('verification','ASC')->get();

            return DataTables::of($customers)
            ->addIndexColumn()

            ->addColumn('verification', function ($row)
            {
                $verification = $row->verification;
                if($verification == 1){
                    return '<span class="badge bg-danger">Unverified</span>';
                }elseif($verification == 2){
                    return '<span class="badge bg-primary">Verified</span>';
                }else{
                    return '<span class="badge bg-success">Registerd</span>';
                }
            })
            ->addColumn('status', function ($row)
            {
                $status = $row->status;
                $checked = ($status == 1) ? 'checked' : '';
                $customer_id = isset($row->id) ? $row->id : '';

                return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" onchange="changeStatus('.$customer_id.')" id="statusBtn" '.$checked.'></div>';
            })
            ->addColumn('actions',function($row)
            {
                $customer_id = isset($row->id) ? $row->id : '';
                $action_html = '';

                // Verify Button
                if($row->verification == 1){
                    $action_html .= '<a href="'.route('customers.verify',encrypt($customer_id)).'" class="btn btn-sm btn-success me-1" title="Verify"><i class="bi bi-check"></i></a>';
                }

                // Edit Button
                $action_html .= '<a href="'.route('customers.edit',encrypt($customer_id)).'" class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil"></i></a>';

                return $action_html;
            })
            ->rawColumns(['verification','actions','status'])
            ->make(true);
        }
    }

    // Function for Verify Customers
    public function verify($id)
    {
        try {
            $customer_id = decrypt($id);
            $customer = User::find($customer_id);
            $customer->verification = 2;
            $customer->update();

            return redirect()->route('customers')->with('success', 'Customer has been Verified SuccessFully...');

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something Went Wrong!');
        }
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        try {
            $customer_id = decrypt($id);
            $customer = User::find($customer_id);

            // State & Cities
            $states = State::get();
            $cities = City::where('state_id',$customer->state)->get();

            return view('admin.customers.edit_customer',compact('customer','states','cities'));

        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something Went Wrong!');
        }
    }

    // Function for Change Customer Status
    public function status(Request $request)
    {
        try {
            $id = $request->id;
            $customer = User::find($id);
            $customer->status =  ($customer->status == 1) ? 0 : 1;
            $customer->update();

            return response()->json([
                'success' => 1,
                'message' => "Customer Status has been Changed Successfully..",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Something went wrong!",
            ]);
        }
    }

    // Function for Update Existing Record
    public function update(CustomerRequest $request)
    {
        try {

            $customer_id = decrypt($request->customer_id);
            $input = $request->except('_token','customer_id');

            $customer = User::find($customer_id);
            if($customer)
            {
                $customer->update($input);

                if(isset($customer->name) && !empty($customer->name) && isset($customer->email) && !empty($customer->email) && isset($customer->phone) && !empty($customer->phone) && isset($customer->pincode) && !empty($customer->pincode) && isset($customer->address) && !empty($customer->address) && isset($customer->city) && !empty($customer->city) && isset($customer->state) && !empty($customer->state))
                {
                    $customer->update(['verification' => 3]);
                }
            }

            return redirect()->route('customers')->with('success','Customer has been Updated Successfully...');

        } catch (\Throwable $th) {
            return redirect()->back()->with('error','Something went wrong!');
        }
    }

}
