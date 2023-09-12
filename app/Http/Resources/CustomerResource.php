<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $profile = isset($this->resource) ? $this->resource : [];
        
        $docs = $profile->document;
        if(count($docs) > 0) {
            foreach($docs as $doc) 
            {
                $pro_doc['id'] = $doc->id;
                $pro_doc['document'] = asset('public/images/uploads/documents/'.$doc->document);
                $pro_doc_array[] = $pro_doc;
            }
        }

        $data['id'] = isset($profile->id) ? $profile->id : '';
        $data['name'] = isset($profile->name) ? $profile->name : '';
        $data['email'] = isset($profile->email) ? $profile->email : '';
        $data['phone'] = isset($profile->phone) ? $profile->phone : '';
        $data['address'] = isset($profile->address) ? $profile->address : '';
        $data['ref_name'] = isset($profile->ref_name) ? $profile->ref_name : '';
        $data['logo'] = isset($profile->logo) ? asset('public/images/uploads/companies_logos/'.$profile->logo) : asset("public/images/uploads/companies_logos/no_image.jpg");
        $data['comapany_name'] = isset($profile->comapany_name) ? $profile->comapany_name : '';
        $data['status'] = isset($profile->status) ? $profile->status : '';
        $data['gst_no'] = isset($profile->gst_no) ? $profile->gst_no : '';
        $data['whatsapp_no'] = isset($profile->whatsapp_no) ? $profile->whatsapp_no : '';
        $data['pincode'] = isset($profile->pincode) ? $profile->pincode : '';
        $data['documents'] = isset($pro_doc_array) ?  $pro_doc_array : [];
        $profile_data = $data;
        return $profile_data;
        
    }
}
