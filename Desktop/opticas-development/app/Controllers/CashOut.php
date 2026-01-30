<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaymentModel;
use App\Models\SaleModel;
use App\Models\UserModel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Database;

class CashOut extends BaseController
{
    public function index()
    {
        $sales = new SaleModel();
		$user = new UserModel();
        $payments = new PaymentModel();
        $select = [
            "si.qty",
            "i.name as item",
            " sales.amount"
        ];
        $salesAtDay = $sales->select($select)
            ->join("sale_items si","si.sale = sales.id")
            ->join('items i', "i.id = si.item")
            ->where([
                "date(sales.created_at)" => date("Y-m-d"),
                "sales.created_by" => auth()->user()->id
            ])->findAll();

        $partialPayments = $payments->select([
            "s.id",
            "payments.amount as abono"
        ])
            ->join("sales s", "s.id = payments.sale")
            ->where([
                "date(payments.created_at)" => date("Y-m-d"),
                "payments.created_by" => auth()->user()->id,

            ])
            ->where("date(payments.created_at) > date(s.created_at)")
			->findAll();


        $paymentsByType = $payments->select([
            "payments.payment_type",
            "sum(amount) as amount"])
            ->where([
                "created_by"=>auth()->user()->id,
                "date(payments.created_at)" => date("Y-m-d"),
            ])
            ->groupBy("payments.payment_type")->findAll();

		$user = $user->find(auth()->user()->id);

        return view("components/sale/ticket_cashout", ["sales"=>$salesAtDay,"partials"=>$partialPayments,"payments"=>$paymentsByType, "user"=>$user]);
    }



}
