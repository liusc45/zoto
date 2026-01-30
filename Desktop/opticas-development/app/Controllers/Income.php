<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\IncomeModel;
use App\Models\PaymentModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Income extends BaseController
{
    use ResponseTrait;
    protected $incomeModel;
    protected $paymentModel;

    public function __construct()
    {
        $this->incomeModel = new IncomeModel();
        $this->paymentModel = new PaymentModel();
    }
    public function index()
    {
        return $this->respond($this->incomeModel->findAll());
    }

    public function create()
    {
        $date = date("Y-m-d H:i:s", time());
        $globalData = $this->request->getPost();

        $incomeData = [
            'concept' => $globalData['concept'],
            'amount' => $globalData['amount'],
            'comments' => $globalData['comments'],
            'applied' => $globalData['applied'],
            'created_by' => $globalData['created_by'],
            'responsible' => $globalData['responsible'],
            'created_at' => $date
        ];

        $paymentData = [
            'amount' => $globalData['amount'],
            'created_by'=>$globalData['created_by'],
            'payment_type' => $globalData['payment_type'],
            'created_at' => $globalData['applied']
        ];

        try{
            $insertedPayment = $this->paymentModel->save(new \App\Entities\Payment($paymentData));
            $payment = $this->paymentModel->find($this->paymentModel->getInsertID());
            $incomeData["payment"] = $payment->id;
            $insertedIncome = $this->incomeModel->save(new \App\Entities\Income($incomeData));
        }catch (\ReflectionException $e){
            return $this->fail($e->getMessage());
        }

        if ($insertedIncome && $insertedPayment) {
            return $this->respondCreated([
                'payment' => $payment,
                'income' => $this->incomeModel->find($this->incomeModel->getInsertID())
            ]);
        }
    }

    public function delete($id): ResponseInterface
    {
        $income = $this->incomeModel->find($id);
        $payment = $this->paymentModel->delete($income->payment);
        return $this->respondDeleted($this->incomeModel->delete($id));
    }
}
