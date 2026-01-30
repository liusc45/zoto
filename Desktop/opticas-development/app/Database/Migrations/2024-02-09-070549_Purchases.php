<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Purchases extends Migration
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
            "supplier"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "store"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "bill"=>[
                "type"=>"varchar",
                "constraint"=>36,
            ],
            "discount"=>
            [
                "type"=>"decimal",
                "constraint"=>"10,2",
                "null"=>true,
            ],
            "amount"=>[
                "type"=>"decimal",
                "constraint"=>"10,2",
                "null"=>true,
            ],

            "created_by"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "purchased_at"=>[
                "type"=>"date",
                "null"=>true,
            ],
            "created_at"=>[
                "type"=>"datetime",
                "default"=> new RawSql("CURRENT_TIMESTAMP"),
            ],
            "updated_at"=>[
                "type"=>"datetime",
                "null"=>true,
                "default"=> new RawSql("NULL ON UPDATE CURRENT_TIMESTAMP"),
            ],
            "deleted_at"=>[
                "type"=>"datetime",
                "null"=>true,
            ],
        ])
            ->addPrimaryKey("id")
            ->addForeignKey("supplier","suppliers","id","CASCADE","SET NULL")
            ->addForeignKey("store","stores","id","CASCADE","SET NULL")
            ->addForeignKey("created_by","users","id","CASCADE","SET NULL")
            ->createTable("purchases",true,["ENGINE"=>"InnoDB"]);

    }

    public function down()
    {
        $this->forge->dropTable("purchases");
    }
}
