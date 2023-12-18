<?php

namespace App\Http\Controllers\APIController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    AdminSetting,
    Category,
    Design,
    Metal,
    Gender,
    Tag,
    User,
    UserDocument,
    DealerCollection,
    UserWishlist,
    CartDealer,
    OrderDealerReport,
    CartUser,
    City,
    Order
};
use App\Http\Resources\{
    BannerResource,
    CategoryResource,
    DesignsResource,
    DetailDesignResource,
    FlashDesignResource,
    HighestDesignResource,
    MetalResource,
    GenderResource,
    CustomerResource,
    DesignsCollectionFirstResource,
    DesignCollectionListResource,
    CartDelaerListResource,
    OrderDelaerListResource,
    CartUserListResource,
    HeaderTagsResource,
    StateCitiesResource
};
use App\Http\Requests\APIRequest\{
    DesignDetailRequest,
    DesignsRequest,
    SubCategoryRequest,
    UserProfileRequest
};
use Illuminate\Http\Response;
use Hash;
use Carbon\Carbon;
use App\Traits\ImageTrait;



class CustomerApiController extends Controller
{
    use ImageTrait;

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
    public function getAllBanners()
    {
        try
        {
            $currentDayIndex = Carbon::now()->dayOfWeek;
            $days_array = ["0", "1", "2", "3", "4", "5", "6"];
            $reorderder_days = array_merge(array_slice($days_array, $currentDayIndex), array_slice($days_array, 0, $currentDayIndex));
            $data = new BannerResource($reorderder_days);
            return $this->sendApiResponse(true, 0,'Banners Loaded SuccessFully', $data);
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

                if (empty($search) && empty($sort_by))
                {
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
                                $query->where('total_price_18k','>=',$minprice);
                        })->when($maxprice, function ($query) use ($maxprice){
                            $query->where('total_price_18k','<=',$maxprice);
                        })->limit(500)->get();
                }
                else if(!empty($sort_by) && empty($search))
                {
                    if($sort_by == "new_added")
                    {
                        $designs = Design::where('status', 1)->orderBy('created_at', 'DESC')->limit(500)->get();
                    }
                    else if($sort_by == "featured")
                    {
                        $designs = Design::where('is_flash',1)->where('status',1)->limit(500)->get();
                    }
                    else if($sort_by == "low_to_high")
                    {
                        $designs = Design::orderByRaw('CAST(total_price_18k as DECIMAL(8,2)) ASC')->where('status',1)->limit(500)->get();
                    }
                    else if($sort_by == "high_to_low")
                    {
                        $designs = Design::orderByRaw('CAST(total_price_18k as DECIMAL(8,2)) DESC')->where('status',1)->limit(500)->get();
                    }
                    else if($sort_by == "clear_all")
                    {
                        $designs = Design::limit(500)->get();
                    }
                    else if($sort_by == "highest_selling")
                    {
                        $designs = Design::where('highest_selling', 1)->where('status', 1)->limit(500)->get();
                    }
                }
                else
                {
                    // $tagids = Tag::where('name','like','%'.$search.'%')->pluck('id')->toArray();
                    $designs = Design::query();

                    $designs->with('categories','gender','metal');

                    // $designs = $designs->whereHas('gender', function ($que) use ($search){
                    //     $que->where('name','like','%'.$search.'%');
                    // });

                    // $designs = $designs->orwhereHas('metal', function ($que) use ($search){
                    //     $que->where('name','like','%'.$search.'%');
                    // });

                    // $designs = $designs->orwhereHas('categories', function ($que) use ($search){
                    //     $que->where('name','like','%'.$search.'%');
                    // });

                    // $designs = $designs->orwhere('name','like','%'.$search.'%');
                    $designs = $designs->where('code',$search);

                    // foreach($tagids as $tagid){
                    //     $designs = $designs->orWhereJsonContains('tags',"$tagid");
                    // }

                    $designs = $designs->limit(500)->get();
                }

