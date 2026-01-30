<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CustomerModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Customer extends BaseController
{
    use ResponseTrait;
    protected CustomerModel $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
    }

    public function index(): ResponseInterface
    {
        return $this->respond($this->customerModel->findAll());

    }
    public function show($id): ResponseInterface
    {
        return $this->respond($this->customerModel->find($id));
    }
    public function create(): ResponseInterface
    {
        $customer = new \App\Entities\Customer($this->request->getPost());
        try {
            $inserted = $this->customerModel->save($customer);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());
        }
        return $inserted ?
            $this->respondCreated($this->customerModel->find($this->customerModel->getInsertID())):
            $this->fail($this->customerModel->errors());

    }
    public function update($id): ResponseInterface
    {
        $customer = $this->customerModel->find($id);
        $customer->fill($this->request->getRawInput());
        try {
            $updated = $this->customerModel->save($customer);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());
        }
        return $updated ? $this->respondUpdated($customer):$this->fail($this->customerModel->errors());
    }

    public function delete($id): ResponseInterface
    {
        $customer = $this->customerModel->find($id);
        $deleted =  $this->customerModel->delete($id);

        return $deleted ? $this->respondDeleted($customer):$this->fail($this->customerModel->errors());
    }
}
