<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class TableInventory extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"=>[
                "type"=>"INT",
                "constraint"=>11,
                "auto_increment"=>true,
                "unsigned"=>true,
            ],
            "code"=>[
                "type"=>"varchar",
                "constraint"=>"50",
            ],
            "item"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "cost"=>[
                "type"=>"decimal",
                "constraint"=>"10,2",
                "null"=>true,
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
            "stock"=>[
                "type"=>"INT",
                "constraint"=>11,
            ],
            "purchase"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "bill"=>[
                "type"=>"varchar",
                "constraint"=>36,
            ],
            "enter_at"=>[
                "type"=>"DATETIME",
                "default"=>new RawSql("CURRENT_TIMESTAMP")
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
            
        ])->addPrimaryKey("id")
            ->addForeignKey("item","items","id","CASCADE","SET NULL")
            ->addForeignKey("supplier","suppliers","id","CASCADE","SET NULL")
            ->addForeignKey("store","stores","id","CASCADE","SET NULL")
            ->addForeignKey("purchase","purchases","id","CASCADE","SET NULL")
            ->createTable("inventories",true,["ENGINE"=>"InnoDB","charset"=>"utf8mb4","collate"=>"utf8mb4_unicode_ci"]);
    }

    public function down()
    {
        $this->forge->dropTable("inventories");
    }
}
