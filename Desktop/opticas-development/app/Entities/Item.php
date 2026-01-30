<?php

namespace App\Entities;

use App\Models\LensModel;
use CodeIgniter\Entity\Entity;

class Item extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];


    /**
     * Returns if the Item has inventory or not.
     * @return bool
     */
    public function isStockable(): bool
    {
        return $this->stockable;
    }

}
