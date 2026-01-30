<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\StoreModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class Store extends BaseController
{
    use ResponseTrait;
    
    protected StoreModel $storeModel;

    public function __construct()
    {
        $this->storeModel = new StoreModel();
    }

    public function index(): ResponseInterface
    {
        return $this->respond($this->storeModel->findAll());
    }
    
    public function show($id): ResponseInterface
    {
        return $this->respond($this->storeModel->find($id));
    }
    public function create(): ResponseInterface
    {
        $store = new \App\Entities\Store($this->request->getPost());

        try {
            $inserted = $this->storeModel->save($store);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());

        }
        return $inserted
            ? $this->respondCreated($this->storeModel->find($this->storeModel->getInsertID()))
            : $this->fail($this->storeModel->errors());
    }

    /**
     * @throws \Exception
     */
    public function update($id): ResponseInterface
    {

        $store = $this->storeModel->find($id);
        $store->fill($this->request->getRawInput());
        $store->fill(["updated_at"=>Time::today()]);
        
        try {
            $updated = $this->storeModel->save($store);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());
        }
        
        return $updated ? $this->respondUpdated($store) : $this->fail($this->storeModel->errors());
    }
    

    public function delete($id): ResponseInterface
    {
        return $this->respondDeleted($this->storeModel->delete($id));
    }
}
