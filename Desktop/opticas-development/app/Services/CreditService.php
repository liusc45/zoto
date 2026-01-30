<?php

namespace App\Services;

use App\Entities\Credit;
use App\Entities\Sale;
use App\Models\CreditModel;

class CreditService
{
    protected CreditModel $creditModel;

    public function __construct()
    {
        $this->creditModel = new CreditModel();
    }

    /**
     * @throws \ReflectionException
     */
    public function create(Sale $sale) :Credit|array
    {
        $credit = new Credit();
        $credit->fill([
            "sale"=>$sale->id,
            "patient"=>$sale->patient,
            "financing"=> $sale->amount,
            "created_by"=> $sale->created_by
        ]);


        $inserted = $this->creditModel->save($credit);

        return $inserted?
            $this->creditModel->find($this->creditModel->getInsertID()):
           false;



    }

}