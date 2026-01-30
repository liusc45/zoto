<?php

namespace App\Services;

use App\Models\SaleItemsModel;
use App\Models\SaleModel;

class SaleService
{
    protected SaleModel $saleModel;

    public function __construct()
    {
        $this->saleModel = new SaleModel();
    }

    public function getSaleByPatient($patient): array
    {
        return $this->saleModel
            ->select(["sales.id","amount","sales.created_at", "sale_items.patient as sale_items"])
            ->join("sale_items","sale_items.sale = sales.id")
            ->where("sale_items.patient",$patient->id)
            ->groupBy("sales.id")
            ->findAll();
    }

    public function getFrameSold($patient): array
    {
        return model(SaleItemsModel::class)->where("patient",$patient->id)->findAll();
    }

}