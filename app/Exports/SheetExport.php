<?php

namespace App\Exports;

use App\Models\{Category, Design, Tag};
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;


class SheetExport implements FromCollection, WithTitle, WithHeadings
{


    private $category;


    public function __construct($category)
    {

        $this->category = $category; 

    }

    public function collection()
    {
        $maincategory = $this->category;
        $categories = Category::where('parent_category',$maincategory)->pluck('id');
        $designs = Design::whereIn('category_id',$categories)->get();
        
            if(count($designs) > 0)
            {
                $inner_data = [];
                foreach ($designs as $design)
                {
                    $item_data = [];

                    // Item Name
                    $item_data[] = isset($design->name) ? $design->name : '';

                    // Item Code
                    $item_data[] = isset($design->code) ? $design->code : '';

                    // Subcategory Id
                    $item_data[] = isset($design->category_id) ? $design->category_id : '';

                    // Gender Id
                    $item_data[] = isset($design->gender_id) ? $design->gender_id : '';

                    // Metal Id
                    $item_data[] = isset($design->metal_id) ? $design->metal_id : '';

                    //tag
                    $tags = json_decode($design->tags);
                    $tag = Tag::whereIn('id',$tags)->pluck('name');
                    $tagname = json_encode($tag);
                    $string = trim($tagname, '[]');
                    $outputString = str_replace('"','',$string);
                    
                    
                    $item_data[] = isset($outputString) ? $outputString : '';

                    // description
                    $item_data[] = isset($design->description) ? $design->description : '';

                    // weight 14k
                    $item_data[] = isset($design->weight1) ? $design->weight1 : '';

                    // weight 18k
                    $item_data[] = isset($design->weight2) ? $design->weight2 : '';

                    // weight 20k
                    $item_data[] = isset($design->weight3) ? $design->weight3 : '';

                    // weight 22k
                    $item_data[] = isset($design->weight4) ? $design->weight4 : '';
                    
                    // gross weight 14k
                    $item_data[] = isset($design->gweight1) ? $design->gweight1 : '' ;

                    // gross weight 18k
                    $item_data[] = isset($design->gweight2) ? $design->gweight2 : '';

                    // gross weight 20k
                    $item_data[] = isset($design->gweight3) ? $design->gweight3 : '';

                    // gross weight 22k
                    $item_data[] = isset($design->gweight4) ? $design->gweight4 : '';

                    // wastage 14k
                    $item_data[] = isset($design->wastage1) ? $design->wastage1 : '';

                    // wastage 18k
                    $item_data[] = isset($design->wastage2) ? $design->wastage2 : '';

                    // wastage 20k
                    $item_data[] = isset($design->wastage3) ? $design->wastage3 : '';

                    // wastage 22k
                    $item_data[] = isset($design->wastage4) ? $design->wastage4 : '';

                    // iaj_weight
                    $item_data[] = isset($design->iaj_weight) ? $design->iaj_weight : '';
                    
                    $inner_data[] = $item_data;
                }
                $all_excel_data[] = $inner_data;
            }
            
        // Return the data for the sheet
        return collect($all_excel_data);
    }

      // Sheet Heading
    public function headings(): array
    {
        $heading_arr = [];
        $heading_arr[] = 'item name';
        $heading_arr[] = 'item Code';
        $heading_arr[] = 'subcategory';
        $heading_arr[] = 'genderid';
        $heading_arr[] = 'metalid';
        $heading_arr[] = 'tag';
        $heading_arr[] = 'description';
        $heading_arr[] = 'weight 14k';
        $heading_arr[] = 'weight 18k';
        $heading_arr[] = 'weight 20k';
        $heading_arr[] = 'weight 22k';
        $heading_arr[] = 'gweight 14k';
        $heading_arr[] = 'gweight 18k';
        $heading_arr[] = 'gweight 20k';
        $heading_arr[] = 'gweight 22k';
        $heading_arr[] = 'wastage 14k';
        $heading_arr[] = 'wastage 18k';
        $heading_arr[] = 'wastage 20k';
        $heading_arr[] = 'wastage 22k';
        $heading_arr[] = 'iajgweight';
        return $heading_arr;
    }

    public function title(): string
    {
        // dd($this->category);
        $maincategory = $this->category;
        $catName= Category::where('id',$maincategory)->first();
        $category = isset($catName) ? $catName->name : ''; 
        // Return the title for the sheet
        return $category;
    }
}
