<?php

namespace App\Models;

use App\Entities\Inventory;
use CodeIgniter\Model;

class InventoryModel extends Model
{
//    const REQUIRED  = "required";
    protected $table            = 'inventories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Inventory::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "code",
        "item",
        "cost",
        "supplier",
        "store",
        "stock",
        "bill",
        "purchase",
        "enter_at",
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
        "item"=>REQUIRED,
        "supplier"=>REQUIRED,
        "store"=>REQUIRED,
        "stock"=>REQUIRED,
        "enter_at"=>REQUIRED,
    
    ];
    protected $validationMessages   = [
        "item"=>[
            "required"=>"el artículo es requerido"
        ],
        "supplier"=>[
            "required"=>"el proveedor es requerido"
        ],
        "store"=>[
            "required"=>"la tienda es requerido"
        ],
        "stock"=>[
            "required"=>"la cantidad es requerido"
        ],

        "enter_at"=>[
            "required"=>"la fecha de entrada  es requerida"
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


    public function getAllowedFields():array
    {
        return $this->allowedFields;
    }

}
