<?php

namespace App\Models;

use CodeIgniter\Model;

class SalePromotionModel extends Model
{
    protected $table            = 'sale_promotions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'sale',
        'promotion',
        'promo_code',
        'discount_amount',
        'meta',
        'created_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = false; // created_at handled by DB default
    protected $dateFormat    = 'datetime';

    // Validation
    protected $validationRules = [
        'sale'            => 'permit_empty|numeric',
        'promotion'       => 'permit_empty|numeric|is_not_unique[promotions.id]',
        'promo_code'      => 'permit_empty|max_length[50]',
        'discount_amount' => 'required|numeric',
        'meta'            => 'permit_empty'
    ];

}
