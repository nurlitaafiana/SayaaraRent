<?php

namespace App\Services;

use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;
use App\Exceptions\PembayaranException;
use App\Repositories\Contracts\RentalRepositoryInterface;
use App\Repositories\Contracts\PembayaranRepositoryInterface;

class PembayaranService
{
    public function __construct(
        protected PembayaranRepositoryInterface $pembayaranRepository,
        protected RentalRepositoryInterface $rentalRepository
    ) {}

    public function createPembayaran(array $data)
    {
        // Cek apakah sudah ada pembayaran untuk rental ini
        $existing = $this->pembayaranRepository->findByRentalId($data['rental_id']);
        if ($existing) {
            throw new \Exception('Pembayaran untuk rental ini sudah ada.');
        }

        $pembayaran = $this->pembayaranRepository->create($data);

        // Update status rental
        $this->rentalRepository->update($data['rental_id'], [
            'status' => 'waiting_payment' // sesuaikan dengan ENUM yang benar
        ]);

        return $pembayaran;
}

    public function verifyPayment(int $paymentId)
    {
        return DB::transaction(function () use ($paymentId) {

            $payment = $this->pembayaranRepository->findById($paymentId);

            $this->ensurePaymentExists($payment);
            $this->ensurePending($payment);

            $this->rentalRepository->update(
                $payment->rental_id,
                [
                    'status' => 'active'
                ]
            );

            return $this->pembayaranRepository->update(
                $paymentId,
                [
                    'status_pembayaran' => 'verified'
                ]
            );
        });
    }

    public function rejectPayment(int $paymentId, ?string $catatanAdmin = null)
    {
        $payment = $this->pembayaranRepository->findById($paymentId);

        $this->ensurePaymentExists($payment);
        $this->ensurePending($payment);

        return $this->pembayaranRepository->update(
            $paymentId,
            [
                'status_pembayaran' => 'rejected',
                'catatan_admin' => $catatanAdmin,
            ]
        );
    }

    public function getUserPayments($userId)
    {
        return Pembayaran::with('rental')
            ->whereHas('rental', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->latest()
            ->get();
    }

    public function getPendingPayments()
    {
        return $this->pembayaranRepository->findPendingPayment();
    }

    public function getVerifiedPayments()
    {
        return $this->pembayaranRepository->findVerifiedPayment();
    }

    public function getPaymentById(int $id)
    {
        return $this->pembayaranRepository->findById($id);
    }

    private function ensurePaymentExists($payment)
    {
        if (!$payment) {
            throw new PembayaranException('Pembayaran tidak ditemukan');
        }
    }

    private function ensurePending($payment)
    {
        if ($payment->status_pembayaran !== 'pending') {
            throw new PembayaranException('Hanya pembayaran pending yang bisa diproses');
        }
    }
}