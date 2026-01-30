<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaymentModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Payment extends BaseController
{
    use ResponseTrait;
    protected $paymentModel;
    
    public function __construct()
    {
        $this->paymentModel = new PaymentModel();
    }
    
    public function index()
    {
        return $this->respond($this->paymentModel->findAll());
    }
    
    public function create()
    {
        $payment = new \App\Entities\Payment($this->request->getPost());
        
        try {
            $inserted =$this->paymentModel->save($payment);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());
        }
        
        return $inserted?
            $this->respondCreated($this->paymentModel->find($this->paymentModel->getInsertID())) :
            $this->fail($this->paymentModel->errors());
        
    }
    public function update($id)
    {
        $payment = $this->paymentModel->find($id);
        $payment->fill($this->request->getRawInput());

        try {
            $this->paymentModel->save($payment);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());
        }
        return $this->respondUpdated($payment);
    }
}
