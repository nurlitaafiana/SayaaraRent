<?php

namespace App\Services;

use App\Exceptions\RentalException;
use App\Models\DetailRental;
use App\Models\Kendaraan;
use App\Models\Rental;
use App\Repositories\Contracts\RentalRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

class RentalService
{
    public function __construct(
        protected RentalRepositoryInterface $rentalRepository
    ) {}

    public function getPendingRentals()
    {
        return $this->rentalRepository->findByStatus('pending_verification');
    }

    public function getActiveRentals()
    {
        return $this->rentalRepository->findByStatus('active');
    }

    public function getAllRentals(?string $status = null)
    {
        $query = Rental::with(['user', 'detailRental.kendaraan'])->latest();

        if ($status && $status !== 'semua') {
            $query->where('status', $status);
        }

        return $query->get();
    }

    public function getRentalsByUser(int $userId, ?string $status = null)
    {
        $query = Rental::where('user_id', $userId)
                       ->with('detailRental.kendaraan')
                       ->latest();

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        return $query->get();
    }

    public function getActiveRentalsByUser(int $userId)
    {
        return $this->rentalRepository->findActiveByUserId($userId);
    }

    public function findById(int $id)
    {
        return $this->rentalRepository->findById($id);
    }

    public function isKendaraanAvailable(int $kendaraanId, string $mulai, string $selesai): bool
    {
        return !DetailRental::where('kendaraan_id', $kendaraanId)
            ->whereHas('rental', fn($q) => $q
                ->whereIn('status', ['pending_verification', 'waiting_payment', 'active'])
                ->where('tanggal_mulai', '<=', $selesai)
                ->where('tanggal_selesai', '>=', $mulai)
            )
            ->exists();
    }

    public function handleStoreRental(
        array $data,
        int $userId,
        ?UploadedFile $ktpFile = null,
        ?UploadedFile $simFile = null
    ): array {
        $tersedia = $this->isKendaraanAvailable(
            $data['kendaraan_id'],
            $data['tanggal_mulai'],
            $data['tanggal_selesai']
        );

        if (!$tersedia) {
            return ['tersedia' => false];
        }

        $data['user_id'] = $userId;
        unset($data['upload_ktp'], $data['upload_sim']);

        $this->createRental($data, $ktpFile, $simFile);

        return ['tersedia' => true];
    }

    public function createRental(
        array $data,
        ?UploadedFile $ktpFile = null,
        ?UploadedFile $simFile = null
    ) {
        if ($ktpFile) {
            $data['upload_ktp'] = $ktpFile->store('ktp', 'public');
        }

        if ($simFile) {
            $data['upload_sim'] = $simFile->store('sim', 'public');
        }

        $kendaraan  = Kendaraan::findOrFail($data['kendaraan_id']);
        $mulai      = Carbon::parse($data['tanggal_mulai']);
        $selesai    = Carbon::parse($data['tanggal_selesai']);
        $jumlahHari = $mulai->diffInDays($selesai) ?: 1;
        $subtotal   = $kendaraan->harga_sewa_per_hari * $jumlahHari;

        $rental = $this->rentalRepository->create([
            'user_id'         => $data['user_id'],
            'tanggal_mulai'   => $data['tanggal_mulai'],
            'tanggal_selesai' => $data['tanggal_selesai'],
            'upload_ktp'      => $data['upload_ktp'],
            'upload_sim'      => $data['upload_sim'],
            'total_harga'     => $subtotal,
            'status'          => 'pending_verification',
            'catatan_admin'   => null,
        ]);

        DetailRental::create([
            'rental_id'      => $rental->id,
            'kendaraan_id'   => $kendaraan->id,
            'harga_per_hari' => $kendaraan->harga_sewa_per_hari,
            'jumlah_hari'    => $jumlahHari,
            'subtotal'       => $subtotal,
        ]);

        return $rental;
    }

    public function verifyRental(int $rentalId)
    {
        $rental = $this->rentalRepository->findById($rentalId);

        if (!$rental) {
            throw new RentalException('Rental tidak ditemukan');
        }

        if ($rental->status !== 'pending_verification') {
            throw new RentalException('Hanya rental pending yang dapat diverifikasi');
        }

        return $this->rentalRepository->update($rentalId, ['status' => 'waiting_payment']);
    }

    public function rejectRental(int $rentalId, ?string $catatanAdmin = null)
    {
        $rental = $this->rentalRepository->findById($rentalId);

        if (!$rental) {
            throw new RentalException('Rental tidak ditemukan');
        }

        if ($rental->status !== 'pending_verification') {
            throw new RentalException('Hanya rental pending yang dapat ditolak');
        }

        return $this->rentalRepository->update($rentalId, [
            'status'        => 'rejected',
            'catatan_admin' => $catatanAdmin,
        ]);
    }

    public function cancelRental(int $rentalId)
    {
        $rental = $this->rentalRepository->findById($rentalId);

        if (!$rental) {
            throw new RentalException('Rental tidak ditemukan');
        }

        if (!in_array($rental->status, ['pending_verification', 'waiting_payment'])) {
            throw new RentalException('Rental tidak dapat dibatalkan');
        }

        return $this->rentalRepository->update($rentalId, ['status' => 'cancelled']);
    }

    public function completeRental(int $rentalId)
    {
        $rental = $this->rentalRepository->findById($rentalId);

        if (!$rental) {
            throw new RentalException('Rental tidak ditemukan');
        }

        if ($rental->status !== 'active') {
            throw new RentalException('Hanya rental aktif yang dapat diselesaikan');
        }

        return $this->rentalRepository->update($rentalId, ['status' => 'completed']);
    }

    public function resetRentalStatus(int $rentalId, string $status)
    {
        $allowedStatus = [
            'pending_verification',
            'waiting_payment',
            'active',
            'completed',
            'rejected',
            'cancelled',
        ];

        if (!in_array($status, $allowedStatus)) {
            throw new RentalException('Status tidak valid');
        }

        $rental = $this->rentalRepository->findById($rentalId);

        if (!$rental) {
            throw new RentalException('Rental tidak ditemukan');
        }

        return $this->rentalRepository->update($rentalId, ['status' => $status]);
    }

    public function getBookedDatesByKendaraan(int $kendaraanId): array
    {
        $rentals = DetailRental::where('kendaraan_id', $kendaraanId)
            ->with('rental')
            ->get()
            ->filter(fn($d) => $d->rental && in_array($d->rental->status, [
                'pending_verification', 'waiting_payment', 'active'
            ]));

        $dates = [];
        foreach ($rentals as $detail) {
            $current = Carbon::parse($detail->rental->tanggal_mulai);
            $end     = Carbon::parse($detail->rental->tanggal_selesai);

            while ($current->lte($end)) {
                $dates[] = $current->format('Y-m-d');
                $current->addDay();
            }
        }

        return array_unique($dates);
    }

    public function getBookedRangesByKendaraan(int $kendaraanId): array
    {
        return DetailRental::where('kendaraan_id', $kendaraanId)
            ->whereHas('rental', fn($q) => $q->whereIn('status', [
                'pending_verification', 'waiting_payment', 'active'
            ]))
            ->with('rental')
            ->get()
            ->map(fn($d) => [
                'start' => $d->rental->tanggal_mulai,
                'end'   => $d->rental->tanggal_selesai,
            ])->toArray();
    }
}