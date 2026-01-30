<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class EmployeesTable extends Migration
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
            "person"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "user"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "store"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,

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
            ->addForeignKey("person","persons","id")
            ->addForeignKey("user","users","id")
            ->addForeignKey("store","stores","id")
            ->createTable("employees",true,["ENGINE"=>"InnoDB"]);

        $this->db->disableForeignKeyChecks();
        $this->db->table("employees")->insert([
            "person"=>null,
            "user"=>1,
            "store"=>1,
        ]);

        $this->db->enableForeignKeyChecks();

    }


    public function down()
    {
        $this->forge->dropTable("employees");
    }
}
