<?php
namespace App\Repositories\Contracts;

interface RentalRepositoryInterface extends BaseRepositoryInterface
{
    public function findByUserId(int $userId); //lihat riwayat rental customer

    public function findByStatus(string $status); //lihat rental berdasarkan status (pending_verification,waiting_payment,active,completed,rejected,cancelled)

    public function findActiveByUserId(int $userId);
}