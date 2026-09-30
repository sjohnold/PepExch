<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            'name'              => 'required|string|max:255|regex:/^[A-Za-z][A-Za-z0-9\s._-]*$/',
            'phone_no'          => 'nullable|string|regex:/^\+?[0-9\s\-\(\)]+$/|max:20',
            'email'             => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email,' . auth()->id(),
                'regex:/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/',
            ],
            'whatsapp_number'   => 'nullable|string|regex:/^\+?[0-9\s\-\(\)]+$/|max:20',
            'address'           => 'nullable|string|max:500',
            'latitude'          => 'nullable|numeric|between:-90,90',
            'longitude'         => 'nullable|numeric|between:-180,180',
            'profile_photo'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
