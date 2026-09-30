<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDownloadLinkRequest extends FormRequest
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
            'thumbnail1' => 'nullable|image|mimes:jpeg,png,svg|max:2048',
            'thumbnail2' => 'nullable|image|mimes:jpeg,png,svg|max:2048',
            'title' => 'nullable|string',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'app_store_url' => 'nullable|url',
            'play_store_url' => 'nullable|url',
        ];
    }
}
