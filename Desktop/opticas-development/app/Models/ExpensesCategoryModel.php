<?php

namespace App\Models;

use App\Entities\ExpensesCategory;
use CodeIgniter\Model;

class ExpensesCategoryModel extends Model
{
    protected $table            = 'expenses_category';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = ExpensesCategory::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "name",
        "description",
        "created_at",
        "updated_at",
        "deleted_at"];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        "name"=>"is_unique[expenses_category.name]",
        "description"=>"max_length[50]"
    ];
    protected $validationMessages   = [
        "name"=>[
            "required"=>"El nombre es requerido.",
            "is_unique"=>"Nombre ya existe "
        ],
        "description"=>[
            "max_length"=>"50 carácteres máximo ",

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
