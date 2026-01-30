<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class GeneralBackground extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at',"last_glucose_date","last_blood_pressure_date"];
    protected $casts   = [];
}
