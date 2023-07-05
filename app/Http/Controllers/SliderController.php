<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Http\Request;
use App\Http\Requests\SlidersRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\ImageTrait;

class SliderController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.sliders.sliders');
    }

    /**
     * Load Sliders Data.
     */ 
    public function loadSliders(Request $request)
    {
        if ($request->ajax())
        {
            // Get all Amenities
            $sliders = Slider::get();
            
            return DataTables::of($sliders)
            ->addIndexColumn()
            ->addColumn('image', function ($row)
            {
                $default_image = asset("public/images/slider_image/not-found4.png");
                $image = ($row->image) ? asset('public/images/slider_image/'.$row->image) : $default_image;
                $image_html = '';
                $image_html .= '<img class="me-2" src="'.$image.'" width="50" height="50">';
                return $image_html;
            })
            ->addColumn('status', function ($row)
            {
                $status = $row->status;
                $checked = ($status == 1) ? 'checked' : '';
                $checkVal = ($status == 1) ? 0 : 1;
                $slider_id = isset($row->id) ? $row->id : '';
                return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" onchange="changeStatus('.$checkVal.','.$slider_id.')" id="statusBtn" '.$checked.'></div>';
            })
            ->addColumn('actions',function($row)
            {
                $slider_id = isset($row->id) ? $row->id : '';
                $action_html = '';
                $action_html .= '<a href="'.route('sliders.edit-slider',encrypt($slider_id)).'" class="btn btn-sm edit_bt me-1"><i class="bi bi-pencil"></i></a>';
                $action_html .= '<a onclick="deleteSliders(\''.encrypt($slider_id).'\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>';
                return $action_html;
            })
            ->rawColumns(['status','actions','image'])
            ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $sliders = Slider::all();
        return view('admin.sliders.add-slider');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SlidersRequest $request)
    {
        $input = $request->except('_token');
 
        // Upload new Image
        if ($request->has('image'))
        {
            $file = $request->image;
            $singleFile = $this->addSingleImage('slider_image',$file, $oldImage = '',"1200*500");
            $input['image'] = $singleFile;
        }
        try
        {
            $slider = Slider::insert($input);
            return redirect()->route('sliders')->with('message','Slider created successfully.');
        }
        catch (\Throwable $th)
        {
            dd($th);
            return redirect()->route('sliders')->with('error','Something with wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Slider $slider,$id)
    {
        $id =  decrypt($id);
        $data = Slider::where('id',$id)->first();
        return view('admin.sliders.edit-slider', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SlidersRequest $request, Slider $slider)
    {
        $input = $request->except('_token','id');
        try
        {
            $id = decrypt($request->id);
            $slider = Slider::find($id);
            
            // Save Image if exists and Delete old Image
            if ($request->has('image'))
            {
                $cimg = Slider::where('id',$id)->first();
                
                // Delete old Image
                $old_image = isset($cimg->image) ? $cimg->image : '';
        
                // Upload new Image
                $file = $request->image;
                $singleFile = $this->addSingleImage('slider_image',$file, $old_image,"1200*500");
                $input['image'] = $singleFile; 
            }

            if ($slider) 
            {
                $slider->update($input);
            }
            return redirect()->route('sliders')->with('message','Slider updated successfully');
        }
        catch (\Throwable $th) 
        {
            return redirect()->route('sliders')->with('error','Something went wrong');
        }
    }

    /**
     * Update the specified status in storage.
     */
    public function status(Request $request)
    {
        $status = $request->status;
        $id = $request->id;
        try 
        {
            $input = Slider::find($id);
            $input->status =  $status;
            $input->update();

            return response()->json(
            [
                'success' => 1,
                'message' => "Slider Status has been Changed Successfully..",
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
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {    
        try 
        {
            $id = decrypt($request->id);
            $slider = Slider::where('id',$id)->first();
            // Delete old Image
            $oldImage = isset($slider->image) ? $slider->image : '';
            if (!empty($oldImage) && file_exists('public/images/slider_image/'.$oldImage))
            {
                unlink('public/images/slider_image/'.$oldImage);
            }
            
             Slider::where('id',$id)->delete();
            
            return response()->json(
            [
                'success' => 1,
                'message' => "Slider delete Successfully..",
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
