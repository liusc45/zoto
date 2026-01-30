<?php

namespace App\Services;

use App\Models\RangeIntervalModel;

class RangeService
{
    protected RangeIntervalModel $rangeIntervalModel;

    public function __construct()
    {
        $this->rangeIntervalModel = new RangeIntervalModel();
    }


    public function calculateRange($prescription): array
    {
       $values =[
           $prescription->final->right->sphere,
           $prescription->final->right->cylinder,
           $prescription->final->left->sphere,
           $prescription->final->left->cylinder];

       $maxSigned = array_reduce($values, function($carry, $value){
           if ($carry === null) return $value;
           return (abs($value) > abs($carry)) ? $value : $carry;
       });

       $ranges = $this->rangeIntervalModel
           ->select([
               "id",
               "range",
               "min_value",
               "max_value"
           ])
           ->where(   "min_value <= ",$maxSigned )
           ->where("max_value >=",$maxSigned )
           ->findAll();

       return $ranges;
    }

}
