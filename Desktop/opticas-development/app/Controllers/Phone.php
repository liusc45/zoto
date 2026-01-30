<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PhoneModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;

class Phone extends BaseController
{
    use ResponseTrait;
    
    protected PhoneModel $phoneModel;
    
    public function __construct()
    {
        $this->phoneModel = new PhoneModel();
    }
    
    public function create(): ResponseInterface
    {
        $phone = new \App\Entities\Phone($this->request->getPost());
        
        try {
            $inserted = $this->phoneModel->save($phone);
        } catch (\ReflectionException | DatabaseException $e) {
            return $this->fail($e->getMessage());
        }
        return $inserted?
            $this->respondCreated($this->phoneModel->find($this->phoneModel->getInsertID())) :
            $this->fail($this->phoneModel->errors());
        
    }
    
    public function update($id): ResponseInterface
    {
        $phone = $this->phoneModel->find($id);
        $phone->fill($this->request->getRawInput());
        try {
            $updated = $this->phoneModel->save($phone);
        } catch (\ReflectionException | DatabaseException $e) {
            return $this->fail($e->getMessage());
        }
        return $updated ?
            $this->respondUpdated($phone):
            $this->fail($this->phoneModel->errors());
    }
    
    public function delete($id): ResponseInterface
    {
        $phone = $this->phoneModel->find($id);
        try {
            $deleted = $this->phoneModel->delete($id);
        } catch (\ReflectionException | DatabaseException $e) {
            return $this->fail($e->getMessage());
        }
        return $deleted ?
            $this->respondDeleted($phone):
            $this->fail($this->phoneModel->errors());
    }
}
