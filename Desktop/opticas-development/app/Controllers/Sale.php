<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Company;
use App\Entities\Payment;
use App\Entities\SaleItem;
use App\Models\CreditModel;
use App\Models\PaymentModel;
use App\Models\SaleItemsModel;
use App\Models\SaleModel;
use App\Models\StoreModel;
use App\Services\AsideService;
use App\Services\ConsultationService;
use App\Services\CreditService;
use App\Services\DiscountService;
use App\Services\EmployeeService;
use App\Services\InventoryService;
use App\Services\PaymentService;
use App\Services\SaleItemService;
use App\Models\SalePromotionModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;
use FPDF;
use Ramsey\Uuid\Uuid;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Html2Pdf;
use function Sodium\add;

class Sale extends BaseController
{
    use ResponseTrait;
    protected SaleModel $saleModel;
    protected array $payment_types = [
        "cash"=> "Efectivo",
        "transfer"=> "Transferencia",
        "card"=>"Tarjeta",
        "credit"=> "Crédito de la tienda",
        "multi" => "Multipago"
    ];
    
    protected  array $types =[
        "cash"=>"Contado",
        "aside"=>"Apartado",
        "credit"=>"Credito"
    ];

    public function __construct()
    {
        $this->saleModel = new SaleModel();
    }
    
    public function index(): ResponseInterface
    {
        $dates = $this->request->getGet();
       
        $where = !isset($dates["start"])?
            []:
            ["date(sales.created_at) >="=>$dates["start"], "date(sales.created_at) <="=>$dates["end"] ];
        $sales = $this->saleModel

            ->select([
                "distinct sales.id,sales.uuid,sales.type,sales.amount,sales.created_at",
                "users.username",
                "sale_items.patient patient",
                "COALESCE(NULLIF(CONCAT_WS(' ', persons.name, persons.last_name), ''), 'público en general') as patients",
                "GROUP_CONCAT(DISTINCT items.key ORDER BY items.key SEPARATOR ', ') as sold_items",

            ],false)
            ->join("users", "users.id = sales.created_by")
            ->join("sale_items","sale_items.sale = sales.id")
            ->join("patients p","p.id = sale_items.patient","left")
            ->join("persons","p.person = persons.id","left")
            ->join("items","items.id = sale_items.item")
            ->where($where)
            ->where(["sales.store" =>session("store")->id])
            ->groupBy("sales.id, sales.uuid, sales.type, sales.amount, sales.created_at, users.username, sale_items.patient, persons.name, persons.last_name")
            ->findAll();
       
        return $this->respond($sales);
        
    }
    
    public function show($id)
    {
        $sale =  is_numeric($id)?
            $this->saleModel->find($id):
            $this->saleModel->where(["uuid"=>$id])->first();
        return $this->respond($sale);
    }
    public function create()
    {
        $sale = new \App\Entities\Sale($this->request->getPost());
        $isAside = $this->request->getPost("type")==="aside";
        $payments = $this->request->getPost("payments");
        $discounts = $this->request->getPost("discounts");
        $credit = null;
        $sale->fill([
            "uuid"=> Uuid::uuid6()->toString(),
            "patient" => $this->request->getPost("customer")===''?null:$this->request->getPost("customer"),
            "created_by"=> auth()->user()->id
            ]);
        $this->saleModel->db->transStart();
        try {
            $sold = $this->saleModel->save($sale);
            $sale->id = $this->saleModel->getInsertID();

            if($sold){
                $saleItemService = new SaleItemService();
                $decreased =  $saleItemService->setSaleItems($sale,$this->request->getPost("cart"));

                $updatedConsultations = (new ConsultationService)
                    ->consultationSale($sale,$this->request->getPost("consultations"));

                if(!$decreased)
                {

                    $this->saleModel->delete($sale->id);
                    return $this->failValidationErrors($saleItemService->getErrors());
                }
                /*Cambia la funcionalidad ahora debes saber el tipo de venta. */
                if($sale->type ==="credit")
                {
                    $credit = (new CreditService)->create( $sale);
                }
                if($sale->type ==="aside")
                {
                    $credit  = (new AsideService)->create( $sale);
                }
                $creditId = is_null($credit)?null:$credit->id;
                $discount = (new DiscountService)->create($sale,$discounts);
                if(!is_null($payments)){
                    foreach($payments as $payment){
                        $payment = (object)$payment;
                        
                        $payment = new Payment([
                            "credit"=>$creditId,
                            "sale"=>$sale->id,
                            "aside"=>$isAside,
                            "payment_type"=>$payment->type,
                            "amount"=>$payment->amount,
                            "aut"=>$payment->aut??null,
                            "cash"=>$payment->received??$payment->amount,
                            "cashback"=>$payment->cashback??'',
                            "created_by"=>auth()->user()->id
                        ]);
                        $paid =  $sale->pay($payment);
                        
                    }
                    
                }else{
                    $paid =  $sale->pay();
                }

                // Persistir promociones aplicadas (si el POS las envió)
                $appliedPromotions = $this->request->getPost('applied_promotions');
                if (is_array($appliedPromotions) && !empty($appliedPromotions)) {
                    $spModel = new SalePromotionModel();
                    foreach ($appliedPromotions as $ap) {
                        // Limpiar/normalizar
                        $promotionId = isset($ap['promotion']) && is_numeric($ap['promotion']) ? (int)$ap['promotion'] : null;
                        $promoCode = isset($ap['promo_code']) ? (string)$ap['promo_code'] : null;
                        $discountAmount = isset($ap['discount_amount']) ? (float)$ap['discount_amount'] : 0.0;
                        $meta = isset($ap['meta']) && is_array($ap['meta']) ? json_encode($ap['meta']) : null;
                        if ($discountAmount <= 0) { continue; }
                        $spModel->insert([
                            'sale' => $sale->id,
                            'promotion' => $promotionId,
                            'promo_code' => $promoCode,
                            'discount_amount' => $discountAmount,
                            'meta' => $meta
                        ]);
                    }
                }

            }
        } catch (\ReflectionException | DatabaseException $e) {
            return $this->fail($e->getMessage());
        }
        $this->saleModel->db->transComplete();
        return $sold  ?$this->respondCreated([
            "sale"=>$sale,
            "items" => $decreased,
            "payments" => $sale->getFee(),
            "credit"=>$credit
            
        ]):$this->fail($this->saleModel->errors());
        
    }
    
