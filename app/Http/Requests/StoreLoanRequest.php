<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLoanRequest extends FormRequest {
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
            'used_by' => 'required|string',
            'tools' => 'required|array|min:1',
            'tools.*.id' => 'required|integer|exists:tools,id',
            'tools.*.condition_before' => 'nullable|string|in:good,broken',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages() {
        return [
            'used_by.required' => 'Nama peminjam wajib diisi.',
            'used_by.string' => 'Nama peminjam harus berupa teks.',
            'tools.required' => 'Daftar alat wajib diisi.',
            'tools.array' => 'Daftar alat harus berupa array.',
            'tools.min' => 'Minimal harus ada 1 alat.',
            'tools.*.id.required' => 'ID alat wajib diisi.',
            'tools.*.id.integer' => 'ID alat harus berupa angka.',
            'tools.*.id.exists' => 'Alat tidak ditemukan.',
            'tools.*.condition_before.string' => 'Kondisi alat harus berupa teks.',
            'tools.*.condition_before.in' => 'Kondisi alat harus good atau broken.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes() {
        return [
            'used_by' => 'nama peminjam',
            'tools' => 'daftar alat',
            'tools.*.id' => 'ID alat',
            'tools.*.condition_before' => 'kondisi alat sebelum',
        ];
    }
}
