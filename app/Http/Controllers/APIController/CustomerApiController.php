<?php

namespace App\Http\Controllers\APIController;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class CustomerApiController extends Controller
{
    // Function for Fetch all categories
    public function getCategories()
    {
        try
        {
            $categories = Category::where('parent_category', 0)->where('status', 1)->get();
            $data = new CategoryResource($categories);
            return $this->sendApiResponse(true, 0,'Categories Loaded SuccessFully', $data);
        }
        catch (\Throwable $th)
        {
            return $this->sendApiResponse(false, 0,'Failed to Load Categories!', (object)[]);
        }
    }
}
