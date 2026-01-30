<?php
namespace App\Services;

use App\Entities\Credit;
use App\Models\ExpensesModel;
use App\Models\PaymentModel;
use App\Models\SaleModel;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Database\Config;
use CodeIgniter\I18n\Time;
use Config\Database;

class ReportService
{
    protected SaleModel $saleModel;
    protected ExpensesModel $expenseModel;
    protected $select;
    protected $expense;
    protected BaseConnection $db;
    
    public function __construct()
    {
        $this->db = Database::connect();
        $this->saleModel = new SaleModel();
        $this->expenseModel = new ExpensesModel();
        $this->select = $this->saleModel->select("coalesce(sum(sales.amount),0) amount");
        $this->expense = $this->expenseModel->select("coalesce(sum(expenses.amount),0) amount");
    }
    
    public function index(Time|array $date): array
    {
		return [
            "sales_today" => $this->today($date),
            "credit_amount" => $this->credits($date),
            "debt" => $this->total_debt(),
            "expenses_today" => $this->expensesToday($date),
            "sales_week" => $this->week($date), //7 días de la semana
            "byStore" => $this->byStore($date),
            "byStoreWeek" => $this->byStoreWeek(),
            "byUser" => $this->byUserToday($date),
            "byUserWeek" => $this->byUserWeek($date),
            "TopCategories" => $this->topCategorySold(),
            "topArticles" => $this->topItemsSold(),
            "monthly" => $this->monthly($date),
            "utility"=> $this->bestUtility($date),
            "deposits"=>$this->deposit($date),
        ];

    }
    
    public function today($date)
    {
		if(is_array($date)){
			$where = $date["start"] === $date["end"] ?
				["date(p.created_at)" => $date["start"]] :
				["date(p.created_at) >=" => $date["start"], "date(p.created_at) <=" => $date["end"]];
		} else{
			$where = [
                "date(p.created_at)" => $date,
                "p.deleted_at" => null,
                
                ];
		}
        $where["p.deleted_at"] = null;
        $paymentQueries = $this->db->table("payments p")
            ->select("coalesce(sum(p.amount),0) amount")
            ->where($where)
			->whereNotIn("payment_type", ["credit"]);
        $total = $paymentQueries->get(null, 0, false)->getRow();
        $payment_type = $paymentQueries
            ->select("payment_type")
            ->groupBy("payment_type")
            ->get()->getResult();
        
        return [
            "totalEarningToday" => $total,
            "totalEarningbyType" => $payment_type];
        
    }
    
    public function expensesToday($date): object|array|null
    {
		if(is_array($date)){
			$where = $date["start"] === $date["end"] ?
				["date(created_at)" => $date["start"]] :
				["date(created_at) >=" => $date["start"], "date(created_at) <=" => $date["end"]];
		} else{
			$where = ["date(created_at)" => $date];
		}
        return $this->expense->where($where)->first();
    }
    
    public function week(): object|array|null
    {
		$today = Time::today();
		$lastSevenDays = $today->subDays(7);

        return $this->saleModel
            ->select("coalesce(sum(p.amount),0) amount")
            ->join("payments p", "p.sale = sales.id")
            ->where(["date(sales.created_at) >=" => $lastSevenDays])
            ->first();
    }
    
    public function byStore($date): array
    {
		if(is_array($date)){
			$where = $date["start"] === $date["end"] ?
				["date(s.created_at)" => $date["start"]] :
				["date(s.created_at) >=" => $date["start"], "date(s.created_at) <=" => $date["end"]];
		} else{
			$where = ["date(s.created_at)" => $date];
		}
        
        return $this->db->table("stores st ")
            ->select("st.name , coalesce(sum(s.amount),0) amount")
            ->join("sales s ", "s.store = st.id", "left")
            ->where($where)
            ->groupBy("st.id")
            ->get()->getResultObject();
        
    }
    
