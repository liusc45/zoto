<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class FrameMaterials extends Migration
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
                "null"=>true,
                "default"=>  new RawSql("NULL ON UPDATE CURRENT_TIMESTAMP"),
            ],
            "deleted_at"=>[
                "type"=>"datetime",
                "null"=>true
            ]
        ])->addPrimaryKey("id")
            ->createTable("frame_materials",true,["ENGINE"=>"InnoDB"]);
        $frontMaterials = [
            ["name"=> "Titanio"],
            ["name"=> "Plástico"],
            ["name"=> "Metal"],
            ["name"=> "Nylon/Propinato"],
            ["name"=> "Acetato"],
            ["name"=> "Pasta"],
        ];
        $this->db->disableForeignKeyChecks();
        $this->db->table("frame_materials")->insertBatch($frontMaterials);
        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        //
    }
}
