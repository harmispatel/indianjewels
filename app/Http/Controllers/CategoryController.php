<?php

namespace App\Http\Controllers;

use App\Models\{Category, Design};
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\CategoriesRequest;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\ImageTrait;



class CategoryController extends Controller
{
    use ImageTrait;

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:admin.categories|categories.add-category|categories.edit-category|categories.destroy', ['only' => ['index','store']]);
         $this->middleware('permission:categories.add-category', ['only' => ['create','store']]);
         $this->middleware('permission:categories.edit-category', ['only' => ['edit','update']]);
         $this->middleware('permission:categories.destroy', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $categories = Category::with('subcategory','parent')->where('parent_category',0)->get();


        
        return view('admin.categories.categories', compact('categories'));
    }

    



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('parent_category',0)->get();
        return view('admin.categories.add-category', compact('categories'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoriesRequest $request)
    {

        $input = $request->except('_token','image');

        // Upload new Image
        if ($request->has('image'))
        {
            $file = $request->image;
            $singleFile = $this->addSingleImage('category_image',$file, $oldImage = '',"300*300");
            $input['image'] = $singleFile;
        }
        try
        {
            $category = Category::insert($input);
            return response()->json(
            [
                'success' => 1,
                'message' => "Category has been inserted Successfully..",
            ]);
        }
        catch (\Throwable $th)
        {
            return redirect()->route('admin.categories')->with('error','Something with wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $id =  decrypt($id);
        $data = Category::where('id',$id)->first();
        $categories = Category::where('parent_category',0)->where('id','!=',$data->id)->get();
        return view('admin.categories.edit-category', compact('categories','data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoriesRequest $request, Category $category)
    {
        $category_id = isset($request->id) ? $request->id : '';
        $input = $request->except('_token','id');
        try
        {
            $category = Category::find($category_id);
            
            // Save Image if exists and Delete old Image
            if ($request->has('image'))
            {
                $cimg = Category::where('id',$id)->first();

                // Delete old Image
                $old_image = isset($cimg->image) ? $cimg->image : '';

                // Upload new Image
                $file = $request->image;
                $singleFile = $this->addSingleImage('category_image',$file, $old_image,"300*300");
                $input['image'] = $singleFile;
            }

            if ($category)
            {
                $category->update($input);
            }
            return response()->json(
            [
                'success' => 1,
                'message' => "Category updated Successfully..",
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
     * Update the specified status in storage.
     */
    public function status(Request $request)
    {
        
        $status = $request->status;
        $id = $request->id;
        try
        {
            $input = Category::find($id);
            $input->status =  $status;
            $input->update();

            return response()->json(
            [
                'success' => 1,
                'message' => "Category Status has been Changed Successfully..",
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
            $category = Category::where('id',$id)->first();
            
            $child_exists = Category::where('parent_category', $id)->count();
            $design_exists = Design::where('category_id',$id)->count();

            
            
            if ($child_exists > 0) 
            {
                return response()->json(
                    [
                        'success' => 2,
                        'message' => "This category will not be deleted until it has a design or has a child category!",
                    ]);
            }
            else if($design_exists > 0)
            {
                return response()->json(
                    [
                        'success' => 2,
                        'message' => "This category will not be deleted until it has a design or has a child category!",
                    ]);
            }
                

            // Delete old Image
            $oldImage = isset($category->image) ? $category->image : '';
            if (!empty($oldImage) && file_exists('public/images/category_image/'.$oldImage))
            {
                unlink('public/images/category_image/'.$oldImage);
            }

             Category::where('id',$id)->delete();

            return response()->json(
            [
                'success' => 1,
                'message' => "Category delete Successfully..",
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
