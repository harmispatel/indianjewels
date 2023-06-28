<?php

namespace App\Http\Controllers;

use App\Models\{Design,Category,Gender,Metal,Tag, Design_image};
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class DesignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
        return view('admin.designs.designs');
    }

    // Display a listing Tags.
    public function loaddesigns(Request $request)
    {
        if ($request->ajax())
        {
            $designs= Design::get();
            return DataTables::of($designs)
            ->addIndexColumn()
            ->addColumn('changestatus', function ($row){
                $status = $row->status;
                $checked = ($status == 1) ? 'checked' : '';
                $checkVal = ($status == 1) ? 0 : 1;
                $design_id = isset($row->id) ? $row->id : '';
                return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" onchange="changeStatus('.$checkVal.','.$design_id.')" id="statusBtn" '.$checked.'></div>';
            })
            ->addColumn('actions',function($row)
            {
                $tag_id = isset($row->id) ? encrypt($row->id) : '';
                $action_html = '';
                $action_html .= '<a href="'.route('designs.edit',$tag_id).'" class="btn btn-sm btn-primary me-1"><i class="bi bi-pencil"></i></a>';
                $action_html .= '<a   onclick="deleteDesign(\''.$tag_id.'\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>';
                return $action_html;
            })
            ->rawColumns(['changestatus','actions'])
            ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::get();
        $genders = Gender::get();
        $metals = Metal::get();
        $tags = Tag::get();
        return view('admin.designs.create_designs',compact('categories','genders','metals','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $dm = json_encode($request->tags);
        // dd($request->all());
        try {
            $input = $request->except('_token','tags','company','image','images');
            $input['tags'] = json_encode($request->tags);
            $input['company'] = json_encode($request->company);
              $data = Design::create($input);
            //   $id = $data->id;

            return redirect()->route('designs')->with('message','Design added Successfully');

        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('designs')->with('error','Something with wrong');
        }
        //
    }

    // Store a Tags status Changes resource in storage..    
    public function status(Request $request)
    {
        $status = $request->status;
        $id = $request->id;
        try {
            $input = Design::find($id);
            $input->status =  $status;
            $input->update();

            return response()->json([
                'success' => 1,
                'message' => "Design Status has been Changed Successfully..",
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
            return response()->json([
                'success' => 0,
                'message' => "Internal Server Error!",
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function edit(Design $design)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Design $design)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function destroy(Design $design)
    {
        //
    }
}
