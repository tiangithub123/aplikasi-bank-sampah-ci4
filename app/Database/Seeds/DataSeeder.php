<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DataSeeder extends Seeder
{
    public function run()
    {
        $this->call('SampahSeeder');
        $this->call('JenisSeeder');
        $this->call('SatuanSeeder');
        $this->call('UserSeeder');
    }
}
