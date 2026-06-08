<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $fillable = [
    'rental_id',
    'metode_pembayaran',
    'bukti_pembayaran',
    'jumlah_bayar',
    'tanggal_bayar',
    'status_pembayaran',
    'catatan_admin',
];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }
}