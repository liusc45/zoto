<?php

namespace App\Models;

use App\Entities\SolarFrame;
use CodeIgniter\Model;

class SolarFrameModel extends Model
{
    protected $table            = 'solar_frames';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = SolarFrame::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [

        "item",
        "frame",
        "material",
        "property",
        "treatment",
        "treatment_color",
        "lens_fade",
        "lens_color",
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        "id"=>"?int",
        "item"=>"?int",
        "frame"=>"?int",
        "material"=>"?int",
        "property"=>"?int",
        "treatment"=>"?int",
        "treatment_color"=>"?int",
        "lens_fade"=>"?int",
        "lens_color"=>"?int",
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
