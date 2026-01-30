<?php

namespace App\Models\Casts;

use App\Models\CompanyModel;
use CodeIgniter\DataCaster\Cast\BaseCast;

class CompanyCast extends BaseCast
{
    public static function get(mixed $value, array $params = [], ?object $helper = null): mixed
    {
        return model(CompanyModel::class)->find($value);

    }

}