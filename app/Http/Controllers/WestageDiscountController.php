<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Dealer,WestageDiscount , RoleHasPermissions, User};
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\WestageDiscountRequest;
use Auth;
use Spatie\Permission\Models\Permission;




class WestageDiscountController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:westage.discount|westage.discount.create|westage.discount.edit|westage.discount.destroy', ['only' => ['index','store']]);
         $this->middleware('permission:westage.discount.create', ['only' => ['create','store']]);
         $this->middleware('permission:westage.discount.edit', ['only' => ['edit','update']]);
         $this->middleware('permission:westage.discount.destroy', ['only' => ['destroy']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.westagediscount.westagediscount');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dealers = User::where('user_type',1)->get();

        return view('admin.westagediscount.create_westagediscount',compact('dealers'));
    }

    public function  loaddiscount(Request $request)
    {
        if ($request->ajax())
        {
            $dicount = WestageDiscount::get();
            return DataTables::of($dicount)
            ->addIndexColumn()
            ->addColumn('status', function ($row)
            {
                $status = $row->status;
                $checked = ($status == 1) ? 'checked' : '';
                $checkVal = ($status == 1) ? 0 : 1;
                $dicount_id = isset($row->id) ? $row->id : '';
                return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" onchange="changeStatus('.$checkVal.','.$dicount_id.')" id="statusBtn" '.$checked.'></div>';
            })
            ->addColumn('actions',function($row)
            {
                $dicount_id = isset($row->id) ? encrypt($row->id) : '';
                $discount_edit = Permission::where('name','westage.discount.edit')->first();
                 $discount_delete = Permission::where('name','westage.discount.destroy')->first();
                 $user_type =  Auth::guard('admin')->user()->user_type;
                 $roles = RoleHasPermissions::where('role_id',$user_type)->pluck('permission_id');
                 foreach ($roles as $key => $value) {
                    $val[] = $value;
                   }
                $action_html = '';
                if(in_array($discount_edit->id,$val)){
                    $action_html .= '<a href="'.route('westage.discount.edit',$dicount_id).'" class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil"></i></a>';
                }
                if(in_array($discount_delete->id,$val)){
                    $action_html .= '<a onclick="deleteDiscount(\''.$dicount_id.'\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>';
                }

                return $action_html;
            })
            ->rawColumns(['status','actions'])
            ->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WestageDiscountRequest $request)
    {
        //
        try {
            $input = $request->except('_token','dealers');
            $input['dealers'] = json_encode($request->dealers);

             $dealer = WestageDiscount::create($input);

             return redirect()->route('westage.discount')->with('success','Westage Discount created successfully');
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('westage.discount')->with('error','Something with wrong');

        }



    }

    public function status(Request $request)
    {
        $status = $request->status;
        $id = $request->id;
        try
        {
            $input = WestageDiscount::find($id);
            $input->status =  $status;
            $input->update();

            return response()->json(
            [
                'success' => 1,
                'message' => "Westage Discount Status has been Changed Successfully..",
            ]);
        }
        catch (\Throwable $th)
        {
            return response()->json(
            [
                'success' => 0,
                'message' => "Internal Server Error!",
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WestageDiscount  $westageDiscount
     * @return \Illuminate\Http\Response
     */
    public function edit(WestageDiscount $westageDiscount, $id)
    {
        try {
            $id = decrypt($id);

            $data = WestageDiscount::where('id',$id)->first();
            $dealers = User::where('user_type',1)->get();

            return view('admin.westagediscount.edit_westagediscount',compact('data','dealers'));
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('westage.discount')->with('error','Something with wrong');

        }


        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WestageDiscount  $westageDiscount
     * @return \Illuminate\Http\Response
     */
    public function update(WestageDiscountRequest $request, WestageDiscount $westageDiscount)
    {
        //
        try {
            $input = $request->except('_token','id','dealers');
            $input['dealers'] = json_encode($request->dealers);
            $id = decrypt($request->id);

             $discount = WestageDiscount::find($id);
             $discount->update($input);

             return redirect()->route('westage.discount')->with('success','Westage Discount Updated successfully');
            //code...
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('westage.discount')->with('error','Something with wrong');

        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WestageDiscount  $westageDiscount
     * @return \Illuminate\Http\Response
     */
    public function destroy(WestageDiscount $westageDiscount, Request $request)
    {

        try
        {
            $tags = WestageDiscount::where('id',decrypt($request->id))->delete();
            return response()->json(
            [
                'success' => 1,
                'message' => "Tag delete Successfully..",
            ]);
        }
        catch (\Throwable $th)
        {
            return response()->json(
            [
                'success' => 0,
                'message' => "Something with wrong",
            ]);
        }
        //
    }
}
