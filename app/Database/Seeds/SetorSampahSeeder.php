<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SetorSampahSeeder extends Seeder
{
    public function run()
    {
        // membuat data
        $setor_sampah_data = [
            [
                'id_nasabah'      => '1',
                'id_sampah'       => '1',
                'jumlah'          => '1',
                'total'           => '10000',
                'tgl_penjemputan' => date('Y-m-d'),
            ],
        ];

        foreach ($setor_sampah_data as $data) {
            // insert semua data ke tabel
            $this->db->table('setor_sampah')->insert($data);
        }
    }
}
