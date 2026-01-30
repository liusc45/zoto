<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class SaleItem extends Migration
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
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "patient"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "prescription"=>[
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
            "inventory"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],

            "item"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "qty"=>[
                "type"=>"INT",
            ],
            "sale_price"=>[
                "type"=>"DECIMAL",
                "constraint"=>"10,2",
            ],
            "unit_price"=>[
                "type"=>"DECIMAL",
                "constraint"=>"10,2",
            ],
            "final_price"=>[
                "type"=>"DECIMAL",
                "constraint"=>"10,2",
            ],
            "created_at"=>[
                "type"=>"DATETIME",
                "default"=>new RawSql("CURRENT_TIMESTAMP"),

            ],
            "updated_at"=>[
                "type"=>"DATETIME",
                "default"=>new RawSql("NULL ON UPDATE CURRENT_TIMESTAMP"),
                "null"=>true,
            ],
            "deleted_at"=>[
                "type"=>"DATETIME",
                "null"=>true,
            ]
        ])->addPrimaryKey("id")

            ->addForeignKey("sale","sales","id","CASCADE","SET NULL")
            ->addForeignKey("patient","patients","id","CASCADE","SET NULL")
            ->addForeignKey("prescription","prescriptions","id","CASCADE","SET NULL")
            ->addForeignKey("item","items","id","CASCADE","SET NULL")
            ->addForeignKey("inventory","inventories","id","CASCADE","SET NULL")
            ->createTable("sale_items",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        $this->forge->dropTable("sale_items");
    }
}
