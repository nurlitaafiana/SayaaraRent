<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;
    protected $fillable = [
        'kategori_id',
        'nama_mobil',
        'merk',
        'tahun',
        'plat_nomor',
        'kapasitas_penumpang',
        'harga_sewa_per_hari',
        'gambar',
        'deskripsi',
        'status',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function detailRental()
    {
        return $this->hasMany(DetailRental::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function detailRentals()
    {
        return $this->hasMany(DetailRental::class);
    }
}
