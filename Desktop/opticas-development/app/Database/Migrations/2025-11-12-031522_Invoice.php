<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Invoice extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'sale' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'comment' => 'Venta facturada',
            ],
            'person_tax' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'comment' => 'Datos fiscales elegidos para timbrar',
            ],
            'series' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
            ],
            'folio' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'subtotal' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'null' => true,
            ],
            'discount' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'null' => true,
                'default' => '0.00',
            ],
            'tax_rate' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true,
                'comment' => 'porcentaje, ej. 16.00',
            ],
            'tax_amount' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'null' => true,
            ],
            'total' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'null' => true,
            ],
            'currency' => [
                'type' => 'VARCHAR',
                'constraint' => 5,
                'default' => 'MXN',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['draft','issued','canceled'],
                'default' => 'draft',
            ],
            'uuid' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'comment' => 'UUID del timbrado',
            ],
            'xml_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'pdf_path' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'issued_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'canceled_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => new RawSql('NULL ON UPDATE CURRENT_TIMESTAMP'),
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge
            ->addKey('id', true)
            ->addUniqueKey(['series','folio'])
            ->addForeignKey('sale', 'sales', 'id', 'CASCADE', 'SET NULL')
            ->addForeignKey('person_tax', 'person_taxes', 'id', 'CASCADE', 'SET NULL')
            ->addForeignKey('created_by', 'users', 'id', 'CASCADE', 'SET NULL')
            ->createTable('invoices', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('invoices', true);
    }
}
