<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBusinessSettingsRequest extends FormRequest
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
            'currency_symbol'   => 'required|string|max:5',
            'currency_position' => 'required|in:left,right',
            'gst_type'  => 'required|in:flat,percentage',
            'gst_value' => 'required|numeric',
            'tax_type'  => 'required|in:flat,percentage',
            'tax_value' => 'required|numeric',
        ];
    }
}
