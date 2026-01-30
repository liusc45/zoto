<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Expense;
use App\Models\ExpensesCategoryModel;
use App\Services\ExpensesCategoryService;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ExpensesModel;
use Psr\Log\LoggerInterface;
use ReflectionException;

class Expenses extends BaseController
{
    use ResponseTrait;
    
    protected ExpensesModel  $expensesModel;
    
    public function __construct()
    {
        $this->expensesModel = new ExpensesModel();
    }
    
    
    public function index(): ResponseInterface
    {
        $expenses = $this->expensesModel
            ->select("expenses.id, expenses.concept, expenses.amount, concat_ws(' ',users.name,users.last_name) responsible,
              expenses.category category, ec.name category_name, expenses.applied , expenses.comments, expenses.reconciled ")
            ->join("expenses_category ec", "ec.id = expenses.category")
            ->join("users ", "users.id = expenses.responsible")
            ->findAll();
        return $this->respond($expenses );
    }

    public function show($id)
    {
        return $this->respond($this->expensesModel->find($id));
    }
    
    
    
    /*
     * api/expense/create
     * post data
     * */
    public function create(): ResponseInterface
    {
        $expense = new \App\Entities\Expense();
        $expense->fill($this->request->getPost());
        $categoryId = (new ExpensesCategoryService)->getCategoryId($this->request->getPost("category"));
        $expense->fill([
            "category"=>$categoryId,
            "applied" => $this->request->getPost("applied")??date(DATE_ATOM)//fecha a considerar
        ]);
        
        
        try{
            $insertedId = $this->expensesModel->insert($expense);
            
            if( is_bool($insertedId)){
                
                $return = $this->expensesModel->errors();
                $statusCode = ResponseInterface::HTTP_BAD_REQUEST;
            }else{
                $return = $this->expensesModel->find($insertedId);
                $statusCode = ResponseInterface::HTTP_OK;
            }
            
            
        }catch (ReflectionException $e) {
            $return = ["error"=>$e->getMessage()];
            $statusCode = ResponseInterface::HTTP_CONFLICT;
        }
        
        
        return $this->respond($return,$statusCode);
    }

    public function new(): string
    {
        $this->viewData['path'] = '/gastos';
        $this->viewData['title'] = 'Gastos';
        $this->viewData["today"] = date('Y-m-d');
        $this->viewData["categories"] = model(ExpensesCategoryModel::class)->findAll();
        $this->viewData["users"] = auth()->getProvider()->findAll();
        return view('components/expenses', $this->viewData);
    }


    public function update($id): ResponseInterface
    {
        $expense = $this->expensesModel
            ->find($id)
            ->fill($this->request->getRawInput());
        
        try {
            $updated = $this->expensesModel->save($expense);

        }catch (ReflectionException $e) {
            return $this->fail($e->getMessage());
        }
        if($updated){
            $return = $expense;
        }
        return $this->respondDeleted($return);
    }
    public function delete($id): ResponseInterface
    {
        return $this->respondDeleted($this->expensesModel->delete($id));
    }
    
}
