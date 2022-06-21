<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Sampah extends Migration
{
    public function up()
    {
        // Membuat kolom/field untuk tabel sampah
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_sampah'      => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'id_jenis'          => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'id_satuan'          => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'harga'      => [
                'type'       => 'INT',
            ],
            'deskripsi'      => [
                'type' => 'TEXT',
            ],
            'stok'      => [
                'type'       => 'INT',
            ],
            'foto'      => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
        ]);

        // Membuat primary key
        $this->forge->addKey('id', TRUE);
        // Membuat foreignKey
        $this->forge->addForeignKey('id_jenis', 'jenis', 'id');
        $this->forge->addForeignKey('id_satuan', 'satuan', 'id');
        // Membuat tabel sampah
        $this->forge->createTable('sampah', TRUE);
    }

    public function down()
    {
        // menghapus tabel sampah
        $this->forge->dropTable('sampah');
    }
}
