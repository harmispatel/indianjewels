<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UserRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\ImageTrait;
use App\Models\{Admin, RoleHasPermissions};
use Hash;
use DB;
use Illuminate\Support\Arr;
use Auth;   
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
    //
    use ImageTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:users|users.create|users.edit|users.destroy', ['only' => ['index','store']]);
         $this->middleware('permission:users.create', ['only' => ['create','store']]);
         $this->middleware('permission:users.edit', ['only' => ['edit','update']]);
         $this->middleware('permission:users.destroy', ['only' => ['destroy']]);
         
    }


    public function index()
    {
        return view('admin.users.users');
    }

    public function create()
    {
        $roles = Role::all();
        
        return view('admin.users.create_users', compact('roles'));
    }

    public function loadUsers(Request $request)
    {
        if ($request->ajax())
        {
            // Get all Amenities
            $sliders = Admin::get();
            
            return DataTables::of($sliders)
            ->addIndexColumn()
            ->addColumn('name', function ($row)
            {
                $firstname = $row->firstname;
                $lastname = $row->lastname;
                $name = $firstname .' '.$lastname;
                return $name;
            })
            ->addColumn('image', function ($row)
            {
                
                $default_image = asset("public/images/uploads/user_images/no_image.jpg");
                $image = ($row->image) ? asset('public/images/uploads/user_images/'.$row->image) : $default_image;
                $image_html = '';
                $image_html .= '<img class="me-2" src="'.$image.'" width="50" height="50">';
                return $image_html;
            })
            ->addColumn('usertype', function ($row)
            {
                $usertype = $row->user_type;
                $role = Role::where('id',$usertype)->first();
                return $role->name;
            })
            ->addColumn('status', function ($row)
            {
                $status = $row->status;
                $checked = ($status == 1) ? 'checked' : '';
                $checkVal = ($status == 1) ? 0 : 1;
                $user_id = isset($row->id) ? $row->id : '';
                if($user_id != 1){
                    return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" onchange="changeStatus('.$checkVal.','.$user_id.')" id="statusBtn" '.$checked.'></div>';
                }
            })
            ->addColumn('actions',function($row)
            {
                $user_id = isset($row->id) ? $row->id : '';
                $user_edit = Permission::where('name','users.edit')->first();
                $user_delete = Permission::where('name','users.destroy')->first();
                $user_type =  Auth::guard('admin')->user()->user_type;
                $roles = RoleHasPermissions::where('role_id',$user_type)->pluck('permission_id');
                foreach ($roles as $key => $value) {
                   $val[] = $value;
                  }
                $action_html = '';
                if(in_array($user_edit->id,$val)){

                    $action_html .= '<a href="'.route('users.edit',encrypt($user_id)).'" class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil"></i></a>';
                }else{
                    $action_html .= '<a href="'.route('users.edit',encrypt($user_id)).'" class="btn btn-sm custom-btn me-1 disabled"><i class="bi bi-pencil"></i></a>';

                }
                if(in_array($user_delete->id,$val)){
                    if($user_id != 1){
                        $action_html .= '<a onclick="deleteUsers(\''.encrypt($user_id).'\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>';
                    }
                }else{
                    $action_html .= '<a onclick="deleteUsers(\''.encrypt($user_id).'\')" class="btn btn-sm btn-danger me-1 disabled"><i class="bi bi-trash"></i></a>';
                    

                }

                return $action_html;
            })
            ->rawColumns(['status','usertype','actions','image','name'])
            ->make(true);
        }
    }

    public function store(UserRequest $request)
    {
                
            try {
                $input = $request->except('_token','image','confirm_password','password');
                $input['password'] = Hash::make($request->password);
                if ($request->hasFile('image'))
                    {
                        $file = $request->file('image');
                        $image_url = $this->addSingleImage('user','user_images',$file, $old_image = '',"300*300");
                        $input['image'] = $image_url;
                    }
                $user = Admin::create($input);
        
                $user_type = $user->user_type;
                $roles = Role::where('id',$user_type)->first();
                $user->assignRole($roles->name);
                
                return redirect()->route('users')->with('success','User created successfully');
            } catch (\Throwable $th) {
                return redirect()->route('users')->with('error','Something with wrong');

            }   
    
    }

     // Store a Users status Changes resource in storage..    
     public function status(Request $request)
     {
         $status = $request->status;
         $id = $request->id;
         try {
             $input = Admin::find($id);
             $input->status =  $status;
             $input->update();
 
             return response()->json([
                 'success' => 1,
                 'message' => "User Status has been Changed Successfully..",
             ]);
         } catch (\Throwable $th) {
             return response()->json([
                 'success' => 0,
                 'message' => "Internal Server Error!",
             ]);
         }
     }

     public function edit(Request $request, $id)
     {
        $id = decrypt($id);
        $data = Admin::where('id',$id)->first();
        $roles = Role::all();
        return view('admin.users.edit_users',compact('data','roles'));
     }

     public function update(UserRequest $request)
     {
        try {
            //code...
            $input = $request->except('_token','id','password','confirm_password','image');
            $id = decrypt($request->id); 
    
            if(!empty($request->password) || $request->password != null)
            {
                $input['password'] = Hash::make($request->password);
            }
                         if ($request->hasFile('image'))
                        {
                            $img = Admin::where('id',$id)->first();
                            $old_image = $img->image;
                            $file = $request->file('image');
                            $image_url = $this->addSingleImage('user','user_images',$file, $old_image = '',"300*300");
                            $input['image'] = $image_url;
                        }
                        $user = Admin::find($id);
                        $user->update($input);
                        DB::table('model_has_roles')->where('model_id',$id)->delete();
                        $user_type = $user->user_type;
                        $roles = Role::where('id',$user_type)->first();
                        $user->assignRole($roles->name);
    
    
                    return redirect()->route('users')->with('success','User updated successfully');
        } catch (\Throwable $th) {
            return redirect()->route('users')->with('error','Something with wrong');

        }


     }

     public function destroy(Request $request)
     {
        try {
            //code...
            $id = decrypt($request->id); 
            
            $user = Admin::where('id',$id)->first();
    
            $img = isset($user->image) ? $user->image : '';
    
            if (!empty($img) && file_exists('public/images/uploads/user_images/'.$img))
            {
                  unlink('public/images/uploads/user_images/'.$img);
            }
    
            Admin::where('id',$id)->delete();
            return response()->json([
                'success' => 1,
                'message' => "User delete Successfully..",
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'success' => 0,
                'message' => "Something with wrong",
            ]);
        }

     }


      // Logout Admin
    public function AdminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }

}
