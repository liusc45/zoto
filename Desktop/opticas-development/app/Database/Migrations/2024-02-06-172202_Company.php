<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Company extends Migration
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
            "name"=>[
                "type"=>"VARCHAR",
                "constraint"=>255,
                "null"=>true,

            ],
            "type"=>[
                "type"=>"ENUM",
                "constraint"=>["lab","contract","supplier"]

            ],
            "contact"=>[
                "type"=>"INT",
                "constraint"=>11,
                "null"=>true,
                "unsigned"=>true,
            ],
            "address"=>[
                "type"=>"VARCHAR",
                "constraint"=>255,
                "null"=>true,
            ],
            "phone"=>[
                "type"=>"VARCHAR",
                "constraint"=>15,
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
            ->addForeignKey("contact","persons","id","CASCADE","SET NULL")
            ->createTable("companies",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        $this->forge->dropTable("companies");
    }
}
