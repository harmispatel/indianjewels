<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DesignRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // $rules = [
        //     'name' => 'required',
        //     'code' => 'required',
        //     'category_id' => 'requried',
        //     'gender_id' => 'requried',
        //     'metal_id' => 'requried',
        //     'company' => 'required|array|min:1',
        //     'tags' => 'required|array|min:1',
            // 'image' => 'required|mimes:jpeg,png,jpg,gif',
        // ];
        
        // return $rules;
// dd($this);
        
        if($this->id)
        {
            $rules = [
                'image' => 'mimes:jpeg,png,jpg',
                'name' => 'required',
                'code'=> 'required',
                'category_id' => 'required',
                'gender_id' => 'required',
                'metal_id' => 'required',
            ];

        }else{
            $rules = [
                'name' => 'required',
                'code'=> 'required',
                'category_id' => 'required',
                'gender_id' => 'required',
                'metal_id' => 'required',
                'image' => 'required|mimes:jpeg,png,jpg',
    
    
            ];
        }
        return $rules;
    }
}
