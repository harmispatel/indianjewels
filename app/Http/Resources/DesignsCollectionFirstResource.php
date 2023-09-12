<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\{Tag, Dealer, User,Design};


class DesignsCollectionFirstResource extends JsonResource
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
        
        $designcollection = Design::where('id',$designscollections)->get();
        

        return $designscollections_array;
    }
}
