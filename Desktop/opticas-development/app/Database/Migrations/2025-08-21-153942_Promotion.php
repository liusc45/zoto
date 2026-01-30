<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreatePromotionsTables extends Migration
{
    public function up()
    {
        // promotions
        $this->forge->addField([
            'id' => ['type' => 'INT','constraint'=>11, 'unsigned' => true, 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 150],
            'code' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'description' => ['type' => 'TEXT', 'null' => true],
            'type' => ['type' => 'ENUM', 'constraint' => ['percent','fixed','bogo','bundle','tier_amount','tier_qty','upgrade','cashback','points','shipping','financing','warranty']],
            'scope' => ['type' => 'ENUM', 'constraint' => ['item','order','mixed'], 'default' => 'mixed'],
            'priority' => ['type' => 'INT', 'default' => 100],
            'combinable' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'channel' => ['type' => 'ENUM', 'constraint' => ['store','online','both'], 'default' => 'both'],
            'audience' => ['type' => 'JSON', 'null' => true],
            'constraints_json' => ['type' => 'JSON', 'null' => true],
            'rule_json' => ['type' => 'JSON', 'null' => false],
            'starts_at' => ['type' => 'DATETIME'],
            'ends_at' => ['type' => 'DATETIME', 'null' => true],
            'active' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
            'created_at' => ['type' => 'DATETIME', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'DATETIME', 'null' => true, 'default' => new RawSql('NULL ON UPDATE CURRENT_TIMESTAMP')],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ])
            ->addPrimaryKey('id')
            ->addKey(['active', 'starts_at', 'ends_at'])
            ->addKey('priority')
            ->addUniqueKey('code')
            ->createTable('promotions', true, ['ENGINE' => 'InnoDB']);

        // sale_promotions
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'sale' => ['type' => 'INT','constraint'=>11, 'unsigned' => true, "null" => true],
            'promotion' => ['type' => 'INT',"constraint"=>11, 'unsigned' => true, 'null' => true],
            'promo_code' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'discount_amount' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
            'meta' => ['type' => 'JSON', 'null' => true],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('promotion', 'promotions', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('sale_promotions', true, ['ENGINE' => 'InnoDB']);

        // sale_item_promotions
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'sale' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'sale_item' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'promotion' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'discount_amount' => ['type' => 'DECIMAL', 'constraint' => '12,2', 'default' => 0],
            'meta' => ['type' => 'JSON', 'null' => true],
            'created_at' => ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at' => ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('promotion', 'promotions', 'id', 'CASCADE', 'SET NULL');
        $this->forge->createTable('sale_item_promotions', true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable('sale_item_promotions', true);
        $this->forge->dropTable('sale_promotions', true);
        $this->forge->dropTable('promotions', true);
    }
}