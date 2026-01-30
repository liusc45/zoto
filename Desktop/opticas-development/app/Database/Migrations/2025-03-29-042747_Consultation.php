<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Consultation extends Migration
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
            "patient"=>[
                "type"=>"int",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "sale"=>[
                "type"=>"int",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "attended_by"=>[
                "type"=>"int",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "comments"=>[
                "type"=>"TEXT",
                "null"=>true,
            ],
         
            "created_at"=>[
                "type"=>"DATETIME",
                "default"=>new RawSql("CURRENT_TIMESTAMP"),
            ],
            "updated_at"=>[
                "type"=>"DATETIME",
                "null"=>true,
                "default"=>  new RawSql("NULL ON UPDATE CURRENT_TIMESTAMP"),
            ],
            "deleted_at"=>[
                "type"=>"DATETIME",
                "null"=>true,
            ]

        ])->addPrimaryKey("id")
            ->addForeignKey("patient","patients","id","CASCADE")
            ->addForeignKey("attended_by","doctors","id","CASCADE")
            ->createTable("consultations",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        $this->forge->dropTable("consultations");
    }
}
