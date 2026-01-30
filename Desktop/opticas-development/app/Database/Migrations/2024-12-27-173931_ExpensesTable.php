<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class ExpensesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"=> [
                "type"=>"INT",
                "constraint"=>11,
                "auto_increment"=> true ,
                "unsigned"=> true
            ],
            "concept"=>[
                "type"=>"VARCHAR",
                "constraint"=>300
            ],
            "amount"=>[
                "type"=>"decimal",
                "constraint"=>"7,2",
            ],

            "responsible"=>[
                "type"=>"int",
                "constraint"=>"11",
                "null"=>true,
                "unsigned"=> true
            ],
            "category"=>[
                "type"=>"INT",
                "constraint"=>11
            ],
            "created_by"=>[
                "type"=>"INT",
                "constraint"=>11
            ],
            "comments"=>[
                "type"=>"varchar",
                "constraint"=>500,
                "null"=>true,
            ],
            "applied"=>[
                "type"=>"datetime",
                "null"=>true,
            ],
            "reconciled"=>[
                "type"=>"datetime",
                "null"=>true,
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
        ]);
        $this->forge->addPrimaryKey("id")
            ->addForeignKey("category","expenses_category","id","CASCADE","CASCADE")
            ->addForeignKey("responsible","users","id","CASCADE");
        $this->forge->createTable("expenses",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        $this->forge->dropTable("expenses");
    }
}
