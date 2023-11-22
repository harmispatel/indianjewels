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
        if($this->id)
        {
            $rules = [
                'image' => 'mimes:jpeg,png,jpg',
                'name' => 'required',
                'code'=> 'required|unique:designs,code,'.decrypt($this->id),
                'category_id' => 'required',
                'gender_id' => 'required',
                'metal_id' => 'required',
                'price' => 'required|numeric|gt:0',
            ];

        }else{
            $rules = [
                'name' => 'required',
                'code'=> 'required|unique:designs,code',
                'category_id' => 'required',
                'gender_id' => 'required',
                'metal_id' => 'required',
                'image' => 'mimes:jpeg,png,jpg',
                'price' => 'required|numeric|gt:0',
            ];
        }
        return $rules;
    }
}