    public function update($id): ResponseInterface
    {
        $sale = $this->saleModel->find($id);
        $sale->fill($this->request->getRawInput());
        try {
            $updated = $this->saleModel->save($sale);
        } catch (\ReflectionException $e) {
            return $this->fail($e->getMessage());
        }
        return $updated ? $this->respondUpdated($sale):$this->fail($sale);
    }
    
    public function delete($id): ResponseInterface
    {
        $sale= $this->saleModel->find($id);
        $saleItems = new saleItemService();
        $inventoryService = new InventoryService();
        $reason = null;

        $rollbackedInventory = $inventoryService->rollback($saleItems->getSaleItems($sale));
        
        if(!$rollbackedInventory){
            $reason = $inventoryService->getReason();
            return $this->fail($reason);
        }

        $paymentDeleted = $sale->deleteFee($id);
        $sale->fill(["paymentDeleted" => $paymentDeleted]);
        if($sale->type ==="credit" || $sale->type ==="aside" )
        {
            $model = ucfirst($sale->type)."Model";
            $creditModel = model($model);
            $credit = $creditModel->where(["sale"=>$sale->id])->first();
            $creditModel->delete($credit->id);
        }
        $this->saleModel->delete($id);

        return $this->respondDeleted($sale);
    }
    
    private function getLetterCurrency($amount): string
    {
        $separated = explode(".",$amount);
        
        $fmt = new \NumberFormatter('es_MX',\NumberFormatter::SPELLOUT);
        $pesos = $fmt->formatCurrency($separated[0],'MXN') ;
        $cents = count($separated)>1  ?  $separated[1] :'00' ;
        return    $pesos ." pesos ". $cents . "/100 m.n.";
    }
    
