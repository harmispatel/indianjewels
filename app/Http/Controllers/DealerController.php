<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\DealerRequest;
use App\Models\{Dealer, DealerDocument};
use App\Traits\ImageTrait;
use Hash;



class DealerController extends Controller
{
    use ImageTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.dealers.dealers');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.dealers.create_dealer'); 
    }

    public function loaddealers(Request $request)
    {
        if ($request->ajax())
        {
            // Get all Amenities
            $dealers = Dealer::get();
            
            return DataTables::of($dealers)
            ->addIndexColumn()
            
            ->addColumn('logo', function ($row)
            {
                $default_image = asset("public/images/uploads/companies_logos/no_image.jpg");
                $image = ($row->logo) ? asset('public/images/uploads/companies_logos/'.$row->logo) : $default_image;
                $image_html = '';
                $image_html .= '<img class="me-2" src="'.$image.'" width="50" height="50">';
                return $image_html;
            })
            ->addColumn('status', function ($row)
            {
                $status = $row->status;
                $checked = ($status == 1) ? 'checked' : '';
                $checkVal = ($status == 1) ? 0 : 1;
                $dealer_id = isset($row->id) ? $row->id : '';

                    return '<div class="form-check form-switch"><input class="form-check-input" type="checkbox" role="switch" onchange="changeStatus('.$checkVal.','.$dealer_id.')" id="statusBtn" '.$checked.'></div>';
                
            })
            ->addColumn('actions',function($row)
            {
                $dealer_id = isset($row->id) ? $row->id : '';
                $action_html = '';
                $action_html .= '<a href="'.route('dealers.edit',encrypt($dealer_id)).'" class="btn btn-sm custom-btn me-1"><i class="bi bi-pencil"></i></a>';
                    $action_html .= '<a onclick="deleteDealer(\''.encrypt($dealer_id).'\')" class="btn btn-sm btn-danger me-1"><i class="bi bi-trash"></i></a>';
                
                return $action_html;
            })
            ->rawColumns(['status','actions','logo'])
            ->make(true);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DealerRequest $request)
    {  
        try {
            $input = $request->except('_token','password','confirm_password','logo','document');
            $input['password'] = Hash::make($request->password);
            if ($request->hasFile('logo'))
            {
                $file = $request->file('logo');
                $image_url = $this->addSingleImage('comapany_logo','companies_logos',$file, $old_image = '',"300*300");
                $input['logo'] = $image_url;
            }
            
            
            $dealer = Dealer::create($input);
    
            if($request->hasFile('document'))
            {
                $multiple = $request->file('document');
                foreach ($multiple as $value)
                {
                    $doc = new DealerDocument;
                    $doc->dealer_id = $dealer->id;
                    $multiDoc = $this->addSingleImage('document','documents',$value,$old_image = '','default');
                    $doc->document = $multiDoc;
                    $doc->save();
                }
            }
            return redirect()->route('dealers')->with('success','Dealers created successfully');
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('dealers')->with('error','Something with wrong');

        }

        //
    }

     // Store a Users status Changes resource in storage..    
     public function status(Request $request)
     {
         $status = $request->status;
         $id = $request->id;
         try {
             $input = Dealer::find($id);
             $input->status =  $status;
             $input->update();
 
             return response()->json([
                 'success' => 1,
                 'message' => "Dealer Status has been Changed Successfully..",
             ]);
         } catch (\Throwable $th) {
            
             return response()->json([
                 'success' => 0,
                 'message' => "Internal Server Error!",
             ]);
         }
     }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function show(Dealer $dealer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function edit(Dealer $dealer,$id)
    {
        $id = decrypt($id);
        $data = Dealer::where('id',$id)->first();
        $documents = DealerDocument::where('dealer_id',$id)->get();
        
        return view('admin.dealers.edit_dealer',compact('data','documents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function update(DealerRequest $request, Dealer $dealer)
    {
        
        try {
            $id = decrypt($request->id);
            $input = $request->except('_token','id','password','confirm_password','logo','document');

            if ($request->password || $request->password != null) {
                $input['password'] = Hash::make($request->password);
            }
                $dealer = Dealer::find($id);

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
                    $doc = new DealerDocument;
                    $doc->dealer_id = $id;
                    $multiDoc = $this->addSingleImage('document','documents',$value,$old_image = '','default');
                    $doc->document = $multiDoc;
                    $doc->save();
                }
            }

            if ($dealer) 
            {
                $dealer->update($input);
            }
            
            return redirect()->route('dealers')->with('success','Dealers created successfully');
        } catch (\Throwable $th) {
            dd($th);    
            return redirect()->route('dealers')->with('error','Something with wrong');

        }
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dealer  $dealer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            //code...
            $id = decrypt($request->id);
            $findLogo = Dealer::where('id',$id)->first();
            $findMulDocs = DealerDocument::where('dealer_id',$id)->get();
            $img = isset($findLogo->logo) ? $findLogo->logo : '';
   
            foreach($findMulDocs as $value)
            {
                   if (!empty($value->document) && file_exists('public/images/uploads/documents/'.$value->document)) 
                   {
                       unlink('public/images/uploads/documents/'.$value->document);
                   }
            }
   
            if (!empty($img) && file_exists('public/images/uploads/companies_logos/'.$img))
             {
                   unlink('public/images/uploads/companies_logos/'.$img);
             }
   
             DealerDocument::where('dealer_id',$id)->delete();

             Dealer::where('id',$id)->delete();

             return response()->json([
               'success' => 1,
               'message' => "Dealer delete Successfully..",
           ]);
        } catch (\Throwable $th) {
            dd($th);
            //throw $th;
            return response()->json([
                'success' => 0,
                'message' => "Something with wrong",
            ]);
        }

    }
        //
    
}
