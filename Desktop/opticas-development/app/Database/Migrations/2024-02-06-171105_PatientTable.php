<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class   PatientTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id" => [
                "type" => "INT",
                "constraint" => 11,
                "auto_increment" => true,
                "unsigned" => true
            ],
            "person"=>[
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "null"=> true
            ],
            "user"=>[
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "null"=> true
            ],
            "company"=>[
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "null"=> true
            ],
            "original_id"=>[
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "null"=> true
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
        ])->addPrimaryKey("id")
            ->addForeignKey("person","persons","id")
            ->addForeignKey("user","users","id")
            ->createTable("patients",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        //
    }
}
