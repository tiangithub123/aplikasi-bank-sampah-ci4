<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class NasabahSeeder extends Seeder
{
    public function run()
    {
        // membuat data
        $nasabah_data = [
            [
                'nama_nasabah' => 'Nasabah A',
                'username'     => 'nasabah',
                'password'     => password_hash('nasabah', PASSWORD_DEFAULT),
                'alamat'       => 'Alamat Nasabah A',
                'telepon'      => '0123456789',
            ],
        ];

        foreach ($nasabah_data as $data) {
            // insert semua data ke tabel
            $this->db->table('nasabah')->insert($data);
        }
    }
}
