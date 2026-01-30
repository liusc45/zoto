<?php

namespace App\Models;

use App\Entities\SaleItem;
use CodeIgniter\Model;

class SaleItemsModel extends Model
{
    protected $table            = 'sale_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = SaleItem::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        "sale",
        "patient",
        "prescription",
        "store",
        "qty",
        "item",
        'lens_side',
        'is_partial',
        'base_unit_price',
        "inventory",
        "sale_price",
        "unit_price",
        "final_price"
    ];

    protected bool $allowEmptyInserts = false;

    protected array $casts = [
        "id"    => "int",
        "sale"    => "?int",
        "patient"    => "?int",
        "store"    => "?int",
        "item"    => "?int",
        "inventory"    => "?int",
        "sale_price"    => "float",
        "unit_price"    => "float",
        "final_price"    => "float",
        "item_obj" => "?ItemCast"
    ];
    protected array $castHandlers = [
        "ItemCast" => \App\Models\Casts\ItemCast::Class
    ];
    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        "sale"          =>REQUIRED,
        "qty"           =>REQUIRED,
        "item"          => REQUIRED,
        "sale_price"    => REQUIRED,
        "final_price"   => REQUIRED
    ];
    protected $validationMessages   = [
        "sale" => ["required"=>"La venta es requerida "],
        "qty" => ["required"=>"La cantidad es requerida "],
        "item" => ["required"=>"Artículo requerido "],
        "sale_price" => ["required"=>"Precio de venta requerido "],
        "final_price"=> ["required"=>"Falta precio final "],
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
