<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class BankComission extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"=>[
                "type"=>"INT",
                "constraint"=>11,
                "auto_increment"=>true,
                "unsigned"=>true
            ],
            "bank"=>[
                "type"=>"varchar",
                "constraint"=>50,
                "null"=>true

            ],
            "payment_method"=>[
                "type"=>"varchar",
                "constraint"=>50,
            ],
            "percentage"=>[
                "type"=>"decimal",
                "constraint"=>"4,2",
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
            ->createTable("bank_commissions",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        $this->forge->dropTable("bank_commissions");
    }
}
