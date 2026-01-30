<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class StoreTable extends Migration
{
    public function up()
    {
        $this->forge
            ->addField([
                "id"=>[
                    "type"=>"INT",
                    "constraint"=>11,
                    "auto_increment"=>true,
                    "unsigned"=>true,
                ],
                "name"=>[
                    "type"=>"varchar",
                    "constraint"=>50,

                ],
                "address"=>[
                    "type"=>"varchar",
                    "constraint"=>250,
                    "null"=>true
                ],
                "phone"=>[
                    "type"=>"varchar",
                    "constraint"=>15,
                    "null"=>true
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
            ])
            ->addPrimaryKey("id")
            ->createTable("stores",true,["ENGINE"=>"InnoDB"]);
        $this->db->table("stores")->insert([
            "name"=>"tienda 1 "
        ]);
    }

    public function down()
    {
        $this->forge->dropTable("stores");
    }
}
