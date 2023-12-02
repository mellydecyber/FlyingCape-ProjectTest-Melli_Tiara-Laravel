<?php

namespace App\Http\Requests;

use App\Enums\Roles;
use Illuminate\Foundation\Http\FormRequest;

class EnrollUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'class_id' => 'required|exists:classes,id',
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:'.Roles::STUDENT.','.Roles::TEACHER,
        ];
    }
}
