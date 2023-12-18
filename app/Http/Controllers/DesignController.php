<?php

namespace App\Http\Controllers;

use App\Models\{Design,Category,Gender,Metal,Tag, Design_image, RoleHasPermissions,Dealer, User};
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Traits\ImageTrait;
use Illuminate\Support\Str;
use App\Http\Requests\DesignRequest;
use Auth;
use Spatie\Permission\Models\Permission;

class DesignController extends Controller
{
    use ImageTrait;

    function __construct()
    {
        $this->middleware('permission:designs|designs.create|designs.edit|designs.destroy', ['only' => ['index','store']]);
        $this->middleware('permission:designs.create', ['only' => ['create','store']]);
        $this->middleware('permission:designs.edit', ['only' => ['edit','update']]);
        $this->middleware('permission:designs.destroy', ['only' => ['destroy']]);
    }

    // Display a listing of the resource.
    public function index()
    {
        return view('admin.designs.designs');
    }

    // Get AJAX listing of the resource.
    public function loaddesigns(Request $request)
    {
        if ($request->ajax())
        {
            $columns = array(
                0 => 'id',
                2 => 'code',
            );
            $limit = $request->request->get('length');
            $start = $request->request->get('start');
            $order = $columns[$request->input('order.0.column')];
            $dir = $request->input('order.0.dir');

            $totalData = Design::query();

            $designs = Design::query();

            if(!empty($request->input('search.value'))){
                $search = $request->input('search.value');
                $designs->where('name', 'LIKE', "%{$search}%")->orWhere('code', 'LIKE', "%{$search}%");
                $totalData = $totalData->where('name', 'LIKE', "%{$search}%")->orWhere('code', 'LIKE', "%{$search}%");
            }

            $totalData = $totalData->count();
            $totalFiltered = $totalData;
            $designs = $designs->offset($start)->orderBy($order, $dir)->limit($limit)->get();

            $item = array();
            $all_items = array();

            if(count($designs) > 0){
                foreach ($designs as $design) {
                    $design_id = $design->id;
                    $item['id'] = $design_id;
                    $item['name'] = (isset($design['name'])) ? $design['name'] : '';
                    $item['code'] = (isset($design['code'])) ? $design['code'] : '';

                    // Status Button
                    $status = $design->status;
                    $checked = ($status == 1) ? 'checked' : '';
                    $item['changestatus'] = '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" onchange="changeStatus('.$design_id.')" id="statusBtn" '.$checked.'></div>';

                    // Top Selling Button
                    $top_selling = $design->highest_selling;
                    $isCheckedTopSelling = ($top_selling == 1) ? 'checked' : '';
                    $item['top_selling'] = '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" onchange="changeTopSelling('.$design_id.')" id="statusBtn" '.$isCheckedTopSelling.'></div>';

                    // Actions Buttons
                    $action_html = '';
                    $design_edit = Permission::where('name','designs.edit')->first();
                    $design_delete = Permission::where('name','designs.destroy')->first();
                    $user_type =  Auth::guard('admin')->user()->user_type;
                    $roles = RoleHasPermissions::where('role_id',$user_type)->pluck('permission_id');
                    foreach ($roles as $key => $value) {
                        $val[] = $value;
                    }
                    if(in_array($design_edit->id,$val)){
                        $action_html .= '<a href="'.route('designs.edit',encrypt($design_id)).'" class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil"></i></a>';
                    }
                    // if(in_array($design_delete->id,$val)){
                    //     $action_html .= '<a onclick="deleteDesign(\''.$design_id.'\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>';
                    // }
                    // $item['actions'] = $action_html;

                    $all_items[] = $item;
                }
            }

            return response()->json([
                "draw"            => intval($request->request->get('draw')),
                "recordsTotal"    => intval($totalData),
                "recordsFiltered" => intval(isset($totalFiltered) ? $totalFiltered : ''),
                "data"            => $all_items
            ]);

        }
    }

    // Show the form for creating a new resource.
    public function create()
    {
        $categories = Category::where('parent_category','!=',0)->get();
        $genders = Gender::get();
        $metals = Metal::get();
        $tags = Tag::get();
        return view('admin.designs.create_designs',compact('categories','genders','metals','tags'));
    }

    // Store a newly created resource in storage.
    public function store(DesignRequest $request)
    {
        try
        {
            $input = $request->except('_token','tags','image','multiImage');
            $input['tags'] = json_encode($request->tags);

            // Upload Main Image
            if($request->hasfile('image'))
            {
                $file = $request->image;
                $singleFile = $this->addSingleImage('item','item_image',$file, $oldImage = '',"300*300");
                $input['image'] = $singleFile;
            }

            // Create Design
            $design = Design::create($input);
            $design_id = $design->id;

            // Insert Design's Multiple Images
            if ($request->hasfile('multiImage'))
            {
                $mulitple = $request->file('multiImage');
                foreach($mulitple as $key => $value)
                {
                    $designImage = new Design_image;
                    $designImage->design_id	= $design_id;
                    $multiFile = $this->addSingleImage('item','item_image',$value, $oldImage = '',"300*300");
                    $designImage->image = $multiFile;
                    $designImage->save();
                }
            }

            return redirect()->route('designs')->with('message','Design added Successfully');

        } catch (\Throwable $th) {
            return redirect()->route('designs')->with('error','Something with wrong');
        }
    }

