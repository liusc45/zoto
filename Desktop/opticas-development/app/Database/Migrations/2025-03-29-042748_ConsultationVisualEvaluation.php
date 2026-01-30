<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ConsultationVisualEvaluation extends Migration
{
    // Migration: CreateConsultationVisualEvaluation
    public function up()
    {
        $this->forge->addField([
            'id'                 => [
                'type' => 'INT',
                "constraint"=>11,
                'auto_increment' => true,
                'unsigned' => true
            ],
            'consultation'    => [
                'type' => 'INT',
                "constraint"=>11,
                'unsigned' => true,
                "null"=>true
            ],
            'oftalmoscopy' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'right_wafer_height' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'left_wafer_height'  => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'anomalies_image' => [
                'type' => 'BLOB',
                'null' => true
            ],

            "anterior_segment"=>["type"=>"TEXT","null"=>true],
            "oftalmoscopy"=>["type"=>"TEXT","null"=>true],
            "others"=>["type"=>"TEXT","null"=>true],
            "cover_test" =>[
                "type" => 'ENUM',
                "null" => true,
                "constraint"=>[
                    "Ortoforia",
                    "Exoforia",
                    "Exotropia",
                    "Endorforia",
                    "Endotropia",
                    "Hipertopria",
                    "Hipotropia",
                    "Cicloforia"
                ]
            ],
            "posterior_segment"=>[
                "type" => 'text',
                "null"=>true
            ],
            "chromatic_vision"=>[
                "type" => 'ENUM',
                "null" => true,
                "constraint"=>[
                    "normal","red","green","blue"
                ]
            ],
            "ease_accommodation"=>[
                "type" => 'INT',
                "null" => true,
                "unsigned" => true,
                "constraint"=>11,
            ],
            "brock_string" =>[
                "type" => 'ENUM',
                "null" => true,
                "constraint"=>[
                    "x","exo","endo"
                ]
            ],
            "stereotest"=>[
               "type"=>"text",
               "null"=>true,

            ],
            "worth_bridge"=>[
                "type" => 'ENUM',
                "null" => true,
                "constraint"=>[
                    "fusion",
                    "right",
                    "left"
                ]
            ],
            "convergence_break"=>[
                "type" => 'int',
                "constraint"=>11,
                "null"=>true,
                "unsigned"=>true,
            ],
            "convergence_recover"=>[
                "type" => 'int',
                "constraint"=>11,
                "null"=>true,
                "unsigned"=>true,
            ],
            "amsler_grid"=>[
                'type' => 'TEXT',
                'null' => true
            ],
            'left_acuity_before' => [
                'type' => 'text',
                'null' => true
            ],
            'right_acuity_before' => [
                'type' => 'text',
                'null' => true
            ],
            'left_acuity_after' => [
                'type' => 'text',
                'null' => true
            ],
            'right_acuity_after' => [
                'type' => 'text',
                'null' => true
            ],

            'left_capacity' => [
                'type' => 'text',
                'null' => true
            ],
            'right_capacity' => [
                'type' => 'text',
                'null' => true
            ],
            'acuity_ocular' => [
                'type' => 'text',
                'null' => true
            ],
            "interpupilar_distance"=>[
                "type" => 'varchar',
                "null" => true,
                "constraint"=>255
            ],
            'refractometer_right_sphere' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true
            ],
            'refractometer_right_cylinder' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true
            ],
            'refractometer_right_axis' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'refractometer_right_addition' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true
            ],
            'refractometer_left_sphere' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true
            ],
            'refractometer_left_cylinder' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true
            ],
            'refractometer_left_axis' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true
            ],
            'refractometer_left_addition' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true
            ],
            'comments'      => [
                'type' => 'TEXT',
                'null' => true
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('consultation', 'consultations', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('consultation_visual_evaluation');
    }

    public function down()
    {
        $this->forge->dropTable('consultation_visual_evaluation');
    }
}
