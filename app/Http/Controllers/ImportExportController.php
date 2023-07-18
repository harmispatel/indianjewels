<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportData;
use App\Exports\Exportdata;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\{Category, Design};



class ImportExportController extends Controller
{
    
    function __construct()
    {  
        $this->middleware('permission:import.export', ['only' => ['index']]);
    } 


    public function index()
    {
        return view('admin.import_export.import_export');
    }

    public function importData(Request $request)
    {
        $this->validate($request, 
        [
            'import'  => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('import');
        try {
            
            Excel::import(new ImportData,$request->file('import'));
            
            return redirect()->route('import.export')->with('success', 'Excel Data Imported successfully.');
            
        } catch (\Throwable $th) {
            
            return redirect()->route('import.export')->with('error', 'Oops Something Went Wrong!');

        }
        
    }

    public function exportData(Request $request)
    {

        $cat = Design::pluck('category_id');
        $category = $cat->unique();
        $cats = Category::whereIn('id',$category)->get();
        foreach ($cats as $value)
        {
            $catIds[] = $value->parent_category; 
        }
         
         $category = $catIds;
         $data['categories'] = $category;
        
        
        if((count($data['categories']) > 0))
        {
            try {
                
                return Excel::download(new Exportdata($data),'Design_data.xlsx');
                
            } catch (\Throwable $th) {
                
                return redirect()->back()->with('error','Something Went Wrong!');
            }

        }

    }
}
