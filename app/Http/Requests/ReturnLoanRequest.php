<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReturnLoanRequest extends FormRequest {
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
            'tools' => 'required|array|min:1',
            'tools.*.id' => 'required|integer|exists:tools,id',
            'tools.*.condition_after' => 'required|string|in:good,broken',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages() {
        return [
            'tools.required' => 'Daftar alat wajib diisi.',
            'tools.array' => 'Daftar alat harus berupa array.',
            'tools.min' => 'Minimal harus ada 1 alat.',
            'tools.*.id.required' => 'ID alat wajib diisi.',
            'tools.*.id.integer' => 'ID alat harus berupa angka.',
            'tools.*.id.exists' => 'Alat tidak ditemukan.',
            'tools.*.condition_after.required' => 'Kondisi alat setelah wajib diisi.',
            'tools.*.condition_after.string' => 'Kondisi alat harus berupa teks.',
            'tools.*.condition_after.in' => 'Kondisi alat harus good atau broken.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes() {
        return [
            'tools' => 'daftar alat',
            'tools.*.id' => 'ID alat',
            'tools.*.condition_after' => 'kondisi alat setelah',
        ];
    }
}
