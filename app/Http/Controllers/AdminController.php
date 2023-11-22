<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\{Role, Permission};
use App\Http\Requests\UserRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\ImageTrait;
use App\Models\{Admin, RoleHasPermissions};
use Hash;
use DB;
use Auth;

class AdminController extends Controller
{
    use ImageTrait;

    function __construct()
    {
        $this->middleware('permission:users|users.create|users.edit|users.destroy', ['only' => ['index','store']]);
        $this->middleware('permission:users.create', ['only' => ['create','store']]);
        $this->middleware('permission:users.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:users.destroy', ['only' => ['destroy']]);
    }

    // Display a listing of the resource.
    public function index()
    {
        return view('admin.users.users');
    }

    // Create User Form
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create_users', compact('roles'));
    }

    // Load All User by Ajax Datatable
    public function loadUsers(Request $request)
    {
        if ($request->ajax())
        {
            // Get all Admins
            $admins = Admin::get();

            return DataTables::of($admins)
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
                $default_image = asset("public/images/default_images/not-found/no_img1.jpg");
                $image = (isset($row->image) && !empty($row->image) && file_exists('public/images/uploads/user_images/'.$row->image)) ? asset('public/images/uploads/user_images/'.$row->image) : $default_image;
                $image_html = '<img class="me-2" src="'.$image.'" width="50" height="50">';
                return $image_html;
            })
            ->addColumn('role', function ($row)
            {
                $usertype = $row->user_type;
                $role = Role::where('id',$usertype)->first();
                return $role->name;
            })
            ->addColumn('status', function ($row)
            {
                $status = $row->status;
                $checked = ($status == 1) ? 'checked' : '';
                $user_id = isset($row->id) ? $row->id : '';
                if($user_id != 1){
                    return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" onchange="changeStatus('.$user_id.')" id="statusBtn" '.$checked.'></div>';
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
                }
                if(in_array($user_delete->id,$val)){
                    if($user_id != 1){
                        $action_html .= '<a onclick="deleteUsers(\''.encrypt($user_id).'\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>';
                    }
                }

                return $action_html;
            })
            ->rawColumns(['status','role','actions','image','name'])
            ->make(true);
        }
    }

    // Store a newly created User
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

    // Change status of User
    public function status(Request $request)
    {
        try {
            $id = $request->id;
            $admin = Admin::find($id);
            $admin->status =  ($admin->status == 1) ? 0 : 1;
            $admin->update();
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

    // Edit Specific User
    public function edit(Request $request, $id)
    {
        try {
            $id = decrypt($id);
            $data = Admin::where('id',$id)->first();
            $roles = Role::all();
            return view('admin.users.edit_users',compact('data','roles'));
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went Wrong!');
        }
    }

    // Update Specific User
    public function update(UserRequest $request)
    {
        try {
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

    // Delete a Specific User
    public function destroy(Request $request)
    {
        try {
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
