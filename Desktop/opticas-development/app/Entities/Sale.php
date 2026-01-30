<?php

namespace App\Entities;

use App\Models\PaymentModel;
use CodeIgniter\Entity\Entity;

class Sale extends Entity
{
    
    private Payment $fee  ;
   
    protected $datamap = [];
    protected $dates   = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    
    protected $casts   = [
        "id"            => "integer",
        "store"         => "integer",
        "items"         => "integer",
        "customer"      => "integer",
        "amount"        => "double",
        "created_by"    => "integer"
    ];
    public function pay(?Payment $payment = null): bool
    {
        if($payment === null)
        {
            $this->fee = new Payment();
            return false;
            
        }
        $paymentModel = new PaymentModel();
        $paymentModel->save($payment);
        $this->fee = $payment;
        return true;
        
    }
    public function getFee(): Payment
    {
        return $this->fee;
    }
    
    public function deleteFee($id): bool
    {
        $paymentModel = new PaymentModel();
        $payment = $paymentModel->where(["sale"=>$id])->first();
        return $paymentModel->delete($payment->id);
        
    }
}
