<?php

namespace App\Http\Requests;

use App\Enums\Roles;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $userId = $this->route('userId');
        return [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email,' . $userId,
            'password' => 'required|string|min:8|max:255',
            'role' => 'required|in:' . Roles::ADMIN . ',' . Roles::STUDENT . ',' . Roles::TEACHER,
        ];
    }
}
