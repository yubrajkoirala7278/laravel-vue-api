<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $rules= [
            'name'=>['required','min:3','max:255'],
            'slug'=>['required',Rule::unique('products')->ignore($this->product)],
            'image' => [$this->isMethod('POST')?'required':'nullable'],
            'price'=>['required'],
            'cross_price'=>['required'],
            'description'=>['required'],
            'color'=>['required']
        ];

        return $rules;
    }
}
