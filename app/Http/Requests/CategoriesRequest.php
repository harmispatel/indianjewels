<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoriesRequest extends FormRequest
{
    // Determine if the user is authorized to make this request.
    public function authorize()
    {
        return true;
    }


    // Get the validation rules that apply to the request.
    public function rules()
    {
        if($this->category_id)
        {
            $rules = [
                'name' => 'required|unique:categories,name,'.decrypt($this->category_id),
                'image' => 'mimes:jpeg,png,jpg,gif,svg|max:3072',
            ];
        }
        else
        {
            $rules = [
                'name' => 'required|unique:categories,name',
                'image' => 'mimes:jpeg,png,jpg,gif,svg|max:3072',
            ];
        }

        return $rules;
    }
}
