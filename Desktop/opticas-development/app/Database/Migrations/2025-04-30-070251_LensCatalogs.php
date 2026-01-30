<?php

namespace App\Database\Migrations;

use App\Entities\LensMaterial;
use App\Entities\Treatment;
use App\Models\AdditionalTreatmentModel;
use App\Models\LensMaterialModel;
use App\Models\TreatmentModel;
use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;
use CodeIgniter\Entity\Entity;

class LensCatalogs extends Migration
{
    public function up()
    {
        $fields = [
            "id"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "auto_increment"=>true
            ],
            "name" =>[
                "type"=>"VARCHAR",
                "constraint"=>255,
            ],
            "created_by"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                null=>true,
            ],
            "created_at"=>[
                "type"=>"datetime",
                "default"=>new RawSql("CURRENT_TIMESTAMP"),
                "null"=>true
            ],
            "updated_at"=>[
                "type"=>"datetime",
                "null"=>true
            ],
            "deleted_at"=>[
                "type"=>"datetime",
                "null"=>true
            ]
        
        ];
        
        
        //treatment
        $this->forge->addField($fields)->addPrimaryKey("id")
            ->addForeignKey("created_by","users","id")
            ->createTable("lens_treatments",true,["ENGINE"=>"InnoDB"]);
        
        $treatments = [
            ["name"=> "Sin Ar", "created_by"=>1],
            ["name"=> "Ar Generico", "created_by"=>1],
            ["name"=> "Star Premium Plus", "created_by"=>1],
            ["name"=> "Star Blue Pro", "created_by"=>1],
            ["name"=> "No Aplica", "created_by"=>1],
            ["name"=> "Crizal Sapphire", "created_by"=>1],
            ["name"=> "Crizal Prevencia", "created_by"=>1],
            ["name"=> "Ain Ar", "created_by"=>1],
            ["name"=> "Light Scan", "created_by"=>1],
            ["name"=> "Optikot", "created_by"=>1],
        ];
        $this->db->disableForeignKeyChecks();
        $this->db->table("lens_treatments")->insertBatch($treatments);
        $this->db->enableForeignKeyChecks();
        
        //designs
        $this->forge->addField($fields)->addPrimaryKey("id")
            ->createTable("lens_designs",true,["ENGINE"=>"InnoDB"]);
        
        $designs = [
            ["name"=>"incoloro"],
            ["name"=>"blue cut filtro azul"],
            ["name"=>"ar genérico"],
            ["name"=>"foto genérico"],
            ["name"=>"Fotocromático ar genérico"],
            ["name"=>"mica foto filtro azul con ar"],
            ["name"=>"Xperio polarizado gris/ café/verde"],
            ["name"=>"xperio polarizado mirror"],
            ["name"=>"Xperio polarizado digital"],
            ["name"=>"polarizado nupolar desvanecido tallado tradicional"],
            ["name"=>"ar crizal sapphire"],
            ["name"=>"ar crizal prevencia"],
            ["name"=>"transitions gen-s"],
            ["name"=>"transitions mirror"],
            ["name"=>"eyezen fit antireflejante con iniciales con add"],
            ["name"=>"eyezen + ar + transitions"],
            ["name"=>  "Fotocromatico Generico"],
            ["name"=>  "Fotocromatico Filtro Azul Con Ar"],
            ["name"=>  "Xperio Polarizado Gris / Café / Verde"],
            ["name"=>  "Crizal Sapphire"],
            ["name"=>  "Crizal Prevencia"],
            ["name"=>  "Eyezen Fit Ar Lightscan"],
            ["name"=>  "Varilux Xtrack"],
            ["name"=>  "Varilux Physio 3.0"],
            ["name"=>  "Varilux Confort"],
            ["name"=>  "Kodak Unique Dro"],
            ["name"=>  "Kodak Easy 2 Plus"],
            ["name"=>  "Kpdak Easy Precise"],
            ["name"=>  "Refract Definition Digital"],
            ["name"=>  "Refract Sensorial Digital"],
            ["name"=>  "Refract Contrast Digital"],
            ["name"=>  "Refract Anatomic Digital"],

        ];
        $this->db->table("lens_designs")->insertBatch($designs);
        
        //types
        $this->forge->addField($fields)->addPrimaryKey("id")
            ->createTable("lens_types",true,["ENGINE"=>"InnoDB"]);
        $types = [
            ["name"=>"Blanco"],
            ["name"=>"Fotocromatico"],
            ["name"=>"Nupolar Xperio"],
            ["name"=>"Nupolar Xperio Mirror"],
            ["name"=>"Nupolar Xperio Digital"],
            ["name"=>"Transitions Gen-S"],
            ["name"=>"Transitions Mirror"],
        ];
        $this->db->table("lens_types")->insertBatch($types);
        
        //materials
        $this->forge->addField($fields)->addPrimaryKey("id")
            ->createTable("lens_materials",true,["ENGINE"=>"InnoDB"]);
        
        
        $lensMaterials = [
            ["name" => "Cr-39"],
            ["name" => "Policarbonato"],
            ["name" => "Policarbonato Hd"],
            ["name" => "Thindex Ultra"],
            ["name" => "Policarbonato Blue Cut"],
            ["name" => "High Index Blue Cut"],
            ["name" => "Cr-39 Filtro Azul"],
            ["name" => "Policarbonato Filtro Azul"],
            ["name" => "High Index"],
            ["name" => "Cr-39 Eyezen Fit"],
            ["name" => "Policarbonato Eyezen Fit"],

        ];
        model(LensMaterialModel::class)->insertBatch($lensMaterials);
        
        $this->forge->addField($fields)
            ->addPrimaryKey("id")
            ->createTable("lens_colors",true,["ENGINE"=>"InnoDB"]);
        $colors = [
           ["name"=> "Blanco"],
           ["name"=> "Gris"],
           ["name"=> "Gris Uniforme"],
           ["name"=> "Café Uniforme"],
           ["name"=> "Verde Uniforme"],
           ["name"=> "Gris Desvanecido"],
           ["name"=> "Café Desvanecido"],
           ["name"=> "Verde Desvanecido"],
           ["name"=> "Azul Uniforme"],
           ["name"=> "Plata Uniforme"],
           ["name"=> "Morado-Verde Uniforme"],
           ["name"=> "Rosa Uniforme"],
           ["name"=> "Azul En Base Gris Uniforme"],
           ["name"=> "Dorado Uniforme"],
           ["name"=> "Rojo En Base Café Uniforme"],
           ["name"=> "Cafe Uniforme"],
           ["name"=> "Café"],
           ["name"=> "Verde"],
           ["name"=> "Rubi"],
           ["name"=> "Indigo"],
           ["name"=> "Ambar"],
           ["name"=> "Amatista"]
        ];
        
        $this->db->table("lens_colors")->insertBatch($colors);
    }

    public function down()
    {
        $this->forge->dropTable("lens_treatments");
        $this->forge->dropTable("lens_designs");
        $this->forge->dropTable("lens_materials");
        $this->forge->dropTable("lens_types");
        $this->forge->dropTable("lens_colors");
    }
}
