<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class ItemPrice extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id" => [
                "type" => "int",
                "constraint" => 11,
                "unsigned" => true,
                "auto_increment" => true,
            ],
            "item" => [
                "type" => "int",
                "constraint" => 11,
                "unsigned" => true,
                "null" => false,
            ],
            "type" => [
                "type" => "ENUM",
                "constraint" => [
                    "regular",
                    "promotion",
                    "discount",
                    "outlet"
                ],
                "default" => "regular",
            ],
            "amount" => [
                "type" => "decimal",
                "constraint" => "10,2",
                "null" => false,
            ],
            "shipping_cost" => [
                "type" => "decimal",
                "constraint" => "10,2",
                "null" => true,
            ],
            "starts_at" => [
                "type" => "datetime",
                "null" => true,
            ],
            "ends_at" => [
                "type" => "datetime",
                "null" => true,
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

        // Clave primaria e índices de relación
        $this->forge->addPrimaryKey("id")
            ->addForeignKey("item", "items", "id", "CASCADE", "CASCADE")
            ->addForeignKey("created_by", "users", "id");

        // Índice para búsquedas por tipo de precio
        $this->forge->addKey("type", false, false, "idx_item_prices_type");

        // Índice compuesto para consultas de precios activos
        $this->forge->addKey(["starts_at", "ends_at"], false, false, "idx_item_prices_date_range");

        // Índice para consultas de precios por item y fechas
        $this->forge->addKey(["item", "starts_at", "ends_at"], false, false, "idx_item_prices_item_dates");

        // Índice para soft deletes
        $this->forge->addKey("deleted_at", false, false, "idx_item_prices_deleted_at");

        $this->forge->createTable("item_prices", true, ["ENGINE" => "InnoDB"]);
    }

    public function down()
    {
        $this->forge->dropTable("item_prices");
    }
}