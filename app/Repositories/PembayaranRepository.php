<?php
namespace App\Repositories;
use App\Models\Pembayaran;
use App\Repositories\Contracts\PembayaranRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;    

class PembayaranRepository extends BaseRepository implements PembayaranRepositoryInterface
{
    public function __construct(Pembayaran $model)
    {
        parent::__construct($model);
    }

    public function findPendingPayment(): Collection
    {
        return $this->model
            ->where('status_pembayaran', 'pending')
            ->get();
    }

    public function findVerifiedPayment(): Collection
    {
        return $this->model
            ->where('status_pembayaran', 'verified')
            ->get();
    }

    public function findByRentalId($rentalId)
    {
        return $this->model->where('rental_id', $rentalId)->first();
    }
}