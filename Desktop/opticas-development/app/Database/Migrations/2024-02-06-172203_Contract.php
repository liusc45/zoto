<?php


use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Contract extends Migration
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
            "company"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "created_at"=>[
                "type"=>"DATETIME",
                "default"=>new RawSql("CURRENT_TIMESTAMP")
            ],
            "updated_at"=>[
                "type"=>"datetime",
                "null"=>true
            ],
            "deleted_at"=>[
                "type"=>"datetime",
                "null"=>true
            ]
        ])->addPrimaryKey("id")
            ->addForeignKey("company","companies","id","CASCADE","SET NULL")
            ->createTable("contracts",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        $this->forge->dropTable("contracts");
    }
}
