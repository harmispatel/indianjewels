<?php

namespace App\Http\Controllers;

use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use App\Http\Requests\BottomBannerRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Models\{
    Tag,
    BottomBanner,
};

class BottomBannerController extends Controller
{
    use ImageTrait;

    // Display a listing of the resource.
    public function index()
    {
        $total_bottom_banner = BottomBanner::count();
        return view('admin.bottom_banners.bottom_banners', compact(['total_bottom_banner']));
    }


    // Load a listing of the resource.
    public function loadBottomBanners(Request $request)
    {
        if ($request->ajax()){

            $bottom_banners = BottomBanner::with(['tag'])->get();

            return DataTables::of($bottom_banners)
            ->addIndexColumn()
            ->addColumn('image', function ($row){
                $banner = (isset($row->image) && !empty($row->image) && file_exists('public/images/uploads/bottom_banners/'.$row->image)) ? asset('public/images/uploads/bottom_banners/'.$row->image) : asset("public/images/default_images/not-found/no_img1.jpg");
                return '<img class="me-2" src="'.$banner.'" width="100" height="50">';
            })
            ->addColumn('status', function ($row){
                $isChecked = ($row->status == 1) ? 'checked' : '';
                return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" onchange="changeStatus(\''.encrypt($row->id).'\')" id="statusBtn" '.$isChecked.'></div>';
            })
            ->addColumn('tag', function ($row){
                $tag_name = (isset($row['tag']['name'])) ? $row['tag']['name'] : '';
                return $tag_name;
            })
            ->addColumn('actions',function($row){
                $action_html = '';
                $action_html .= '<a href="'.route('bottom-banners.edit',encrypt($row->id)).'" class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil"></i></a>';
                $action_html .= '<a onclick="deleteBottomBanner(\''.encrypt($row->id).'\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>';
                return $action_html;
            })
            ->rawColumns(['status','actions','image','tag'])
            ->make(true);
        }
    }


    // Show the form for creating a new resource.
    public function create()
    {
        $tags = Tag::get();
        return view('admin.bottom_banners.create_bottom_banner', compact(['tags']));
    }


    // Store a newly created resource in storage.
    public function store(BottomBannerRequest $request)
    {
        try{
            $input = $request->except(['_token', 'image','tag']);
            $input['tag_id'] = $request->tag;

            if($request->hasFile('image')){
                $image = $this->addSingleImage('bottom_banner', 'bottom_banners', $request->file('image'), '', "450*550");
                $input['image'] = $image;
            }

            BottomBanner::insert($input);
            return redirect()->route('bottom-banners')->with('success', 'Bottom Banner has been Created.');
        }catch (\Throwable $th){
            return redirect()->back()->with('error', 'Oops, Something went wrong!');
        }
    }


    // Change Status of the specified resource.
    public function status(Request $request)
    {
        try{
            $bottom_banner = BottomBanner::find(decrypt($request->id));
            $bottom_banner->status = ($bottom_banner->status == 1) ? 0 : 1;
            $bottom_banner->update();
            return response()->json([
                'success' => 1,
                'message' => "Status has been Changed.",
            ]);
        }catch (\Throwable $th){
            return response()->json([
                'success' => 0,
                'message' => "Oops, Something went wrong!",
            ]);
        }
    }


    // Show the form for editing the specified resource.
    public function edit($id)
    {
        try{
            $bottom_banner = BottomBanner::find(decrypt($id));
            $tags = Tag::all();
            return view('admin.bottom_banners.edit_bottom_banner', compact(['bottom_banner','tags']));
        }catch (\Throwable $th){
            return redirect()->back()->with('error', 'Oops, Something went wrong!');
        }
    }


    // Update the specified resource in storage.
    public function update(BottomBannerRequest $request)
    {
        try{
            $bottom_banner = BottomBanner::find(decrypt($request->id));
            $input = $request->except(['_token', 'image','tag','id']);
            $input['tag_id'] = $request->tag;

            if($request->hasFile('image')){
                $old_image = (isset($bottom_banner['image'])) ? $bottom_banner['image'] : '';
                $image = $this->addSingleImage('bottom_banner', 'bottom_banners', $request->file('image'), $old_image, "450*550");
                $input['image'] = $image;
            }

           $bottom_banner->update($input);
            return redirect()->route('bottom-banners')->with('success', 'Bottom Banner has been Updated.');
        }catch (\Throwable $th){
            return redirect()->back()->with('error', 'Oops, Something went wrong!');
        }
    }


    // Remove the specified resource from storage.
    public function destroy(Request $request)
    {
        try{
            $bottom_banner = BottomBanner::find(decrypt($request->id));

            // Delete old Image
            $old_image = isset($bottom_banner->image) ? $bottom_banner->image : '';
            if (!empty($old_image) && file_exists('public/images/uploads/bottom_banners/'.$old_image)){
                unlink('public/images/uploads/bottom_banners/'.$old_image);
            }

            $bottom_banner->delete();
            return response()->json([
                'success' => 1,
                'message' => "Bottom Banner has been Deleted.",
            ]);
        }catch (\Throwable $th){
            return response()->json([
                'success' => 0,
                'message' => "Oops, Something went wrong!",
            ]);
        }
    }
}
