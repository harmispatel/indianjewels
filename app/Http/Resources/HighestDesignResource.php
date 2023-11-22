<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Design;

class HighestDesignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $designs = isset($this->resource) ? $this->resource : [];
        $designs_array = [];

        if(count($designs) > 0)
        {
            foreach ($designs as $design)
            {
                $data['id'] = $design->id;
                $data['image'] = (isset($design->image) && !empty($design->image) && file_exists('public/images/uploads/item_images/'.$design->code.'/'.$design->image)) ? asset('public/images/uploads/item_images/'.$design->code.'/'.$design->image) : asset('public/images/default_images/not-found/no_img1.jpg');
                $designs_array[] = $data;
            }
        }
        return $designs_array;
    }
}
