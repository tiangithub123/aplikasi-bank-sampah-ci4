<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // membuat data
        $user_data = [
            [
                'nama_user' => 'Administrator',
                'username'  => 'admin',
                'password'  => password_hash('admin', PASSWORD_DEFAULT),
                'level'     => 'Admin',
            ],
        ];

        foreach ($user_data as $data) {
            // insert semua data ke tabel
            $this->db->table('user')->insert($data);
        }
    }
}
