<?php

namespace App\Models\Casts;

use App\Models\ItemModel;
use CodeIgniter\DataCaster\Cast\BaseCast;

class ItemCast extends BaseCast
{

    public static function get(mixed $value, array $params = [], ?object $helper = null): mixed
    {
        return model(ItemModel::class)
            ->select([
                "items.id",
                "key",
                "items.name",
                "coalesce(lines.name, '') line",
                "coalesce(brands.name, '') brand",
                "coalesce(colors.name, '') color",

            ])
            ->join("lines","lines.id = items.line","left")
            ->join("brands","brands.id = items.brand","left")
            ->join("colors","colors.id = items.color","left")
            ->find($value);
    }
}