<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'condition' => 'required|string|max:255',
            'price' => 'nullable|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email:rfc|max:255',
            'description' => 'required|string',
            'location' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'brand' => 'required|integer|exists:brands,id',
            'warranty' => 'nullable|integer|min:0',
            'model' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:255',
            'negotiable' => 'nullable',
            'category' => 'required|integer|exists:categories,id',
            'subcategory' => 'nullable|integer|exists:categories,id',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,bmp,svg',
            'additional_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif,bmp,svg',
            'attributes' => 'nullable|array',
            'user_name' => auth()->check() ? 'nullable|string|max:255' : 'required|string|max:255',
            'email' => auth()->check() ? 'nullable|email:rfc|max:255' : 'required|email:rfc|max:255',
        ];
    }
}
