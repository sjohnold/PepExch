<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BoostPlanRequest extends FormRequest
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
            'payable_amount'  => 'required|numeric|max:99999999999',
            'discount_amount' => 'nullable|numeric|max:99999999999',
            'plan_items' => 'nullable|array',
            'plan_items.*' => 'string|max:255',
            'sustain_days' => 'required|integer|min:1|max:999',
            'thumbnail' => 'nullable|image|max:3000',
        ];
    }
}
