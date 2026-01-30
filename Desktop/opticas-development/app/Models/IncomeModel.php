<?php

namespace App\Models;

use App\Entities\ItemCategory;
use CodeIgniter\Model;

class IncomeModel extends Model
{
    protected $table            = 'incomes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = ItemCategory::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "id",
        "payment",
        "amount",
        "concept",
        "comments",
        "applied",
        "responsible",
        "created_by",
        "created_at",
        "updated_at",
        "deleted_at"
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
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
