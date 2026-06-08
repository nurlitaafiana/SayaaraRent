<?php

namespace App\Services;

use App\Repositories\Contracts\RentalRepositoryInterface;
use App\Repositories\Contracts\DetailRentalRepositoryInterface;

class DetailRentalService
{
    public function __construct(
        protected DetailRentalRepositoryInterface $detailRentalRepository,
        protected RentalRepositoryInterface $rentalRepository
    ) {}

    public function createDetailRental(array $data)
    {
        $detail = $this->detailRentalRepository->create([
            'rental_id' => $data['rental_id'],
            'kendaraan_id' => $data['kendaraan_id'],
            'harga_per_hari' => $data['harga_per_hari'],
            'jumlah_hari' => $data['jumlah_hari'],
            'subtotal' => $this->calculateSubtotal(
                $data['harga_per_hari'],
                $data['jumlah_hari']
            ),
        ]);

        $this->updateTotalHargaRental(
            $data['rental_id']
        );

        return $detail;
    }

    public function findByRentalId(int $rentalId)
    {
        return $this->detailRentalRepository
            ->findByRentalId($rentalId);
    }

    public function findById(int $id)
    {
        return $this->detailRentalRepository
            ->findById($id);
    }

    public function deleteDetailRental(int $id)
    {
        $detail = $this->detailRentalRepository
            ->findById($id);

        if (!$detail) {
            return false;
        }

        $rentalId = $detail->rental_id;

        $this->detailRentalRepository
            ->delete($id);

        $this->updateTotalHargaRental(
            $rentalId
        );

        return true;
    }

    public function calculateSubtotal(
        float $hargaPerHari,
        int $jumlahHari
    ) {
        return $hargaPerHari * $jumlahHari;
    }

    private function updateTotalHargaRental(
        int $rentalId
    ) {
        $details = $this->detailRentalRepository
            ->findByRentalId($rentalId);

        $total = $details->sum('subtotal');

        $this->rentalRepository->update(
            $rentalId,
            [
                'total_harga' => $total
            ]
        );
    }

    public function getBookedRangesByKendaraan(int $kendaraanId): \Illuminate\Support\Collection
    {
        return \App\Models\DetailRental::where('kendaraan_id', $kendaraanId)
            ->with('rental')
            ->get()
            ->filter(fn($d) => $d->rental && in_array($d->rental->status, [
                'pending_verification', 'waiting_payment', 'active'
            ]));
    }
}