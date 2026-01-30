<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Company;
use App\Models\AsideModel;
use App\Models\SaleItemsModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;

class Aside extends BaseController
{
	use ResponseTrait;
    protected array $payment_types = [
        "cash"=> "Efectivo",
        "transfer"=> "Transferencia",
        "card"=>"Tarjeta",
    ];
	protected asideModel $asideModel;

	public function __construct()
	{
		$this->asideModel = new AsideModel();
	}

	public function index()
    {

    }
    public function delete($id)
    {
        $aside = $this->asideModel->find($id);
        $deleted = $this->asideModel->delete($id);
        return $deleted? $this->respondDeleted($aside):$this->asideModel->errors();
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
            "sales.discount ",
            "sales.amount",
            "sales.delivery",
            "sales.created_by",
            "sales.created_at",
            "c.id customer",
            "concat_ws(' ',c.name,c.last_name) customer_name",
            "c.address customer_address",


        ];
        $saleModel = new \App\Models\SaleModel();


        $sale = $saleModel
            ->select($select)
            ->join("customers c ","c.id = sales.customer")
            ->join("users u","u.id = sales.created_by")
            ->join("stores st", "st.id = sales.store")
            ->where(["uuid"=>$uuid])
            ->first();
        $credit = $this->asideModel->where(["sale"=>$sale->id])->first();

        $paymentModel = new \App\Models\PaymentModel();
        $payments = $paymentModel->where([
            "sale"=>$sale->id,
            "credit"=>$credit->id,
            "aside"=>1
        ])->findAll();
        $saleItems = model(SaleItemsModel::class)->where(["sale"=>$sale->id])
            ->join("items i","i.id = sale_items.item")
            ->findAll();

        $html  = view("components/sale/ticket_deposit",[
            "sales"=>$sale,
            "items"=>$saleItems,
            "company"=>$company,
            "sale_type" =>"Apartado",
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
    public function items($id): ResponseInterface
    {
        $items = $this->asideModel
            ->select([
                "group_concat(i.name) item_name",
            ])
            ->join('sales as s', 's.id = asides.sale')
            ->join('sale_items as si', 'si.sale = s.id')
            ->join('items as i', 'i.id = si.item')
            ->where("asides.id",$id)
            ->first();
        return $this->respond($items);
        
    }
}
