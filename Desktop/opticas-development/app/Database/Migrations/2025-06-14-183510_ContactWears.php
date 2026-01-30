<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;
use CodeIgniter\Entity\Entity;

class ContactWears extends Migration
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
            "name" => [
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

            ->createTable("contact_wears",true,["Engine"=>"InnoDB"]);
        $wears = [
            ["name"=>"Diurno"],
            ["name"=>"30 Dias Y 30 Noches"],
            ["name"=>"1 Par Diario"],
            ["name"=>"1 Dia 1 Noche"],
            ["name"=>"Diario"],
        ];
        $this->db->table("contact_wears")->insertBatch($wears);
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable("contact_wears");
        $this->db->enableForeignKeyChecks();
    }
}
