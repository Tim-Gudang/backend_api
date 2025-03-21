<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGudangRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->hasAnyRole(['superadmin']);
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:gudangs,name,' . $this->route('id')],
            'description' => ['nullable', 'string'],
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama gudang wajib diisi.',
            'name.unique' => 'Nama gudang sudah digunakan.',
            // 'gudang_status.in' => 'Status gudang hanya boleh "aktif" atau "nonaktif".',
        ];
    }
}
