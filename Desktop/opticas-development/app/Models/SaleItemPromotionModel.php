<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleItemPromotionModel extends Model
{
    protected $table            = 'sale_item_promotions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'sale',
        'sale_item',
        'promotion',
        'discount_amount',
        'meta',
        'created_at',
        'updated_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = false; // handled by DB
    protected $dateFormat    = 'datetime';
}
