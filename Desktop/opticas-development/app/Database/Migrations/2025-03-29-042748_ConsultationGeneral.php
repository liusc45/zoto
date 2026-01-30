<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ConsultationGeneral extends Migration
{
    // Migration: CreateConsultationGeneral
    public function up()
    {
        $this->forge->addField([
            'id'                        => ['type' => 'INT', "constraint"=>11, 'auto_increment' => true, 'unsigned' => true],
            'consultation'              => ['type' => 'INT',"constraint"=>11,"null"=>true, 'unsigned' => true],
            'healthy'                   => ['type' => 'BOOLEAN', 'default' => true],
            'diabetes'                  => ['type' => 'BOOLEAN', 'null' => true],
            'last_glucose_date'         => ['type' => 'DATE', 'null' => true],
            'glucose_date_number'   => ['type' => 'INT', 'null' => true],
            'glucose_date_unit'     => ['type' => 'ENUM', 'constraint' => ['days','weeks','months','years'], 'null' => true],
            'glucose_level'             => ['type' => 'VARCHAR', 'constraint' => '10', 'null' => true],
            'hypertensive'              => ['type' => 'BOOLEAN', 'null' => true],
            'last_blood_pressure_date'  => ['type' => 'DATE', 'null' => true],
            'blood_date_number'   => ['type' => 'INT', 'null' => true],
            'blood_date_unit'     => ['type' => 'ENUM', 'constraint' => ['days','weeks','months','years'], 'null' => true],
            'blood_pressure_level'      => ['type' => 'VARCHAR', 'constraint' => '10', 'null' => true],
            //'ocular_pathological_history'=> ['type' => 'TEXT', 'null' => true],
            'comments'              => ['type' => 'TEXT', 'null' => true],
            'observations'              => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('consultation', 'consultations', 'id', 'CASCADE');
        $this->forge->createTable('consultation_general_background');
    }

    public function down()
    {
        $this->forge->dropTable('consultation_general_background');
    }
}
