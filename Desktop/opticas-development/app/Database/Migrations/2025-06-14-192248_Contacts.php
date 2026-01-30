<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Contacts extends Migration
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
            "item"=>[
                "type"=>"int",
                "constraint"=>11,
                "null"=>true,
                "unsigned"=>true,
            ],
            "design" => [
                "type"=>"int",
                "constraint"=>11,
                "null"=>true,
                "unsigned"=>true,
            ],

            "wear" => [
                "type"=>"int",
                "constraint"=>11,
                "null"=>true,
                "unsigned"=>true,

            ],
            "units_per_package" => [
                "type"=>"int",
                "constraint"=>2,
                "null"=>true,
                "unsigned"=>true,
                "default"=>1,
            ],
            "color" => [
                "type"=>"int",
                "constraint"=>11,
                "null"=>true,
                "unsigned"=>true,
            ],
            "replace_unit" => [
                "type"=>"int",
                "constraint"=>11,
                "null"=>true,
                "unsigned"=>true,
            ],
            "replace_time" => [
                "type"=>"enum",
                "constraint"=>["days","weeks","months","years"],
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
            ->addForeignKey("item","items","id","CASCADE","SET NULL")
            ->addForeignKey("design","contact_designs","id","CASCADE","SET NULL")
            ->addForeignKey("wear","contact_wears","id","CASCADE","SET NULL")
            ->addForeignKey("color","contact_colors","id","CASCADE","SET NULL")
            ->createTable("contacts",true,["Engine"=>"InnoDB"]);
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable("contacts");
        $this->db->enableForeignKeyChecks();
    }
}
