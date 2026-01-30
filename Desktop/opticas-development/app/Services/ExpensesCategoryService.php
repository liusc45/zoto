<?php
namespace App\Services;


use App\Entities\ExpensesCategory;
use App\Models\ExpensesCategoryModel;
use ReflectionException;

class ExpensesCategoryService
{
    
    private ExpensesCategoryModel $categoryModel;
    
    public function __construct()
    {
        $this->categoryModel = new ExpensesCategoryModel();
    }
    
    
    public function setCategory(ExpensesCategory $category)
    {
        try {
            $newCategoryId = $this->categoryModel->insert($category);
        }catch (ReflectionException $e){
            return [
                "success"=>false,
                "errors"=>$e->getMessage(),
            ];
        }
        
        if(is_bool($newCategoryId))
        {
            return [
                "success"=>false,
                "errors"=>$this->categoryModel->errors()
            ];
        }
        
        return  $this->categoryModel->find($newCategoryId);
        
        
    }
    public function getCategoryId($category)
    {
        if(is_numeric($category)){
            $categoryId =  $category;
        }elseif(empty($category)){
            $categoryId = 2;
        }
        else{
            
            $found = $this->categoryModel
                ->where("name",$category)
                ->first();
            if(is_null($found))
            {
                $entity = new ExpensesCategory(["name"=>$category,"description"=>$category]);
                try {
                    $categoryId   = $this->categoryModel->insert($entity);
                } catch (ReflectionException $e) {
                    return ["errors"=>$e->getMessage()];
                }
                
            }else{
                $categoryId = $found->id ;
            }
        }
        
        
        return $categoryId;
    }
    
    
}
