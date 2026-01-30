<?php

namespace App\Models\Casts;

use App\Models\PhoneModel;
use CodeIgniter\DataCaster\Cast\BaseCast;

class PhoneCast extends BaseCast
{
   public static function get(mixed $value, array $params = [], ?object $helper = null): mixed
   {
       return model(PhoneModel::class)->where("person", $value)->findAll();
   }

}
