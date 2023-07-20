<?php

namespace App\Http\Controllers\APIController;

use App\Http\Controllers\Controller;
use App\Models\{Category,Design,Slider};
use Illuminate\Http\Request;
use App\Http\Resources\{CategoryResource,FlashDesignResource, HighestDesignResource, SliderResource, DetailDesignResource, DesignsResource};

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
                    $designs = Design::where('highest_selling',1)->where('status',1)->take(6)->get();
                    $data = new HighestDesignResource($designs);
                    return $this->sendApiResponse(true, 0,'Highest selling Designs Loaded SuccessFully', $data);
                } 
                catch (\Throwable $th) 
                {  
                    return $this->sendApiResponse(false, 0,'Failed to Load Designs!', (object)[]);
                }
            }

            // Function for fetch Flash designs
            public function getFlashDesign()
            {
                
                try {
                        $designs = Design::where('is_flash',1)->where('status',1)->take(5)->get();
                        $data = new FlashDesignResource($designs);
                        return $this->sendApiResponse(true, 0,'Flash Design Loaded SuccessFully', $data);

                     } catch (\Throwable $th) {
                        
                        return $this->sendApiResponse(false, 0,'Failed to Load Design!', (object)[]);

                     }
            }

            // Function for fetch Slider
            public function getSlider()
            {
                try {

                    $sliders = Slider::where('status',1)->get();
                    
                    $data = new SliderResource($sliders);
                    return $this->sendApiResponse(true, 0,'Slider Loaded SuccessFully', $data);
                    
                } catch (\Throwable $th) {

                    return $this->sendApiResponse(false, 0,'Failed to Load Slider!', (object)[]);                    
                }
            }
        
    // Function for fetch lstest designs
    public function getLatestDesign(Request $request) 
    {
        try 
        {
            $designs = Design::where('status', 1)->orderBy('id', 'desc')->take(6)->get();
            $data = new HighestDesignResource($designs);
            return $this->sendApiResponse(true, 0,'Latest Designs Loaded SuccessFully.', $data);
        } 
        catch (\Throwable $th) 
        {  
            return $this->sendApiResponse(false, 0,'Failed to Load Designs!', (object)[]);
        }
    }

    // Function for design details
    public function getDesignDetail(Request $request)
    {
        try 
        {
            $id = $request->id;
            $design = Design::where('id', $id)->with('categories','metal','gender','designImages')->first(); 
            $data = new DetailDesignResource($design);
            return $this->sendApiResponse(true, 0,'Design Loaded SuccessFully.', $data);
        } 
        catch (\Throwable $th) 
        {
            return $this->sendApiResponse(false, 0,'Failed to Load Designs!', (object)[]);
        }
    }

    // Function for design details from category
    public function getDesigns(Request $request)
    {
        try 
        {
            $id = $request->category_id;
            $designs = Design::where('category_id', $id)->with('categories','metal','gender','designImages')->get(); 
            $data = new DesignsResource($designs);
            return $this->sendApiResponse(true, 0,'Designs Loaded SuccessFully.', $data);
        } 
        catch (\Throwable $th) 
        {
            return $this->sendApiResponse(false, 0,'Failed to Load Designs!', (object)[]);
        }
    }
}
