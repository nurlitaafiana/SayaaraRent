<?php
namespace App\Repositories;
use App\Models\Rental;
use App\Repositories\Contracts\RentalRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class RentalRepository extends BaseRepository implements RentalRepositoryInterface
{
    public function __construct(Rental $model)
    {
        parent::__construct($model);
    }

    public function findByUserId(int $userId): Collection
    {
        return $this->model
            ->where('user_id', $userId)
            ->get();
    }

    public function findByStatus(string $status): Collection
    {
        return $this->model
            ->where('status', $status)
            ->get();
    }

    public function findActiveByUserId(int $userId)
{
    return $this->model
        ->where('user_id', $userId)
        ->whereNotIn('status', ['cancelled', 'completed', 'rejected'])
        ->with('detailRental.kendaraan')
        ->latest()
        ->get();
}
}