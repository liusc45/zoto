<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HalfLenseSaleItem extends Migration
{
    public function up()
    {
        $this->forge->addColumn('sale_items', [
            "lens_side" =>[
                "type"=>"ENUM('left','right','pair')",
                "null"=>false,
                "default"=>"pair",
                "after"=>"item"
            ],
            "is_partial"=>[
                "type" => "BOOLEAN",
                "default" => false,
                "after"=>"lens_side"
            ],
            "base_unit_price" =>[
                "type" => "DECIMAL",
                "constraint"=> "10,2",
                "default"=> "0.00"
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('sale_items', ['lens_side','is_partial','base_unit_price']);
    }
}
