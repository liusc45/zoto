<?php

namespace App\Services;

use App\Entities\Discount;
use App\Entities\Sale;
use App\Models\DiscountModel;
use CodeIgniter\HTTP\RequestInterface;

class DiscountService
{
    private DiscountModel $discountModel;

    public function __construct()
    {
        $this->discountModel = new DiscountModel();
    }


    public function getBySale(Sale $sale): array
    {
        return $this->discountModel->where(["sale"=>$sale])->findAll();
    }

    /**
     * @throws \ReflectionException
     */
    public function create(Sale $sale,  array $discounts):bool
    {
        $saved = false;
        $toInsert =[];

        foreach($discounts as $key =>$discount)
        {
            if($discount["percentage"] > 0) {
                $toInsert[] = new Discount([
                    "sale" => $sale->id,
                    "concept" => $discount['concept'],
                    "percentage" => $discount['percentage'],
                    "amount" => $discount['amount'],
                ]);
            }
        }
        return empty($toInsert)?true: $this->discountModel->insertBatch($toInsert);
    }

}