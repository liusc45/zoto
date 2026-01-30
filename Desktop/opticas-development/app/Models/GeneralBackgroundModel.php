<?php

namespace App\Models;

use App\Entities\GeneralBackground;
use CodeIgniter\Model;

class GeneralBackgroundModel extends Model
{
    protected $table            = 'consultation_general_background';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = GeneralBackground::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "id",
        "consultation",
        "healthy",
        "diabetes",
        "last_glucose_date",
        "glucose_date_number",
        "glucose_date_unit",
        "glucose_level",
        "hypertensive",
        "last_blood_pressure_date",
        "blood_date_number",
        "blood_date_unit",
        "blood_pressure_level",
        "comments",
        "observations",
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        "id" => "int",
        "consultation" => "int",
        "healthy" =>"?bool",
        "diabetes"=>"?bool",
        "glucose_date_number"=>"?int" ,
        "glucose_level" =>"?int",
        "hypertension"=>"?bool",
        "blood_date_number"=>"?int",
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
