<?php

namespace App\Entities;

use App\Models\FrameModel;
use App\Models\LensModel;
use CodeIgniter\Entity\Entity;

class SaleItem extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function getLens(): object|array|null
    {
        return model(LensModel::class)
            ->where(["item"=>$this->attributes['item']])->first();
    }
    public function getFrame(): Frame|null
    {
        return model(FrameModel::class)
            ->where(["item"=>$this->attributes['item']])->first();
    }
}
