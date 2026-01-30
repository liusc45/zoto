<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Inventory extends Entity
{
    protected $datamap = [];
    protected $dates   = ['enter_at','created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        "item"=>"integer",
        "stock"=>"integer",
        "store"=>"integer"
    ];
}
