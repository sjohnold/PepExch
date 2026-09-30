<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Str;

class LanguageRequest extends FormRequest
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
            'thumbnail_id' => 'nullable',
            'title' => 'required|string',
            'name' => 'required|string|max:3|min:2',
            'status' => 'boolean',
        ];

    }
    protected function prepareForValidation()
    {
        if ($this->has('name')) {
            $this->merge([
                'name' => Str::lower($this->input('name')),
            ]);
        }
    }
}
