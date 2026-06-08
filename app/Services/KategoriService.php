<?php

namespace App\Services;

use App\Repositories\Contracts\KategoriRepositoryInterface;

class KategoriService
{
    public function __construct(
        protected KategoriRepositoryInterface $kategoriRepository
    ) {}

    public function createKategori(array $data)
    {
        return $this->kategoriRepository->create($data);
    }

    public function updateKategori(int $id, array $data)
    {
        return $this->kategoriRepository->update($id, $data);
    }

    public function deleteKategori(int $id)
    {
        return $this->kategoriRepository->delete($id);
    }

    public function findKategoriById(int $id)
    {
        return $this->kategoriRepository->findById($id);
    }

    public function getAllKategori()
    {
        return $this->kategoriRepository->all();
    }
}