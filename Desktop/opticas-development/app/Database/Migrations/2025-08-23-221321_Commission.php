<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Commission extends Migration
{
    public function up()
    {
        // Commission configuration table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'tax_rate' => [ // e.g., 0.16 for 16%
                'type' => 'DECIMAL',
                'constraint' => '5,4',
                'default' => '0.1600',
            ],
            'bank_commission_rate' => [ // e.g., 0.03 for 3% applied to card/transfer payments
                'type' => 'DECIMAL',
                'constraint' => '5,4',
                'default' => '0.0300',
            ],
            'percent_line1' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => '5.00',
            ],
            'percent_line2' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => '3.00',
            ],
            'percent_line13' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => '5.00',
            ],
            'percent_bundle_1_13' => [ // higher rate when both lines 1 and 13 are present
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => '7.00',
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => true,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
                'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
        ])
            ->addPrimaryKey('id')
            ->createTable('commission_config', true, ['ENGINE' => 'InnoDB']);

        // Sale commissions ledger table
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'sale_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'seller_user_id' => [ // users.id of the seller (sales.created_by)
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'commissionable_amount' => [ // subtotal for items in lines 1,2,13
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'default' => '0.00',
            ],
            'taxes_amount' => [ // taxes applied to commissionable amount
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'default' => '0.00',
            ],
            'bank_commission_amount' => [ // proportional bank commission for commissionable portion
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'default' => '0.00',
            ],
            'net_amount' => [ // commissionable - taxes - bank commission
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'default' => '0.00',
            ],
            'commission_amount' => [ // final commission to pay
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'default' => '0.00',
            ],
            'status' => [ // pending|paid
                'type' => 'ENUM',
                'constraint' => ['pending', 'paid'],
                'default' => 'pending',
            ],
            'paid_at' => [
                'type' => 'datetime',
                'null' => true,
                'default' => null,
            ],
            'created_at' => [
                'type' => 'datetime',
                'null' => true,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type' => 'datetime',
                'null' => true,
                'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
            'deleted_at' => [
                'type' => 'datetime',
                'null' => true,
                'default' => null,
            ],
        ])
            ->addPrimaryKey('id')
            ->addUniqueKey(['sale_id'])
            ->addForeignKey('sale_id', 'sales', 'id', 'CASCADE', 'CASCADE')
            ->addForeignKey('seller_user_id', 'users', 'id', 'RESTRICT', 'CASCADE')
            ->createTable('sale_commissions', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('sale_commissions', true);
        $this->forge->dropTable('commission_config', true);
    }
}
