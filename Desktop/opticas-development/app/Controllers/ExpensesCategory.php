<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ExpensesCategoryModel;
use App\Services\ExpensesCategoryService;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\Response;
use CodeIgniter\HTTP\ResponseInterface;
use ReflectionException;

class ExpensesCategory extends BaseController
{
    use ResponseTrait;
    protected ExpensesCategoryModel $categoryModel ;
    private ExpensesCategoryService $categoryService;
    
    public function __construct()
    {
        $this->categoryService = new ExpensesCategoryService();
        $this->categoryModel = new ExpensesCategoryModel();
    }
    
    public function index(): ResponseInterface
    {
        return $this->respond($this->categoryModel->findAll());
    }
    
    /**
     * @throws ReflectionException
     */
    public function create(): ResponseInterface
    {
        $category = new \App\Entities\ExpensesCategory();
        $category->fill($this->request->getPost());
        
        $newCategoryId = $this->categoryService->setCategory($category);
        
        if($newCategoryId instanceof  \App\Entities\Category)
        {
            return  $this->respondCreated($this->categoryModel->find($newCategoryId));
            
        }
        return $this->respond($this->categoryModel->errors(), ResponseInterface::HTTP_BAD_REQUEST);
        
        
    }
    
    public function show(int $id): ResponseInterface
    {
        
        return $this->respond( $this->categoryModel->find($id));
    }
    
    /**
     * @throws ReflectionException
     */
    public function update($id): ResponseInterface
    {
        $category = $this->categoryModel->find($id);
        
        $category->fill($this->request->getRawInput());
        $updated=$this->categoryModel->save($category);
        if($updated){
            $return =  $this->respondUpdated($category);
        }else {
            $return = $this->respond([
                "error"=>$this->categoryModel->errors()
            ],ResponseInterface::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        return $return;
        
    }
    public function delete($id): ResponseInterface
    {
        return $this->respondDeleted([
            "deleted "=>$this->categoryModel->delete($id)
        ]);
    }
    
}
