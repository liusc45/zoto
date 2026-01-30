<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Frames extends Migration
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

            "item"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "model"=>[
                "type"=>"VARCHAR",
                "constraint"=>255,
                "null"=>true,
            ],
            "solar"=> [
                "type"=>"boolean",
                "default"=>false,
            ],
            "key_color"=>[
                "type"=>"VARCHAR",
                "constraint"=>255,
                "null"=>true,
            ],
            "color"=>[
                "type"=>"int",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "size"=>[
                "type"=>"json",
                "null"=>true,
            ],
            "style"=>[
                "type"=>"ENUM",
                "constraint"=>["full" , "slotted" , "3 pieces"]
            ],
            "gender"=>[
                "type"=>"ENUM",
                "constraint"=>["f" , "m"],
                "default"=>"m"
            ],
            "frame_material"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "rod_material"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "frame_color"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "rod_color"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "published"=>[
                "type"=>"boolean",
                "default"=>false,
                
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
        ]);
        $this->forge->addPrimaryKey("id")
            ->addForeignKey("item","items","id","CASCADE","SET NULL")
            ->addForeignKey("color","colors","id","CASCADE","SET NULL")
            ->addForeignKey("frame_color","frame_colors","id","CASCADE","SET NULL")
            ->addForeignKey("frame_material","frame_materials","id","CASCADE","SET NULL")
            ->addForeignKey("rod_material","frame_materials","id","CASCADE","SET NULL")
            ->addForeignKey("rod_color","frame_colors","id","CASCADE","SET NULL")

            ->createTable("frames",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        //
    }
}
