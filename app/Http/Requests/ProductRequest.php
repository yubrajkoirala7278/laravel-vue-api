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
            // 'slug'=>['required',Rule::unique('products')->ignore($this->product)],
            'image' => ['required'],
            'price'=>['required'],
            'cross_price'=>['required'],
            'description'=>['required'],
            'color'=>['required']
        ];

        // Conditionally require the image field for POST requests
        if ($this->isMethod('POST')) {
            $rules['image'][] = 'required';
        } else {
            $rules['image'][] = 'nullable';
        }

        return $rules;
    }
}
