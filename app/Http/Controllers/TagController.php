<?php

namespace App\Http\Controllers;

use App\Models\{Tag,RoleHasPermissions};
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\TagRequest;
use Auth;


class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:tags|tags.create|tags.edit|tags.destroy', ['only' => ['index','store']]);
         $this->middleware('permission:tags.create', ['only' => ['create','store']]);
         $this->middleware('permission:tags.edit', ['only' => ['edit','update']]);
         $this->middleware('permission:tags.destroy', ['only' => ['destroy']]);
    }

    // Display a listing of the resource.
    public function index()
    {
        return view('admin.tags.tags');
    }


    // Display a listing Tags.
    public function loadtags(Request $request)
    {
        if ($request->ajax())
        {
            $tags= Tag::get();
            return DataTables::of($tags)
            ->addIndexColumn()
            ->addColumn('changestatus', function ($row)
            {
                $status = $row->status;
                $checked = ($status == 1) ? 'checked' : '';
                $checkVal = ($status == 1) ? 0 : 1;
                $tag_id = isset($row->id) ? $row->id : '';
                return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" onchange="changeStatus('.$checkVal.','.$tag_id.')" id="statusBtn" '.$checked.'></div>';
            })
            ->addColumn('actions',function($row)
            {
                $tag_id = isset($row->id) ? encrypt($row->id) : '';
                 $tag_edit = Permission::where('name','tags.edit')->first();
                 $tag_delete = Permission::where('name','tags.destroy')->first();
                 $user_type =  Auth::guard('admin')->user()->user_type;
                 $roles = RoleHasPermissions::where('role_id',$user_type)->pluck('permission_id');
                 foreach ($roles as $key => $value) {
                    $val[] = $value;
                   }
                $action_html = '';
                if(in_array($tag_edit->id,$val)){

                    $action_html .= '<a onclick="editTag(\''.$tag_id.'\')" class="btn btn-sm custom-btn me-1" id="editTags"><i class="bi bi-pencil"></i></a>';
                }else{
                    $action_html .= '<a onclick="editTag(\''.$tag_id.'\')" class="btn btn-sm custom-btn me-1 disabled" id="editTags"><i class="bi bi-pencil"></i></a>';

                }
                if(in_array($tag_delete->id,$val)){

                    $action_html .= '<a onclick="deleteTag(\''.$tag_id.'\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>';
                }else{
                    $action_html .= '<a onclick="deleteTag(\''.$tag_id.'\')" class="btn btn-sm btn-danger me-1 disabled"><i class="bi bi-trash"></i></a>';

                }
                return $action_html;
            })
            ->rawColumns(['changestatus','actions'])
            ->make(true);
        }
    }

    
    // Show the form for creating a new Tags.
    public function create()
    {
        return view('admin.tags.create_tags');  
    }


    /**
     * Store a Tags created resource in storage.
     *
     * @param  \Illuminate\Http\TagRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TagRequest $request)
    {
        $input = $request->except('_token');
        $input['created_at'] = Carbon::now();

        try 
        {
            $tags = Tag::insert($input);
            return response()->json(
            [
                'success' => 1,
                'message' => "Tag has been created Successfully..",
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
    }


    // Store a Tags status Changes resource in storage..    
    public function status(Request $request)
    {
        $status = $request->status;
        $id = $request->id;
        try 
        {
            $input = Tag::find($id);
            $input->status =  $status;
            $input->update();

            return response()->json(
            [
                'success' => 1,
                'message' => "Tag Status has been Changed Successfully..",
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

    
    // Show the form for editing the specified Tags.
    public function edit(Request $request)
    {
        try 
        {
            $id = decrypt($request->id);
            $data = Tag::where('id',$id)->first();
            
            return response()->json(
            [
                'success' => 1,
                'data' => $data,
                'message' => "Tag edit Successfully..",
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
    }


    /**
     * Update the specified Tags in storage.
     *
     * @param  \Illuminate\Http\TagRequest  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(TagRequest $request, Tag $tag)
    {
        $tag_id = isset($request->id) ? $request->id : '';
        $input = $request->except('_token','id');

        try 
        {
            $tags = Tag::find($tag_id);
         
            $tags->update($input);
            return response()->json(
            [
                'success' => 1,
                'message' => "Tag updated Successfully..",
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
    }

    
    //  Remove the specified tags from storage.
    public function destroy(Request $request)
    {
        try 
        {
            $tags = Tag::where('id',decrypt($request->id))->delete();
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
    }
}
