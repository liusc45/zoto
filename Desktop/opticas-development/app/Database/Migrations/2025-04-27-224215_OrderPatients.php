<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class OrderPatients extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>TRUE,
                "auto_increment"=>TRUE
            ],
            "order"=>[
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
            "sale"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "sale_item" =>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
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
        ])
            ->addPrimaryKey("id")
            ->addForeignKey("order","orders","id","CASCADE","SET NULL")
            ->addForeignKey("patient","patients","id","CASCADE","SET NULL")
            ->addForeignKey("sale","sales","id","CASCADE","SET NULL")
            ->addForeignKey("sale_item","sale_items","id","CASCADE","SET NULL")
            ->createTable("order_patients",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        $this->forge->dropTable("order_patients");
    }
}
