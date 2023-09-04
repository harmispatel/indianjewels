<?php

namespace App\Http\Controllers\APIController;

use App\Http\Controllers\Controller;
use App\Models\{Category,Design,Slider,Metal,Gender,Tag};
use Illuminate\Http\Request;
use App\Http\Resources\{CategoryResource,FlashDesignResource, HighestDesignResource, SliderResource, DetailDesignResource, DesignsResource, MetalResource, GenderResource};
use App\Http\Requests\APIRequest\{DesignDetailRequest, DesignsRequest, SubCategoryRequest};
use Illuminate\Http\Response;
use Carbon\Carbon;

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
    public function getSubCategories(SubCategoryRequest $request)
    {
        try 
        {
            $id = $request->parent_category;
            $categories = Category::where('parent_category',$id)->where('status', 1)->get();
            $data = new CategoryResource($categories);
            return $this->sendApiResponse(true, 0,'SubCategories Loaded SuccessFully', $data);
        } 
        catch (\Throwable $th) 
        {
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
        try 
        {
            $designs = Design::where('is_flash',1)->where('status',1)->take(5)->get();
            $data = new FlashDesignResource($designs);
            return $this->sendApiResponse(true, 0,'Flash Design Loaded SuccessFully', $data); 
        } 
        catch (\Throwable $th) 
        {
            return $this->sendApiResponse(false, 0,'Failed to Load Design!', (object)[]);
        }
    }

    // Function for fetch Slider
    public function getSlider()
    {
        try 
        {   
             // Get the current day of the week (0 = Sunday, 6 = Saturday)
                $currentDayIndex = Carbon::now()->dayOfWeek;

            // List of days of the week
            $daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];

            // Reorder the days of the week starting from today
            $reorderedDays = array_merge(array_slice($daysOfWeek, $currentDayIndex), array_slice($daysOfWeek, 0, $currentDayIndex));

            $data = new SliderResource($reorderedDays);
            return $this->sendApiResponse(true, 0,'Slider Loaded SuccessFully', $data); 
        } 
        catch (\Throwable $th) 
        {
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

    public function getTags()
    {
        try {
            
            $tags = Tag::get();
            $data = new GenderResource($tags);
            return $this->sendApiResponse(true, 0,'Tags Loaded SuccessFully.', $data);
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
            $tags = $request->TagIds;
            $search = $request->search;
            $sort_by = $request->sort_by;
            $minprice = $request->MinPrice;
            $maxprice = $request->MaxPrice;

            $main_categories = Category::whereIn('parent_category',$main_categorys)->get();
       
                if (count($main_categories) > 0)
                    {
                        foreach ($main_categories as $main_category) 
                        {
                            
                            $category_ids[] = strval($main_category['id']);
                        }
                    }
                    else
                    {
                    
                        $category_ids = [];
                    }
       
                if (empty($search) && empty($sort_by)) {
                        $designs = Design::query()
                                            ->when($category_ids, function ($query) use ($category_ids) {
                                                $query->whereIn('category_id', $category_ids);
                                            })
                                            ->when($metals, function ($query) use ($metals) {
                                                $query->whereIn('metal_id', $metals);
                                            })
                                            ->when($genders, function ($query) use ($genders) {
                                                $query->whereIn('gender_id', $genders);
                                            })->when($tags, function ($query) use ($tags){
                                                foreach($tags as $tag){
                                                    $query->orwhereJsonContains('tags',$tag);
                                                }
                                            })->when($minprice, function ($query) use ($minprice){
                                                    $query->where('price','>=',$minprice);
                                            })->when($maxprice, function ($query) use ($maxprice){
                                                $query->where('price','<=',$maxprice);
                                            })
                                            ->get();
                    }else if(!empty($sort_by) && empty($search)){

                            if($sort_by == "new_added"){
                                $designs = Design::where('status', 1)->orderBy('created_at', 'DESC')->get();
                                
                            }else if($sort_by == "featured"){
                                $designs = Design::where('is_flash',1)->where('status',1)->get();
                            }else if($sort_by == "low_to_high"){
                                $designs = Design::orderByRaw('CAST(price as DECIMAL(8,2)) ASC')->where('status',1)->get();
                            }else if($sort_by == "high_to_low"){
                                $designs = Design::orderByRaw('CAST(price as DECIMAL(8,2)) DESC')->where('status',1)->get();
                            }else{
                                $designs = Design::where('highest_selling',1)->where('status',1)->get();
                            }
                        
                        }else{   
                            $tagids = Tag::where('name','like','%'.$search.'%')->pluck('id')->toArray();
                            $designs = Design::query();

                            $designs->with('categories','gender','metal');

                            $designs = $designs->whereHas('gender', function ($que) use ($search){
                                $que->where('name','like','%'.$search.'%');
                            });

                            $designs = $designs->orwhereHas('metal', function ($que) use ($search){
                                $que->where('name','like','%'.$search.'%');
                            });

                            $designs = $designs->orwhereHas('categories', function ($que) use ($search){
                                $que->where('name','like','%'.$search.'%');
                            });

                            $designs = $designs->orwhere('name','like','%'.$search.'%');
                            
                            foreach($tagids as $tagid){
                                $designs = $designs->orWhereJsonContains('tags',"$tagid");
                            }
                                        
                            $designs = $designs->get();
                         }
                                
           
       $data = new DesignsResource($designs);
       return $this->sendApiResponse(true, 0,'Filter Design Loaded SuccessFully', $data);
        } catch (\Throwable $th) {
        return $this->sendApiResponse(false, 0,'Failed to Load Designs!', (object)[]);   
        }
    }

    // Function for Related Design List from Design
    public function relatedDesigns(Request $request)
    {
        try {
            $id = $request->categoryId;            
            
            $designs = Design::where('category_id',$id)->with('categories')->get();
            $category = Category::where('id',$id)->first();
            $data = new DesignsResource($designs);
            return response()->json(
            [
                'success' => true,
                'message' => 'Related Design Loaded SuccessFully',
                'category_name' => $category->name,
                'data'    => $data,
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            
            return $this->sendApiResponse(false, 0,'Failed to Load Designs!', (object)[]);   

        }

    }

    public function getalldesigns()
    {
        try{
            
            $designs = Design::get();
            $data = new DesignsResource($designs);
            $minprice = Design::min('price');
            $maxprice = Design::max('price');

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Related Design Loaded SuccessFully',
                    'minprice' => round($minprice),
                    'maxprice' => round($maxprice),
                    'data'    => $data,
                ], Response::HTTP_OK);
             
        } catch (\Throwable $th) {
             return $this->sendApiResponse(false, 0,'Failed to Load Designs!', (object)[]);   
 
         }
    }

}