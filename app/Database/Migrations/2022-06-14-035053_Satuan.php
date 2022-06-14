<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Satuan extends Migration
{
    public function up()
    {
        // Membuat kolom/field untuk tabel satuan
        $this->forge->addField([
            'id'          => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_satuan'      => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
        ]);

        // Membuat primary key
        $this->forge->addKey('id', TRUE);

        // Membuat tabel satuan
        $this->forge->createTable('satuan', TRUE);
    }

    public function down()
    {
        // menghapus tabel satuan
        $this->forge->dropTable('satuan');
    }
}
