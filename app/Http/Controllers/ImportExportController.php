<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImportExportController extends Controller
{
    //


    function __construct()
    {  
        $this->middleware('permission:import.export', ['only' => ['index']]);
    } 


    public function index()
    {
        return view('admin.import_export.import_export');
    }
}
