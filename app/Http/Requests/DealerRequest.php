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
        // dd($this);
        if($this->id)
        {
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:dealers,email,'.decrypt($this->id),
                'phone' => 'required|numeric|digits:10',
                'address' => 'required',
                'comapany_name' => 'required',
                'gst_no' => 'required',
                'confirm_password' => 'same:password',
                'pincode' => 'required',
                'document.*' => 'mimes:pdf,png,jpg,jpeg',
            ];

        }else{
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:dealers,email',
                'phone' => 'required|numeric|digits:10',
                'address' => 'required',
                'comapany_name' => 'required',
                'gst_no' => 'required',
                'password' =>'required|min:6',
                'confirm_password' => 'required|same:password|min:6',
                'pincode' => 'required',
                'document.*' => 'mimes:jpg,png,pdf,doc,docx',
            ];
        }
        return $rules;
    }
}
