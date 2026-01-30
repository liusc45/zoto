<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Company;
use App\Models\CreditModel;
use App\Models\PaymentModel;
use App\Models\SaleItemsModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;

class Credit extends BaseController
{
    use ResponseTrait;
    protected CreditModel $creditModel;
    
    protected array $payment_types = [
        "cash"=> "Efectivo",
        "transfer"=> "Transferencia",
        "card"=>"Tarjeta",
    ];

    public function __construct()
    {
        $this->creditModel = new CreditModel();
    }

    public function index(): ResponseInterface
    {
        $dates = $this->request->getGet();
        $where = !isset($dates["start"])?[]:["date(credits.created_at) >="=>$dates["start"], "date(credits.created_at) <="=>$dates["end"] ];
        
        $select =[
            "credits.id",
            "s.id sale",
            "s.uuid",
            "c.id patient",
         //   "concat_ws(' ', c.name, c.last_name) customer_name",
            "s.created_at",
            "s.amount",
            "p.cash",
            "credits.financing",
            "(s.amount-sum(p.amount)) rest",
            "paid_at"];
        
        $credits = $this->creditModel->select($select)
            ->join("sales s ","credits.sale = s.id")
            ->join("payments p","p.credit = credits.id")
            ->join("patients c","c.id = credits.patient")
            ->where($where)
            ->groupBy("credits.id")
            ->findAll();
        return $this->respond($credits);
    }

    public function show($id): ResponseInterface
    {
        $credit = $this->creditModel->find($id);
        $payments  = model(PaymentModel::class)->where(["credit" => $id, "sale"=> $credit->sale, "aside"=>0])->findAll();
        $credit->partials = $payments;
        return $this->respond($credit);
    }
    public function create():void
    {

        $credit = new \App\Entities\Credit($this->request->getPost());
    }
    
    public function update($id): ResponseInterface
    {
        //
    }
    
    public function delete($id): ResponseInterface
    {
        $credit = $this->creditModel->find($id);
        $deleted = $this->creditModel->delete($id);
        
        return  $deleted ? $this->respondDeleted($credit): $this->fail($this->creditModel->errors());
    }
    
    public function ticket($uuid)
    {
        helper("number");
        helper("inflector");
        $settings = service("settings");
        $company = new Company([
            "owner"=> humanize( mb_strtolower($settings->get("App.owner"),'UTF-8')),
            "store"=> session("store"),
            "rfc"=> $settings->get("App.RFC")
        ]) ;
        
        $select = [
            "sales.id",
            "sales.uuid",
            "payment_type",
            "sales.aut authorization",
          //  "sales.discount ",
            "sales.amount",
            "sales.delivery",
            "sales.created_by",
            "sales.created_at",
            "c.id customer",
         //   "concat_ws(' ',c.name,c.last_name) customer_name",
           // "c.address customer_address",
        
        
        ];
        $saleModel = new \App\Models\SaleModel();
        
        
        $sale = $saleModel
            ->where(["uuid"=>$uuid])
            ->join("patients c ","c.id = sales.patient")
            ->join("users u","u.id = sales.created_by")
            ->join("stores st", "st.id = sales.store")
            ->select(
                implode(",",$select)
            )
            ->first();
        $credit = $this->creditModel->where(["sale"=>$sale->id])->first();
        
        $paymentModel = new \App\Models\PaymentModel();
        $payments = $paymentModel->where([
            "sale"=>$sale->id,
            "credit"=>$credit->id
        ])->findAll();
        $saleItems = model(SaleItemsModel::class)->where(["sale"=>$sale->id])
            ->join("items i","i.id = sale_items.item")
            ->findAll();
        
        $html  = view("components/sale/ticket_deposit",[
            "sales"=>$sale,
            "items"=>$saleItems,
            "company"=>$company,
            "payment_types" =>$this->payment_types,
            "payments"=>$payments,
            "user"=> auth()->getProvider()->findById($sale->created_by)
        ]);
        
        
        $pdf = new Html2Pdf('P',[58,350]);
        $pdf->writeHTML($html);
        $this->response->setHeader("Content-Type","application/pdf");
        try {
            return $pdf->output();
        } catch (Html2PdfException $e) {
            log_message("error",$e->getMessage());
        }
    
    
    }

}
