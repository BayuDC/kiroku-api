<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateToolRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() {
        return [
            'name' => 'sometimes|required|string|max:255',
            'category_id' => 'sometimes|required|exists:categories,id',
            'condition' => 'sometimes|required|in:good,broken',
            'description' => 'nullable|string',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages() {
        return [
            'name.required' => 'Nama alat wajib diisi.',
            'name.string' => 'Nama alat harus berupa teks.',
            'name.max' => 'Nama alat tidak boleh lebih dari 255 karakter.',
            'category_id.required' => 'Kategori wajib diisi.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid.',
            'condition.required' => 'Kondisi alat wajib diisi.',
            'condition.in' => 'Kondisi alat harus good atau broken.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ];
    }
}
