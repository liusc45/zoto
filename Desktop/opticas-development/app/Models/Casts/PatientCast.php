<?php

namespace App\Models\Casts;

use App\Models\DoctorModel;
use App\Models\PatientModel;
use CodeIgniter\DataCaster\Cast\BaseCast;

class PatientCast extends BaseCast
{

    public static function get(mixed $value, array $params = [], ?object $helper = null): mixed
    {
        return model(PatientModel::class)
            ->select(["patients.id as patient", "persons.*"])
            ->join("persons","persons.id = patients.person")
            ->find($value);
            //->where("person", $value)->findAll();
    }

}