<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SampahSeeder extends Seeder
{
    public function run()
    {
        // membuat data
        $sampah_data = [
            [
                'nama_sampah' => 'Plastik Kresek',
                'id_jenis'    => '1',
                'id_satuan'   => '1',
                'harga'       => '10000',
                'deskripsi'   => 'Sampah Organik',
            ],
            [
                'nama_sampah' => 'Kertas HVS',
                'id_jenis'    => '2',
                'id_satuan'   => '1',
                'harga'       => '15000',
                'deskripsi'   => 'Sampah Organik',
            ],
        ];

        foreach ($sampah_data as $data) {
            // insert semua data ke tabel
            $this->db->table('sampah')->insert($data);
        }
    }
}
