<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class PrescriptionRange extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
                'unsigned' => true,
            ],
            'description' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('ranges');

        // Tabla de intervalos asociados a cada rango
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => true,
                'unsigned' => true,
            ],
            'range' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'min_value' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2', // hasta +/-16.00 con pasos de 0.25
                'null' => false,
            ],
            'max_value' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'default' =>  new RawSql('CURRENT_TIMESTAMP'),
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' =>  new RawSql('NULL ON UPDATE CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('range', 'ranges', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('range_intervals');
    }

    public function down()
    {
        $this->forge->dropTable('range_intervals');
        $this->forge->dropTable('ranges');
    }
}
