<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class TableTransfers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"=>[
                "type" =>"INT",
                "constraint"=>11,
                "auto_increment"=>true,
                "unsigned"=>true,
            ],
            "inventory"=>[
                "type" =>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "item"=>[
                "type" =>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "qty"=>[
                "type"=>"INT",
                "constraint"=>11
            ],
            "store_dispatch"=>[
                "type" =>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "store_receive"=>[
                "type" =>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "created_by"=>[
                "type" =>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
                "default"=>0
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
            ->addForeignKey("inventory","inventories","id","CASCADE","SET NULL")
            ->addForeignKey("item","items","id","CASCADE","SET NULL")
            ->addForeignKey("store_dispatch","stores","id","CASCADE","SET NULL")
            ->addForeignKey("store_receive","stores","id","CASCADE","SET NULL")
            ->addForeignKey("created_by","users","id","CASCADE","SET NULL")
            ->createTable("transfers",true,["ENGINE"=>"InnoDB"]);

    }

    public function down()
    {
        $this->forge->dropTable("transfers",true);
    }
}
