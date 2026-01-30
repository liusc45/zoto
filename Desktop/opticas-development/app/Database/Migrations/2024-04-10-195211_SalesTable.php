<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class SalesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id" => [
                "type"=>"int",
                "constraint",11,
                "auto_increment"=>true,
                "unsigned"=>true,
            ],
            "uuid"=>[
                "type"=> "varchar",
                "constraint"=> 36
            ],

            "store"=>[
                "type"=>"int",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "patient"=>[
                "type"=>"int",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "items"=>[
                "type"=>"int",
                "constraint"=>6
            ],
            "type"=>[
                "type"=>"ENUM",
                "constraint"=>["cash","aside","credit"]
            ],
            "payment_type"=>[
                "type"=> "ENUM",
                "constraint"=>['cash','card','transfer','credit'],
                "default"=>'cash'
            ],

            "aut"=>[
                "type"=>"VARCHAR",
                "constraint"=>"100",
                "null"=>true,
            ],
            "delivery"=>[
              "type"=>"enum",
              "constraint"=>['store','pending','delivered'],
              "default"=>'pending'
            ],

            "amount" =>[
                "type"=>"decimal",
                "constraint"=>"10,2",

            ],
            "comments"=>[
                "type"=>"varchar",
                "constraint"=>250,
                "null"=>true
            ],
            "document"=>[
                "type"  => "varchar",
                "constraint"=>250,
                "null"=>true
            ],
            "created_by"=>[
                "type"=>"int",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "created_at"=>[
                "type" =>"DATETIME",
                "default"=>new RawSql("CURRENT_TIMESTAMP")
            ],
            "updated_at"=>[
                "type" =>"DATETIME",
                "null"=>true,
                "default"=>new RawSql("NULL ON UPDATE CURRENT_TIMESTAMP")
            ],
            "deleted_at"=>[
                "type" =>"DATETIME",
                "null"=>true
            ]

        ])
            ->addPrimaryKey("id")
            ->addForeignKey("store","stores","id","CASCADE","SET NULL")
            ->addForeignKey("patient","patients","id","CASCADE","SET NULL")
            ->addForeignKey("created_by","users","id","CASCADE","SET NULL")
            ->createTable("sales",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        $this->forge->dropTable("sales");
    }
}
