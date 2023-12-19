<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DealerRequest extends FormRequest
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
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'.decrypt($this->id),
                'phone' => 'required|numeric|digits:10|unique:users,phone,'.decrypt($this->id),
                'address' => 'required',
                'comapany_name' => 'required',
                'gst_no' => 'required',
                'confirm_password' => 'same:password',
                'pincode' => 'required',
                'city' => 'required',
                'state' => 'required',
                'document.*' => 'mimes:pdf,png,jpg,jpeg',
                'discount_value' => 'required',
                'dealer_code' => 'required|unique:users,dealer_code,'.decrypt($this->id),
                'company_logo' => 'mimes:png,jpg,gif,svg',
                'profile_picture' => 'mimes:png,jpg,gif,svg',
            ];

        }else{
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|numeric|digits:10|unique:users,phone',
                'address' => 'required',
                'comapany_name' => 'required',
                'gst_no' => 'required',
                'password' =>'required|min:6',
                'confirm_password' => 'required|same:password|min:6',
                'pincode' => 'required',
                'city' => 'required',
                'state' => 'required',
                'document.*' => 'mimes:jpg,png,pdf,doc,docx',
                'discount_value' => 'required',
                'dealer_code' => 'required|unique:users,dealer_code',
                'company_logo' => 'mimes:png,jpg,gif,svg',
                'profile_picture' => 'mimes:png,jpg,gif,svg',
            ];
        }
        return $rules;
    }
}
