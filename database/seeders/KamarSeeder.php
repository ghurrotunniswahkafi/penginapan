<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kamar;

class KamarSeeder extends Seeder
{
    public function run()
    {
        $kamars = [
            ['nomor_kamar' => '101', 'jenis_kamar' => 'Single', 'gedung' => 'A', 'harga' => 150000, 'fasilitas' => 'AC, TV', 'status' => 'kosong'],
            ['nomor_kamar' => '102', 'jenis_kamar' => 'Double', 'gedung' => 'A', 'harga' => 200000, 'fasilitas' => 'AC, TV, Wifi', 'status' => 'terisi'],
            ['nomor_kamar' => '103', 'jenis_kamar' => 'Single', 'gedung' => 'A', 'harga' => 150000, 'fasilitas' => 'AC', 'status' => 'kosong'],
            ['nomor_kamar' => '201', 'jenis_kamar' => 'Double', 'gedung' => 'B', 'harga' => 250000, 'fasilitas' => 'AC, TV, Wifi, Kulkas', 'status' => 'kosong'],
            ['nomor_kamar' => '202', 'jenis_kamar' => 'Suite', 'gedung' => 'B', 'harga' => 350000, 'fasilitas' => 'AC, TV, Wifi, Kulkas, Balkon', 'status' => 'terisi'],
            ['nomor_kamar' => '203', 'jenis_kamar' => 'Single', 'gedung' => 'B', 'harga' => 150000, 'fasilitas' => 'AC, TV', 'status' => 'kosong'],
        ];

        foreach ($kamars as $kamar) {
            Kamar::firstOrCreate(
                ['nomor_kamar' => $kamar['nomor_kamar']],
                $kamar
            );
        }
    }
}
