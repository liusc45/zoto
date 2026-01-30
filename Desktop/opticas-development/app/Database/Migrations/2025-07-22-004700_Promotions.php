<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Promotions extends Migration
{
    public function up()
    {
        // Create promotions table
        $this->forge->addField([
            "id" => [
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "auto_increment" => true
            ],
            "name" => [
                "type" => "VARCHAR",
                "constraint" => 100,
                "null" => false,
            ],
            "description" => [
                "type" => "TEXT",
                "null" => true,
            ],
            "starts_at" => [
                "type" => "datetime",
                "null" => false,
            ],
            "ends_at" => [
                "type" => "datetime",
                "null" => false,
            ],
            "status" => [
                "type" => "ENUM",
                "constraint" => ["active", "inactive", "expired"],
                "default" => "active",
            ],
            "created_by" => [
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "null" => true,
            ],
            "created_at" => [
                "type" => "datetime",
                "default" => new RawSql("CURRENT_TIMESTAMP"),
                "null" => true
            ],
            "updated_at" => [
                "type" => "datetime",
                "null" => true
            ],
            "deleted_at" => [
                "type" => "datetime",
                "null" => true
            ]
        ]);

        // Add primary key and foreign keys
        $this->forge->addPrimaryKey("id")
            ->addForeignKey("created_by", "users", "id");

        // Add indexes
        $this->forge->addKey(["starts_at", "ends_at"], false, false, "idx_promotions_date_range");
        $this->forge->addKey("status", false, false, "idx_promotions_status");
        $this->forge->addKey("deleted_at", false, false, "idx_promotions_deleted_at");

        // Create the table
        $this->forge->createTable("promotions", true, ["ENGINE" => "InnoDB"]);

        // Create promotion_items table
        $this->forge->addField([
            "id" => [
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "auto_increment" => true
            ],
            "promotion_id" => [
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "null" => false,
            ],
            "item_id" => [
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "null" => false,
            ],
            "price" => [
                "type" => "decimal",
                "constraint" => "10,2",
                "null" => false,
            ],
            "created_at" => [
                "type" => "datetime",
                "default" => new RawSql("CURRENT_TIMESTAMP"),
                "null" => true
            ],
            "updated_at" => [
                "type" => "datetime",
                "null" => true
            ],
            "deleted_at" => [
                "type" => "datetime",
                "null" => true
            ]
        ]);

        // Add primary key and foreign keys
        $this->forge->addPrimaryKey("id")
            ->addForeignKey("promotion_id", "promotions", "id", "CASCADE", "CASCADE")
            ->addForeignKey("item_id", "items", "id", "CASCADE", "CASCADE");

        // Add indexes
        $this->forge->addKey(["promotion_id", "item_id"], false, true, "idx_promotion_items_unique");
        $this->forge->addKey("deleted_at", false, false, "idx_promotion_items_deleted_at");

        // Create the table
        $this->forge->createTable("promotion_items", true, ["ENGINE" => "InnoDB"]);
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable("promotion_items");
        $this->forge->dropTable("promotions");
        $this->db->enableForeignKeyChecks();
    }
}