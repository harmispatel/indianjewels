<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\DealerRequest;
use App\Models\{City, User, UserDocument, RoleHasPermissions, State};
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            ->addColumn('company_logo', function ($row)
            {
                $default_logo = asset('public/images/default_images/not-found/no_img1.jpg');
                $logo = ($row->company_logo && file_exists('public/images/uploads/companies_logos/'.$row->company_logo)) ? asset('public/images/uploads/companies_logos/'.$row->company_logo) : $default_logo;
                $logo_html = '';
                $logo_html .= '<img class="me-2" src="'.$logo.'" width="50" height="50">';
                return $logo_html;
            })
            ->addColumn('profile_picture', function ($row)
            {
                $default_profile_picture = asset('public/images/default_images/profiles/profile1.jpg');
                $profile_picture = ($row->profile && file_exists('public/images/uploads/user_images/'.$row->profile)) ? asset('public/images/uploads/user_images/'.$row->profile) : $default_profile_picture;
                $logo_html = '';
                $logo_html .= '<img class="me-2" style="border-radius:50%;" src="'.$profile_picture.'" width="50" height="50">';
                return $logo_html;
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
            ->rawColumns(['status','actions','company_logo', 'profile_picture'])
            ->make(true);
        }
    }


    // Store a newly created resource in storage.
    public function store(DealerRequest $request)
    {
        try {
            $input = $request->except('_token','password','confirm_password','company_logo','document','profile_picture');
            $input['password'] = Hash::make($request->password);

            // Upload Company Logo
            if ($request->hasFile('company_logo')){
                $file = $request->file('company_logo');
                $image_url = $this->addSingleImage('comapany_logo','companies_logos',$file, '',"300*300");
                $input['company_logo'] = $image_url;
            }

            // Upload Dealer Profile Picture
            if ($request->hasFile('profile_picture')){
                $file = $request->file('profile_picture');
                $image_url = $this->addSingleImage('user_image','user_images',$file, '',"300*300");
                $input['profile'] = $image_url;
            }

            $dealer = User::create($input);

            // Upload Dealers Documents
            if($request->hasFile('document')) {
                $documents = $request->file('document');
                foreach ($documents as $doc)
                {
                    $new_document = new UserDocument;
                    $new_document->user_id = $dealer->id;
                    $doc_name = $this->addSingleImage('document','documents',$doc, '','default');
                    $new_document->document = $doc_name;
                    $new_document->save();
                }
            }
            return redirect()->route('dealers')->with('success','Dealers has been created successfully');
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
            return back()->with('error', 'Something went wrong!');
        }
    }


    // Update the specified resource in storage.
    public function update(DealerRequest $request)
    {
        try {
            $id = decrypt($request->id);
            $input = $request->except('_token','id','password','confirm_password','company_logo','document','profile_picture');

            if ($request->password || $request->password != null) {
                $input['password'] = Hash::make($request->password);
            }

            $dealer = User::find($id);

            if ($dealer)
            {
                // Upload Company Logo
                if ($request->has('company_logo')){
                    $old_company_logo = (isset($dealer->company_logo)) ? $dealer->company_logo : '';
                    if( $request->hasFile('company_logo'))
                    {
                        $file = $request->file('company_logo');
                        $image_url = $this->addSingleImage('comapany_logo','companies_logos',$file, $old_company_logo,"300*300");
                        $input['company_logo'] = $image_url;
                    }
                }

                // Upload Dealer Profile Picture
                if ($request->has('profile_picture')){
                    $old_profile = (isset($dealer->profile)) ? $dealer->profile : '';
                    if( $request->hasFile('profile_picture'))
                    {
                        $file = $request->file('profile_picture');
                        $image_url = $this->addSingleImage('user_image','user_images',$file, $old_profile,"300*300");
                        $input['profile'] = $image_url;
                    }
                }

                // Upload Dealer Documents
                if ($request->hasFile('document')){
                    $documents = $request->file('document');
                    foreach ($documents as $doc){
                        $new_document = new UserDocument;
                        $new_document->user_id = $id;
                        $doc_name = $this->addSingleImage('document','documents',$doc, '','default');
                        $new_document->document = $doc_name;
                        $new_document->save();
                    }
                }

                $dealer->update($input);
            }

            return redirect()->route('dealers')->with('success','Dealers has been Updated.');
        } catch (\Throwable $th) {

            return redirect()->route('dealers')->with('error','Something went wrong!');
        }
    }


    // Remove the specified resource from storage.
    public function destroy(Request $request)
    {
        try {
            $id = decrypt($request->id);
            $user = User::find($id);
            $company_logo = (isset($user->company_logo)) ? $user->company_logo : '';
            $profile_picture = (isset($user->profile)) ? $user->profile : '';

            // Delete Company Logo
            if (!empty($company_logo) && file_exists('public/images/uploads/companies_logos/'.$company_logo))
            {
                unlink('public/images/uploads/companies_logos/'.$company_logo);
            }

            // Delete Profile Picture
            if (!empty($profile_picture) && file_exists('public/images/uploads/user_images/'.$profile_picture))
            {
                unlink('public/images/uploads/user_images/'.$profile_picture);
            }

            // Delete Dealer Documents
            $documents = UserDocument::where('user_id',$id)->get();
            foreach($documents as $doc)
            {
                if (!empty($doc->document) && file_exists('public/images/uploads/documents/'.$doc->document))
                {
                    unlink('public/images/uploads/documents/'.$doc->document);
                }
            }
            UserDocument::where('user_id',$id)->delete();

            $user->delete();
            return response()->json([
               'success' => 1,
               'message' => "Dealer has been Deleted.",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Something went wrong!",
            ]);
        }

    }

}
