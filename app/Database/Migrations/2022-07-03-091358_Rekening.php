<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Rekening extends Migration
{
    public function up()
    {
        // Membuat kolom/field untuk tabel rekening
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_nasabah'      => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'nama_bank'      => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'no_rekening'      => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
            'atas_nama'      => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
            ],
        ]);

        // Membuat primary key
        $this->forge->addKey('id', TRUE);
        // Membuat foreignKey
        $this->forge->addForeignKey('id_nasabah', 'nasabah', 'id');
        // Membuat tabel rekening
        $this->forge->createTable('rekening', TRUE);
    }

    public function down()
    {
        // menghapus tabel rekening
        $this->forge->dropTable('rekening');
    }
}
