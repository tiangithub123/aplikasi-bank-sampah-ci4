<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Nasabah extends Migration
{
    public function up()
    {
        // Membuat kolom/field untuk tabel nasabah
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_nasabah'      => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'username'      => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'password'      => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'alamat'      => [
                'type'       => 'TEXT',
            ],
            'telepon'      => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
            ],
            'nama_bank'      => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'no_rek'      => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'atas_nama'      => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'saldo'      => [
                'type'       => 'INT',
            ],
            'foto'      => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
        ]);

        // Membuat primary key
        $this->forge->addKey('id', TRUE);

        // Membuat tabel nasabah
        $this->forge->createTable('nasabah', TRUE);
    }

    public function down()
    {
        // menghapus tabel nasabah
        $this->forge->dropTable('nasabah');
    }
}
