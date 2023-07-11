<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\{Category, Design};
use Illuminate\Validation\Rule;


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
        // dd($this);
         $ex = Category::get();
         foreach($ex as $value)
         {
            $val[] = $value->parent_category;
         }
        if($this->id)
        {
            
            if ($this->parent_category == 0) {
                $rules = [
                    'name' => 'required|unique:categories,name,'.$this->id,
                    // 'name' => 'required|unique:categories,name,'.decrypt($this->category_id),
                    'image' => 'mimes:jpeg,png,jpg,gif,svg|max:3072',
                ];
            }else{
                if(in_array($this->parent_category,$val))
                {
                    // $id = decrypt($this->category_id);
                    $id = $this->id;
                    $request = $this;
                    $rules = [
                        'name' => [
                            'required',
                            Rule::unique('categories')->where(function ($query) use ($request, $id) {
                                return $query->where('parent_category', $request->parent_category)
                                    ->where('id', '<>', $id);
                            }),
                        ],
                        
                        'image' => 'mimes:jpeg,png,jpg,gif,svg|max:3072',
                    ];
                }else{

                    $rules = [
                        
                        'name' => 'required',
                        'image' => 'mimes:jpeg,png,jpg,gif,svg|max:3072',
                    ];
                }

            }

        }
        else
        {   
            if($this->parent_category == null)
            {
                $rules = [
                    'name' => 'required|unique:categories,name',
                    'image' => 'mimes:jpeg,png,jpg,gif,svg|max:3072',
                ];

            }else{
                if (in_array($this->parent_category,$val)) {
                    # code...
                    $rules = [
                        'name' => 'required|unique:categories,name',
                        'image' => 'mimes:jpeg,png,jpg,gif,svg|max:3072',
                    ];
                }else{
                    $rules = [
                        'name' => 'required',
                        'image' => 'mimes:jpeg,png,jpg,gif,svg|max:3072',
                    ];
                }

            }
        }

        return $rules;
    }
}
