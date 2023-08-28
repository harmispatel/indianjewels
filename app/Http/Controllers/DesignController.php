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


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:designs|designs.create|designs.edit|designs.destroy', ['only' => ['index','store']]);
         $this->middleware('permission:designs.create', ['only' => ['create','store']]);
         $this->middleware('permission:designs.edit', ['only' => ['edit','update']]);
         $this->middleware('permission:designs.destroy', ['only' => ['destroy']]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return view('admin.designs.designs');
    }

    // Display a listing Tags.
    public function loaddesigns(Request $request)
    {
        if ($request->ajax())
        {
            $designs= Design::get();
            return DataTables::of($designs)
            ->addIndexColumn()
            ->addColumn('changestatus', function ($row){
                $status = $row->status;
                $checked = ($status == 1) ? 'checked' : '';
                $checkVal = ($status == 1) ? 0 : 1;
                $design_id = isset($row->id) ? $row->id : '';
                return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" onchange="changeStatus('.$checkVal.','.$design_id.')" id="statusBtn" '.$checked.'></div>';
            })
            ->addColumn('actions',function($row)
            {
                $tag_id = isset($row->id) ? encrypt($row->id) : '';
                $design_edit = Permission::where('name','designs.edit')->first();
                 $design_delete = Permission::where('name','designs.destroy')->first();
                 $user_type =  Auth::guard('admin')->user()->user_type;
                 $roles = RoleHasPermissions::where('role_id',$user_type)->pluck('permission_id');
                 foreach ($roles as $key => $value) {
                    $val[] = $value;
                   }
                $action_html = '';
                if(in_array($design_edit->id,$val)){

                $action_html .= '<a href="'.route('designs.edit',$tag_id).'" class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil"></i></a>';
                }
                if(in_array($design_delete->id,$val)){
                $action_html .= '<a onclick="deleteDesign(\''.$tag_id.'\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>';
                }
                return $action_html;
            })
            ->rawColumns(['changestatus','actions'])
            ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::where('parent_category','!=',0)->get();
        $genders = Gender::get();
        $metals = Metal::get();
        $tags = Tag::get();
        $companies = User::where('user_type',1)->get();
        return view('admin.designs.create_designs',compact('categories','genders','metals','tags','companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\DesignRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DesignRequest $request)
    {

        try {
            $input = $request->except('_token','tags','company','image','multiImage');
            $input['tags'] = json_encode($request->tags);
            $input['company'] = json_encode($request->company);
            if ($request->hasfile('image'))
        {
            $file = $request->image;
            $singleFile = $this->addSingleImage('item','item_image',$file, $oldImage = '',"300*300");
            $input['image'] = $singleFile;
        }
              $data = Design::create($input);

              $id = $data->id;
              if ($request->hasfile('multiImage'))
              {
                  $mulitple = $request->file('multiImage');

                foreach($mulitple as $key => $value)
                {

                    $designImage = new Design_image;
                    $designImage->design_id	= $id;
                    $multiFile = $this->addSingleImage('item','item_image',$value, $oldImage = '',"300*300");
                    $designImage->image = $multiFile;
                    $designImage->save();

                }

              }

            return redirect()->route('designs')->with('message','Design added Successfully');

        } catch (\Throwable $th) {

            return redirect()->route('designs')->with('error','Something with wrong');
        }
        //
    }

    // Store a Tags status Changes resource in storage..
    public function status(Request $request)
    {
        $status = $request->status;
        $id = $request->id;
        try {
            $input = Design::find($id);
            $input->status =  $status;
            $input->update();

            return response()->json([
                'success' => 1,
                'message' => "Design Status has been Changed Successfully..",
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'success' => 0,
                'message' => "Internal Server Error!",
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function edit(Design $design, $id)
    {
        $id = decrypt($id);
        $data = Design::where('id',$id)->with('designImages')->first();
        $categories = Category::where('parent_category','!=',0)->get();
        $genders = Gender::get();
        $metals = Metal::get();
        $tags = Tag::get();
        $companies = User::where('user_type',1)->get();
        return view('admin.designs.edit_designs',compact('categories','genders','metals','tags','data','companies'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function update(DesignRequest $request, Design $design)
    {
        try {


            $input = $request->except('_token','tags','company','image','multiImage','id');
            $input['tags'] = json_encode($request->tags);
            $input['company'] = json_encode($request->company);

            if (empty($request->highest_selling))
            {
                $input['highest_selling'] = 0;
            }
            if (empty($request->is_flash))
            {
                $input['is_flash'] = 0;
            }

            $id = decrypt($request->id);


            if ($request->hasfile('image'))
            {
                $img  = Design::where('id',$id)->first();

                $old_image = isset($cimg->image) ? $cimg->image : '';

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
            // dd($th);
            return redirect()->route('designs')->with('error','Something with wrong');

        }
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            //code...
            $id = decrypt($request->id);
            $findImage = Design::where('id',$id)->first();
            $findMulImage = Design_image::where('design_id',$id)->get();
            $img = isset($findImage->image) ? $findImage->image : '';

            foreach($findMulImage as $value)
            {
                   if (!empty($value->image) && file_exists('public/images/uploads/item_image/'.$value->image))
                   {
                       unlink('public/images/uploads/item_image/'.$value->image);
                   }
            }

            if (!empty($img) && file_exists('public/images/uploads/item_image/'.$img))
             {
                   unlink('public/images/uploads/item_image/'.$img);
             }

             Design_image::where('design_id',$id)->delete();
             Design::where('id',$id)->delete();

             return response()->json([
               'success' => 1,
               'message' => "Design delete Successfully..",
           ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'success' => 0,
                'message' => "Something with wrong",
            ]);
        }

    }

    public function imagedestroy(Request $request)
    {
        try {
            //code...
            $id = decrypt($request->id);
             $deleteImage = Design_image::where('id',$id)->first();

             $img = isset($deleteImage->image) ? $deleteImage->image : '';

             if (!empty($img) && file_exists('public/images/uploads/item_image/'.$img))
             {
                unlink('public/images/uploads/item_image/'.$img);

             }
             Design_image::find($id)->delete();

             return response()->json([
                'success' => 1,
                'message' => "Image delete Successfully..",
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json([
                'success' => 0,
                'message' => "Something with wrong",
            ]);
        }
    }
}
