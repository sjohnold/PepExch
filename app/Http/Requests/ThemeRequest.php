<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ThemeRequest extends FormRequest
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
            'primary_color'    => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'secondary_color'  => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'text_color'       => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'font_family'      => ['required', 'string', Rule::in([
                "'Poppins', sans-serif",
                "'Inter', sans-serif",
                "'Roboto', sans-serif",
                "'Outfit', sans-serif",
                "'Montserrat', sans-serif",
            ])],
        ];
    }
}
