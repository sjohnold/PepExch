<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Logic handled in controller/service
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'selling_post_id' => 'required|exists:selling_posts,id',
            'sender_items' => 'required|array|min:1',
            'sender_items.*' => 'string|max:255',
            'receiver_items' => 'nullable|array',
            'receiver_items.*' => 'string|max:255',
        ];
    }
}
