<?php

namespace App\Http\Controllers;

use App\Models\{Design,Category,Gender,Metal,Tag, Design_image};
use Illuminate\Http\Request;

class DesignController extends Controller
{
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::get();
        $genders = Gender::get();
        $metals = Metal::get();
        $tags = Tag::get();
        return view('admin.designs.create_designs',compact('categories','genders','metals','tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $dm = json_encode($request->tags);
        // dd($request->all());
        try {
            $input = $request->except('_token','tags','company','image','images');
            $input['tags'] = json_encode($request->tags);
            $input['company'] = json_encode($request->company);
              $data = Design::create($input);
            //   $id = $data->id;

            return redirect()->route('designs')->with('message','Design added Successfully');

        } catch (\Throwable $th) {
            dd($th);
            return redirect()->route('designs')->with('error','Something with wrong');
        }
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function show(Design $design)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function edit(Design $design)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Design $design)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Design  $design
     * @return \Illuminate\Http\Response
     */
    public function destroy(Design $design)
    {
        //
    }
}
