<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriesRequest extends FormRequest
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
            'name' => 'required|unique:categories,name,'.decrypt($this->id),
            'iamge' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
        else 
        {
            $rules = [
                'name' => 'required|unique:categories,name',
                'iamge' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];
        }
        return $rules;
    }
}
