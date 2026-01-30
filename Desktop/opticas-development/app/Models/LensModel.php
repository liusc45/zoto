<?php

namespace App\Models;

use App\Entities\Lens;
use CodeIgniter\Model;

class LensModel extends Model
{
    protected $table            = 'lenses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Lens::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "item",
        "design",
        "category_sphere",
        "range_sphere" ,
        "category_cylinder",
        "range_cylinder",
        "max_graduation" ,
        "over_processed" ,
        "arrival_days" ,
        "frame_type" ,
        "optical_correction" ,
        "material" ,
        "type",
        "color" ,
        "correction_type" ,
        "treatment",
        "comments",
        "price" ,
        "created_by",
        "created_at",
        "updated_at",
        "deleted_at",
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        "id"=>"int",
        "arrival_days"=>"int",
        "max_graduation"=>"int",
        "frame_type"=>"int",
        "lab"=>"?int"
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
