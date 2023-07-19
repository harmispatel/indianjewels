<?php

namespace App\Http\Controllers\APIController;

use App\Http\Controllers\Controller;
use App\Models\{Category,Design};
use Illuminate\Http\Request;
use App\Http\Resources\{CategoryResource,FlashDesignResource, HighestDesignResource};

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

    // Function for fetch higest selling designs
    public function getHigestSellingDesigns(Request $request) 
    {
        try 
        {
            $designs = Design::where('highest_selling', 1)->limit(6)->get();
            $data = new HighestDesignResource($designs);
            return $this->sendApiResponse(true, 0,'Highest selling Designs Loaded SuccessFully', $data);
        } 
        catch (\Throwable $th) 
        {  
            return $this->sendApiResponse(false, 0,'Failed to Load Designs!', (object)[]);
        }
    }

    public function getFlashDesign()
        {
            
            try {
                    $designs = Design::where('is_flash',1)->where('status',1)->take(5)->get();
                    $data = new FlashDesignResource($designs);
                    return $this->sendApiResponse(true, 0,'Flash Design Loaded SuccessFully', $data);

            } catch (\Throwable $th) {
                //throw $th;
            return $this->sendApiResponse(false, 0,'Failed to Load Categories!', (object)[]);

           }
        }
        
}
