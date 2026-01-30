<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Patient extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at','dob'];
    protected $casts   = [];
}
