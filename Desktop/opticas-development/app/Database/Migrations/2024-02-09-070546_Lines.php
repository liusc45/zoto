<?php

namespace App\Database\Migrations;

use App\Models\LineModel;
use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Lines extends Migration
{
    public function up()
    {
        //lines
        $this->forge->addField([
            "id" =>[
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "auto_increment" => true
            ],
            "name"=>[
                "type"=>"VARCHAR",
                "constraint"=>255,
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
            ->createTable("lines",true,["ENGINE"=>"InnoDB"]);

        $lines = [
            ["name"=>"Armazon Oftalmico"],
            ["name"=>"Armazon Solar"],
            ["name"=>"Lente de Contacto"],
            ["name"=>"Portalentes"],
            ["name"=>"Gotas"],
            ["name"=>"Soluciones"],
            ["name"=>"Micas"],
            ["name"=>"Paños"],
            ["name"=>"Plaquetas"],
            ["name"=>"Puentes"],
            ["name"=>"Accesorios"],
            ["name"=>"Varillas"]
        ];


        model(LineModel::class)->insertBatch($lines);
    }

    public function down()
    {
        $this->forge->dropTable("lines");

    }
}
