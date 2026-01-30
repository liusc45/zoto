<?php

namespace App\Models;

use App\Entities\PaymentCard;
use CodeIgniter\Model;

class PaymentCardModel extends Model
{
    protected $table            = 'payment_cards';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = PaymentCard::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name',
        'commission',
        'active',
        'bank_account',
        'bank_payment_type',
        'store',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        "id"=>"int",
        "commission"=>"float",
        "active"=>"boolean"
    ];
    protected array $castHandlers = [];

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
    protected $afterFind      = [
        'indexCards'
    ];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


    public function indexCards($data): array
    {
        $accounts = [];
        $cards = $data["data"];
        foreach($cards as $card)
        {
            $accounts[$card->bank_account][] = $card;

          //  $card->bank_account = str_repeat("*", strlen($card->bank_account) - 4) . substr($card->bank_account, -4);
        }

        $data["data"] = $accounts;
        return $data;
    }
}
