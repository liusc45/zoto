<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class OccupationTable extends Migration
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
           "title"=>[
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
            ->createTable("occupations",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        $this->forge->dropTable("occupations");
    }
}
