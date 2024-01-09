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
            $data['gold_type'] = $designscollection->gold_type;
            $data['gold_color'] = $designscollection->gold_color;
            $data['image'] = (isset($designscollection->designs->image) && file_exists('public/images/uploads/item_images/'.$designscollection->designs->code.'/'.$designscollection->designs->image)) ? asset('public/images/uploads/item_images/'.$designscollection->designs->code.'/'.$designscollection->designs->image) : asset('public/images/default_images/not-found/no_img1.jpg');
            $designscollections_array[] = $data;
        }

        $response['wishlist_items'] = $designscollections_array;
        $response['total_quantity'] = count($designscollections);
        return $response;
    }
}
