<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ConsultationVisualBackground extends Migration
{
    // Migration: CreateConsultationEyeHealth
    public function up()
    {
        $this->forge->addField([

            'id' => [
                'type' => 'INT',
                "constraint"=>11,
                'auto_increment' => true,
                'unsigned' => true
            ],
            'consultation' => [
                'type' => 'INT',
                "constraint"=>11,
                'unsigned' => true,
                "null"=>true
            ],
            'glasses' => [
                'type' => 'BOOLEAN',
                'null' => true
            ],
            'last_check_date' => [
                'type' => 'DATE',
                'null' => true
            ],

            'fatigue' => [
                'type' => 'BOOLEAN',
                'null' => true
            ],
            'burning' => [
                'type' => 'BOOLEAN',
                'null' => true
            ],
            'itching' => [
                'type' => 'BOOLEAN',
                'null' => true
            ],
            'photophobia' => [
                'type' => 'BOOLEAN',
                'null' => true
            ],
            'redness' => [
                'type' => 'BOOLEAN',
                'null' => true
            ],
            'blurry' => [
                'type' => 'SET',
                'constraint' => ['close', 'far', 'double'],
                'null' => true
            ],
            'headache' => [
                'type' => 'SET',
                'constraint' => ['frontal', 'parietal', 'temporal', 'occipital'],
                'null' => true
            ],
            'secretion' => [
                'type' => 'ENUM',
                'constraint' => ['white', 'transparent', 'yellow', 'green'],
                'null' => true
            ],
            'other_conditions' => [
                'type' => 'TEXT',
                'null' => true
            ],
            'comments' => [
                'type' => 'TEXT',
                'null' => true
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('consultation', 'consultations', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('consultation_visual_background');
    }

    public function down()
    {
        $this->forge->dropTable('consultation_visual_background');
    }
}
