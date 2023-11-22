<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
        if($this->customer_id)
        {
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.decrypt($this->customer_id),
                'phone' => 'required|numeric|digits:10',
                'gst_no' => 'nullable|min:15',
                'pan_no' => 'nullable|min:10',
            ];

        }else{
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|numeric|digits:10',
                'gst_no' => 'nullable|min:15',
                'pan_no' => 'nullable|min:10',
            ];
        }
        return $rules;
    }
}
