<?php

namespace App\Entities;

use App\Models\SaleItemsModel;
use CodeIgniter\Entity\Entity;

class Consultation extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at','consultation_date'];
    protected $casts   = [];


}
