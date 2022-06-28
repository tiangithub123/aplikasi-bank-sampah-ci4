<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DataSeeder extends Seeder
{
    public function run()
    {
        $this->call('UserSeeder');
        // $this->call('NasabahSeeder');
        $this->call('JenisSeeder');
        $this->call('SatuanSeeder');
        $this->call('SampahSeeder');
    }
}
