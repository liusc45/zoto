<?php

namespace App\Models;

use App\Entities\Transfer;
use CodeIgniter\Model;

class TransferModel extends Model
{
    protected $table            = 'transfers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Transfer::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "inventory",
        "item",
        "qty",
        "store_dispatch",
        "store_receive",
        "created_by",
        "created_at",
        "updated_at",
        "deleted_at",
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
        "inventory"=>[REQUIRED],
        "item"=>[REQUIRED],
        "store_dispatch"=>[REQUIRED],
        "store_receive"=>[REQUIRED],
        "created_by"=>[REQUIRED],

    ];
    protected $validationMessages   = [
        "inventory"=>[
            REQUIRED =>"El invetario es requerido" ],
        "item"=>[
            REQUIRED => " El artículo es requerido"
        ],
        "store_dispatch"=>[
            REQUIRED => " la tienda que envía es requerida "
        ],
        "store_receive"=>[
            REQUIRED=> " la tienda que recibe es requerida "
        ],
        "created_by"=>[
            REQUIRED => " el usuario que transfiere es requerido "
        ],
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
