<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InventoryModel;
use App\Models\PurchaseModel;
use App\Services\InventoryService;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;

class Purchase extends BaseController
{
    protected PurchaseModel $purchaseModel;
    public function __construct()
    {
        $this->purchaseModel = new PurchaseModel();
    }

    use ResponseTrait;
    public function index()
    {
        $purchases = $this->purchaseModel->findAll();


        return $this->respond($purchases);

    }

    public function create()
    {
        $purchase  = new \App\Entities\Purchase([
            "supplier" => $this->request->getPost("supplier"),
            "bill" => $this->request->getPost("bill"),
            "discount" => $this->request->getPost("discount"),
            "amount" => $this->request->getPost("amount"),
            "store" =>  session("store")->id,
            "created_by" => auth()->user()->id,
            "purchased_at" => $this->request->getPost("date")
        ]);
        try {
            $this->purchaseModel->save($purchase);

            foreach($this->request->getPost("articles") as $article) {

                if(is_array($article)){
                    $article = (object)$article;
                    $inventory = (new InventoryService)->setInventory(new \App\Entities\Inventory([
                        "item" => $article->id,
                        "supplier" => $purchase->supplier,
                        "store" => $purchase->store,
                        "stock" => $article->qty,
                        "bill" => $purchase->bill,
                        "purchase"=>$this->purchaseModel->getInsertID(),
                        "cost" => $article->cost,

                    ]), $this->request->getPost());
                }
            }
        }
        catch (\ReflectionException | DatabaseException $e) {
            return $this->fail($e->getMessage());
        }

        return is_bool($inventory)?$this->respondCreated($purchase):$this->fail($inventory);
    }

}
