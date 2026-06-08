<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategori = [
            ['nama_kategori' => 'MPV', 'deskripsi' => 'MPV luas untuk keluarga besar.'],
            ['nama_kategori' => 'SUV', 'deskripsi' => 'SUV tangguh untuk petualangan off-road.'],
            ['nama_kategori' => 'City Car', 'deskripsi' => 'City Car nyaman untuk perjalanan kota.'],
            ['nama_kategori' => 'Luxury', 'deskripsi' => 'Mobil mewah untuk pengalaman berkendara yang luar biasa.'],
            ['nama_kategori' => 'Mini Bus', 'deskripsi' => 'Mini Bus luas untuk perjalanan kelompok.'],
        ];

        foreach ($kategori as $item) {
            Kategori::create($item);
        }
    }
}
