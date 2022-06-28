<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Penarikan extends Migration
{
    public function up()
    {
        // Membuat kolom/field untuk tabel penarikan
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'tanggal DATETIME DEFAULT CURRENT_TIMESTAMP',
            'id_nasabah'      => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'jumlah'      => [
                'type' => 'INT',
            ],
            'tgl_verifikasi'      => [
                'type'       => 'VARCHAR',
                'constraint' => 15,
            ],
            'status'      => [
                'type'       => 'ENUM',
                'constraint' => ['Menunggu', 'Berhasil', 'Gagal'],
                'default'    => 'Menunggu',
            ],
        ]);

        // Membuat primary key
        $this->forge->addKey('id', TRUE);
        // Membuat foreignKey
        $this->forge->addForeignKey('id_nasabah', 'nasabah', 'id');
        // Membuat tabel penarikan
        $this->forge->createTable('penarikan', TRUE);
    }

    public function down()
    {
        // menghapus tabel penarikan
        $this->forge->dropTable('penarikan');
    }
}