    public function byStoreWeek(): array
    {
		$today = Time::today();
		$lastSevenDays = $today->subDays(7);

        $stores = $this->db->table("stores st ")
            ->select(" date(s.created_at) saled_at,st.id, st.name ,  coalesce(sum(s.amount),0) amount")
            ->join("sales s ", "s.store = st.id", "left")
            ->where("date(s.created_at)>=", $lastSevenDays)
            ->groupBy("st.id, date(s.created_at)")
            ->orderBy("date(s.created_at) ASC, amount DESC")
            ->get()->getResultObject();
        $dates = $this->getSevenDates($lastSevenDays);
        $series = [];

        
        foreach($stores as $store){
            foreach($dates as $key =>$curDate){
               if($curDate ===$store->saled_at){
                   if(!isset($series[$store->id]["data"][$key]) || $series[$store->id]["data"][$key]===0){
                       $series[$store->id]["name"] = $store->name;
                       $series[$store->id]["data"][$key] = floatval( $store->amount);
                       //break;
                   }

               }else {
                   if(!isset($series[$store->id]["data"][$key])){
                       $series[$store->id]["data"][$key] =0;
                   }
               }
            }
        }
        
//        $dates = array_unique(array_column($stores, 'saled_at'), SORT_REGULAR);
        //$series = ["name" => array_column($stores, 'name')];
        return ["dates" => $dates , "series" => array_values($series)];
    }
    
    public function byUserToday($date): array
    {
		if(is_array($date)){
			$where = $date["start"] === $date["end"] ?
				["date(sales.created_at)" => $date["start"]] :
				["date(sales.created_at) >=" => $date["start"], "date(sales.created_at) <=" => $date["end"]];
		} else{
			$where = ["date(sales.created_at)" => $date];
		}
        $sales = $this->saleModel
            ->select("concat_ws(' ', p.name, p.last_name) username, sum(coalesce(sales.amount,0)) amount")
            ->join("users u  ", " sales.created_by = u.id", "")
            ->join("patients p2 ", " u.id = p2.user", "left")
            ->join("persons p ", " p.id = p2.user", "left")
            ->where($where)
            ->groupBy("u.id")
            ->orderBy("date(sales.created_at) ASC, amount DESC")
            ->findAll();
        
        return $sales;
        
    }
    
    public function byUserWeek($date): array
    {
		if(is_array($date)){
			$where = $date["start"] === $date["end"] ?
				["date(sales.created_at)" => $date["start"]] :
				["date(sales.created_at) >=" => $date["start"], "date(sales.created_at) <=" => $date["end"]];
		} else{
			$where = ["date(sales.created_at)" => $date];
		}

        $sales = $this->saleModel
            ->select("date(sales.created_at) date, username, sum(coalesce(sales.amount,0)) amount")
            ->join("users u  ", " sales.created_by = u.id", "")
            ->where($where)
            ->groupBy("u.id")
            ->orderBy("date(sales.created_at) ASC, amount DESC")
            ->findAll();
        
        return $sales;
    }
    
    public function credits($date)
    {
		if(is_array($date)){
			$where = $date["start"] === $date["end"] ?
				["date(c.created_at)" => $date["start"]] :
				["date(c.created_at) >=" => $date["start"], "date(c.created_at) <=" => $date["end"]];
		} else{
			$where = ["date(c.created_at)" => $date];
		}

        $payments = $this->db->table("credits c");
        return $payments
            ->select("coalesce(sum(c.financing),0) amount")
            ->where($where)
            //->getCompiledSelect();
            ->get()
            ->getRow();
    }
    
    public function total_debt(): string|object|array
    {
        $credits= $this->saleModel
            ->select("c.financing-sum(p.amount) amount")
            ->where([
                "sales.payment_type" => "credit",
            ])
            ->where("p.credit IS NOT NULL")
            ->join("payments p", "p.sale = sales.id")
            ->join("credits c", "c.sale = sales.id")
            ->groupBy("sales.id")
            ->findAll();
        return new Credit([
            "amount"=>  array_sum( array_column($credits, "amount"))
        ]);
    }

    public function topCategorySold():array
    {
       $saleItems =   $this->db->table("sale_items si");

       return $saleItems->selectCount("si.id ","sales")
           ->select("ic.name category")
           ->join( "items i", " si.item  = i.id")
           ->join("lines ic","ic.id = i.line")
           ->groupBy("ic.id")->orderBy("1 DESC")
           ->get()->getResultObject();
    }

