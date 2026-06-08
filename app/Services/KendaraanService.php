<?php

namespace App\Services;

use App\Repositories\Contracts\KendaraanRepositoryInterface;
use Illuminate\Http\UploadedFile;

class KendaraanService
{
    public function __construct(
        protected KendaraanRepositoryInterface $kendaraanRepository
    ) {}

    public function createKendaraan(array $data, ?UploadedFile $gambar = null)
    {
        if ($gambar) {
            $data['gambar'] = $gambar->store('kendaraan', 'public');
        }
        return $this->kendaraanRepository->create($data);
    }

    public function updateKendaraan(int $id, array $data, ?UploadedFile $gambar = null)
    {
        if ($gambar) {
            $data['gambar'] = $gambar->store('kendaraan', 'public');
        }
        return $this->kendaraanRepository->update($id, $data);
    }

    public function deleteKendaraan(int $id)
    {
        return $this->kendaraanRepository->delete($id);
    }

    public function findKendaraanById(int $id)
    {
        return $this->kendaraanRepository->findById($id);
    }

    public function getAllKendaraans()
    {
        return $this->kendaraanRepository->all();
    }

    public function getAvailableKendaraans()
    {
        return $this->kendaraanRepository->findAvailable();
    }

    public function getKendaraansByKategori(int $kategoriId)
    {
        return $this->kendaraanRepository->findByKategori($kategoriId);
    }

    public function getKendaraansByKategoriForCustomer()
    {
        return \App\Models\Kategori::with(['kendaraans' => fn($q) =>
            $q->where('status', 'tersedia')
        ])->get();
    }

    public function isKendaraanAvailable(int $kendaraanId, string $mulai, string $selesai): bool
    {
        $booked = \App\Models\DetailRental::where('kendaraan_id', $kendaraanId)
            ->whereHas('rental', fn($q) => $q->whereIn('status', [
                'pending_verification', 'waiting_payment', 'active'
            ]))
            ->whereHas('rental', fn($q) => $q
                ->where('tanggal_mulai', '<=', $selesai)
                ->where('tanggal_selesai', '>=', $mulai)
            )
            ->exists();

        return !$booked;
    }
}