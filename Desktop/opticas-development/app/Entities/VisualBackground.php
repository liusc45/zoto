<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class VisualBackground extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at',"last_check_date"];
    protected $casts   = [];
}
