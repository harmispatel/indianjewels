<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DesignCollectionListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $designscollections = (isset($this->resource)) ? $this->resource : [];
        $designscollections_array = [];

        
            
            foreach($designscollections as $designscollection)
            {
             
                $data['id'] = $designscollection->designs->id;
                $data['name'] = $designscollection->designs->name;
                $data['image'] = isset($designscollection->designs->image) ? asset('public/images/uploads/item_image/'.$designscollection->designs->image) : asset('public/images/uploads/item_image/no_image.jpg');
                $designscollections_array[] = $data;
            }

        return $designscollections_array;
    }
}
