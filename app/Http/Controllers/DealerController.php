<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\DealerRequest;
use App\Models\{City, User, UserDocument, RoleHasPermissions, State};
use App\Traits\ImageTrait;
use Hash;
use Auth;
use Spatie\Permission\Models\Permission;



class DealerController extends Controller
{
    use ImageTrait;

    function __construct()
    {
        $this->middleware('permission:dealers|dealers.create|dealers.edit|dealers.destroy', ['only' => ['index','store']]);
        $this->middleware('permission:dealers.create', ['only' => ['create','store']]);
        $this->middleware('permission:dealers.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:dealers.destroy', ['only' => ['destroy']]);
    }


    // Display a listing of the resource.
    public function index()
    {
        return view('admin.dealers.dealers');
    }


    // Show the form for creating a new resource.
    public function create()
    {
        $states = State::get();
        return view('admin.dealers.create_dealer',compact(['states']));
    }


    public function loaddealers(Request $request)
    {
        if ($request->ajax())
        {
            // Get all Amenities
            $dealers = User::where('user_type',1)->orderBy('status','DESC')->get();

            return DataTables::of($dealers)
            ->addIndexColumn()

            ->addColumn('logo', function ($row)
            {
                $default_image = asset('public/images/default_images/not-found/no_img1.jpg');
                $image = ($row->logo && file_exists('public/images/uploads/companies_logos/'.$row->logo)) ? asset('public/images/uploads/companies_logos/'.$row->logo) : $default_image;
                $image_html = '';
                $image_html .= '<img class="me-2" src="'.$image.'" width="50" height="50">';
                return $image_html;
            })
            ->addColumn('status', function ($row)
            {
                $status = $row->status;
                $checked = ($status == 1) ? 'checked' : '';
                $checkVal = ($status == 1) ? 0 : 1;
                $dealer_id = isset($row->id) ? $row->id : '';

                    return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" onchange="changeStatus('.$checkVal.','.$dealer_id.')" id="statusBtn" '.$checked.'></div>';

            })
            ->addColumn('actions',function($row)
            {
                $dealer_id = isset($row->id) ? $row->id : '';
                $dealer_edit = Permission::where('name','dealers.edit')->first();
                $dealer_delete = Permission::where('name','dealers.destroy')->first();
                $user_type =  Auth::guard('admin')->user()->user_type;
                $roles = RoleHasPermissions::where('role_id',$user_type)->pluck('permission_id');
                foreach ($roles as $key => $value) {
                    $val[] = $value;
                }
                $action_html = '';
                if(in_array($dealer_edit->id,$val)){
                $action_html .= '<a href="'.route('dealers.edit',encrypt($dealer_id)).'" class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil"></i></a>';
                }
                // if(in_array($dealer_delete->id,$val)){

                //     $action_html .= '<a onclick="deleteDealer(\''.encrypt($dealer_id).'\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>';
                // }
                return $action_html;
            })
            ->rawColumns(['status','actions','logo'])
            ->make(true);
        }
    }


    // Store a newly created resource in storage.
    public function store(DealerRequest $request)
    {
        try {
            $input = $request->except('_token','password','confirm_password','logo','document');
            $input['password'] = Hash::make($request->password);


            if ($request->hasFile('logo'))
            {
                $file = $request->file('logo');
                $image_url = $this->addSingleImage('comapany_logo','companies_logos',$file, $old_image = '',"300*300");
                $input['logo'] = $image_url;
            }

            $dealer = User::create($input);

            if($request->hasFile('document'))
            {
                $multiple = $request->file('document');
                foreach ($multiple as $value)
                {
                    $doc = new UserDocument;
                    $doc->user_id = $dealer->id;
                    $multiDoc = $this->addSingleImage('document','documents',$value,$old_image = '','default');
                    $doc->document = $multiDoc;
                    $doc->save();
                }
            }
            return redirect()->route('dealers')->with('success','Dealers created successfully');
        } catch (\Throwable $th) {
            return redirect()->route('dealers')->with('error','Oops Something Went Wrong!');
        }
    }


    // Store a Users status Changes resource in storage..
    public function status(Request $request)
    {
        $status = $request->status;
        $id = $request->id;
        try {
            $input = User::find($id);
            $input->status =  $status;
            $input->update();

            return response()->json([
                'success' => 1,
                'message' => "Dealer Status has been Changed Successfully..",
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'success' => 0,
                'message' => "Internal Server Error!",
            ]);
        }
    }


    // Show the form for editing the specified resource.
    public function edit($id)
    {
        try {
            $id = decrypt($id);
            $data = User::where('id',$id)->first();
            $documents = UserDocument::where('user_id',$id)->get();
            // State & Cities
            $states = State::get();
            $cities = City::where('state_id',$data->state)->get();
            return view('admin.dealers.edit_dealer',compact('data','documents','states','cities'));
        } catch (\Throwable $th) {
            return back()->with('error', 'Internal Server Error!');
        }
    }


    // Update the specified resource in storage.
    public function update(DealerRequest $request)
    {

        try {
            $id = decrypt($request->id);
            $input = $request->except('_token','id','password','confirm_password','logo','document');

            if ($request->password || $request->password != null) {
                $input['password'] = Hash::make($request->password);
            }
                $dealer = User::find($id);

            if ($request->has('logo'))
            {
                $old_logo = (isset($dealer->logo)) ? $dealer->logo : '';
                if( $request->hasFile('logo'))
                {
                    $file = $request->file('logo');
                    $image_url = $this->addSingleImage('comapany_logo','companies_logos',$file, $old_image = $old_logo,"300*300");
                    $input['logo'] = $image_url;
                }
            }

            if ($request->hasFile('document')) {

                $multiple = $request->file('document');
                foreach ($multiple as $value)
                {
                    $doc = new UserDocument;
                    $doc->user_id = $id;
                    $multiDoc = $this->addSingleImage('document','documents',$value,$old_image = '','default');
                    $doc->document = $multiDoc;
                    $doc->save();
                }
            }

            if ($dealer)
            {
                $dealer->update($input);
            }

            return redirect()->route('dealers')->with('success','Dealers Updated successfully');
        } catch (\Throwable $th) {

            return redirect()->route('dealers')->with('error','Something with wrong');

        }
        //
    }


    // Remove the specified resource from storage.
    public function destroy(Request $request)
    {
        try {
            $id = decrypt($request->id);
            $findLogo = User::where('id',$id)->first();
            $findMulDocs = UserDocument::where('user_id',$id)->get();
            $img = isset($findLogo->logo) ? $findLogo->logo : '';

            foreach($findMulDocs as $value)
            {
                   if (!empty($value->document) && file_exists('public/images/uploads/documents/'.$value->document))
                   {
                       unlink('public/images/uploads/documents/'.$value->document);
                   }
            }

            if (!empty($img) && file_exists('public/images/uploads/companies_logos/'.$img))
             {
                   unlink('public/images/uploads/companies_logos/'.$img);
             }

             UserDocument::where('user_id',$id)->delete();

             User::where('id',$id)->delete();

             return response()->json([
               'success' => 1,
               'message' => "Dealer delete Successfully..",
           ]);
        } catch (\Throwable $th) {

            //throw $th;
            return response()->json([
                'success' => 0,
                'message' => "Something with wrong",
            ]);
        }

    }

}
