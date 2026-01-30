<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class PaymentCards extends Migration
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
            "name"=>[
                "type"=>"varchar",
                "constraint"=>50,
            ],
            "commission"=>[
                "type"=>"decimal",
                "constraint"=>"4,2",
            ],
            "active"=>[
                "type"=>"boolean",
                "default"=>true,
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
        ])
            ->addPrimaryKey("id")
            ->createTable("payment_cards",true,["ENGINE"=>"InnoDB","charset"=>"utf8mb4","collate"=>"utf8mb4_unicode_ci"]);




    }

    public function down()
    {
        $this->forge->dropTable("payment_cards");
        //
    }
}
