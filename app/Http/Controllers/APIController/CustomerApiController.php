<?php

namespace App\Http\Controllers\APIController;

use Hash;
use Carbon\Carbon;
use App\Traits\ImageTrait;
use App\Http\Controllers\Controller;
use Illuminate\Http\{
    Request,
    Response
};
use App\Models\{
    Tag,
    User,
    City,
    Page,
    Order,
    Metal,
    Design,
    Gender,
    Category,
    CartUser,
    CartDealer,
    AdminSetting,
    UserDocument,
    UserWishlist,
    DealerCollection,
    OrderDealerReport,
    OrderItems,
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
    CustomPagesResource,
    HeaderTagsResource,
    OrderDetailsResource,
    OrdersResource,
    StateCitiesResource
};
use App\Http\Requests\APIRequest\{
    DesignDetailRequest,
    DesignsRequest,
    SubCategoryRequest,
    UserProfileRequest
};
use Illuminate\Support\Collection;

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
            $designs = Design::where('highest_selling',1)->where('status',1)->take(50)->get();
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
            $designs = Design::where('status', 1)->orderBy('id', 'desc')->take(50)->get();
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

    // Get Designs using filters (search, sorting);
    Public function filterDesign(Request $request)
    {
        try {
            $sub_categories = [];
            $parent_category = (isset($request->category_id)) ? $request->category_id : '';
            $metal = (isset($request->metal_id)) ? $request->metal_id : '';
            $gender = (isset($request->gender_id)) ? $request->gender_id : '';
            $tag = (isset($request->tag_id)) ? $request->tag_id : [];
            $search = (isset($request->search)) ? $request->search : '';
            $sort_by = (isset($request->sort_by)) ? $request->sort_by : '';
            $minprice = (isset($request->min_price)) ? $request->min_price : '';
            $maxprice = (isset($request->max_price)) ? $request->max_price : '';
            $offset = (isset($request->offset) && !empty($request->offset)) ? $request->offset : 0;
            $user_type = $request->userType;
            $user_id = $request->userId;

            if(isset($parent_category) && !empty($parent_category)){
                $sub_categories = Category::where('parent_category', $parent_category)->pluck('id')->toArray();
            }

            $designs = Design::where('status', 1);

            if(isset($search) && !empty($search)){
                // Search Filter
                $designs = $designs->where('code', $search);
            }else{
                // Category Filter
                if(isset($sub_categories) && count($sub_categories) > 0){
                    $designs = $designs->whereIn('category_id', $sub_categories);
                }

                // Gender Filter
                if(isset($gender) && !empty($gender)){
                    $designs = $designs->where('gender_id', $gender);
                }

                // Metal Filter
                if(isset($metal) && !empty($metal)){
                    $designs = $designs->where('metal_id', $metal);
                }

                // Tags Filter
                if (isset($tag) && !empty($tag)) {
                    $designs->where(function ($query) use ($tag) {
                        $query->orWhereJsonContains('tags', $tag);
                    });
                }

                // Price Range Filter
                if(isset($minprice) && !empty($minprice) && isset($maxprice) && !empty($maxprice)){
                    $designs->whereBetween('total_price_18k', [$minprice, $maxprice]);
                }

                // Sort By Filter
                if(isset($sort_by) && !empty($sort_by)){
                    if($sort_by == 'new_added'){
                        $designs = $designs->orderBy('created_at', 'DESC');
                    }elseif($sort_by == 'low_to_high'){
                        $designs = $designs->orderByRaw('CAST(total_price_18k as DECIMAL(8,2)) ASC');
                    }elseif($sort_by == 'high_to_low'){
                        $designs = $designs->orderByRaw('CAST(total_price_18k as DECIMAL(8,2)) DESC');
                    }else{
                        $designs = $designs->where('highest_selling', 1);
                    }
                }
            }

            $total_records = $designs->count();

            if($user_type == 1){
                $designs = $designs->with(['dealer_collections' => function ($query) use ($user_id) {
                    $query->where('user_id', $user_id);
                }])->get()->sortBy(function($design) {
                    return optional($design->dealer_collections)->first()->design_id ?? PHP_INT_MAX;
                })->values();
                $designs = $designs->slice($offset, 40);
            }else{
                $designs = $designs->offset($offset)->limit(40)->get();
            }

            $datas = new DesignsResource($designs, $sub_categories, $total_records);
            return $this->sendApiResponse(true, 1,'Designs has been Loaded.', $datas);

        } catch (\Throwable $th) {
            return $this->sendApiResponse(false, 0,'Failed to Load Designs!', (object)[]);
        }
    }

    // Function for Related Design List from Design
    public function relatedDesigns(Request $request)
    {
        try {
            $id = $request->categoryId;
            $offset = (isset($request->offset)) ? $request->offset : 0;
            $sub_categories = Category::where('parent_category',$id)->pluck('id');
            $total_designs =  Design::whereIn('category_id',$sub_categories)->count();
            $designs = Design::whereIn('category_id',$sub_categories)->with('categories')->offset($offset)->limit(20)->get();
            $data = new DesignsResource($designs , null, $total_designs);
            return response()->json([
                'success' => true,
                'message' => 'Related Design Loaded SuccessFully',
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
                        'total_quantity' =>  UserWishlist::where('user_id',$user->id)->count(),
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
                        'total_quantity' =>  UserWishlist::where('user_id',$userId)->count(),
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
            $input = $request->except('id');
            $user = User::find($id);

            if (isset($user->id)){
                $user->update($input);
                if(isset($user->name) && !empty($user->name) && isset($user->email) && !empty($user->email) && isset($user->phone) && !empty($user->phone) && isset($user->pincode) && !empty($user->pincode) && isset($user->address) && !empty($user->address) && isset($user->city) && !empty($user->city) && isset($user->state) && !empty($user->state))
                {
                    $user->update(['verification' => 2]);
                }else{
                    $user->update(['verification' => 1]);
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

    public function uploadUserImage(Request $request)
    {
        try {
            $user = User::find($request->user_id);
            if(isset($user->id)){
                if($request->hasFile('user_image')){
                    $old_image = $user->profile;
                    $file = $request->file('user_image');
                    $image_url = $this->addSingleImage('user_image','user_images',$file, $old_image,"300*300");
                    $user->profile = $image_url;
                    $user->update();
                }
                $data = new CustomerResource($user);
                return $this->sendApiResponse(true, 0,'Image has been Uploaded.', $data);
            }else{
                return $this->sendApiResponse(false, 0,'User Not Found!', (object)[]);
            }
        } catch (\Throwable $th) {
            return $this->sendApiResponse(false, 0,'Failed to Upload Image!', (object)[]);
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

    public function userCartUpdate(Request $request) {
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
            $sub_total = (isset($request->sub_total)) ? $request->sub_total : 0;
            $charges = (isset($request->charges)) ? $request->charges : 0;
            $total = (isset($request->total)) ? $request->total : 0;
            $gold_price = 0;

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
            $net_weight_keys = [
                '22k' => 'nweight4',
                '20k' => 'nweight3',
                '18k' => 'nweight2',
                '14k' => 'nweight1',
            ];
            $price_keys = [
                '22k' => 'price_22k',
                '20k' => 'price_20k',
                '18k' => 'price_18k',
                '14k' => 'price_14k',
            ];
            $total_price_keys = [
                '22k' => 'total_price_22k',
                '20k' => 'total_price_20k',
                '18k' => 'total_price_18k',
                '14k' => 'total_price_14k',
            ];

            $user = User::find($user_id);
            $dealer = User::where('dealer_code', $dealer_code)->first();
            // $commission_type = (isset($dealer->commission_type)) ? $dealer->commission_type : '';
            // $commission_value = (isset($dealer->commission_value)) ? $dealer->commission_value : 0;
            // $commission_days = (isset($dealer->commission_days)) ? $dealer->commission_days : 10;
            // $commission_date = Carbon::now()->addDays($commission_days);

            if($user && count($cart_items) > 0){

                // Create New Order
                $order = new Order();
                $order->user_id = $user->id;
                $order->dealer_id = (isset($dealer->id)) ? $dealer->id : NULL;
                $order->order_status = 'pending';
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
                $order->gold_price = $gold_price;
                $order->sub_total = $sub_total;
                $order->charges = $charges;
                $order->total = $total;
                $order->save();

                if($order->id) {
                    $product_ids = [];
                    foreach($cart_items as $cart_item){
                        $cart_item = CartUser::with(['designs'])->where('id',$cart_item)->first();
                        $item_quantity = $cart_item->quantity;
                        $gold_type = $cart_item->gold_type;
                        $gold_color = $gold_color_arr[$cart_item->gold_color];
                        $gross_weight = $cart_item->designs[$gross_weight_keys[$gold_type]];
                        $net_weight = $cart_item->designs[$net_weight_keys[$gold_type]];
                        $less_gems_stone = $cart_item->designs['less_gems_stone'];
                        $less_cz_stone  = $cart_item->designs['less_cz_stone'];
                        $percentage  = $cart_item->designs['percentage'];
                        $item_sub_total = (isset($cart_item->designs[$price_keys[$gold_type]])) ? $cart_item->designs[$price_keys[$gold_type]] : 0;
                        $item_total = $item_sub_total * $item_quantity;

                        $order_item = new OrderItems();
                        $order_item->user_id = $user->id;
                        $order_item->order_id = $order->id;
                        $order_item->dealer_id = (isset($dealer->id)) ? $dealer->id : NULL;
                        $order_item->design_id =  $cart_item->designs['id'];
                        $order_item->design_name =  $cart_item->designs['name'];
                        $order_item->quantity =  $item_quantity;
                        $order_item->gold_type =  $gold_type;
                        $order_item->gold_color =  $gold_color;
                        $order_item->gross_weight =  $gross_weight;
                        $order_item->less_gems_stone =  $less_gems_stone;
                        $order_item->less_cz_stone =  $less_cz_stone;
                        $order_item->net_weight =  $net_weight;
                        $order_item->percentage =  $percentage;
                        $order_item->less_gems_stone_price =  (isset($cart_item->designs['gemstone_price'])) ? $cart_item->designs['gemstone_price'] : 0;
                        $order_item->less_cz_stone_price =  (isset($cart_item->designs['cz_stone_price'])) ? $cart_item->designs['cz_stone_price'] : 0;
                        $order_item->item_sub_total = $item_sub_total;
                        $order_item->item_total = $item_total;
                        $order_item->save();

                        $product_ids[] = $cart_item->designs['id'];
                        $gold_price =  (isset($cart_item->designs['gold_price_24k'])) ? $cart_item->designs['gold_price_24k'] : 0;
                    }

                    // Update Order
                    $update_order = Order::find($order->id);
                    $update_order->gold_price = $gold_price;
                    $update_order->product_ids = $product_ids;

                    // Add Dealer Commission
                    // if(!empty($commission_type) && $commission_value > 0 && $charges > 0){
                    //     if($commission_type == 'percentage'){
                    //         $commission_val = $charges * $commission_value / 100;
                    //     }else{
                    //         $commission_val = $charges - $commission_value;
                    //     }
                    //     $update_order->dealer_commission_type = $commission_type;
                    //     $update_order->dealer_commission_value = $commission_value;
                    //     $update_order->dealer_commission = $commission_val;
                    //     $update_order->commission_date = $commission_date;
                    //     $update_order->commission_status = 0;
                    // }

                    $update_order->update();

                    // Delete Items from Cart
                    CartUser::whereIn('id', $cart_items)->delete();
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Order has been Placed SuccessFully.',
                    'data'    => $order->id,
                ], Response::HTTP_OK);
            }else{
                return $this->sendApiResponse(false, 0,'Failed to Purchase Order!', (object)[]);
            }
        }catch (\Throwable $th){
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
    public function getHeaderTags()
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
    public function applyDealerCode(Request $request)
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
    public function getSiteSettings()
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


    // Function for Get Page Settings
    public function customPages(Request $request)
    {
        try {
            $page_slug = (isset($request->page_slug)) ? $request->page_slug : '';
            if(empty($page_slug)){
                $pages = Page::where('status',1)->where('is_static', 0)->get();
            }else{
                $pages = Page::where('slug',$page_slug)->get();
            }

            if(count($pages) > 0){
                $data = new CustomPagesResource($pages);
                return $this->sendApiResponse(true, 0,'Pages retrived SuccessFully..', $data);
            }else{
                return $this->sendApiResponse(false, 0,'Oops, Page Not Found!', (object)[]);
            }

        } catch (\Throwable $th) {
            return $this->sendApiResponse(false, 0,'Something went Wrong!', (object)[]);
        }
    }

    // Function for Get Order Details
    public function orderDetails(Request $request)
    {
        try {
            $order_id = $request->order_id;
            $user_id = $request->user_id;
            $user_type = $request->user_type;
            $user = User::where('id', $user_id)->where('user_type', $user_type)->first();

            if(isset($user->id)){
                if($user->user_type == 1){
                    $order_details = Order::with(['order_items'])->where('id', $order_id)->where('dealer_id', $user_id)->first();
                }else{
                    $order_details = Order::with(['order_items'])->where('id', $order_id)->where('user_id', $user_id)->first();
                }

                if(isset($order_details->id)){
                    $data = new OrderDetailsResource($order_details);
                    return $this->sendApiResponse(true, 0,'Order Details has been Fetched.', $data);
                }else{
                    return $this->sendApiResponse(false, 0,'Order Not Found!', (object)[]);
                }
            }
            else{
                return $this->sendApiResponse(false, 0,'User Not Found!', (object)[]);
            }
        } catch (\Throwable $th) {
            return $this->sendApiResponse(false, 0,'Something went Wrong!', (object)[]);
        }
    }

    // Function for Get Customer & Dealers Orders
    public function myOrders(Request $request)
    {
        try {
            $user_type = $request->user_type;
            $user_id = $request->user_id;
            $user = User::where('id', $user_id)->where('user_type', $user_type)->first();
            if(isset($user->id)){
                if($user->user_type == 1){
                    $orders = Order::where('dealer_id', $user->id)->orderBy('created_at', 'DESC')->get();
                }else{
                    $orders = Order::where('user_id', $user->id)->orderBy('created_at', 'DESC')->get();
                }
                $data = new OrdersResource($orders);
                return $this->sendApiResponse(true, 0,'Orders has been Fetched.', $data);
            }else{
                return $this->sendApiResponse(false, 0,'User Not Found!', (object)[]);
            }
        } catch (\Throwable $th) {
            return $this->sendApiResponse(false, 0,'Something went Wrong!', (object)[]);
        }
    }

}
