<?php
namespace App\Repositories;
use App\Models\DetailRental;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\DetailRentalRepositoryInterface;

class DetailRentalRepository extends BaseRepository implements DetailRentalRepositoryInterface
{
    public function __construct(DetailRental $model)
    {
        parent::__construct($model);
    }

    public function findByRentalId($rentalId)
    {
        return $this->model
            ->where('rental_id', $rentalId)
            ->get();
    }
}