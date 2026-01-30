<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleCommissionModel extends Model
{
    protected $table            = 'sale_commissions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'sale_id',
        'seller_user_id',
        'commissionable_amount',
        'taxes_amount',
        'bank_commission_amount',
        'net_amount',
        'commission_amount',
        'status',
        'paid_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
}
