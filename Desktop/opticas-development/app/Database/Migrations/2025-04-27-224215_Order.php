<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Order extends Migration
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
            "sale"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
                ],
            "lab"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
            ],
            "patient"=>[
                "type"=>"INT",
                "constraint"=>11,
                "unsigned"=>true,
                "null"=>true,
                "default"=>null
            ],

            "status"=>[
                "type"=>"ENUM",
                "constraint"=>[
                    "pending",
                    "processing",
                    "to_delivery",
                    "delivered",
                    "completed",
                    "warranty",
                ]
            ],
            "lab_sent"=>[
                "type"=>"datetime",
                "null"=>true,
            ],
            "lab_received"=>[
                "type"=>"datetime",
                "null"=>true,
            ],
            "delivered"=>[
                "type"=>"datetime",
                "null"=>true,
            ],
            "panoramic"=>[
                "type"=>"text",
                "null"=>true,
                
            ],
            "pantoscopic" => [
                "type"=>"text",
                "null"=>true,
                
            ],
            "vertex"=>[
                "type"=>"json",
                null=>true,
                "default"=>json_encode(["left"=>0,"right"=>0]),
            ],
            "initials"=>[
                "type"=>"text",
                "null"=>true,
            ],
            "nve"=>[
                "type"=>"text",
                "null"=>true,
                
            ],
            "frame_measures"=>[
                "type"=>"json",
                "null"=>true,
                "default"=>json_encode(["horizontal_diameter"=>0,"vertical_diameter"=>0,"efective"=>0,"bridge"=>0]),
            ],
            "comments"=>[
               "type"=>"text",
               "null"=>true,
            ],
            "created_at"=>[
                "type"=>"datetime",
                "null"=>true,
                "default"=>new RawSql("CURRENT_TIMESTAMP"),
            ],
            "updated_at"=>[
                "type"=>"datetime",
                "null"=>true,
                "default"=>new RawSql("CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"),

            ],
            "deleted_at"=>[
                "type"=>"datetime",
                "null"=>true,
                "default"=>null,
            ]
        ])
            ->addPrimaryKey("id")
            ->addForeignKey("sale","sales","id","CASCADE","set null")
            ->addForeignKey("patient","patients","id","CASCADE","set null")
            ->addForeignKey("lab","labs","id","CASCADE","set null")
            ->createTable("orders",true,["ENGINE"=>"InnoDB"]);
    }

    public function down()
    {
        $this->forge->dropTable("orders");
    }
}