    public function ticket($uuid): string|ResponseInterface
    {
        helper("number");
        helper("inflector");
        $settings = service("settings");
        $company = new Company([
            "owner"=> humanize( mb_strtolower($settings->get("App.owner"),'UTF-8')),
            "rfc"=> $settings->get("App.RFC")
        ]) ;
        $select = [
            "sales.id",
            "sales.uuid",
            "sales.type",
            "payment_type",
            "sales.aut authorization",
            //"sales.discount ",
            "sales.amount",
            "sales.delivery",
            "sales.created_by",
            "sales.created_at",
            "sales.store",
            "st.name store_name",
            "p.id patient",
            "persons.id person",
            "concat_ws(' ',persons.name,persons.last_name) person_name",
           // "persons.address person_address"
        ];
        $sales = $this->saleModel
            ->select($select)
            ->where(["uuid"=>$uuid])
            ->join("patients p ","p.id = sales.patient","left")
            ->join("persons","p.person = persons.id","left")
            ->join("users u","u.id = sales.created_by","left")
            ->join("stores st", "st.id = sales.store",)
            ->first();



        if(!$sales instanceof \App\Entities\Sale){
            return $this->failNotFound();
        }
        $company->store = model(StoreModel::class)->find($sales->store);

        $saleItems = model(SaleItemsModel::class)
            ->select("sum(qty) qty,sale,item,unit_price,final_price, a.name")
            ->where(["sale"=>$sales->id])
            ->join("items a","a.id = sale_items.item")
            ->groupBy("sale, item")
            ->findAll();
        $payments = model(PaymentModel::class)->where(["sale"=>$sales->id])->findAll();

        // Obtener promociones aplicadas a la venta
        $salePromotions = model(SalePromotionModel::class)->where(['sale' => $sales->id])->findAll();
        $promoDiscountTotal = 0.0;
        foreach ($salePromotions as $sp) { $promoDiscountTotal += (float)($sp['discount_amount'] ?? 0); }
        
        $sales->payment =count($payments)>1 ? $payments:(!empty($payments)?$payments[0]:["cash"=>0,"cashback"=>0]);
        
            //->amount= (new PaymentService)->calculatePaid($payments);
        $sales->amount_letter = $this->getLetterCurrency($sales->amount);
        $html  = view("components/sale/ticket",[
            "sales"=>$sales,
            "items"=>$saleItems,
            "company"=>$company,
            "payment_types" =>$this->payment_types,
            "payments" => $payments,
            "type" =>	$this->types[$sales->type],
            "employee"=> EmployeeService::getEmployeeByUser($sales->created_by),
            "sale_promotions" => $salePromotions,
            "promo_discount_total" => $promoDiscountTotal
        ]);
		//dd($sales,$payments);
        $pdf = new Html2Pdf('P',[58,350]);
        $pdf->writeHTML($html);
        $this->response->setHeader("Content-Type","application/pdf");
       // dd($sales,$saleItems);
        try {
            return $pdf->output();
        } catch (Html2PdfException $e) {
            log_message("error",$e->getMessage());

            dd($e->getMessage());
        }
    }
    
    public function sales($field,$id)
    {
        $this->saleModel
            ->select("sales.*, users.username")
            ->join("users", "users.id = sales.created_by");
        if($field ==="store")
        {
            $this->saleModel
                ->where(["sales.store"=>$id]);
        }
        if($field ==="user")
        {
            $this->saleModel
                ->where(["sales.created_by"=>$id]);
        }
        $sales = $this->saleModel->findAll();
        //store || created_by
        return $this->respond($sales);
    }
    public function tickets(): string|ResponseInterface
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');
        $start = $this->request->getGet("start") ?? Time::today()->toDateString();
        $end = $this->request->getGet("end") ?? Time::today()->toDateString();
        helper("number");
        helper("inflector");
        $settings = service("settings");
        $company = new Company([
            "owner"=> humanize( mb_strtolower($settings->get("App.owner"),'UTF-8')),
            "rfc"=> $settings->get("App.RFC")
        ]) ;
        $sales = $this->saleModel
            ->select("uuid")
            ->where([
            "sales.created_at >="=> $start,
            "sales.created_at <="=> $end,
        ])->findAll();
        
        $html ='';
        foreach($sales as $sale){
            
            
            
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
                "sales.store",
                "st.name store_name",
                "c.id customer",
                "concat_ws(' ',c.name,c.last_name) customer_name",
                "c.address customer_address",
            
            
            ];
            $sales = $this->saleModel
                ->select($select)
                ->where(["uuid"=>$sale->uuid])
                ->join("customers c ","c.id = sales.customer")
                ->join("users u","u.id = sales.created_by")
                ->join("stores st", "st.id = sales.store")
                ->first();
            if(!$sales instanceof \App\Entities\Sale){
                return $this->failNotFound();
            }
            $company->store = model(StoreModel::class)->find($sales->store);
            
            $saleItems = model(SaleItemsModel::class)->where(["sale"=>$sales->id])
                ->join("items i","i.id = sale_items.item")
                ->findAll();
            $payments = model(PaymentModel::class)->where(["sale"=>$sales->id])->findAll();
            
            $sales->payment= count($payments)>1 ? $payments:(!empty($payments)?$payments[0]:["cash"=>0,"cashback"=>0]);
            $sales->amount_letter = $this->getLetterCurrency($sales->amount);
            
            $html .= view("components/sale/ticket",[
                "sales"=>$sales,
                "items"=>$saleItems,
                "company"=>$company,
                "payment_types" =>$this->payment_types,
                "payments" => $payments,
                
                "user"=> auth()->getProvider()->findById($sales->created_by)
            ]);

        }
        $pdf = new Html2Pdf('P',[58,350],'es');
        
        $pdf->writeHTML($html);
        
//        echo $html;exit;
        
        $this->response->setHeader("Content-Type","application/pdf");
        try {
            return $pdf->output();
        } catch (Html2PdfException $e) {
            log_message("error", $e->getMessage());
            return $this->fail($e->getMessage());
        }
    }
}
