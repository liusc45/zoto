<?php

namespace App\Models;

use App\Entities\Range;
use CodeIgniter\Model;

class RangeModel extends Model
{
    protected $table            = 'ranges';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = Range::class;
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'description',
        'created_at',
        'updated_at',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'description' => 'required|min_length[2]|max_length[255]'
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
