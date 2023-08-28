<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SliderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $sliders = isset($this->resource) ? $this->resource : [];
        $slider_array  = [];

        if (count($sliders) > 0)
        {
            foreach ($sliders as $slider)
            {
                $data['id'] = $slider->id;
                $data['image'] = asset('public/images/uploads/slider_image/'.$slider->image);
                $data['text'] = isset($slider->banner_text) ? $slider->banner_text : '';
                $slider_array[] = $data;
            }
        }
        return $slider_array;
    }
}
