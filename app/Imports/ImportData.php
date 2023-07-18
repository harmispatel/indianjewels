<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use App\Models\{Design,Category,Gender,Metal,Tag, Design_image, RoleHasPermissions,Dealer};
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ImportData implements ToModel,WithHeadingRow
{
   /**
    * @param Collection $collection
    */
    public function model(array  $rows)
    {
        if ($rows['tag']) 
        {
                $tagnames = explode(',',$rows['tag']);
                $tag = [];
                foreach ($tagnames as $tagname)
                {
                    $tagId = Tag::where('name',$tagname)->first();

                    if ($tagId) {
                        $tagIds = $tagId->id;
                        $tag[] = $tagIds;
                    }else{
                        $newTag = new Tag;
                        $newTag->name = $tagname;
                        $newTag->save();
                        $newTagId = $newTag->id;
                        $tag[] = $newTagId;
                    }
                }  
        }

            //code...
            try {
                $insert = new Design;
                $insert->name = $rows['item_name'];
                $insert->code = $rows['item_code'];
                $insert->category_id = $rows['subcategory'];
                $insert->gender_id = $rows['genderid'];
                $insert->metal_id = $rows['metalid'];
                $insert->description = $rows['description'];
                $insert->weight1 = $rows['weight_14k'];
                $insert->weight2 = $rows['weight_18k'];
                $insert->weight3 = $rows['weight_20k'];
                $insert->weight4 = $rows['weight_22k'];
                $insert->gweight1 = $rows['gweight_14k'];
                $insert->gweight2 = $rows['gweight_18k'];
                $insert->gweight3 = $rows['gweight_20k'];
                $insert->gweight4 = $rows['gweight_22k'];
                $insert->wastage1 = $rows['wastage_14k'];
                $insert->wastage2 = $rows['wastage_18k'];
                $insert->wastage3 = $rows['wastage_20k'];
                $insert->wastage4 = $rows['wastage_22k'];
                $insert->iaj_weight = $rows['iajgweight'];
                $insert->tags = json_encode($tag);
                $insert->save();   
                //code...
            } catch (\Throwable $th) {
                //throw $th;
            return redirect()->route('import.export')->with('error', 'Oops Something Went Wrong!');

            }
    }
}
