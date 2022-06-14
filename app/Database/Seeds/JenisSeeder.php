<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class JenisSeeder extends Seeder
{
    public function run()
    {
        // membuat data
        $jenis_data = [
            [
                'nama_jenis' => 'Plastik',
            ],
            [
                'nama_jenis' => 'Kertas',
            ],
        ];

        foreach ($jenis_data as $data) {
            // insert semua data ke tabel
            $this->db->table('jenis')->insert($data);
        }
    }
}
