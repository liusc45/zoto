<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Doctors extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"=>[
                "type"=>"int",
                "constraint"=>11,
                "unsigned"=>true,
                "auto_increment"=>true,
            ],
            "person"=>[
                "type"=>"int",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "created_at"=>[
                "type"=>"datetime",
                "default"=>new RawSql("CURRENT_TIMESTAMP"),
                
            ],
            "updated_at"=>[
                "type"=>"datetime",
                "default"=>new RawSql("NULL ON UPDATE CURRENT_TIMESTAMP"),
                "null"=>true,
            ],
            "deleted_at"=>[
                "type"=>"datetime",
                "null"=>true,
            ]
            
        ])->addPrimaryKey("id")
            ->addForeignKey("person","persons","id")
            ->createTable("doctors",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        $this->forge->dropTable("doctors");
    }
}
