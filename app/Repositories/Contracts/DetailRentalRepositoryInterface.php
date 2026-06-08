<?php
namespace App\Repositories\Contracts;

use App\Repositories\Contracts\BaseRepositoryInterface;

interface DetailRentalRepositoryInterface extends BaseRepositoryInterface
{
    public function findByRentalId($rentalId); //mencari detail rental berdasarkan id rental
}