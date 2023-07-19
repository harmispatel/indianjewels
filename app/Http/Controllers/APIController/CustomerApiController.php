<?php

namespace App\Http\Controllers\APIController;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class CustomerApiController extends Controller
{
    // Function for Fetch Parent categories
    public function getParentCategories()
    {
        try
        {
            $categories = Category::where('parent_category', 0)->where('status', 1)->get();
            $data = new CategoryResource($categories);
            return $this->sendApiResponse(true, 0,'Parent Categories Loaded SuccessFully', $data);
        }
        catch (\Throwable $th)
        {
            return $this->sendApiResponse(false, 0,'Failed to Load Categories!', (object)[]);
        }
    }

    // Function for Fetch Sub categories
    public function getSubCategories(Request $request)
    {
        try {
            $categories = Category::where('parent_category',$request->id)->where('status', 1)->get();
            $data = new CategoryResource($categories);
            return $this->sendApiResponse(true, 0,'SubCategories Loaded SuccessFully', $data);
            
        } catch (\Throwable $th) {
            
            return $this->sendApiResponse(false, 0,'Failed to Load Categories!', (object)[]);

        }
    }
}
