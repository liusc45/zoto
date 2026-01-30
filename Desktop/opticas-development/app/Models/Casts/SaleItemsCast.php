<?php

namespace App\Models\Casts;

use App\Models\SaleItemsModel;
use CodeIgniter\DataCaster\Cast\BaseCast;

class SaleItemsCast extends BaseCast
{

    public static function get(mixed $value, array $params = [], ?object $helper = null): mixed
    {
        $item = '';
        return model(SaleItemsModel::class)
            ->select(["sale_items.*", "sale_items.item as item_obj"])
            ->where("sale", $value)
            ->findAll();
    }
}