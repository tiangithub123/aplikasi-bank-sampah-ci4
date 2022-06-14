<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SatuanSeeder extends Seeder
{
    public function run()
    {
        // membuat data
        $satuan_data = [
            [
                'nama_satuan' => 'KG',
            ],
            [
                'nama_satuan' => 'PCS',
            ],
        ];

        foreach ($satuan_data as $data) {
            // insert semua data ke tabel
            $this->db->table('satuan')->insert($data);
        }
    }
}
