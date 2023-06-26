<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\CategoriesRequest;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::get();
    
        return view('admin.categories.categories' , compact('categories'));
    }
    
    
    // Load Categories Data.
    public function loadCategories(Request $request)
    {
        if ($request->ajax())
        {
            // Get all Amenities
            $categories = Category::get();
            
            return DataTables::of($categories)
            ->addIndexColumn()
            ->addColumn('image', function ($row)
            {
                  $default_image = asset("public/category_image/demo_images/not-found/not-found4.png");
                  $image = ($row->icon) ? asset($row->icon) : $default_image;
                  $image_html = '';
                  $image_html .= '<img src="'.$image.'" width="50">';
                  return $image_html;
                })
                ->addColumn('status', function ($row)
                {
                    $status = $row->status;
                    $checked = ($status == 1) ? 'checked' : '';
                    $checkVal = ($status == 1) ? 0 : 1;
                    $category_id = isset($row->id) ? $row->id : '';
                    return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" onchange="changeStatus('.$checkVal.','.$amenity_id.','.$row->vendor_amenities_count.')" id="statusBtn" '.$checked.'></div>';
                })
                ->addColumn('actions',function($row)
                {
                    $category_id = isset($row->id) ? $row->id : '';
                    $action_html = '';
                    $action_html .= '<a onclick="editCategories('.$category_id.')" class="btn btn-sm btn-primary me-1"><i class="bi bi-pencil"></i></a>';
                    //   $action_html .= '<a onclick="deleteCategories('.$amenity_id.','.$row->vendor_amenities_count.')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>';
                    return $action_html;
                })
                ->rawColumns(['status','actions','image'])
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
            return view('admin.categories.add-category');
        }

        
    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoriesRequest $request)
    {
        // Except this fields from input
        $input = $request->except('_token','categories_id');

        // Add this field in input
        $input['created_at'] = Carbon::now();

        
            if ($image = $request->file('image')) 
            {
                $destinationPath = 'public/images/category_image/';
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['image'] = "$profileImage";
            }
            
            $category = Category::insert($input);
            // return $this->sendResponse(true,"Category has been Inserted SuccessFully...");
            return redirect()->route('admin.categories')->with('success','Category created successfully.');
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $categories = Category::where('id', $request->id)->first();
        return view('admin.categories.edit-category', compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoriesRequest $request, Category $category)
    {
        $input = $request->all();
        // $input = $request->except('_token','categories_id');

        if ($image = $request->file('image')) 
        {
            $destinationPath = 'public/images/category_image/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['image'] = "$profileImage";
        }
        else
        {
            unset($input['image']);
        }
          
        $category->update($input);
    
        return redirect()->route('admin.categories')->with('success','Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
