<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Prescriptions extends Migration
{
    public function up()
    {
        $this->forge->addField([
            "id" => [
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "auto_increment" => true
            ],
            "patient" => [
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "null" => false
            ],
            "consultation" => [
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "null" => false
            ],
            "consultation_date" => [
                "type" => "DATE",
                "null" => true
            ],
            "created_at" => [
                "type" => "DATETIME",
                "default" => new RawSql("CURRENT_TIMESTAMP")
            ],
            "updated_at" => [
                "type" => "DATETIME",
                "null" => true,
                "default" => new RawSql("CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP")
            ],
            "deleted_at" => [
                "type" => "DATETIME",
                "null" => true
            ]
        ]);
        
        $this->forge->addPrimaryKey("id");
        $this->forge->addForeignKey("patient", "patients", "id", "CASCADE", "CASCADE");
        $this->forge->addForeignKey("consultation", "consultations", "id", "CASCADE", "CASCADE");
        
        $this->forge->createTable("prescriptions", true, ["ENGINE" => "InnoDB"]);
        
        
        
        $this->forge->addField([
            "id" => [
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "auto_increment" => true
            ],
            "prescription" => [
                "type" => "INT",
                "constraint" => 11,
                "unsigned" => true,
                "null" => false
            ],
            "eye" => [
                "type" => "ENUM",
                "constraint" => ["right", "left"],
                "null" => false
            ],
            "source" => [
                "type" => "ENUM",
                "constraint" => ["autorefractometer", "total", "final", "subjective"],
                "null" => false
            ],
            "sphere" => [
                "type" => "DECIMAL",
                "constraint" => "5,2",
                "null" => true
            ],
            "cylinder" => [
                "type" => "DECIMAL",
                "constraint" => "5,2",
                "null" => true
            ],
            "axis" => [
                "type" => "DECIMAL",
                "constraint" => "5,2",
                "null" => true
            ],
            "addition" => [
                "type" => "DECIMAL",
                "constraint" => "5,2",
                "null" => true
            ]
        ]);
        
        $this->forge->addPrimaryKey("id");
        $this->forge->addForeignKey("prescription", "prescriptions", "id", "CASCADE", "CASCADE");
        $this->forge->createTable("prescription_details", true, ["ENGINE" => "InnoDB"]);
    }
    
    public function down()
    {
        $this->forge->dropTable("prescriptions");
        $this->forge->dropTable("prescription_details");
    }
    
}
