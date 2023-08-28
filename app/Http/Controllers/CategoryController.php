<?php

namespace App\Http\Controllers;

use App\Models\{Category, Design};
use Illuminate\Http\Request;
use App\Http\Requests\CategoriesRequest;
use App\Traits\ImageTrait;


class CategoryController extends Controller
{
    use ImageTrait;

    function __construct()
    {
        $this->middleware('permission:categories|categories.add|categories.edit|categories.destroy', ['only' => ['index','store']]);
        $this->middleware('permission:categories.add', ['only' => ['create','store']]);
        $this->middleware('permission:categories.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:categories.destroy', ['only' => ['destroy']]);
    }



    // Display a listing of the resource.
    public function index()
    {
        $categories = Category::with(['subcategories','parentcategory'])->where('parent_category',0)->get();
        return view('admin.categories.categories', compact('categories'));
    }



    // Show the form for creating a new resource.
    public function create()
    {
        $categories = Category::where('parent_category',0)->get();
        return view('admin.categories.add_category', compact('categories'));
    }



    // Store a newly created resource in storage.
    public function store(CategoriesRequest $request)
    {
        
        $input = $request->except('_token','image','parent_category','parent_cat');

        try
        {

            // Parent Category
            if ($request->parent_cat) {
                $input['parent_category'] = 0;
            }else{
                $input['parent_category'] = $request->parent_category;
            }

            // $input['parent_category'] = (isset($request->parent_category) && !empty($request->parent_category)) ? $request->parent_category : 0;

            // Upload Category Image when Exists
            if ($request->hasFile('image'))
            {
                $file = $request->file('image');
                $image_url = $this->addSingleImage('category','category_images',$file, $old_image = '',"300*300");
                $input['image'] = $image_url;
            }

            // Insert Category
            Category::insert($input);

            // return redirect()->route('categories')->with('success','Category has been Inserted SuccessFully..');
            return $this->sendResponse(true, "Category has been Inserted SuccessFully....");

        }
        catch (\Throwable $th)
        {
            
            // return redirect()->route('categories')->with('error','Internal Server Error!');
            return $this->sendResponse(false, "500, Internal Server Error!");

        }
    }



    // Display the specified resource.
    public function show(Category $category)
    {
        //
    }



    // Show the form for editing the specified resource.
    public function edit(Request $request)
    {
        
        $category_id =  decrypt($request->id);
try {
    //code...
    // Existing Category Details
    $category_details = Category::where('id',$category_id)->first();

    // Get All Parent Categories
    // $categories = Category::where('parent_category',0)->where('id','!=',$category_id)->get();

    return $this->sendResponse(true,"Category has been Retrive SuccessFully...",$category_details);
} catch (\Throwable $th) {
    //throw $th;
    return $this->sendResponse(false, "500, Internal Server Error!");
}

    }


    // CategoriesRequest
    // Update the specified resource in storage.
    public function update(CategoriesRequest $request)
    {
        

        $category_id = isset($request->id) ? $request->id : '';
        $input = $request->except('_token','category_id','image','parent_category','parent_cat');
        
        try
        {
            $category = Category::find($category_id);
            
            
            // Parent Category
            if ($request->parent_cat == null || $request->parent_cat ) {
                
                $input['parent_category'] = 0;
            }else{
                
                $input['parent_category'] = $request->parent_category;
            }

            // Parent Category
            // $input['parent_category'] = (isset($request->parent_category) && !empty($request->parent_category)) ? $request->parent_category : 0;

            // Save Image if exists
            if ($request->has('image'))
            {
                // Old Image
                $old_image_name = (isset($category['image'])) ? $category['image'] : '';

                // Upload Category Image when Exists
                if ($request->hasFile('image'))
                {
                    $file = $request->file('image');
                    $image_url = $this->addSingleImage('category','category_images',$file, $old_image = $old_image_name,"300*300");
                    $input['image'] = $image_url;
                }
            }

            // Update Category
            if ($category)
            {
                $category->update($input);
            }

            
            return $this->sendResponse(true, "Category has been Upadated SuccessFully....");

        }
        catch (\Throwable $th)
        {
            return $this->sendResponse(false, "500, Internal Server Error!"); 
        }
    }



    // Change Category Status
    public function status(Request $request)
    {
        $status = $request->status;

        try
        {
            $category_id = decrypt($request->id);
            $input = Category::find($category_id);
            $input->status =  $status;
            $input->update();

            return response()->json(
            [
                'success' => 1,
                'message' => "Status has been Changed Successfully..",
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



    // Remove the specified resource from storage.
    public function destroy(Request $request)
    {
        try
        {
            $category_id = decrypt($request->id);

            $category = Category::where('id',$category_id)->first();

            $child_exists = Category::where('parent_category', $category_id)->count();
            $design_exists = Design::where('category_id',$category_id)->count();

            if($child_exists > 0)
            {
                return response()->json([
                    'success' => 0,
                    'message' => "This category will not be deleted until it has a design or has a child category!",
                ]);
            }
            else if($design_exists > 0)
            {
                return response()->json([
                    'success' => 0,
                    'message' => "This category will not be deleted until it has a design or has a child category!",
                ]);
            }

            // Delete Category Image
            $cat_image = isset($category->image) ? $category->image : '';
            if(!empty($cat_image) && file_exists('public/images/uploads/category_images/'.$cat_image))
            {
                unlink('public/images/uploads/category_images/'.$cat_image);
            }

            // Delete Category
            Category::where('id',$category_id)->delete();

            return response()->json([
                'success' => 1,
                'message' => "Category has been Deleted SuccessFully...",
            ]);
        }
        catch (\Throwable $th)
        {
            return response()->json([
                'success' => 0,
                'message' => "Internal Server Error!",
            ]);
        }
    }
}
