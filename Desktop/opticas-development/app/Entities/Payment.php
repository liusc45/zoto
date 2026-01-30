<?php

namespace App\Entities;

use App\Models\PaymentModel;
use CodeIgniter\Entity\Entity;

class Payment extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        "id"=>"integer",
        "credit"=>"integer",
        "sale"=>"integer",
        "amount"=>"float",
        "cash"=>"float",
        "cashback"=>"float",
        "created_by"=>"integer"
    ];
    

}
