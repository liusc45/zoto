<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Lenses extends Migration
{
    public function up()
    {
        define("SET_NULL", "SET NULL");
        $this->forge->addField([
            "id"=> [
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "auto_increment" => true,
            ],
            "item"=>[
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "null"=>true,
            ],
            "design"=>[
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "null"=>true,
            ],
            "category_sphere"=>[
                "type"=>"tinyint",
                "constraint"=>2,
                "null"=>true,
                
            ],
            "range_sphere" =>[
                "type"=>"varchar",
                "constraint"=>4,
                "null"=>true,
            ],
            "category_cylinder"=>[
                "type"=>"tinyint",
                "constraint"=>2,
                "null"=>true,
            
            ],
            "range_cylinder"=>[
                "type"=>"varchar",
                "constraint"=>4,
                "null"=>true,
            ],
            "max_graduation" => [
                "type"=>"tinyint",
                "constraint"=>2,
                "null"=>true,
            ],
            "over_processed" => [
                "type"=>"enum",
                "constraint"=>["T","P"],
            ],
            "arrival_days" =>[
                "type"=>"tinyint",
                "constraint"=>2,
            ],
            "frame_type" =>[
                "type"=>"tinyint",
                "constraint"=>2,
                "null"=>true,
            ],
            "optical_correction" =>[
                "type"=>"varchar",
                "constraint"=>25,
                "null"=>true,
            ],
            "material" =>[
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "null"=>true,
            ],
            "type" => [
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "null"=>true,
            ],
            "color" =>[
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "null"=>true,
            ],
            "correction_type" => [
                "type"=>"varchar",
                "constraint"=>4,
                "null"=>true,
            
            ],
            "treatment"  => [
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "null"=>true,
            ],
            "comments" => [
                "type"=>"varchar",
                "constraint"=>512,
                "null"=>true,
            
            ],

            "created_by"=>[
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "null"=>true,
            ],
            "created_at"=>[
                "type" => "DATETIME",
                "default" => new RawSql("CURRENT_TIMESTAMP"),
            ],
            "updated_at"=>[
                "type" => "datetime",
                "null"=>true,
                "default"=> new RawSql("NULL ON UPDATE CURRENT_TIMESTAMP"),
                
            ],
            "deleted_at"=>[
                "type" => "datetime",
                "null"=>true,
            ],
        ])
            ->addprimaryKey("id")
            ->addForeignKey("item","items","id","CASCADE",SET_NULL)
            ->addForeignKey("material","lens_materials","id","CASCADE",SET_NULL)
            ->addForeignKey("type","lens_types","id","CASCADE",SET_NULL)
            ->addForeignKey("color","lens_colors","id","CASCADE",SET_NULL)
            ->addForeignKey("treatment","lens_treatments","id","CASCADE",SET_NULL)
            ->addForeignKey("design","lens_designs","id","CASCADE",SET_NULL)
            ->createTable("lenses",true,["ENGINE"=>"InnoDB","COLLATE"=>"utf8mb4_general_ci","CHARSET"=>"utf8mb4"]);
    }

    public function down(): void
    {
        $this->forge->dropTable("lenses");
    }
}
