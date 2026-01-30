<?php

namespace App\Services;

use App\Entities\Order;
use App\Entities\Sale;
use App\Models\OrderModel;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\Request;

class OrderService
{
    protected OrderModel $orderModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
    }

    /**
     * @throws \ReflectionException
     */
    public function setOrder(Sale $sale, IncomingRequest $request): Order
    {
        $order = new Order([
            "sale" => $sale->id,
            "patients_number"=> $request->getPost("patients_number"),
            "status" => "pending",
        ]);

            $this->orderModel->save($order);
            $order->id =  $this->orderModel->getInsertID();
        return $order ;

    }

}