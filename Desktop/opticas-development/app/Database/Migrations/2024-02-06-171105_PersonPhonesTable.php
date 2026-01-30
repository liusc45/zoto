<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class PersonPhonesTable extends Migration
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
            "person"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "number"=>[
                "type"=>"varchar",
                "constraint"=>15,
            ],
            "type"=>[
                "type"=>"varchar",
                "constraint"=>25,
            ],
            "created_at"=>[
                "type" =>"DATETIME",
                "default"=>new RawSql("CURRENT_TIMESTAMP")
            ],
            "updated_at"=>[
                "type" =>"DATETIME",
                "null"=>true
            ],
            "deleted_at"=>[
                "type" =>"DATETIME",
                "null"=>true
            ]
        ])->addPrimaryKey("id")
            ->addForeignKey(
                "person",
                "persons",
                "id",
                "CASCADE",
                "CASCADE")
            ->createTable("person_phones",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        $this->forge->dropTable("person_phones");
    }
}
