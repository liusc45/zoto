<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class TableCredits extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"=>[
                "type"=>"int",
                "constraint"=>11,
                "auto_increment"=>true,
                "unsigned"=>true,
            ],
            "sale"=>[
                "type"=>"int",
                "constraint"=>11,
                "null"=>true,
                "unsigned"=>true
            ],
            "patient"=>[
                "type"=>"int",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "financing"=>[
                "type"=>"decimal",
                "constraint"=>"10,2"
            ],
            "created_by"=>[
                "type" =>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true
            ],
            "paid_at"=>[
                "type" =>"DATETIME",
                "null"=>true
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

        ])->addPrimaryKey("id")
            ->addForeignKey("sale","sales","id","CASCADE","SET NULL")
            ->addForeignKey("patient","patients","id","CASCADE","SET NULL")
            ->addForeignKey("created_by","users","id","CASCADE","SET NULL")
            ->createTable("credits",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        $this->forge->dropTable("credits");
    }
}
