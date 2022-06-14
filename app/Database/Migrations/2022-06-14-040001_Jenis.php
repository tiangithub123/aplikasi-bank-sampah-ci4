<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jenis extends Migration
{
    public function up()
    {
        // Membuat kolom/field untuk tabel jenis
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_jenis'      => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
        ]);

        // Membuat primary key
        $this->forge->addKey('id', TRUE);

        // Membuat tabel jenis
        $this->forge->createTable('jenis', TRUE);
    }

    public function down()
    {
        // menghapus tabel jenis
        $this->forge->dropTable('jenis');
    }
}
