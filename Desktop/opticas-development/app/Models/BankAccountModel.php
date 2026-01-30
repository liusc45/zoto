<?php

namespace App\Models;

use App\Entities\BankAccount;
use CodeIgniter\Model;

class BankAccountModel extends Model
{
    protected $table            = 'bank_accounts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = BankAccount::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'bank_name',
        'alias',
        'account_number',
        'clabe',
        'owner_name',
        'store',
        'currency',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'id' => 'int',
        'store' => 'int',
    ];

    protected $useTimestamps = false;
}
