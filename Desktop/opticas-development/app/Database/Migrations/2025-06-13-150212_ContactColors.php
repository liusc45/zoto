<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;
use CodeIgniter\Entity\Entity;

class ContactColors extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id"=>[
                "type"=>"INT",
                "constraint"=>11,
                "auto_increment"=>true,
                "unsigned"=>true
            ],
            "name"=>[
                "type"=>"VARCHAR",
                "constraint"=>50,
                
            ],
            "created_at"=>[
                "type"=>"DATETIME",
                "default"=>new RawSql("CURRENT_TIMESTAMP")
            ],
            "updated_at"=>[
                "type"=>"datetime",
                "null"=>true,
                "default"=> new RawSql("NULL ON UPDATE CURRENT_TIMESTAMP")
            ],
            "deleted_at"=>[
                "type"=>"datetime",
                "null"=>true,
            ]
        ])->addPrimaryKey("id")
            ->createTable("contact_colors",true,["ENGINE"=>"InnoDB"]);
        $colors = [
            ["name"=>"Sin Color"],
            ["name"=>"Amatista"],
            ["name"=>"Azul"],
            ["name"=>"Azul Brillante"],
            ["name"=>"Café"],
            ["name"=>"Verde Gema"],
            ["name"=>"Gris"],
            ["name"=>"Verde"],
            ["name"=>"Avellana Puro"],
            ["name"=>"miel"],
            ["name"=>"Zafiro Puro"],
            ["name"=>"Gris Esterlina"],
            ["name"=>"Turquesa"],
        ];
        $this->db->table("contact_colors")->insertBatch($colors);
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();
        $this->forge->dropTable("contact_colors");
        $this->db->enableForeignKeyChecks();
    }
}
