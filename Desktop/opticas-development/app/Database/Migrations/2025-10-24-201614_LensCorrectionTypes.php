<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class LensCorrectionTypes extends Migration
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
            "created_at"=>[
                "type"=>"datetime",
                "default"=> new RawSql( "CURRENT_TIMESTAMP")
            ],
            "updated_at" => [
                "type"       =>  "datetime",
                "null"       =>  true,
                "default"    => new RawSql("NULL ON UPDATE CURRENT_TIMESTAMP")

            ],
            "deleted_at"=> [
                "type"=>"datetime",
                "null"=>true
            ]

        ])
            ->addPrimaryKey("id")
            ->createTable("lens_correction_types",true,["ENGINE"=>"InnoDB","charset"=>"utf8mb4",]);
        $corrections = [
            ["name" => "FLAT TOP"],
            ["name" => "BLENDED"],
            ["name" => "REFRACT BLEN"],
            ["name" => "REFRACT DUAL"],
            ["name" => "REFRACT OFFICE"],
            ["name" => "PROGRESIVO GENERICO"],
            ["name" => "REFRACT ANATOMIC DIGITAL"],
            ["name" => "REFRACT CONTRAST DIGITAL"],
            ["name" => "REFRACT SENSORIAL DIGITAL"],
            ["name" => "REFRACT DEFINITION DIGITAL"],
            ["name" => "REFRACT PERFEC DIGITAL"],
            ["name" => "VARILUX CONFORT"],
            ["name" => "VARILUX CONFORT MAX"],
            ["name" => "VARILUX PHYSIO"],
            ["name" => "VARILUX PHYSIO 3.0"],
            ["name" => "VARILUX XR TRACK"],
            ["name" => "KODAK UNIQUE DRO"],
            ["name" => "KODAK EASY 2 PLUS"],
            ["name" => "KODAK EASY PRECISE"]
        ];
        $this->db->table("lens_correction_types")->insertBatch($corrections);
    }

    public function down()
    {
        $this->forge->dropTable("lens_correction_types");
    }
}
