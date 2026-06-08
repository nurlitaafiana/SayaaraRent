<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRentalRequest extends FormRequest
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
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'upload_ktp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'upload_sim' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ];
    }

    public function store(StoreRentalRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        // Cek ketersediaan tanggal
        $tersedia = $this->rentalService->isKendaraanAvailable(
            $data['kendaraan_id'],
            $data['tanggal_mulai'],
            $data['tanggal_selesai']
        );

        if (!$tersedia) {
            return back()
                ->withInput()
                ->withErrors(['tanggal_mulai' => 'Kendaraan sudah dibooking pada tanggal tersebut.']);
        }

        unset($data['upload_ktp']);
        unset($data['upload_sim']);

        $this->rentalService->createRental(
            $data,
            $request->file('upload_ktp'),
            $request->file('upload_sim')
        );

        return redirect()
            ->route('customer.rental.index')
            ->with('success', 'Booking berhasil! Menunggu verifikasi admin.');
    }
}
