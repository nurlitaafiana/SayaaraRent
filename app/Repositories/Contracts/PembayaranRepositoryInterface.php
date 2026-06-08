<?php
namespace App\Repositories\Contracts;

interface PembayaranRepositoryInterface extends BaseRepositoryInterface
{
    public function findPendingPayment(); //lihat pembayaran yg belum dikonfirmasi admin (verifikasi pembayaran oleh admin)

    public function findVerifiedPayment(); //lihat pembayaran yg sudah dikonfirmasi admin (sudah diverifikasi admin)
    public function findByRentalId($rentalId);
}   