    // Change Status of Specific Design
    public function status(Request $request)
    {
        try
        {
            $id = $request->id;
            $design = Design::find($id);
            $design->status =  ($design->status == 1) ? 0 : 1;
            $design->update();

            return response()->json([
                'success' => 1,
                'message' => "Design Status has been Changed Successfully..",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Internal Server Error!",
            ]);
        }
    }

    // Change Status of Top Selling
    public function topSelling(Request $request)
    {
        try
        {
            $id = $request->id;
            $design = Design::find($id);
            $design->highest_selling =  ($design->highest_selling == 1) ? 0 : 1;
            $design->update();
            $message = ($design->highest_selling == 1) ? 'Design has been Added to Top Selling.' : 'Design has been Removed from Top Selling.';
            return response()->json([
                'success' => 1,
                'message' => $message,
            ]);
        }
        catch (\Throwable $th)
        {
            return response()->json([
                'success' => 0,
                'message' => "Internal Server Error!",
            ]);
        }
    }

    // Show the form for editing the specified resource.
    public function edit($id)
    {
        try {
            $id = decrypt($id);
            $data = Design::where('id',$id)->with('designImages')->first();
            $categories = Category::where('parent_category','!=',0)->get();
            $genders = Gender::get();
            $metals = Metal::get();
            $tags = Tag::get();
            return view('admin.designs.edit_designs',compact('categories','genders','metals','tags','data'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went Wrong!');
        }
    }

    // Update the specified resource in storage.
    public function update(DesignRequest $request, Design $design)
    {
        try {
            $id = decrypt($request->id);
            $input = $request->except('_token','tags','company','image','multiImage','id');
            $input['tags'] = json_encode($request->tags);
            $input['highest_selling'] = (isset($request->highest_selling)) ? $request->highest_selling : 0;

            if ($request->hasfile('image'))
            {
                $img  = Design::where('id',$id)->first();
                $old_image = isset($img->image) ? $img->image : '';
                $file = $request->image;
                $singleFile = $this->addSingleImage('item','item_image',$file, $oldImage = '',"300*300");
                $input['image'] = $singleFile;
            }

            $data = Design::find($id);
            $data->update($input);

            if ($request->hasfile('multiImage'))
            {
                $mulitple = $request->file('multiImage');

                foreach($mulitple as $key => $value)
                {
                    $designImage = new Design_image;
                    $designImage->design_id = $id;
                    $multiFile = $this->addSingleImage('item','item_image',$value, $oldImage = '',"300*300");
                    $designImage->image = $multiFile;
                    $designImage->save();
                }
        }

            return redirect()->route('designs')->with('message','Design updated Successfully');

        } catch (\Throwable $th) {
            return redirect()->route('designs')->with('error','Something with wrong');
        }
    }

    // Remove the specified resource from storage.
    public function destroy(Request $request)
    {
        try {
            $id = decrypt($request->id);
            $design = Design::where('id',$id)->first();
            $designImages = Design_image::where('design_id',$id)->get();
            $main_image = isset($design->image) ? $design->image : '';

            // Delete Multiple Image
            foreach($designImages as $design_image)
            {
                if (!empty($design_image->image) && file_exists('public/images/uploads/item_image/'.$design_image->image))
                {
                    unlink('public/images/uploads/item_image/'.$design_image->image);
                }
            }

            // Delete Main Image
            if (!empty($main_image) && file_exists('public/images/uploads/item_image/'.$main_image))
            {
                unlink('public/images/uploads/item_image/'.$main_image);
            }

            Design_image::where('design_id',$id)->delete();
            Design::where('id',$id)->delete();

            return response()->json([
                'success' => 1,
                'message' => "Design delete Successfully..",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Something with wrong",
            ]);
        }

    }

    // Delete Specific Image of Design
    public function imagedestroy(Request $request)
    {
        try {
            $id = decrypt($request->id);
            $design_image = Design_image::where('id',$id)->first();
            $image = isset($design_image->image) ? $design_image->image : '';

            if (!empty($image) && file_exists('public/images/uploads/item_image/'.$image))
            {
                unlink('public/images/uploads/item_image/'.$image);
            }
            Design_image::find($id)->delete();

            return response()->json([
                'success' => 1,
                'message' => "Image delete Successfully..",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => 0,
                'message' => "Something with wrong",
            ]);
        }
    }
}
