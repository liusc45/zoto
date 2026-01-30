<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Purchase extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        "supplier"=>"integer",
        "discount"=>"float",
        "amount"=>"float",
        "store"=>"integer",
        "created_by"=>"integer",

    ];
}
