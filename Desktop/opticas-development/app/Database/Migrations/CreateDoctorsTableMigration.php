<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateDoctorsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id" => [
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "auto_increment" => true
            ],
            "person" => [
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "comment" => "Relación con la tabla de personas para sus datos personales."
            ],
         
            "created_at" => [
                "type" => "DATETIME",
                "null" => false,
                "default" => new RawSql("CURRENT_TIMESTAMP"),
            ],
            "updated_at" => [
                "type" => "DATETIME",
                "null" => true,
                "default" => new RawSql("NULL ON UPDATE CURRENT_TIMESTAMP"),
            ],
            "deleted_at" => [
                "type" => "DATETIME",
                "null" => true
            ]
        ])
        ->addPrimaryKey("id")
        ->addForeignKey("person", "persons", "id", "CASCADE", "RESTRICT")
        ->createTable("doctors", true, ["ENGINE" => "InnoDB"]);
    }

    public function down()
    {
        $this->forge->dropTable("doctors");
    }
}
