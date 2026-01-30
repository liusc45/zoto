<?php

namespace App\Services;

use App\Entities\Aside;
use App\Entities\Sale;
use App\Models\AsideModel;

class AsideService
{
    private AsideModel $asideModel;

    public function __construct()
    {
        $this->asideModel = new AsideModel();
    }

    /**
     * @throws \ReflectionException
     */
    public function create(Sale $sale): array|Aside|null
    {

        $aside = new Aside([
            'sale' => $sale->id,
            "customer"=>$sale->customer,
            "financing"=> $sale->amount,
            "created_by"=> $sale->created_by
        ]);

        $saved = $this->asideModel->save($aside);

        return $saved ?
            $this->asideModel->find($this->asideModel->getInsertID()):
            ["errors"=>$this->asideModel->errors()];

    }
    
    public function list(): array
    {
        $select = [
            "asides.id",
            "asides.sale",
            "asides.created_at",
            "asides.patient as patient_obj",
            "max(p.created_at) as last_payment_date",
            "count(p.id) as payments",
			"s.uuid",
            "datediff(now(),asides.created_at) days_since",
            "s.amount- sum(p.amount) as debt"
        ];
        
        $asides = $this->asideModel
            ->select($select)
            ->join('sales as s', 's.id = asides.sale')
            ->join('payments as p', 'p.sale = s.id AND p.credit = asides.id')
            ->groupBy('asides.id')
            ->findAll();
        return $asides;
    }
}
