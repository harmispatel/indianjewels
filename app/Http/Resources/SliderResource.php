<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Models\{Category,Design,Slider,Metal,Gender,Tag};


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
        $reorderedDays = isset($this->resource) ? $this->resource : [];
        
        $sliders = Slider::where('status',1)->where('days',$reorderedDays[0])->get();
        
        $datas = Slider::where('status',1)->where('days','!=',$reorderedDays[0])->get();
        
        
        $slider_array  = [];

        if (count($sliders) > 0)
        {
            foreach ($sliders as $slider)
            {
                
                $data['id'] = $slider->id;
                $data['image'] = asset('public/images/uploads/slider_image/'.$slider->image);
                $data['text'] = isset($slider->banner_text) ? $slider->banner_text : '';
                $data['day'] = $slider->days;
                $slider_array[] = $data;
            }
        }

        if (count($datas) > 0) {
            foreach($datas as $value){
                 
                $datass['id'] = $value->id;
                $datass['image'] = asset('public/images/uploads/slider_image/'.$value->image);
                $datass['text'] = isset($value->banner_text) ? $value->banner_text : '';
                $datass['day'] = $value->days;
                $slider_array[] = $datass;

            }
        }
        return $slider_array;
    }
}
