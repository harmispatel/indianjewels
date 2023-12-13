<?php

namespace App\Http\Controllers;

use App\Http\Requests\MiddleBannerRequest;
use App\Models\{MiddleBanner, Tag};
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MiddleBannerController extends Controller
{
    use ImageTrait;

    // Display a listing of the resource.
    public function index()
    {
        $total_middle_banner = MiddleBanner::count();
        return view('admin.middle_banners.middle_banners', compact(['total_middle_banner']));
    }


    // Load a listing of the resource.
    public function loadMiddleBanners(Request $request)
    {
        if ($request->ajax()){

            $middle_banners = MiddleBanner::with(['tag'])->get();

            return DataTables::of($middle_banners)
            ->addIndexColumn()
            ->addColumn('image', function ($row)
            {
                $default_image = asset("public/images/default_images/not-found/no_img1.jpg");
                $banner = (isset($row->image) && !empty($row->image) && file_exists('public/images/uploads/middle_banners/'.$row->image)) ? asset('public/images/uploads/middle_banners/'.$row->image) : $default_image;
                return '<img class="me-2" src="'.$banner.'" width="100" height="50">';
            })
            ->addColumn('status', function ($row)
            {
                $isChecked = ($row->status == 1) ? 'checked' : '';
                return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" onchange="changeStatus(\''.encrypt($row->id).'\')" id="statusBtn" '.$isChecked.'></div>';
            })
            ->addColumn('tag', function ($row)
            {
                $tag_name = (isset($row['tag']['name'])) ? $row['tag']['name'] : '';
                return $tag_name;
            })
            ->addColumn('actions',function($row)
            {
                $action_html = '';
                $action_html .= '<a href="'.route('middle-banners.edit',encrypt($row->id)).'" class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil"></i></a>';
                $action_html .= '<a onclick="deleteMiddleBanner(\''.encrypt($row->id).'\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>';
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
        return view('admin.middle_banners.create_middle_banner', compact(['tags']));
    }


    // Store a newly created resource in storage.
    public function store(MiddleBannerRequest $request)
    {
        try
        {
            $input = $request->except(['_token', 'image','tag']);
            $input['tag_id'] = $request->tag;

            if($request->hasFile('image')){
                $file = $request->image;
                $image = $this->addSingleImage('middle_banner', 'middle_banners', $file, '', "550*450");
                $input['image'] = $image;
            }

            MiddleBanner::insert($input);

            return redirect()->route('middle-banners')->with('success', 'Record has been Inserted.');
        }
        catch (\Throwable $th)
        {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }


    // Change Status of the specified resource.
    public function status(Request $request)
    {
        try
        {
            $banner_id = decrypt($request->id);
            $middle_banner = MiddleBanner::find($banner_id);
            $middle_banner->status = ($middle_banner->status == 1) ? 0 : 1;
            $middle_banner->update();

            return response()->json([
                'success' => 1,
                'message' => "Status has been Changed.",
            ]);
        }
        catch (\Throwable $th)
        {
            return response()->json([
                'success' => 0,
                'message' => "Something went wrong!",
            ]);
        }
    }


    // Show the form for editing the specified resource.
    public function edit($id)
    {
        try
        {
            $banner_id = decrypt($id);
            $middle_banner = MiddleBanner::find($banner_id);
            $tags = Tag::all();

            return view('admin.middle_banners.edit_middle_banner', compact(['middle_banner','tags']));
        }
        catch (\Throwable $th)
        {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }


    // Update the specified resource in storage.
    public function update(MiddleBannerRequest $request)
    {
        try
        {
            $banner_id = decrypt($request->id);
            $middle_banner = MiddleBanner::find($banner_id);

            $input = $request->except(['_token', 'image','tag','id']);
            $input['tag_id'] = $request->tag;

            if($request->hasFile('image')){
                $file = $request->image;
                $old_image = (isset($middle_banner['image'])) ? $middle_banner['image'] : '';
                $image = $this->addSingleImage('middle_banner', 'middle_banners', $file, $old_image, "550*450");
                $input['image'] = $image;
            }

           $middle_banner->update($input);

            return redirect()->route('middle-banners')->with('success', 'Record has been Updated.');
        }
        catch (\Throwable $th)
        {
            return redirect()->back()->with('error', 'Something went wrong!');
        }
    }


    // Remove the specified resource from storage.
    public function destroy(Request $request)
    {
        try
        {
            $banner_id = decrypt($request->id);
            $middle_banner = MiddleBanner::find($banner_id);

            // Delete old Image
            $old_image = isset($middle_banner->image) ? $middle_banner->image : '';
            if (!empty($old_image) && file_exists('public/images/uploads/middle_banners/'.$old_image))
            {
                unlink('public/images/uploads/middle_banners/'.$old_image);
            }

            $middle_banner->delete();

            return response()->json([
                'success' => 1,
                'message' => "Record has been Removed.",
            ]);
        }
        catch (\Throwable $th)
        {
            return response()->json([
                'success' => 0,
                'message' => "Something went wrong!",
            ]);
        }
    }
}
