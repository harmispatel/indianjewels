<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
            return redirect()->route('admin.categories')->with('message','Category created successfully.');
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
    public function edit(Category $category,$id)
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
        $input = $request->except('_token','id');
        try
        {
            $id = decrypt($request->id);
            $category = Category::find($id);

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
            return redirect()->route('admin.categories')->with('message','Category updated successfully');
        }
        catch (\Throwable $th)
        {
            return redirect()->route('admin.categories')->with('error','Something went wrong');
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
