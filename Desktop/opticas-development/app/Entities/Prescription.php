<?php

namespace App\Entities;

use App\Models\SaleItemsModel;
use CodeIgniter\Entity\Entity;

class Prescription extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];


    public function getItems(): array
    {
        $sale    = $this->attributes['sale']    ?? null;
        $patient = $this->attributes['patient'] ?? null;
        $prescription = $this->attributes['id'] ?? null;

        $where = array_filter(["sale"=>$sale,"patient"=> $patient,"prescription"=> $prescription],fn($v)=>!is_null($v));


        return model(SaleItemsModel::class)
            ->select('sale_items.*, sale_items.item as item_obj')
            ->where($where)
            ->findAll();
    }

}
