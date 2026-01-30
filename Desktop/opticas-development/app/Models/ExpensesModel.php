<?php

namespace App\Models;

use App\Entities\Expense;
use CodeIgniter\Model;

class ExpensesModel extends Model
{
    protected $table            = 'expenses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Expense::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "concept",
        "amount",
        "adjustment",
        "responsible",
        "category",
        "created_by",
        "comments",
        "reconciled",
        "applied",
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
        "concept" =>"required|min_length[3]",
        "amount"=>"required|greater_than[0]",
        "responsible"=>"required|min_length[1]|is_natural_no_zero",
        "category"=>"required"
    ];
    protected $validationMessages   = [
        "concept" =>[
            "required"=>"El concepto es requerido",
            "min_length"=>"Concepto muy corto"
        ],
        "amount"=>[
            "required"=>"El monto es requerido",
            "greater_than"=>"Monto debe ser mayor a 0"
            
        ],
        "responsible"=>[
            "required"=>"El responsable es requerido"
        ],
        "category"=>[
            "required"=>"una categoría es requerida"
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
