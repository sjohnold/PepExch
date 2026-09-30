<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellingPostRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'condition' => 'required|string|max:255',
            'price' => 'required|numeric|min:1',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'description' => 'required|string',
            'location' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'location' => 'nullable',
            'brand_id' => 'required|integer|exists:brands,id',
            'warranty' => 'nullable|integer|min:0',
            'model' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'negotiable' => 'nullable|boolean',
            'category_id' => 'required|integer|exists:categories,id',
            'subcategory_id' => 'nullable|integer|exists:categories,id',
            'thumbnail' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'additional_images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'attributes' => 'nullable|array',
        ];
    }
}
