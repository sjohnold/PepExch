<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'services' => 'required|array|min:1',
        'services.*.title' => 'required|string|max:255',
        'services.*.service_title' => 'required|string|max:255', 
        'services.*.subtitle' => 'nullable|string|max:255',
        'services.*.description' => 'nullable|string',
        'services.*.thumbnail_id' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp|max:2048',
    ];
    }
}
