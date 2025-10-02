<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
        {
            return [
                'username' => ['required', 'string', 'max:15', Rule::unique('users', 'username')->ignore($this->user()->user_id, 'user_id')],
                'full_name' => ['required', 'string', 'max:100'],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email')->ignore($this->user()->user_id, 'user_id'),
                ],
            ];
        }
}
