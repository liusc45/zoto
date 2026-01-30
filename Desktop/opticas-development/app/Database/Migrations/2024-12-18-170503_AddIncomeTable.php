<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class AddIncomeTable extends Migration
{
    public function up()
    {
        $this->forge
            ->addField([
                "id"=>[
                    "type"=>"INT",
                    "constraint"=>11,
                    "auto_increment"=>true,
                ],
                "payment"=>[
                    "type"=>"int",
                    "constraint"=>11,
                    "unsigned"=>true,
                    "null"=>false,
                ],
                "amount"=>[
                    "type"=>"decimal",
                    "constraint"=>"10,2",
                    "null"=>false
                ],
                "concept"=>[
                    "type"=>"varchar",
                    "constraint"=>250,
                ],
                "comments"=>[
                    "type"=>"varchar",
                    "constraint"=>500
                ],
                "applied"=>[
                    "type"=>"DATETIME",
                    "null"=>true,
                ],
                "responsible"=>[
                    "type"=>"int",
                    "constraint"=>11,
                    "null"=>true,
                    "unsigned"=>true,
                ],
                "created_by"=>[
                    "type"=>"int",
                    "constraint"=>11,
                    "unsigned"=>true,
                    "null"=>true
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
            ->createTable("incomes", true, ['ENGINE' => 'InnoDB']);
    }

    public function down()
    {
        $this->forge->dropTable("incomes");
    }
}
