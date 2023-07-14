<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{

    function __construct()
     {
         $this->middleware('permission:reports.summary.items', ['only' => ['index']]);
         $this->middleware('permission:reports.star', ['only' => ['index']]);
         $this->middleware('permission:reports.scheme', ['only' => ['index']]);
         $this->middleware('permission:reports.dealer.performace', ['only' => ['index']]);
     }
            /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function summaryitemsindex()
    {
        return view('admin.reports.item_reports.summary_item');
    }

    public function starreportindex()
    {
        return view('admin.reports.item_reports.star_report');
    }
    public function schemereportindex()
    {
        return view('admin.reports.dealer_reports.scheme_report');
    }
    public function dealerperrformanceindex()
    {
        return view('admin.reports.dealer_reports.dealer_performance');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
