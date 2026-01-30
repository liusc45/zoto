<?php

namespace App\Models;

use App\Entities\ItemCategory;
use CodeIgniter\Model;

class ItemCategoryModel extends Model
{
    protected $table            = 'items_category';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = ItemCategory::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "name",
        "description",
        "created_at",
        "updated_at",
        "deleted_at"
    ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        "name"=>"required",
        "description"=>"required",
        
    ];
    protected $validationMessages   = [
        "name"=>[
            "required"=>"Nombre es requerido."
        ],
        "description"=>[
            "required"=>"Descripción es requerida."
        ]
    ];
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
