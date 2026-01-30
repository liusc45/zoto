<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;
use CodeIgniter\Entity\Entity;

class ContactDesigns extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "auto_increment"=>true
            ],
            "name"=>[
                "type"=>"VARCHAR",
                "constraint"=>255,
                "null"=>true,
            ],
            "created_at"=>[
                "type"=>"datetime",
                "default"=> new RawSql( "CURRENT_TIMESTAMP")
            ],
            "updated_at" => [
                "type"       =>  "datetime",
                "null"       =>  true,
                "default"    => new RawSql("NULL ON UPDATE CURRENT_TIMESTAMP")

            ],
            "deleted_at"=> [
                "type"=>"datetime",
                "null"=>true
            ]
        ])->addPrimaryKey("id")

            ->createTable("contact_designs",true,["Engine"=>"InnoDB"]);
        $designs = [
            ["name"=>"Gas Permeable Torico"],
            ["name"=>"Gas Permeable"],
            ["name"=>"Blando"],
            ["name"=>"Optigas Especial Queratocono"],

        ];
        $this->db->table("contact_designs")->insertBatch($designs);
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable("contact_designs");
        $this->db->enableForeignKeyChecks();
    }
}
