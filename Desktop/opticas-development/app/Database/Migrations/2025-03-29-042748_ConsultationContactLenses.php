<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ConsultationContactLenses extends Migration
{
    // Migration: CreateConsultationContactLenses
    public function up()
    {
        $this->forge->addField([
            'id'                    => ['type' => 'INT', 'auto_increment' => true, 'unsigned' => true],
            "consultation"          =>['type'=>'INT',"constraint"=>11,"null"=>true, 'unsigned' => true],
            "patient"               =>['type'=>'INT',"constraint"=>11,"null"=>true, 'unsigned' => true],
            "right_keratometry_a"   =>['type'=>'DECIMAL',"constraint"=>"6,3",'null'=>true, 'unsigned' => true],
            "left_keratometry_a"    =>['type'=>'DECIMAL',"constraint"=>"6,3",'null'=>true, 'unsigned' => true],
            "right_keratometry_b"   =>['type'=>'DECIMAL',"constraint"=>"6,3",'null'=>true, 'unsigned' => true],
            "left_keratometry_b"    =>['type'=>'DECIMAL',"constraint"=>"6,3",'null'=>true, 'unsigned' => true],
            "eyelid_opening"        =>['type'=>'INT',"constraint"=>2,'null'=>true, 'unsigned' => true],
            "cornea_diameter"       =>['type'=>'DECIMAL', "constraint"=>"4,2", 'null'=>true, 'unsigned' => true],
            "pupil_diameter"        =>['type'=>'DECIMAL', "constraint"=>"4,2", 'null'=>true, 'unsigned' => true],
            "tear_breakup_time"     =>['type'=>'INT',"constraint"=>2,'null'=>true, 'unsigned' => true],
            "right_base"            =>['type'=>'DECIMAL', "constraint"=>"4,2", 'null'=>true, 'unsigned' => true],
            "left_base"             =>['type'=>'DECIMAL', "constraint"=>"4,2", 'null'=>true, 'unsigned' => true],
            "right_diameter"         =>['type'=>'INT',"constraint"=>2,'null'=>true, 'unsigned' => true],
            "left_diameter"          =>['type'=>'INT',"constraint"=>2,'null'=>true, 'unsigned' => true],
            "final_right_sphere"          =>['type'=>'DECIMAL', "constraint"=>"4,2", 'null'=>true, ],
            "final_left_sphere"           =>['type'=>'DECIMAL', "constraint"=>"4,2", 'null'=>true,],
            "final_right_cylinder"        =>['type'=>'DECIMAL', "constraint"=>"4,2", 'null'=>true, ],
            "final_left_cylinder"         =>['type'=>'DECIMAL', "constraint"=>"4,2", 'null'=>true, ],
            "final_right_axis"            =>['type'=>'INT',"constraint"=>3,'null'=>true, 'unsigned' => true],
            "final_left_axis"             =>['type'=>'INT',"constraint"=>3,'null'=>true, 'unsigned' => true],
            "right_keratometry_axis"            =>['type'=>'INT',"constraint"=>3,'null'=>true, 'unsigned' => true],
            "left_keratometry_axis"             =>['type'=>'INT',"constraint"=>3,'null'=>true, 'unsigned' => true],
            "over_right_sphere"          =>['type'=>'DECIMAL', "constraint"=>"4,2", 'null'=>true, ],
            "over_left_sphere"           =>['type'=>'DECIMAL', "constraint"=>"4,2", 'null'=>true,],
            "over_right_cylinder"        =>['type'=>'DECIMAL', "constraint"=>"4,2", 'null'=>true, ],
            "over_left_cylinder"         =>['type'=>'DECIMAL', "constraint"=>"4,2", 'null'=>true, ],
            "right_thickness"            =>['type'=>'VARCHAR', "constraint"=>50, 'null'=>true, ],
            "left_thickness"             =>['type'=>'VARCHAR', "constraint"=>50, 'null'=>true, ],
            "right_cpp"                  =>['type'=>'VARCHAR', "constraint"=>50, 'null'=>true, ],
            "left_cpp"                   =>['type'=>'VARCHAR', "constraint"=>50, 'null'=>true, ],
            "contact_right_acuity_before" =>['type'=>'VARCHAR', "constraint"=>50, 'null'=>true, ],
            "contact_right_acuity_after"  =>['type'=>'VARCHAR', "constraint"=>50, 'null'=>true, ],
            "contact_left_acuity_before"  =>['type'=>'VARCHAR', "constraint"=>50, 'null'=>true, ],
            "contact_left_acuity_after"   =>['type'=>'VARCHAR', "constraint"=>50, 'null'=>true, ],
            "suggested"                   =>['type'=>'INT', "constraint"=>11, 'null'=>true, 'unsigned' => true],


        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('consultation', 'consultations', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('consultation_contact_lenses');
    }

    public function down()
    {
        $this->forge->dropTable('consultation_contact_lenses');
    }
}
