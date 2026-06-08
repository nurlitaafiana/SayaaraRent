<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKendaraanRequest extends FormRequest
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
            'nama_mobil' => 'sometimes|string|max:255',
            'merk' => 'sometimes|string|max:100',
            'kategori_id' => 'sometimes|exists:kategoris,id',
            'tahun' => 'sometimes|integer|between:1900,' . date('Y'),
            'plat_nomor' => 'sometimes|string|max:20|unique:kendaraans,plat_nomor,' . $this->route('kendaraan') ,
            'kapasitas_penumpang' => 'sometimes|integer|min:1',
            'harga_sewa_per_hari' => 'sometimes|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'status' => 'sometimes|in:tersedia,disewa,maintenance',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,jpg|max:2048',
        ];
    }
}
