<?php

namespace App\Models;

use App\Entities\ConsultationContact;
use CodeIgniter\Model;

class ConsultationContactModel extends Model
{
    protected $table            = 'consultation_contact_lenses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = ConsultationContact::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "consultation",
        "patient",
        "right_keratometry_a",
        "left_keratometry_a",
        "right_keratometry_b",
        "left_keratometry_b",
        "eyelid_opening",
        "cornea_diameter",
        "pupil_diameter",
        "tear_breakup_time",
        "right_base",
        "left_base",
        "right_diameter",
        "left_diameter",
        "final_right_sphere",
        "final_left_sphere",
        "final_right_cylinder",
        "final_left_cylinder",
        "final_right_axis",
        "final_left_axis",
        "right_keratometry_axis",
        "left_keratometry_axis",
        "over_right_sphere",
        "over_left_sphere",
        "over_right_cylinder",
        "over_left_cylinder",
        "right_thickness",
        "left_thickness",
        "right_cpp",
        "left_cpp",
        "contact_right_acuity_before",
        "contact_right_acuity_after",
        "contact_left_acuity_before",
        "contact_left_acuity_after",
        "suggested",
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        "id"=>"int",
        "consultation"=>"int",
        "patient"=>"int",
        "right_keratometry_a"=>"float",
        "left_keratometry_a"=>"float",
        "right_keratometry_b"=>"float",
        "left_keratometry_b"=>"float",
        "eyelid_opening"=>"float",
        "cornea_diameter"=>"float",
        "pupil_diameter"=>"float",
        "tear_breakup_time"=>"int",
        "right_base"=>"float",
        "left_base"=>"float",
        "right_diameter"=>"int",
        "left_diameter"=>"int",
        "final_right_sphere"=>"float",
        "final_left_sphere"=>"float",
        "final_right_cylinder"=>"float",
        "final_left_cylinder"=>"float",
        "final_right_axis"=>"int",
        "final_left_axis"=>"int",
        "right_keratometry_axis"=>"int",
        "left_keratometry_axis"=>"int",
        "over_right_sphere"=>"float",
        "over_left_sphere"=>"float",
        "over_right_cylinder"=>"float",
        "over_left_cylinder"=>"float",
        "suggested"=>"?int",
    ];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
