<?php

namespace App\Repositories;

use App\Models\Kendaraan;
use App\Repositories\Contracts\KendaraanRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class KendaraanRepository extends BaseRepository implements KendaraanRepositoryInterface
{
    public function __construct(Kendaraan $model)
    {
        parent::__construct($model);
    }

    public function findAvailable(): Collection
    {
        return $this->model
            ->where('status', 'tersedia')
            ->get();
    }

    public function findByKategori(int $kategoriId): Collection
    {
        return $this->model
            ->where('kategori_id', $kategoriId)
            ->get();
    }
}