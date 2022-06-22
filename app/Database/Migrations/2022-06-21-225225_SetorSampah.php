<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class SetorSampah extends Migration
{
    public function up()
    {
        // Membuat kolom/field untuk tabel user
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
            'id_sampah'      => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
            ],
            'jumlah'      => [
                'type' => 'INT',
            ],
            'total'      => [
                'type' => 'INT',
            ],
            'tgl_penjemputan'      => [
                'type'       => 'DATE',
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
        $this->forge->addForeignKey('id_sampah', 'sampah', 'id');
        // Membuat tabel setor_sampah
        $this->forge->createTable('setor_sampah', TRUE);
    }

    public function down()
    {
        // menghapus tabel setor_sampah
        $this->forge->dropTable('setor_sampah');
    }
}
