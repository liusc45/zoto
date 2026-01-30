<?php

namespace App\Models;

use App\Entities\Item;
use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $table            = 'items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Item::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [

        "id",
        "key",
        "barcode",
        "name",
        "cost",
        "supplier",
        "line",
        "brand",
        "color_key",
        "color",
        "model",
        "size",
        "stockable",
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
       
        "name"=>"required",
    ];
    protected $validationMessages   = [
       
        "name"=> [
            "required"=>"El nombre es requerido"
        ],
        "category"=>[
            "required"=>"la categoría es requerida"
        ]
    ];
    protected array $casts = [
        "id"        =>"integer",
        "cost"      =>"?float",
        "price"     =>"?float",
        "stockable" =>"bool",
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
