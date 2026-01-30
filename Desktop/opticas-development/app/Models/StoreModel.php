<?php

namespace App\Models;

use App\Entities\Store;
use CodeIgniter\Model;

class StoreModel extends Model
{
    protected $table            = 'stores';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Store::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "name",
        "address",
        "phone",
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
        "name"=>REQUIRED
    ];
    protected $validationMessages   = [
        "name"=>[
            REQUIRED => "El nombre es requerido"
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
