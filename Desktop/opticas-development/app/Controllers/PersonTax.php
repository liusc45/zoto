<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PersonTaxModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class PersonTax extends BaseController
{
    use ResponseTrait;
    protected PersonTaxModel $personTaxModel;
    

    public function __construct()
    {
        $this->personTaxModel = new PersonTaxModel();
    }
    
    public function index(): ResponseInterface
    {
        
        return $this->respond($this->personTaxModel->findAll());
        
    }
    
    public function create(): ResponseInterface{
        $personTax = new \App\Entities\PersonTax($this->request->getPost());
        try {
            $inserted = $this->personTaxModel->save($personTax);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());
        }
        return $inserted ?
            $this->respondCreated($this->personTaxModel->find($this->personTaxModel->getInsertID())) :
            $this->fail($this->personTaxModel->errors());
    }
    
    public function update($id): ResponseInterface
    {
        $personTax = $this->personTaxModel->find($id);
        $personTax->fill($this->request->getRawInput());
        try {
            $updated = $this->personTaxModel->save($personTax);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());
        }
        return $updated ?
            $this->respondUpdated($personTax):
            $this->fail($this->personTaxModel->errors());
    }
    
    public function delete($id): ResponseInterface
    {
        return $this->respondDeleted($this->personTaxModel->delete($id));
    }
}
