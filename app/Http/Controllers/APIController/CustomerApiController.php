<?php

namespace App\Http\Controllers\APIController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Resources\ParentCategoryResource;

class CustomerApiController extends Controller
{
    //
    public function parentcategory(Request $request)
    {
        $category  = Category::where('parent_category',$request->id)->get();
        
        $datas = new ParentCategoryResource($category);
    }
}
