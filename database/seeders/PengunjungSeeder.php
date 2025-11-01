<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengunjung;

class PengunjungSeeder extends Seeder
{
    public function run()
    {
        $pengunjungs = [
            [
                'nama' => 'Ahmad Zulkifli',
                'no_identitas' => '3201012345670001',
                'jenis_tamu' => 'Individu',
                'check_in' => '2025-10-15',
                'check_out' => '2025-10-17',
                'nomor_kamar' => '102',
            ],
            [
                'nama' => 'Siti Rahma',
                'no_identitas' => '3201012345670002',
                'jenis_tamu' => 'Corporate',
                'check_in' => '2025-10-16',
                'check_out' => '2025-10-20',
                'nomor_kamar' => '202',
            ],
            [
                'nama' => 'Budi Santoso',
                'no_identitas' => '1234567890123',
                'jenis_tamu' => 'Individu',
                'check_in' => '2025-10-14',
                'check_out' => '2025-10-18',
                'nomor_kamar' => '101',
            ],
        ];

        foreach ($pengunjungs as $p) {
            Pengunjung::firstOrCreate(
                ['no_identitas' => $p['no_identitas']],
                $p
            );
        }
    }
}
