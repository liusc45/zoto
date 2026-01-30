<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;
use CodeIgniter\Entity\Entity;

class ContactBrands extends Migration
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
                "type"=>"varchar",
                "constraint"=>255,
                "null"=>true,
            ],

            "created_at"=>[
                "type"=>"datetime",
                "default"=> new RawSql( "CURRENT_TIMESTAMP")
            ],
            "updated_at" => [
                "type"=> "datetime",
                "null" => true,
                "default" => new RawSql("NULL ON UPDATE CURRENT_TIMESTAMP")
            ],
            "deleted_at"=> [
                "type"=>"datetime",
                "null"=>true
            ]
        ])
            ->addPrimaryKey("id")
            ->createTable("contact_brands",true,["Engine"=>"InnoDB"]);

        $brands = [
            ["name"=>"Hidrosoft"],
            ["name"=>"Lumilent"],
            ["name"=>"Alcon"],
            ["name"=>"Johnson&Johnson"],
            ["name"=>"Coopervision"],
            ["name"=>"Bca Opticas"],
        ];
        $this->db->table("contact_brands")->insertBatch($brands);

    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable("contact_brands");
        $this->db->enableForeignKeyChecks();
    }
}
