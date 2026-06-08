<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreKendaraanRequest extends FormRequest
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
        return [
            'nama_mobil' => 'required|string|max:255',
            'merk' => 'required|string|max:100',
            'kategori_id' => 'required|exists:kategoris,id',
            'tahun' => 'required|integer|between:1900,' . date('Y'),
            'plat_nomor' => [
                'required',
                'string',
                'max:20',
                Rule::unique('kendaraans', 'plat_nomor')->ignore($this->route('kendaraan')),
            ],
            'kapasitas_penumpang' => 'required|integer|min:1',
            'harga_sewa_per_hari' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:tersedia,disewa,maintenance',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
