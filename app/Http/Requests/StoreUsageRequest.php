<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsageRequest extends FormRequest {
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
            'consumables' => 'required|array|min:1',
            'consumables.*.id' => 'required|integer|exists:consumables,id',
            'consumables.*.quantity' => 'required|integer|min:1',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages() {
        return [
            'used_by.required' => 'Nama pengguna wajib diisi.',
            'used_by.string' => 'Nama pengguna harus berupa teks.',
            'consumables.required' => 'Daftar barang wajib diisi.',
            'consumables.array' => 'Daftar barang harus berupa array.',
            'consumables.min' => 'Minimal harus ada 1 barang.',
            'consumables.*.id.required' => 'ID barang wajib diisi.',
            'consumables.*.id.integer' => 'ID barang harus berupa angka.',
            'consumables.*.id.exists' => 'Barang tidak ditemukan.',
            'consumables.*.quantity.required' => 'Jumlah barang wajib diisi.',
            'consumables.*.quantity.integer' => 'Jumlah barang harus berupa angka.',
            'consumables.*.quantity.min' => 'Jumlah barang minimal 1.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes() {
        return [
            'used_by' => 'nama pengguna',
            'consumables' => 'daftar barang',
            'consumables.*.id' => 'ID barang',
            'consumables.*.quantity' => 'jumlah barang',
        ];
    }
}
