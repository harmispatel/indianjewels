<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\{Tag, Dealer};

class DetailDesignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $designs = (isset($this->resource)) ? $this->resource : [];
        $designs_array = [];
        
        foreach($designs as $design)
        {
            
            $tags = json_decode($design->tags);
            $tagname = Tag::whereIn('id',$tags)->pluck('name');
            
            $company = json_decode($design->company);
            if ($company) 
            {
                $companyname = Dealer::whereIn('id',$company)->pluck('name');
            }   
            $mul_images = $design->designImages;            
            $images = [];
            if ($mul_images) {
                foreach ($mul_images as $mul_image)
                {
                    $imgs =  asset('public/images/uploads/item_image/'.$mul_image->image);
                    $images[] = $imgs;
                }
            }
            $category_name = isset($design->categories) ? $design->categories->name : '';
            $gender_name = isset($design->gender) ? $design->gender->name : '';
            $metal_name = isset($design->metal) ? $design->metal->name : '';
            $data['id'] = $design->id;
            $data['name'] = $design->name;
            $data['category_id'] = $category_name;
            $data['gender_id'] = $gender_name;
            $data['metal_id'] = $metal_name;
            $data['companies'] = isset($company) ? $companyname : [];
            $data['tags'] = $tagname;
            $data['code'] = $design->code;
            $data['status'] = ($design->status == 1) ? 'Active' : 'Inactive';
            $data['is_flash'] = ($design->is_flash == 1) ? 'Yes' : 'No';
            $data['highest_selling'] = ($design->highest_selling == 1) ? 'Yes' : 'No';
            $data['weight_14k'] = isset($design->weight1) ? $design->weight1 : '';
            $data['weight_18k'] = isset($design->weight2) ? $design->weight2 : '' ;
            $data['weight_20k'] = isset($design->weight3) ? $design->weight3 : '';
            $data['weight_22k'] = isset($design->weight4) ? $design->weight4 : '';
            $data['gross_weight_14k'] = isset($design->gweight1) ? $design->gweight1 : '';
            $data['gross_weight_18k'] = isset($design->gweight2) ? $design->gweight2 : '';
            $data['gross_weight_20k'] = isset($design->gweight3) ? $design->gweight3 : '';
            $data['gross_weight_22k'] = isset($design->gweight4) ? $design->gweight4 : '';
            $data['wastage_14k'] = isset($design->wastage1) ? $design->wastage1 : '';
            $data['wastage_18k'] = isset($design->wastage2) ? $design->wastage2 : '';
            $data['wastage_20k'] = isset($design->wastage3) ? $design->wastage3 : '';
            $data['wastage_22k'] = isset($design->wastage4) ? $design->wastage4 : '';
            $data['iaj_gross_weight'] = isset($design->iaj_weight) ? $design->iaj_weight : '';
            $data['multiple_image'] = isset($mul_images) ? $images : [] ;
            $designs_array[] = $data;
        }
        return $designs_array;
    }
}
