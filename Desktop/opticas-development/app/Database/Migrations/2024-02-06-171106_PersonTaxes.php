<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class PersonTaxes extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"=>[
                "type"=>"int",
                "constraint"=>11,
                "auto_increment"=>true,
                "unsigned"=>true
            ],
            "person"=>[
                "type"=>"int",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "rfc" =>[
                "type"=>"varchar",
                "constraint"=>13,
                "null"=>true
            ],
            "curp" =>[
                "type"=>"varchar",
                "constraint"=>18,
                "null"=>true
            ],
            "nickname"=>[
                "type"=>"varchar",
                "constraint"=>255,
                "after"=>"person",
            ],
            "tax_name"=>[
                "type"=>"varchar",
                "constraint"=>100,
                "null"=>true
            ],
            "tax_adress"=>[
                "type"=>"varchar",
                "constraint"=>500,
            ],
            "postal_code"=>[
                "type"=>"varchar",
                "constraint"=>5,
            ],
            "tax_regime"=>[
                "type"=>"enum",
                "constraint"=>["general","federal","municipal","local","special"],
                null=>true
            ],
            "created_at"=>[
                "type"=>"datetime",
                "default"=>new RawSql("CURRENT_TIMESTAMP"),
            ],
            "updated_at"=>[
                "type"=>"datetime",
                "null"=>true,
                "default"=> new RawSql("NULL ON UPDATE CURRENT_TIMESTAMP"),
            ],
            "deleted_at"=>[
                "type"=>"datetime",
                "null"=>true,
            ],
        ])
            ->addPrimaryKey("id")
            ->addForeignKey("person","persons","id","CASCADE","SET NULL")
            ->createTable("person_taxes",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        $this->forge->dropTable("person_taxes");
    }
}
