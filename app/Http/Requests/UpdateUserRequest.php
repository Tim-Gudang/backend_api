<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();

        return $user && ($user->hasRole('superadmin') || $user->hasPermissionTo('update_user'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:users,name,' . $this->route('id'),
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->route('id'),
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Nama sudah digunakan, silakan gunakan nama lain.',
            'email.unique' => 'Email sudah terdaftar, silakan gunakan email lain.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.regex' => 'Password harus mengandung minimal 1 huruf besar, 1 huruf kecil, dan 1 simbol.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ];
    }
}
