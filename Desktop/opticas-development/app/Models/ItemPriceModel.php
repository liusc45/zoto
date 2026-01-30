<?php

namespace App\Models;

use App\Entities\ItemPrice;
use CodeIgniter\Model;

class ItemPriceModel extends Model
{
    protected $table            = 'item_prices';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = ItemPrice::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'item',
        'type',
        'amount',
        'shipping_cost',
        'starts_at',
        'ends_at',
        'created_by',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        "id"=>"?int",
        "item"=>"?int",
        "amount"=>"float",
        "shipping_cost"=>"?float",
        "prices" => "json"
    ];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'item'     => 'required|numeric',
        'type'     => 'required|in_list[regular,promotion,discount,outlet]',
        'amount'   => 'required|numeric|greater_than[0]',
        'starts_at' => 'valid_date[Y-m-d H:i:s]',
        'ends_at'   => 'valid_date[Y-m-d H:i:s]',
    ];
    protected $validationMessages   = [
        'item' => [
            'required' => 'El item es requerido',
            'numeric'  => 'El item debe ser numérico'
        ],
        'type' => [
            'required'  => 'El tipo de precio es requerido',
            'in_list'  => 'El tipo de precio debe ser regular, promotion, discount u outlet'
        ],
        'amount' => [
            'required' => 'El monto es requerido',
            'numeric'  => 'El monto debe ser numérico',
            'greater_than' => 'El monto debe ser mayor a 0'
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
