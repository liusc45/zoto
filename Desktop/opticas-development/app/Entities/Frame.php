<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Frame extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];


    public function isSolar(): bool
    {
        return $this->attributes['is_solar'] == 1;
    }
}
