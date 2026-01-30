<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Person extends Migration
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
                "type" => "varchar",
                "constraint"=>"50",
                "null"=>true,
            ],
            "last_name"=>[
                "type"=>"varchar",
                "constraint"=>"50",
                "null"=>true,

            ],
            "dob"=>[
                "type"=>"date",
                "null"=>true,
            ],
            "main_phone"=>[
                "type"=>"varchar",
                "constraint"=>"15",
                "null"=>true,
            ],
            "email"=>[
                "type"=>"varchar",
                "constraint"=>"50",
                "null"=>true,
            ],
            "street"=>[
                "type"=>"varchar",
                "constraint"=>"50",
                "null"=>true,
            ],
            "city" => [
                "type" => "varchar",
                "constraint" => "50",
                "null"=>true,
            ],
            "state" => [
                "type" => "varchar",
                "constraint" => "50",
                "null"=>true,

            ],
            "postal_code" => [
                "type" => "varchar",
                "constraint" => "6",
                "null"=>true,
            ],
            "occupation"=>[
                "type"=>"INT",
                "constraint"=>11,
                "null"=>true,
                "unsigned"=>true,
            ],

            "created_at"=>[
                "type" =>"DATETIME",
                "default"=>new RawSql("CURRENT_TIMESTAMP")
            ],
            "updated_at"=>[
                "type" =>"DATETIME",
                "null"=>true
            ],
            "deleted_at"=>[
                "type" =>"DATETIME",
                "null"=>true
            ]
        ])->addPrimaryKey("id")
            ->addForeignKey(
                "occupation",
                "occupations",
                "id",
                "CASCADE",
                "SET NULL")
            ->createTable("persons",true,["ENGINE"=>"InnoDB"]);
        $this->db->disableForeignKeyChecks();
        $this->db->table("persons")->insert([
           "name"=>"Admin",
        ]);
    }

    public function down()
    {
        $this->forge->dropTable("persons");
    }
}
