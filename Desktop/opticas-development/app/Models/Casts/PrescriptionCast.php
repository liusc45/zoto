<?php

namespace App\Models\Casts;

use App\Entities\Prescription;
use App\Models\PrescriptionModel;
use CodeIgniter\DataCaster\Cast\BaseCast;

class PrescriptionCast extends BaseCast
{

    public static function get(mixed $value, array $params = [], ?object $helper = null): mixed
    {
        return model(PrescriptionModel::class)
            ->where(["consultation"=>$value])
            ->first()??new Prescription();
    }

}