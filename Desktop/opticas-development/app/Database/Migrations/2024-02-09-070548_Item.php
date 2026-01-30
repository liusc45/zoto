<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Item extends Migration
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
            "key"=>[
                "type"=>"VARCHAR",
                "constraint"=>255,
                "null"=>true,
            ],
            "barcode"=>[
                "type"=>"VARCHAR",
                "constraint"=>255,
                "null"=>true,
            ],
            "name"=>[
                "type"=>"varchar",
                "constraint"=>150 ,
                "null"=>false,
            ],
            "cost"=> [
                "type"=>"decimal",
                "constraint"=>"10,2",
                "null"=>true,
            ],
            "supplier"=>[
               "type"=>"int",
                "constraint"=>11,
                "null"=>true,
                "unsigned"=>true,
            ],
            "line"=>[
               "type"=>"int",
                "constraint"=>11,
                "null"=>true,
                "unsigned"=>true,
            ],
            "brand" =>[
                "type"=>"int",
                "constraint"=>11,
                "null"=>true,
                "unsigned"=>true,
            ],
            "color_key" => [
                "type"=>"varchar",
                "constraint"=>10,
                "null"=>true,
            ],
            "color" => [
                "type"=>"int",
                "constraint"=>11,
                "null"=>true,
                "unsigned"=>true,
            ],
            "model" => [
                "type"=>"varchar",
                "constraint"=>10,
                "null"=>true,
            ],
            "size" => [
                "type"=>"int",
                "constraint"=>11,
                "null"=>true,
            ],

            "stockable"=>[
              "type"=>"BOOLEAN",
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
        ]);
        $this->forge->addPrimaryKey("id")
            ->addForeignKey("supplier","suppliers","id","CASCADE","SET NULL")
            ->addForeignKey("line","lines","id","CASCADE","SET NULL")
            ->addForeignKey("brand","brands","id","CASCADE","SET NULL")
            ->addForeignKey("color","colors","id","CASCADE","SET NULL")
            ->createTable("items",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        $this->forge->dropTable("items",true);
    }
}