                $data = new DesignsResource($designs);
                return $this->sendApiResponse(true, 0,'Filter Design Loaded SuccessFully', $data);
        } catch (\Throwable $th) {
            dd($th);
            return $this->sendApiResponse(false, 0,'Failed to Load Designs!', (object)[]);
        }
    }

    // Function for Related Design List from Design
    public function relatedDesigns(Request $request)
    {
        try {
            $id = $request->categoryId;
            $sub_category_ids = Category::where('parent_category',$id)->pluck('id');
            $designs = Design::whereIn('category_id',$sub_category_ids)->with('categories')->get();
            // $designs = Design::where('category_id',$id)->with('categories')->get();
            // $category = Category::where('id',$id)->first();
            $data = new DesignsResource($designs);
            return response()->json(
            [
                'success' => true,
                'message' => 'Related Design Loaded SuccessFully',
                // 'category_name' => $category->name,
                'category_name' => '',
                'data'    => $data,
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {

            return $this->sendApiResponse(false, 0,'Failed to Load Designs!', (object)[]);

        }

    }

    public function getalldesigns(Request $request)
    {
        try{
            $user_type = $request->userType;
            $user_id = $request->userId;

            $designs = Design::query();

            if($user_type == 1){
                $designs = $designs->with(['dealer_collections' => function ($query) use ($user_id) {
                    $query->where('user_id', $user_id);
                }])->limit(500)->get()->sortBy(function($design) {
                    return optional($design->dealer_collections)->first()->design_id ?? PHP_INT_MAX;
                })->values();
            }else{
                $designs = $designs->limit(500)->get();
            }
            $data = new DesignsResource($designs);
            $minprice = Design::min('total_price_18k');
            $maxprice = Design::max('total_price_18k');

            return response()->json(
                [
                    'success' => true,
                    'message' => 'All Design Loaded SuccessFully',
                    'minprice' => round($minprice),
                    'maxprice' => round($maxprice),
                    'data'    => $data,
                ], Response::HTTP_OK);

        } catch (\Throwable $th) {
             return $this->sendApiResponse(false, 0,'Failed to Load Designs!', (object)[]);

         }
    }

    public function profile(Request $request)
    {
        try {
            // $id = auth()->user()->id;
            $user = User::where('email',$request->email)->with('document')->first();
            $data = new CustomerResource($user);
               return $this->sendApiResponse(true, 0,'Profile Loaded SuccessFully', $data);
            } catch (\Throwable $th) {
                dd($th);
            return $this->sendApiResponse(false, 0,'Failed to Load Profile!', (object)[]);
        }
    }

    public function updateProfile(Request $request)
    {


        try {
            $id = $request->id;
            $input = $request->except('id','password','document');
            if ($request->password || $request->password != null) {
                $input['password'] = Hash::make($request->password);
            }
            $dealer = User::find($id);

            if ($request->has('logo'))
            {
                $old_logo = (isset($dealer->logo)) ? $dealer->logo : '';
                if( $request->hasFile('logo'))
                {
                    $file = $request->file('logo');
                    $image_url = $this->addSingleImage('comapany_logo','companies_logos',$file, $old_image = $old_logo,"300*300");
                    $input['logo'] = $image_url;
                }
            }

            if ($request->hasFile('document')) {

                $multiple = $request->file('document');
                foreach ($multiple as $value)
                {
                    $doc = new UserDocument;
                    $doc->user_id = $id;
                    $multiDoc = $this->addSingleImage('document','documents',$value,$old_image = '','default');
                    $doc->document = $multiDoc;
                    $doc->save();
                }
            }
            if ($dealer)
            {
                $dealer->update($input);
            }
            $data = new CustomerResource($dealer);
            return $this->sendApiResponse(true, 0,'Profile update Loaded SuccessFully', $data);
        } catch (\Throwable $th) {
            return $this->sendApiResponse(false, 0,'Failed to Profile Update Profile!', (object)[]);
        }
    }


    public function dealerAddCollectionDesign(Request $request)
    {
        try {
                    $email = $request->email;
                    $designId = $request->design_id;

                    $user = User::where('email',$email)->first();
                    $userId = $user->id;


                    $collection = DealerCollection::where('user_id',$userId)->where('design_id',$designId)->first();

                    if (empty($collection)) {

                        $insert = new DealerCollection;
                        $insert->user_id = $userId;
                        $insert->design_id = $designId;
                        $insert->save();
                        return response()->json(
                            [
                                'success' => true,
                                'message' => 'Added design collection SuccessFully',
                                'collection_status' => 1,
                            ], Response::HTTP_OK);

                    }else{

                        // $deletecollection = DealerCollection::find($collection->id);
                        // $collection->delete();
                        return response()->json(
                            [
                                'success' => true,
                                'message' => 'Already design collection Exits',
                                'collection_status' => 0,
                            ], Response::HTTP_OK);

                    }

                } catch (\Throwable $th) {

                    return $this->sendApiResponse(false, 0,'Failed to Load Update Profile!', (object)[]);
                }

    }

    public function dealerRemoveCollectionDesign(Request $request)
    {
        try {
            $email = $request->email;
            $designId = $request->design_id;

            $user = User::where('email',$email)->first();
            $userId = $user->id;


            $collection = DealerCollection::where('user_id',$userId)->where('design_id',$designId)->first();

            if ($collection) {

                $deletecollection = DealerCollection::find($collection->id);
                $deletecollection->delete();
                            return response()->json(
                    [
                        'success' => true,
                        'message' => 'Remove design collection SuccessFully',
                        'collection_status' => 0,
                    ], Response::HTTP_OK);
            }else{
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'design collection Not Found',
                        'collection_status' => 0,
                    ], Response::HTTP_OK);
            }



        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
            return $this->sendApiResponse(false, 0,'Failed to Dealer Remove Collection!', (object)[]);

        }
    }

    public function listCollectionDesign(Request $request)
    {
        try {
            $email = $request->email;
            $user = User::where('email',$email)->first();
            $userId = $user->id;
            $collection = DealerCollection::where('user_id',$userId)->with('designs')->get();

            $data = new DesignCollectionListResource($collection);

            return $this->sendApiResponse(true, 0,'Collection Design Loaded SuccessFully', $data);
        } catch (\Throwable $th) {
            return $this->sendApiResponse(false, 0,'Failed to Load Collection Design!', (object)[]);

        }
    }

    public function getalldesignscollection(Request $request)
    {
        try {
            $email = $request->email;
            $user = User::where('email',$email)->first();
            $userId = $user->id;
            $collection = DealerCollection::where('user_id',$userId)->with('designs')->pluck('design_id');
            $data = new DesignsCollectionFirstResource($collection);
            return $this->sendApiResponse(true, 0,'Collection First Design Loaded SuccessFully', $data);

        } catch (\Throwable $th) {
            dd($th);
            return $this->sendApiResponse(false, 0,'Failed to Load Collection First Design!', (object)[]);

        }
    }

    public function userAddWishlist(Request $request)
    {
        try {
            $phone = $request->phone;
            $design_id = $request->design_id;
            $design_name = $request->design_name;
            $gold_color = $request->gold_color;
            $gold_type = $request->gold_type;

            $user = User::where('phone',$phone)->first();

            if(isset($user->id)){
                $wishlist = UserWishlist::where('user_id',$user->id)->where('design_id',$design_id)->first();
                if (empty($wishlist)) {
                    $new_wishlist = new UserWishlist;
                    $new_wishlist->user_id = $user->id;
                    $new_wishlist->design_id = $design_id;
                    $new_wishlist->design_name = $design_name;
                    $new_wishlist->gold_color = $gold_color;
                    $new_wishlist->gold_type = $gold_type;
                    $new_wishlist->save();
                    return response()->json([
                        'success' => true,
                        'message' => 'Design has been Added to Wishlist.',
                        'wishlist_status' => 1,
                    ], Response::HTTP_OK);
                }
                else{
                    return response()->json([
                        'success' => true,
                        'message' => 'This design is already exists in your wishlist!',
                        'wishlist_status' => 0,
                    ], Response::HTTP_OK);
                }
            }else{
                return response()->json([
                    'success' => true,
                    'message' => 'User not Found!',
                    'wishlist_status' => 0,
                ], Response::HTTP_OK);
            }
        } catch (\Throwable $th) {
            return $this->sendApiResponse(false, 0,'Something went wrong!', (object)[]);
        }

    }

    public function userReomveWishlist(Request $request)
    {
        try {
            $phone = $request->phone;
            $designId = $request->design_id;
            $user = User::where('phone',$phone)->first();
            $userId = $user->id;


            $wishlist = UserWishlist::where('user_id',$userId)->where('design_id',$designId)->first();

            if ($wishlist) {
                $deletewishlist = UserWishlist::find($wishlist->id);
                $deletewishlist->delete();
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'Remove User wishlist SuccessFully',
                        'wishlist_status' => 0,
                    ], Response::HTTP_OK);
            }else{
                return response()->json(
                    [
                        'success' => true,
                        'message' => 'User wishlist Not Found',
                        'wishlist_status' => 0,
                    ], Response::HTTP_OK);
            }


        } catch (\Throwable $th) {
            return $this->sendApiResponse(false, 0,'Failed to Load Collection Design!', (object)[]);
        }
    }


    public function userProfile(Request $request)
    {
        try {

            $phone = $request->phone;
            $user = User::where('phone',$phone)->first();
            $data = new CustomerResource($user);
            return $this->sendApiResponse(true, 0,'User Profile Loaded SuccessFully', $data);
        } catch (\Throwable $th) {
            return $this->sendApiResponse(false, 0,'Failed to Load User Profile!', (object)[]);
        }
    }

    public function updateUserProfile(UserProfileRequest $request)
    {
        try {
            $id = $request->id;
            $input = $request->except('id','user_image');
            $user = User::find($id);

            if (isset($user->id)){

                if ($request->has('user_image')){
                    $old_logo = (isset($user->logo)) ? $user->logo : '';
                    if( $request->hasFile('user_image'))
                    {
                        $file = $request->file('image');
                        $image_url = $this->addSingleImage('user_image','user_images',$file, $old_logo,"300*300");
                        $input['profile'] = $image_url;
                    }
                }

                $user->update($input);

                if(isset($user->name) && !empty($user->name) && isset($user->email) && !empty($user->email) && isset($user->phone) && !empty($user->phone) && isset($user->pincode) && !empty($user->pincode) && isset($user->address) && !empty($user->address) && isset($user->city) && !empty($user->city) && isset($user->state) && !empty($user->state))
                {
                    $user->update(['verification' => 3]);
                }else{
                    $user->update(['verification' => 2]);
                }
                $data = new CustomerResource($user);
                return $this->sendApiResponse(true, 0,'Profile has been Updated.', $data);
            }else{
                return $this->sendApiResponse(false, 0,'User not Found!', (object)[]);
            }
        } catch (\Throwable $th) {
            return $this->sendApiResponse(false, 0,'Failed to Update Profile!', (object)[]);
        }
    }

    public function getuserWishlist(Request $request)
    {
        try {
            $phone = $request->phone;
            $user = User::where('phone',$phone)->first();
            if(isset($user->id)){
                $user_id = $user->id;
                $collection = UserWishlist::where('user_id',$user_id)->with('designs')->get();
                $data = new DesignCollectionListResource($collection);
                return $this->sendApiResponse(true, 0,'User Wishlist Loaded SuccessFully', $data);
            }else{
                return $this->sendApiResponse(false, 0,'User not Found!', (object)[]);
            }
        } catch (\Throwable $th) {
            return $this->sendApiResponse(false, 0,'Failed to Load User Wishlist!', (object)[]);
        }
    }

    public function dealerCartStore(Request $request)
    {
        try {
            $email = $request->email;
            $user = User::where('email',$email)->first();
            $userId = $user->id;
            $insert = $request->except('email');
            $insert['dealer_id'] = $userId;
            $data = CartDealer::create($insert);

            return $this->sendApiResponse(true, 0,'Add To Cart SuccessFully', $data);
        } catch (\Throwable $th) {
            dd($th);
            return $this->sendApiResponse(false, 0,'Failed to Add To Cart!', (object)[]);
        }
    }

    public function dealerCartList(Request $request)
    {
        try {
            $email = $request->email;
            $user = User::where('email',$email)->first();
            $userId = $user->id;
            $carts =  CartDealer::where('dealer_id',$userId)->with('designs')->get();
            $data = new CartDelaerListResource($carts);
            return $this->sendApiResponse(true, 0,'Cart List SuccessFully', $data);

        } catch (\Throwable $th) {
            return $this->sendApiResponse(false, 0,'Failed to Cart List!', (object)[]);

        }
    }

    public function dealerCartRemove(Request $request)
    {
        try {
            $cartId = $request->cart_id;
            if ($cartId) {
                $cartRemove = CartDealer::where('id',$cartId);
                $cartRemove->delete();

                return $this->sendApiResponse(true, 0,'Remove Cart SuccessFully', (object)[]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
            return $this->sendApiResponse(false, 0,'Failed to Cart List!', (object)[]);

        }
    }

    public function dealerOrderStore(Request $request)
    {
        try {

            $email = $request->email;
            $items = $request->items;
            $user = User::where('email',$email)->first();
            $userId = $user->id;
            foreach ($items as $item){
                $data = new OrderDealerReport;
                $data->order_date = Carbon::now()->format('Y-m-d');
                $data->dealer_id = $userId;
                $data->design_id = $item['id'];
                $data->quantity = $item['quantity'];
                $data->order_status = 'Pending';
                $data->save();
            }
            return $this->sendApiResponse(true, 0,'Order SuccessFully',(object)[]);
        } catch (\Throwable $th) {
            dd($th);
            return $this->sendApiResponse(false, 0,'Failed to Order!', (object)[]);

        }

    }

    public function dealerOrderList(Request $request)
    {
        try {
            $email = $request->email;
            $user = User::where('email',$email)->first();
            $userId = $user->id;
            $order =  OrderDealerReport::where('dealer_id',$userId)->with('designs')->get();
            $data = new OrderDelaerListResource($order);
            return $this->sendApiResponse(true, 0,'Order List SuccessFully', $data);
        } catch (\Throwable $th) {
            return $this->sendApiResponse(false, 0,'Failed to Order List!', (object)[]);
        }
    }

    public function userCartStore(Request $request)
    {
        try {
            $phone = $request->phone;
            $user = User::where('phone',$phone)->first();

            if($user->id){
                $user_id = $user->id;
                $input = $request->except('phone');
                $input['user_id'] = $user_id;
                $input['quantity'] = (isset($request->quantity) && !empty($request->quantity)) ? $request->quantity : 1;

                $is_exists = CartUser::where('user_id',$user_id)->where('design_id', $request->design_id)->where('gold_type', $request->gold_type)->where('gold_color', $request->gold_color)->first();
                if(isset($is_exists->id)){
                    UserWishlist::where('user_id',$user_id)->where('design_id', $request->design_id)->where('gold_type', $request->gold_type)->where('gold_color', $request->gold_color)->delete();
                    return $this->sendApiResponse(false, 0,'Design has already exists in Your Cart!', (object)[]);
                }else{
                    $data = CartUser::create($input);
                    $data['total_quantity'] =  CartUser::where('user_id',$user_id)->sum('quantity');
                    UserWishlist::where('user_id',$user_id)->where('design_id', $request->design_id)->where('gold_type', $request->gold_type)->where('gold_color', $request->gold_color)->delete();
                    return $this->sendApiResponse(true, 0,'Design has been Added to Your Cart.', $data);
                }
            }else{
                return $this->sendApiResponse(false, 0,'User not Found!', (object)[]);
            }
        } catch (\Throwable $th) {
            return $this->sendApiResponse(false, 0,'Failed to Add to Cart!', (object)[]);
        }
    }

    public function userCartList(Request $request)
    {
        try {
            $phone = $request->phone;
            $user = User::where('phone',$phone)->first();
            $userId = $user->id;
            $cart_data['carts'] =  CartUser::where('user_id',$userId)->with('designs')->get();
            $cart_data['total_qty'] =  CartUser::where('user_id',$userId)->sum('quantity');

            $data = new CartUserListResource($cart_data);
            return $this->sendApiResponse(true, 0,'Cart List SuccessFully', $data);
        } catch (\Throwable $th) {
            return $this->sendApiResponse(false, 0,'Failed to Cart List!', (object)[]);
        }
    }

    function userCartUpdate(Request $request) {
        try {
            $cart_item_id = $request->id;
            $update_type = $request->update_type;
            $cart_item = CartUser::find($cart_item_id);

            if($cart_item){
                if($update_type == 'increment'){
                    $cart_item->quantity = $cart_item->quantity + 1;
                }else{
                    $cart_item->quantity = $cart_item->quantity - 1;
                }
                $cart_item->update();
                return $this->sendApiResponse(true, 0,'Cart has been Updated SuccessFully...', (object)[]);
            }else{
                return $this->sendApiResponse(false, 0,'Failed to Update Cart!', (object)[]);
            }
        } catch (\Throwable $th) {
            return $this->sendApiResponse(false, 0,'Failed to Update Cart!', (object)[]);
        }
    }

    public function userCartRemove(Request $request)
    {
        try {
            $cartId = $request->cart_id;
            if ($cartId) {
                $cart_item = CartUser::where('id',$cartId)->first();
                $cart_item->delete();
                $data['total_quantity'] =  CartUser::where('user_id',$cart_item['user_id'])->sum('quantity');
                return $this->sendApiResponse(true, 0,'Remove Cart SuccessFully', $data);
            }
        } catch (\Throwable $th) {
            return $this->sendApiResponse(false, 0,'Failed to Cart List!', (object)[]);

        }

    }

    public function userPurchaseOrder(Request $request)
    {
        try
        {
            $user_id = $request->user_id;
            $dealer_code = (isset($request->dealer_code)) ? $request->dealer_code : '';
            $dealer_discount_type = (isset($request->dealer_discount_type)) ? $request->dealer_discount_type : '';
            $dealer_discount_value = (isset($request->dealer_discount_value)) ? $request->dealer_discount_value : '';
            $cart_items = (isset($request->cart_items)) ? $request->cart_items : [];
            $gold_price = (isset($request->gold_price)) ? $request->gold_price : [];
            $gold_color_arr = [
                'yellow_gold' => 'Yellow Gold',
                'rose_gold' => 'Rose Gold',
                'white_gold' => 'White Gold',
            ];
            $gross_weight_keys = [
                '22k' => 'gweight4',
                '20k' => 'gweight3',
                '18k' => 'gweight2',
                '14k' => 'gweight1',
            ];

            $user = User::find($user_id);
            $dealer = User::where('dealer_code', $dealer_code)->first();

            if($user && count($cart_items) > 0){

                // Create New Order
                $order = new Order();
                $order->user_id = $user->id;
                $order->dealer_id = (isset($dealer->id)) ? $dealer->id : NULL;
                $order->name = $user->name;
                $order->email = $user->email;
                $order->phone = $user->phone;
                $order->address = ($user->address_same_as_company == 1) ? $user->address : $user->shipping_address;
                $order->city = ($user->address_same_as_company == 1) ? $user->city : $user->shipping_city;
                $order->state = ($user->address_same_as_company == 1) ? $user->state : $user->shipping_state;
                $order->pincode = ($user->address_same_as_company == 1) ? $user->pincode : $user->shipping_pincode;
                $order->dealer_code = $dealer_code;
                $order->dealer_discount_type = $dealer_discount_type;
                $order->dealer_discount_value = $dealer_discount_value;
                $order->gold_price = json_encode($gold_price);
                $order->sub_total = $request->sub_total;
                $order->total = $request->total;
                // $order->save();

                // if($order->id)
                // {
                        foreach($cart_items as $cart_item)
                        {
                            $cart_item = CartUser::with(['designs'])->where('id',$cart_item)->first();
                            $item_quantity = $cart_item->quantity;
                            $gold_type = $cart_item->gold_type;
                            $gold_color = $gold_color_arr[$cart_item->gold_color];
                            $gross_weight = $cart_item->designs[$gross_weight_keys[$gold_type]];
                            $less_gems_stone = $cart_item->designs['less_gems_stone'];
                            $less_cz_stone  = $cart_item->designs['less_cz_stone '];

                            // echo '<pre>';
                            // print_r($gold_color);
                            // exit();
                            echo '<pre>';
                            print_r($cart_item->toArray());
                            exit();
                        }
                // }

            }else{
                echo '<pre>';
                print_r($request->all());
                exit();
                return $this->sendApiResponse(false, 0,'Failed to Purchase Order!', (object)[]);
            }

            echo '<pre>';
            print_r($request->all());
            exit();
        }
        catch (\Throwable $th)
        {
            dd($th);
            return $this->sendApiResponse(false, 0,'Failed to Purchase Order!', (object)[]);
        }
    }

    // function for Get All States
    public function getStateCities(Request $request)
    {
        try {
            $cities = City::select('id','state_id','name')->where('state_id',$request->state_id)->get();
            $data = new StateCitiesResource($cities);
            return $this->sendApiResponse(true, 0,'State records retrived SuccessFully..', $data);
        } catch (\Throwable $th) {
            return $this->sendApiResponse(false, 0,'Failed to retrived States!', (object)[]);
        }
    }

    // Function for Get Header Tags
    function getHeaderTags()
    {
        try {
            $tags = Tag::where('display_on_header',1)->where('status',1)->get();
            $data = new HeaderTagsResource($tags);
            return $this->sendApiResponse(true, 0,'Header Tags retrived SuccessFully..', $data);
        } catch (\Throwable $th) {
            return $this->sendApiResponse(false, 0,'Failed to retrived Tags!', (object)[]);
        }
    }

    // Function for Apply Dealer Code
    function applyDealerCode(Request $request)
    {
        try {
            $dealer_code = (isset($request->dealer_code)) ? $request->dealer_code : '';

            if(!empty($dealer_code)){
                // Dealer
                $dealer = User::where('dealer_code', $dealer_code)->first();
                if(isset($dealer->id) && $dealer->status == 1){
                    $code_data['dealer_code'] = $dealer->dealer_code;
                    $code_data['discount_type'] = $dealer->discount_type;
                    $code_data['discount_value'] = $dealer->discount_value;
                    return $this->sendApiResponse(true, 0,'Dealer code has been Applied SuccessFully.', $code_data);
                }else{
                    return $this->sendApiResponse(false, 0,'Please Enter a Valid Dealer Code!', (object)[]);
                }
            }else{
                return $this->sendApiResponse(false, 0,'Please Enter a Dealer Code!', (object)[]);
            }
        } catch (\Throwable $th) {
            return $this->sendApiResponse(false, 0,'Something went Wrong!', (object)[]);
        }
    }


    // Function for Get Settings
    function getSiteSettings()
    {
        try
        {
            $keys = [
                'instagram_link',
                'facebook_link',
                'twitter_link',
                'youtube_link',
                'frontend_copyright',
            ];

            $settings = [];
            foreach($keys as $key_val)
            {
                $setting = AdminSetting::where('setting_key', $key_val)->first();
                $settings[$key_val] = (isset($setting->value) && !empty($setting->value)) ? $setting->value : '';
            }

            return $this->sendApiResponse(true, 0,'Site Settings has been Fetched.', $settings);

        }
        catch (\Throwable $th)
        {
            return $this->sendApiResponse(false, 0,'Something went Wrong!', (object)[]);
        }
    }

}
