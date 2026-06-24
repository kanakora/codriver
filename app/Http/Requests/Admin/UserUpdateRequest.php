<?php

namespace App\Http\Requests\Admin;

use App\Concerns\ProfileValidationRules;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserUpdateRequest extends FormRequest
{
    use ProfileValidationRules;

    public function authorize(): bool
    {
        $user = $this->user();

        return $user ? $user->hasRole('admin') : false;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            ...$this->profileRules($this->route('user')->id),
            'password' => ['nullable', 'string', Password::default(), 'confirmed'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['integer', 'exists:roles,id'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'A name is required.',
            'name.max' => 'Name may not be longer than 255 characters.',
            'email.required' => 'An email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.max' => 'Email may not be longer than 255 characters.',
            'email.unique' => 'That email address is already in use.',
            'password.confirmed' => 'Please confirm the password.',
            'roles.array' => 'Roles must be an array.',
            'roles.*.exists' => 'Selected roles are invalid.',
        ];
    }
}
