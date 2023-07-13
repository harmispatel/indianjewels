<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WestageDiscountRequest extends FormRequest
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
        $rules = [
            'dealers' => 'required|array|min:1',
            'code' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'discount_type' => 'required',
            'value' => 'required',
            'area' => 'required',
        ];
        return $rules;
    }
}
