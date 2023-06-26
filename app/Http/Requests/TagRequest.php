<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
                'name' => 'required|unique:tags,name,'.$this->id,
                'status'=>'required'               
            ];
        }
        else
        {
            $rules = [
                'name' => 'required|unique:tags,name',
                'status'=>'required'               
            ];
        }
        return $rules;
    }
}
