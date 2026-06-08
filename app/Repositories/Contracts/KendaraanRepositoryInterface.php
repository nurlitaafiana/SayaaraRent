<?php
namespace App\Repositories\Contracts;

interface KendaraanRepositoryInterface extends BaseRepositoryInterface
{
    public function findAvailable(); //lihat armada yang tersedia
    public function findByKategori(int $kategoriId); //filter kendaraan berdasarkan kategori
}