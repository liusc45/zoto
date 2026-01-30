<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ItemCategoryModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class ItemCategory extends BaseController
{
    use ResponseTrait;
    protected ItemCategoryModel $itemCatModel;
    
    public function __construct()
    {
        $this->itemCatModel  = new ItemCategoryModel();
    }
    
    public function index(): ResponseInterface
    {
        return $this->respond( $this->itemCatModel->findAll());
    }
    
    public function show($id): ResponseInterface
    {
        return $this->respond($this->itemCatModel->find($id));
    }
    
    public function create()
    {
        $itemCat = new \App\Entities\ItemCategory($this->request->getPost());
        
        try {
            $inserted = $this->itemCatModel->save($itemCat);
        } catch (\ReflectionException $e) {
            return $this->fail($this->itemCatModel->errors());
        }
        if($inserted){
            $return = $this->respondCreated($this->itemCatModel->find($this->itemCatModel->getInsertID()));
        }else{
            $return = $this->fail($this->itemCatModel->errors());
        }
        return $return;
        
        
    }
    public function update($id): ResponseInterface
    {
        $itemCat = $this
            ->itemCatModel
            ->find($id)
            ->fill($this->request->getRawInput());
        try {
            
            $updated = $this->itemCatModel->save($itemCat);
        }catch (\ReflectionException $exception){
            return $this->fail($exception->getMessage());
        }
        return  $updated ? $this->respondUpdated($itemCat) : $this->fail($this->itemCatModel->errors());
        
    }
    
    public function delete($id): ResponseInterface
    {
        return $this->respondDeleted($this->itemCatModel->delete($id));
    }
}
