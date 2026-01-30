<?php

namespace App\Models;

use App\Entities\Sale;
use CodeIgniter\Model;

class SaleModel extends Model
{
    protected $table            = 'sales';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Sale::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "uuid",
        "store",
        "items",
        "patient",
        "type",
        "payment_type",
        "aut",
        "discount",
        "amount",
        "delivery",
        "comments",
        "document",
        "created_by",
        "created_at",
        "updated_at",
        "deleted_at",
        
    ];

    protected bool $allowEmptyInserts = false;

    protected array $casts = [
        "id"=>"int",
        "patient" => "?int",
        "sale_items" => "saleItems['patient']",

    ];
    protected array $castHandlers = [
        "saleItems" => "App\Models\Casts\SaleItemsCast"
    ];
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
