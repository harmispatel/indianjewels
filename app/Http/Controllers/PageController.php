<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\{Page};
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    // Display a listing of the resource.
    public function index()
    {
        if(Auth::guard('admin')->user()->can('pages.index')){
            return view('admin.pages.index');
        }else{
            return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
        }
    }

    // Load all pages helping with AJAX Datatable
    public function load(Request $request)
    {
        if ($request->ajax()){
            // Get all Pages
            $pages = Page::all();

            return DataTables::of($pages)
            ->addIndexColumn()
            ->addColumn('status', function ($row){
                $checked = ($row->status == 1) ? 'checked' : '';
                if(Auth::guard('admin')->user()->can('pages.status')){
                    return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" onchange="changeStatus('.$row->id.')" id="statusBtn" '.$checked.'></div>';
                }else{
                    return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" id="statusBtn" '.$checked.' disabled></div>';
                }
            })
            ->addColumn('actions',function($row){
                $action_html = '';
                // Edit Button
                if(Auth::guard('admin')->user()->can('pages.edit')){
                    $action_html .= '<a href="'.route('pages.edit',encrypt($row->id)).'" class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil"></i></a>';
                }else{
                    $action_html .= '- ';
                }

                if($row->is_static == 0){
                    // Delete Button
                    if(Auth::guard('admin')->user()->can('pages.destroy')){
                        $action_html .= '<a onclick="deletePage(\''.encrypt($row->id).'\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>';
                    }else{
                        $action_html .= '- ';
                    }
                }

                return $action_html;
            })
            ->rawColumns(['actions','status'])
            ->make(true);
        }
    }

    // Show the form for creating a new resource.
    public function create()
    {
        if(Auth::guard('admin')->user()->can('pages.create')){
            return view('admin.pages.create');
        }else{
            return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
        }
    }

    // Store a newly created resource in storage.
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:pages,name',
            'content' => 'required',
        ]);

        try {
            $input = $request->except(['_token']);
            $input['status'] = 1;
            $slug = str_replace(' ','_',strtolower($request->name));
            $input['slug'] = str_replace('&','and',$slug);
            Page::create($input);
            return redirect()->route('pages.index')->with('success', 'Page has been Created.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Oops, Something went wrong!');
        }
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        try {
            if(Auth::guard('admin')->user()->can('pages.edit')){
                $page = Page::find(decrypt($id));
                return view('admin.pages.edit', compact(['page']));
            }else{
                return redirect()->route('admin.dashboard')->with('error','You have no rights for this action!');
            }
        } catch (\Throwable $th) {
            return back()->with('error', 'Oops, Something went wrong!');
        }
    }

    // Update the specified resource in storage.
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|unique:pages,name,'.$request->id,
            'content' => 'required',
        ]);

        try {
            $input = $request->except(['_token']);
            $input['status'] = 1;
            $slug = str_replace(' ','_',strtolower($request->name));
            $input['slug'] = str_replace('&','and',$slug);
            Page::find($request->id)->update($input);
            return redirect()->route('pages.index')->with('success', 'Page has been Updated.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Oops, Something went wrong!');
        }
    }

    // Function for Change Page Status
    public function status(Request $request)
    {
        try {
            $page = Page::find($request->id);
            $page->status =  ($page->status == 1) ? 0 : 1;
            $page->update();
            return response()->json([
                'success' => 1,
                'message' => "Status has been Changed.",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Oops, Something went wrong!",
            ]);
        }
    }

    // Remove the specified resource from storage.
    public function destroy(Request $request)
    {
        try{
            $page = Page::find(decrypt($request->id));
            $page->delete();
            return response()->json([
                'success' => 1,
                'message' => "Page has been Deleted.",
            ]);
        }catch (\Throwable $th){
            return response()->json([
                'success' => 0,
                'message' => "Oops, Something went wrong!",
            ]);
        }
    }
}
