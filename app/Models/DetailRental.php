<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailRental extends Model
{
    use HasFactory;
    protected $fillable = [
        'kendaraan_id',
        'rental_id',
        'jumlah_hari',
        'harga_per_hari',
        'subtotal'
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }
}
