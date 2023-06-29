<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SlidersRequest extends FormRequest
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
        return 
        [
<<<<<<< HEAD
            'iamge' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
=======
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
>>>>>>> b31e6380c09c027ff20e4112e8ef8767acff0bdb
        ];
    }
}
