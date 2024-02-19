<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\{Tag, Dealer, User};

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
        $design = (isset($this->resource)) ? $this->resource : [];

            $tags = json_decode($design->tags);
            $tagname = Tag::whereIn('id',$tags)->pluck('name');

            $company = json_decode($design->company);
            if ($company)
            {
                $companyname = User::whereIn('id',$company)->pluck('name');
            }

            $image = (isset($design->image) && !empty($design->image) && file_exists('public/images/uploads/item_images/'.$design->code.'/'.$design->image)) ? asset('public/images/uploads/item_images/'.$design->code.'/'.$design->image) : asset('public/images/default_images/not-found/no_img1.jpg');
            $ogimage = (isset($design->image) && !empty($design->image) && file_exists('public/images/uploads/item_images/'.$design->code.'/og_image/'.$design->image)) ? asset('public/images/uploads/item_images/'.$design->code.'/og_image/'.$design->image) : asset('public/images/default_images/not-found/no_img1.jpg');

            $mul_images = $design->designImages;
            $images = [];
            $images[] = $image;
            $og_images = [];
            $og_images[] = $ogimage;
            if ($mul_images)
            {
                foreach ($mul_images as $mul_image)
                {
                    if(isset($mul_image->image) && !empty($mul_image->image) && file_exists('public/images/uploads/item_images/'.$design->code.'/'.$mul_image->image))
                    {
                        $imgs =  asset('public/images/uploads/item_images/'.$design->code.'/'.$mul_image->image);
                        $og_img =  asset('public/images/uploads/item_images/'.$design->code.'/og_image/'.$mul_image->image);
                        $images[] = $imgs;
                        $og_images[] = $og_img;
                    }
                }
            }
            $category_name = isset($design->categories) ? $design->categories->name : '';
            $gender_name = isset($design->gender) ? $design->gender->name : '';
            $metal_name = isset($design->metal) ? $design->metal->name : '';
            $data['id'] = $design->id;
            $data['name'] = $design->name;
            $data['category_id'] = $category_name;
            $data['description'] = $design->description;
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
            $data['net_weight_14k'] = isset($design->nweight1) ? $design->nweight1 : '';
            $data['net_weight_18k'] = isset($design->nweight2) ? $design->nweight2 : '';
            $data['net_weight_20k'] = isset($design->nweight3) ? $design->nweight3 : '';
            $data['net_weight_22k'] = isset($design->nweight4) ? $design->nweight4 : '';
            $data['wastage_14k'] = isset($design->wastage1) ? $design->wastage1 : '';
            $data['wastage_18k'] = isset($design->wastage2) ? $design->wastage2 : '';
            $data['wastage_20k'] = isset($design->wastage3) ? $design->wastage3 : '';
            $data['wastage_22k'] = isset($design->wastage4) ? $design->wastage4 : '';
            $data['iaj_gross_weight'] = isset($design->iaj_weight) ? $design->iaj_weight : '';
            $data['image'] = $image;
            $data['multiple_image'] = isset($mul_images) ? $images : [] ;
            $data['og_images'] = isset($mul_images) ? $og_images : [] ;
            $data['gemstone_price'] = isset($design->gemstone_price) ? round($design->gemstone_price,2) : 0;
            $data['cz_stone_price'] = isset($design->cz_stone_price) ? round($design->cz_stone_price,2) : 0;
            $data['less_gems_stone'] = isset($design->less_gems_stone) ? $design->less_gems_stone : 0;
            $data['less_cz_stone'] = isset($design->less_cz_stone) ? $design->less_cz_stone : 0;
            $data['gold_price_14k'] = isset($design->gold_price_14k) ? round($design->gold_price_14k,2) : 0;
            $data['gold_price_18k'] = isset($design->gold_price_18k) ? round($design->gold_price_18k,2) : 0;
            $data['gold_price_20k'] = isset($design->gold_price_20k) ? round($design->gold_price_20k,2) : 0;
            $data['gold_price_22k'] = isset($design->gold_price_22k) ? round($design->gold_price_22k,2) : 0;
            $data['gold_price_24k'] = isset($design->gold_price_24k) ? round($design->gold_price_24k,2) : 0;
            $data['price_14k'] = isset($design->price_14k) ? round($design->price_14k, 2) : 0;
            $data['price_18k'] = isset($design->price_18k) ? round($design->price_18k, 2) : 0;
            $data['price_20k'] = isset($design->price_20k) ? round($design->price_20k, 2) : 0;
            $data['price_22k'] = isset($design->price_22k) ? round($design->price_22k, 2) : 0;
            $data['making_charge'] = isset($design->making_charge) ? round($design->making_charge,2) : 0;
            $data['percentage'] = isset($design->percentage) ? $design->percentage : '';
            $data['total_price_14k'] = isset($design->total_price_14k) ? round($design->total_price_14k,2) : 0;
            $data['total_price_18k'] = isset($design->total_price_18k) ? round($design->total_price_18k,2) : 0;
            $data['total_price_20k'] = isset($design->total_price_20k) ? round($design->total_price_20k,2) : 0;
            $data['total_price_22k'] = isset($design->total_price_22k) ? round($design->total_price_22k,2) : 0;
            $design = $data;
        return $design;
    }
}
