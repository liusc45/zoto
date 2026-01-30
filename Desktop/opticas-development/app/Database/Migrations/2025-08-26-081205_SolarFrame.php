<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class SolarFrame extends Migration
{
    public function up()
    {
        $properties = [
            "id"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "auto_increment"=>true,
            ],
            "name"=>[
                "type"=>"VARCHAR",
                "constraint"=>50,
                "null"=>true,
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
                "null"=>true,
            ]
        ];

//        MATERIAL LENTE
        $this->forge->addField($properties)
            ->addPrimaryKey("id")
            ->createTable("solar_lens_materials",true,["ENGINE"=>"InnoDB"]);

        //PROPIEDAD LENTE
        $this->forge->addField($properties)
            ->addPrimaryKey("id")
            ->createTable("solar_lens_properties",true,["ENGINE"=>"InnoDB"]);

        //TRATAMIENTO
        $this->forge->addField($properties)
            ->addPrimaryKey("id")
            ->createTable("solar_lens_treatments",true,["ENGINE"=>"InnoDB"]);
        //COLOR TRATAMIENTO
        $this->forge->addField($properties)
            ->addPrimaryKey("id")
            ->createTable("solar_lens_treatment_colors",true,["ENGINE"=>"InnoDB"]);
        //COLOR degradado
        $this->forge->addField($properties)
            ->addPrimaryKey("id")
            ->createTable("solar_lens_fade",true,["ENGINE"=>"InnoDB"]);
        //COLOR LENTE
        $this->forge->addField($properties)
            ->addPrimaryKey("id")
            ->createTable("solar_lens_colors",true,["ENGINE"=>"InnoDB"]);


        $this->forge->addField([
            "id"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "auto_increment"=>true
            ],
            "item"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "frame" => [
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "material" =>[
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "null"=>true,
            ],
            "property" => [
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "null"=>true,
            ],
            "treatment" => [
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "null"=>true,
            ],
            "treatment_color"=>[
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "null"=>true,
            ],
            "lens_fade"=>[
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "null"=>true,
            ],
            "lens_color"=>[
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "null"=>true,
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
            ->addForeignKey("item","items","id")
            ->addForeignKey("frame","frames","id")
            ->addForeignKey("material","solar_lens_materials","id")
            ->addForeignKey("property","solar_lens_properties","id")
            ->addForeignKey("treatment","solar_lens_treatments","id")
            ->addForeignKey("treatment_color","solar_lens_treatment_colors","id")
            ->addForeignKey("lens_fade","solar_lens_fade","id")
            ->addForeignKey("lens_color","solar_lens_colors","id")
            ->createTable("solar_frames",true,["ENGINE"=>"InnoDB"]);
    }


    public function down()
    {
        $this->forge->dropTable("solar_lens_materials");
        $this->forge->dropTable("solar_lens_properties");
        $this->forge->dropTable("solar_lens_treatments");
        $this->forge->dropTable("solar_lens_treatment_colors");
        $this->forge->dropTable("solar_lens_fade");
        $this->forge->dropTable("solar_lens_colors");

        $this->forge->dropTable("solar_frames");

    }
}
