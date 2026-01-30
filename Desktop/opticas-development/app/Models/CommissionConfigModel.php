<?php

namespace App\Models;

use CodeIgniter\Model;

class CommissionConfigModel extends Model
{
    protected $table            = 'commission_config';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'tax_rate',
        'bank_commission_rate',
        'percent_line1',
        'percent_line2',
        'percent_line13',
        'percent_bundle_1_13',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getConfig(): array
    {
        // Ensure there is at least one row
        $row = $this->first();
        if (!$row) {
            $this->insert([]);
            $row = $this->first();
        }
        return $row;
    }
}
