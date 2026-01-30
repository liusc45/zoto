<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Brands extends Migration
{
    public function up()
    {
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
                "null"=>true,
                "default"=>  new RawSql("NULL ON UPDATE CURRENT_TIMESTAMP"),
            ],
            "deleted_at"=>[
                "type"=>"datetime",
                "null"=>true
            ]
        ])->addPrimaryKey("id")
            ->createTable("brands",true,["ENGINE"=>"InnoDB"]);

        $this->db->disableForeignKeyChecks();
        $frameBrands = [["name"=>"Michael Kors"],
            ["name"=>"Vogue"], ["name"=>"Arnette"], ["name"=>"Bvlgari"], ["name"=>"Ray Ban"], ["name"=>"Michell Kors"],
            ["name"=>"Ray-Ban"], ["name"=>"Carrera"], ["name"=>"Versace"], ["name"=>"Tiffany"], ["name"=>"Polo"],
            ["name"=>"Coach"], ["name"=>"Carlo Marioni"], ["name"=>"Calvin Klein"], ["name"=>"Ralph"], ["name"=>"Pinky"],
            ["name"=>"Emporio Armani"], ["name"=>"Caterpillar"], ["name"=>"Marioni"], ["name"=>"Oakley"],
            ["name"=>"Ray Ban Rx"],
            ["name"=>"Likids"],
            ["name"=>"Minai"],
            ["name"=>"Minami"],
            ["name"=>"Nivada"],
            ["name"=>"Metal"],
            ["name"=>"Olivegtm"],
            ["name"=>"Olive"],
            ["name"=>"Live Tornasol"],
            ["name"=>"Aramni Exchange"],
            ["name"=>"Funky Fred"],
            ["name"=>"Unky Fred"],
            ["name"=>"Hugo Boss"],
            ["name"=>"Google"],
            ["name"=>"Tom Berry"],
            ["name"=>"Prince"],
            ["name"=>"Funky"],
            ["name"=>"Pure Titanium"],
            ["name"=>"Owen"],
            ["name"=>"Oda"],
            ["name"=>"Top Moda"],
            ["name"=>"Lacoste"],
            ["name"=>"Ado"],
            ["name"=>"Kipling"],
            ["name"=>"Tommy Jeans"],
            ["name"=>"Tommy Hilfiger"],
            ["name"=>"Tommy Hilfinger"],
            ["name"=>"C Mark"],
            ["name"=>"Marina"],
            ["name"=>"Gemma"],
            ["name"=>"Bivaldi"],
            ["name"=>"Emilia Anne"],
            ["name"=>"Lotus"],
            ["name"=>"Mosson"],
            ["name"=>"Sophia"],
            ["name"=>"Essencial"],
            ["name"=>"St Sport"],
            ["name"=>"Miss Moe"],
            ["name"=>"Vivhy"],
            ["name"=>"Armani Exchange"],
            ["name"=>"Funky Fared"],
            ["name"=>"Just Marioni"],
            ["name"=>"Kind"],
            ["name"=>"Boss"],
            ["name"=>"Prince Kids"],
            ["name"=>"Vx"],
            ["name"=>"Bmec"],
            ["name"=>"Hagnus"],
            ["name"=>"Dotti"],
            ["name"=>"Michelle Kors"],
            ["name"=>"Paris"],
            ["name"=>"Rivalto"],
            ["name"=>"Vichy"],
            ["name"=>"Botox"],
            ["name"=>"Johan"],
            ["name"=>"Sone"],
            ["name"=>"Estefano"]];
        $this->db->table("brands")->insertBatch($frameBrands);

    }

    public function down()
    {
        $this->forge->dropTable("brands");
    }
}
