<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class ExpensesCategoryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"=>[
                "type" => "INT",
                "constraint"=>11,
                "auto_increment"=>true
            ],
            "name"=>[
                "type"=>"varchar",
                "constraint"=>30,
            ],
            "description"=>[
                "type"=>"varchar",
                "constraint"=>50,
                "null"=>true
            ],
            "created_at"=>[
                "type"=>"DATETIME",
                "default"=>new RawSql("CURRENT_TIMESTAMP")
            ],
            "updated_at"=>[
                "type"=>"datetime",
                "null"=>true,
                "default"=>new RawSql("NULL ON UPDATE CURRENT_TIMESTAMP")
            ],
            "deleted_at"=>[
                "type"=>"datetime",
                "null"=>true
            ]
        ]);
        $this->forge->addPrimaryKey("id");
        $this->forge->createTable("expenses_category",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        //
    }
}
