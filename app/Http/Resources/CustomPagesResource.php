<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomPagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $pages = isset($this->resource) ? $this->resource : [];
        $pages_array = [];

        if(count($pages) > 0)
        {
            foreach($pages as $page)
            {
                $data['id'] = $page->id;
                $data['name'] = $page->name;
                $data['slug'] = $page->slug;
                $data['content'] = $page->content;
                $data['status'] = $page->status;
                $pages_array[] = $data;
            }
        }
        return $pages_array;
    }
}
