<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaymentCardModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class PaymentCard extends BaseController
{
    use ResponseTrait;
    protected PaymentCardModel $paymentCardModel;

    public function __construct()
    {
        $this->paymentCardModel = new PaymentCardModel();
    }

    public function index(): ResponseInterface
    {
        return $this->respond($this->paymentCardModel->findAll());
    }

    public function show($id): ResponseInterface
    {
        return $this->respond($this->paymentCardModel->find($id));
    }

    public function create(): ResponseInterface
    {
        $paymentCard = new \App\Entities\PaymentCard([
            "name" => $this->request->getPost("name"),
            "commission" => $this->request->getPost("commission"),
            "active" => $this->request->getPost("active") === "1" ? true : false,
            "bank_account" => $this->request->getPost("bank_account"),
            "bank_payment_type" => $this->request->getPost("bank_payment_type"),
            "store" => $this->request->getPost("store"),
        ]);
        
        try {
            $saved = $this->paymentCardModel->save($paymentCard);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());
        }
        
        return $saved ?
            $this->respondCreated($this->paymentCardModel->find($this->paymentCardModel->getInsertID())):
            $this->fail($this->paymentCardModel->errors());
    }

    public function update($id = null): ResponseInterface
    {
        $paymentCard = $this->paymentCardModel->find($id);
        
        if ($paymentCard === null) {
            return $this->failNotFound('Payment card not found');
        }
        
        $paymentCard->fill([
            "name" => $this->request->getPost("name"),
            "commission" => $this->request->getPost("commission"),
            "active" => $this->request->getPost("active") === "1" ? true : false,
            "bank_account" => $this->request->getPost("bank_account"),
            "bank_payment_type" => $this->request->getPost("bank_payment_type"),
            "store" => $this->request->getPost("store"),
        ]);
        
        try {
            $saved = $this->paymentCardModel->save($paymentCard);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());
        }
        
        return $saved ?
            $this->respondUpdated($this->paymentCardModel->find($id)):
            $this->fail($this->paymentCardModel->errors());
    }

    public function delete(int $id): ResponseInterface
    {
        $paymentCard = $this->paymentCardModel->withDeleted()->find($id);
        
        if ($paymentCard === null) {
            return $this->failNotFound('Payment card not found');
        }
        
        $this->paymentCardModel->delete($paymentCard->id);
        return $this->respondDeleted($paymentCard);
    }
}
