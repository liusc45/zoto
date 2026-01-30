<?php

namespace App\Models;

use App\Entities\Aside;
use CodeIgniter\Model;

class AsideModel extends Model
{
    protected $table            = 'asides';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Aside::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "sale",
        "patient",
        "financing",
        "created_by",
        "paid_at",
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        "patient" => "int",
        "patient_obj" => "patientCast"
    ];
    protected array $castHandlers = [
        "patientCast" => "App\Models\Casts\PatientCast"
    ];

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
