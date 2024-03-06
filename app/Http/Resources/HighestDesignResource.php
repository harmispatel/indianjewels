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

        if (count($designs) > 0) {
            foreach ($designs as $design) {
                $data['id'] = $design->id;
                $data['image'] = (isset($design->image) && !empty($design->image) && file_exists('public/images/uploads/item_images/' . $design->code . '/' . $design->image)) ? asset('public/images/uploads/item_images/' . $design->code . '/' . $design->image) : asset('public/images/default_images/not-found/no_img1.jpg');
                $data['gold_price_14k'] = isset($design->gold_price_14k) ? round($design->gold_price_14k, 2) : 0;
                $data['gold_price_18k'] = isset($design->gold_price_18k) ? round($design->gold_price_18k, 2) : 0;
                $data['gold_price_20k'] = isset($design->gold_price_20k) ? round($design->gold_price_20k, 2) : 0;
                $data['gold_price_22k'] = isset($design->gold_price_22k) ? round($design->gold_price_22k, 2) : 0;
                $data['gold_price_24k'] = isset($design->gold_price_24k) ? round($design->gold_price_24k, 2) : 0;
                $data['price_14k'] = isset($design->price_14k) ? round($design->price_14k, 2) : 0;
                $data['price_18k'] = isset($design->price_18k) ? round($design->price_18k, 2) : 0;
                $data['price_20k'] = isset($design->price_20k) ? round($design->price_20k, 2) : 0;
                $data['price_22k'] = isset($design->price_22k) ? round($design->price_22k, 2) : 0;
                $data['total_price_14k'] = isset($design->total_price_14k) ? round($design->total_price_14k, 2) : 0;
                $data['total_price_18k'] = isset($design->total_price_18k) ? round($design->total_price_18k, 2) : 0;
                $data['total_price_20k'] = isset($design->total_price_20k) ? round($design->total_price_20k, 2) : 0;
                $data['total_price_22k'] = isset($design->total_price_22k) ? round($design->total_price_22k, 2) : 0;
                $designs_array[] = $data;
            }
        }
        return $designs_array;
    }
}
