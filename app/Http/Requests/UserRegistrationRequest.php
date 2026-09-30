<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }


    protected function prepareForValidation()
    {
        if ($this->has('phone_no')) {
            // Remove all characters except digits and leading +
            $phone = $this->phone_no;
            $cleaned = preg_replace('/[^0-9+]/', '', $phone);
            if (str_starts_with($cleaned, '+')) {
                $cleaned = '+' . preg_replace('/\+/', '', substr($cleaned, 1));
            } else {
                $cleaned = preg_replace('/\+/', '', $cleaned);
            }
            $this->merge([
                'phone_no' => $cleaned
            ]);
        }
    }


    public function rules(): array
    {
        $provider = $this->provider;
        $rules = [
            'name'      => 'required|string|max:255|regex:/^[A-Za-z][A-Za-z0-9\s._-]*$/'
        ];

        if (!$provider) {
            $rules['email'] = 'required|email|unique:users,email';
            $rules['phone_no'] = 'required|string|regex:/^[0-9+\-\s\(\)]+$/|unique:users,phone_no';
            $rules['password'] = 'required|string|min:6';
        } else {
            $rules['provider'] = 'required';
            $rules['provider_id'] = 'required';
        }
        return $rules;
    }
}
