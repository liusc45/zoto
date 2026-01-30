<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Discount extends Migration
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
            "sale"=>[
                "type"=>"int",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "concept"=>[
                "type"=>"varchar",
                "constraint"=>50,
                "null"=>true,
            ],
            "percentage"=>[
                "type"=>"int",
                "constraint"=>11,
            ],
            "amount"=>[
                "type"=>"decimal",
                "constraint"=>"10,2",

            ],
            "created_at"=>[
                "type"=>"datetime",
                "default"=>new RawSql("CURRENT_TIMESTAMP")
            ],
            "updated_at"=>[
                "type"=>"datetime",
                "null"=>true,
                "default"=>new RawSql("NULL ON UPDATE CURRENT_TIMESTAMP")
            ],
            "deleted_at"=>[
                "type"=>"datetime",
                "null"=>true,
            ]
        ])->addPrimaryKey("id")
            ->addForeignKey("sale","sales","id","CASCADE")
            ->createTable("discounts",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        $this->forge->dropTable("discounts");
    }
}
