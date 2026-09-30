<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SoldOutRequest extends FormRequest
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
            'product_id' => 'nullable|exists:selling_posts,id',
            'sold_price' => 'required|numeric|min:0',
            'buyer_name' => 'nullable|string|max:255',
            'updated_at' => 'nullable|string|max:255',
        ];
    }
}
