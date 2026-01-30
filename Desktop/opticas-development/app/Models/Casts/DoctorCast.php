<?php

namespace App\Models\Casts;

use App\Models\DoctorModel;
use CodeIgniter\DataCaster\Cast\BaseCast;

class DoctorCast extends BaseCast
{

    public static function get(mixed $value, array $params = [], ?object $helper = null): mixed
    {
        return model(DoctorModel::class)
            ->select(["doctors.id as doctor", "persons.*"])
            ->join("persons","persons.id = doctors.person")
            ->find($value);
            //->where("person", $value)->findAll();
    }

}