    public function topItemsSold(): array
    {
        $saleItems =   $this->db->table("sale_items si");

        return $saleItems->selectCount("si.id ","sales")
            ->select("i.name item")
            ->join( "items i", " si.item  = i.id")
            ->groupBy("i.id")->orderBy("1 DESC")
            ->get()->getResultObject();
    }
    
    private function getSevenDates($date):array
    {
        $dates = [];
        $days = 7;
        for ($i = 0; $i < $days; $i++) {
            $dates[] = $date->addDays($i)->toDateString();
        }
        return $dates;
    
    }
    
    private function monthly(Time|array $date): array
    {
        $where = [];
        if(!is_array($date)){
            $where = [
                "month(sales.created_at)" => $date->getMonth(),
                "year(sales.created_at)" => $date->getYear(),
                "sales.deleted_at "=> null
            ];
        }else{
            $where = $date["start"] === $date["end"] ?
                ["date(sales.created_at)" => $date["start"]] :
                ["date(sales.created_at) >=" => $date["start"], "date(sales.created_at) <=" => $date["end"]];
        }
        $select = [
            "p2.name as user_name",
            "sum(si.qty) quantity",
            "i.id item",
            "i.name item_name",
            "i.cost unit_cost",
            "i.cost*sum(si.qty) sales_cost",
            //"coalesce(sales.discount,0)/si.qty discount",
            //"sum(si.unit_price*si.qty)-coalesce(sales.discount, 0)-(i.cost*sum(si.qty)) ganancia",
            "sum(si.unit_price*si.qty) sales"
        ];
        return $this->saleModel->select($select)
            ->select("case
            when sales.payment_type = 'cash' then 'efectivo'
            when sales.payment_type = 'transfer' then 'transferencia'
            when sales.payment_type = 'credit' then 'crédito'
            when sales.payment_type = 'card' then 'tarjeta'
            end tipo_pago")
            ->join("sale_items si ","si.sale = sales.id")
            ->join("items i","si.item = i.id")
            ->join("users u ","sales.created_by = u.id")
            ->join("patients p","u.id = p.user")
            ->join("persons p2","p.user = p2.id")
            ->where($where)
            ->groupBy("sales.id,i.id,tipo_pago")
            ->orderBy("i.id","ASC")
            ->findAll();
    }
    public function bestUtility($date):array{

        if(!is_array($date))
        {
            return [];
        }
        $saleItems =  $this->db->table("sale_items si");

        $select = [ "u.name as user_name",
        "s.created_by",
            "sum(si.qty) as sold_items",
            "sum(si.final_price) as sold",
            " sum(si.qty* i.cost) as final_cost",
            " (sum(si.final_price)-sum(si.qty*i.cost))-sum(coalesce(s.discount,0)) as difference"];

        $start = $date["start"];
        $end = $date["end"];
       return
           $saleItems
               ->select($select)
               ->join("items i" ,"si.item = i.id")
               ->join("sales s" , "si.sale = s.id and date(s.created_at)between '$start'  and '$end'" )
               ->join("users u ","u.id = s.created_by")
               ->groupBy("s.created_by")
               ->orderBY("difference DESC")
               ->where("s.deleted_at is null")
           ->get()->getResultObject();
    }
    
    private function deposit(Time|array $date)
    {
        $paymentModel = new PaymentModel();
        if(is_array($date)){
            $start = $date["start"];
            $end = $date["end"];
            $where = "date(payments.created_at) between '$start' and '$end'";
        }else{
             $where = "date(payments.created_at) = '$date'";

        }

        $deposits = $paymentModel
            ->select([
                "payments.amount",
                "payments.created_by",
                "date(payments.created_at) created_at",
                "case
                   when payments.aside = 1 then 'Apartado'
                   when payments.aside = 0 then 'Crédito'
                   end venta",
                "pe.name",
                "case
                    when payments.payment_type ='cash' then 'Efectivo'
                    when payments.payment_type = 'transfer' then 'Transferencia'
                    when payments.payment_type = 'card' then 'Tarjeta'
                end tipo_pago",
            ])
            ->join ("sales s"," payments.sale = s.id")
            ->join("patients p","s.patient = p.id")
            ->join( "persons pe" ," p.person = pe.id")
            ->where($where)
            ->where("payments.credit is not null")
            ->orderBy("payments.created_at", "DESC")
            ->findAll();
        
        
        return $deposits;

    }
    
}
