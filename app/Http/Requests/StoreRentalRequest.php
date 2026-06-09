<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRentalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kendaraan_id'    => 'required|exists:kendaraans,id',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'upload_ktp'      => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'upload_sim'      => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }
}