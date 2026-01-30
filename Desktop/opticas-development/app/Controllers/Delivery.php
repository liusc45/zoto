<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SaleModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class Delivery extends BaseController
{
    use ResponseTrait;
    protected SaleModel $saleModel;

    public function __construct()
    {
        $this->saleModel = new SaleModel();
    }

    public function index(): ResponseInterface
    {
        $select = [
            "sales.id sale",
            "sales.uuid",
            "sales.store",
            "sales.customer customer",
            "sales.payment_type",
            "sales.discount",
            "sales.amount",
            "sales.created_at",
            "group_concat(items.name) as article_names",
            "customers.name customer_name",
            "customers.last_name",
            "customers.phone",
            "customers.address"
        ];
        $toDeliver  = $this->saleModel
            ->select($select)
            ->join("sale_items", "sale_items.sale = sales.id")
            ->join("items", "items.id = sale_items.item")
            ->join("customers", "customers.id = sales.customer")
            ->where(["delivery"=>"pending"])
			->groupBy("sales.id")
            ->findAll();

        return $this->respond($toDeliver);

    }

    public function update($id = null): ResponseInterface
    {
        $sale = $this->saleModel->find($id);
        $sale->fill($this->request->getRawInput());
        $sale->fill(["updated_at" =>Time::now()]);
        try {
            $updated = $this->saleModel->save($sale);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());
        }
        return $updated?
            $this->respondUpdated($sale):
            $this->fail($this->saleModel->errors());
    }
}
