<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Color extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id" =>[
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "auto_increment" => true
            ],
            "name"=>[
                "type"=>"VARCHAR",
                "constraint"=>255,
                "null"=>true,
            ],
            "created_at"=>[
                "type"=>"DATETIME",
                "default"=>new RawSql("CURRENT_TIMESTAMP")
            ],
            "updated_at"=>[
                "type"=>"datetime",
                "null"=>true
            ],
            "deleted_at"=>[
                "type"=>"datetime",
                "null"=>true
            ]
        ])->addPrimaryKey("id")
            ->createTable("colors",true,["ENGINE"=>"InnoDB"]);


        $frameColors = [
            ["name" => "Carey"],
            ["name" => "Negro"],
            ["name" => "Gris"],
            ["name" => "Dorado"],
            ["name" => "Café"],
            ["name" => "Plateado"],
            ["name" => "Azul"],
            ["name" => "Verde"],
            ["name" => "Translucido"],
            ["name" => "Rojo"],
            ["name" => "Morado"],

        ];
        $this->db->disableForeignKeyChecks();
        $this->db->table("colors")->insertBatch($frameColors);
        $this->db->enableForeignKeyChecks();

    }

    public function down()
    {
        $this->forge->dropTable("colors");
    }
}
