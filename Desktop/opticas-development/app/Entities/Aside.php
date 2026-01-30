<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Aside extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at','last_payment_date'];
    protected $casts   = [];
}
