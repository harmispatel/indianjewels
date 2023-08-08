<?php

namespace App\Http\Controllers\APIController;

use App\Http\Controllers\Controller;
use App\Models\{Category,Design,Slider,Metal,Gender};
use Illuminate\Http\Request;
use App\Http\Resources\{CategoryResource,FlashDesignResource, HighestDesignResource, SliderResource, DetailDesignResource, DesignsResource, MetalResource, GenderResource};
use App\Http\Requests\APIRequest\{DesignDetailRequest, DesignsRequest};

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
    public function getDesignDetail(DesignDetailRequest $request)
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
    public function getDesigns(DesignsRequest $request)
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


    // Function for Metal list from Metal
    public function getMetal()
    {
        try {
            
            $metal = Metal::get();
            $data = new MetalResource($metal);
            return $this->sendApiResponse(true, 0,'Metal Loaded SuccessFully.', $data);
        } catch (\Throwable $th) {
    
            return $this->sendApiResponse(false, 0,'Failed to Load Designs!', (object)[]);
    
        }

    }

    // Function for Gender List from Gender
    public function getGender()
    {
        try {
            //code...
            $gender = Gender::get();
            $data = new GenderResource($gender);
            return $this->sendApiResponse(true, 0,'Gender Loaded SuccessFully.', $data);

        } catch (\Throwable $th) {
            return $this->sendApiResponse(false, 0,'Failed to Load Designs!', (object)[]);
        }
    }

    // Function for child category List from Category
    public function getChildCategories()
    {
        try {
            $categories = Category::where('parent_category','!=', 0)->where('status', 1)->get();
            $data = new CategoryResource($categories);
            return $this->sendApiResponse(true, 0,'Child Categories Loaded SuccessFully', $data);
        } catch (\Throwable $th) {

            return $this->sendApiResponse(false, 0,'Failed to Load Designs!', (object)[]);

        }
    }

    // Function for get Design List from Design
    Public function filterDesign(Request $request)
    {
        try {
            
            $main_categorys = $request->categoryIds;
            $metals = $request->MetalIds;
            $genders = $request->GenderIds;
            
            $main_categories = Category::whereIn('parent_category',$main_categorys)->get();
                if (count($main_categories) > 0) {
                    foreach ($main_categories as $main_category) {
                        $category_ids[] = $main_category['id'];
                    }
                }
                else
                {
                    $category_ids = [];
                }
            $designs = Design::query()
                                ->when($category_ids, function ($query) use ($category_ids) {
                                    $query->whereIn('category_id', $category_ids);
                                })
                                ->when($metals, function ($query) use ($metals) {
                                    $query->whereIn('metal_id', $metals);
                                })
                                ->when($request->has('GenderIds'), function ($query) use ($genders) {
                                    $query->whereIn('gender_id', $genders);
                                })
                                ->get();
            
            $data = new DesignsResource($designs);
            return $this->sendApiResponse(true, 0,'Filter Design Loaded SuccessFully', $data);
        } catch (\Throwable $th) {
            return $this->sendApiResponse(false, 0,'Failed to Load Designs!', (object)[]);   
        }
    }
}
