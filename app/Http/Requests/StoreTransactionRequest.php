<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
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
            'boost_plan_id' => 'nullable|exists:boost_plans,id',
            'selling_post_id' => 'nullable|exists:selling_posts,id',
            'payment_gateway_id' => 'nullable',
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'contact' => 'required|string|max:20',
            'auto_pay' => 'nullable|boolean',
            'service_price' => 'nullable|numeric|min:0',
            'service_tax' => 'nullable|numeric|min:0',
            'service_total' => 'nullable|numeric|min:0',
        ];
    }
}
