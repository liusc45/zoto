<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Payments extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"=>[
                "type"=>"int",
                "constraint"=>11,
                "unsigned"=>true,
                "auto_increment"=>true,
            ],
            "credit"=>[
                "type"=> "int",
                "constraint"=>11,
                "unsigned"=>true,
                "null" => true,
            ],
            "sale"=>[
                "type"=> "int",
                "constraint"=>11,
                "unsigned"=>true,
                "null" => true,
                "after"=>"credit"
            ],
            "aside"=>[
                "type"=>"TINYINT",
                "constraint"=>1,
                "default"=>0,
            ],
            "payment_type"=>[
                "type"=>"enum",
                "constraint"=>["cash","transfer","card"],
                "default"=>"cash"
            ],
            "terminal"=>[
                "type"=>"varchar",
                "constraint"=>50,
                "default"=>null,
                "null"=>true,
            ],
            "aut"=>[
                "type"=>"varchar",
                "constraint"=>50,
                "default"=>null,
                "null"=>true,
            ],
            "amount"=>[
                "type"=>"decimal",
                "constraint"=>"11,2",
            ],
            "cash"=>[
                "type"=> "decimal",
                "constraint"=>"10,2",
                "unsigned"=>true,
                "null" => true,
            ],
            "cashback"=>[
                "type"=> "decimal",
                "constraint"=>"10,2",
                "unsigned"=>true,
                "null" => true,
            ],

            "created_by"=>[
                "type"=>"int",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "document"=>[
                "type"=>"varchar",
                "constraint"=>250,
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
            ->addForeignKey("sale","sales","id")
            ->addForeignKey("credit","credits","id")
            ->createTable("payments",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        $this->forge->dropTable("payments");
    }
}
