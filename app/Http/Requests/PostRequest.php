<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'condition'   => 'required|string|max:255',
            'price' => 'required|numeric|min:1|regex:/^\d+(\.\d{1,2})?$/',
            'phone' => [
                'required',
                'max:20',
                'regex:/^[^a-zA-Z]+$/'
            ],


            'email' => 'nullable|email:rfc|max:255',
            'description' => 'required|string',

            'brand'       => 'nullable|exists:brands,id',
            'model'       => 'nullable|string|max:255',
            'color'       => 'nullable|string|max:50',

            'warranty'    => 'nullable|string|max:100',
            'negotiable'  => 'nullable|boolean',

            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            'category'    => 'nullable|exists:categories,id',
            'subcategory' => 'nullable|exists:categories,id',

            'attributes'  => 'nullable|array',
            'attributes.*' => 'exists:attributes,id',

            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
        ];
    }
}
