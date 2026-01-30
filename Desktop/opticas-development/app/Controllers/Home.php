<?php

namespace App\Controllers;

use App\Models\BankAccountModel;
use App\Models\ItemModel;
use App\Models\BrandModel;
use App\Models\ColorModel;
use App\Models\CompanyModel;
use App\Models\ExpensesCategoryModel;
use App\Models\LineModel;
use App\Models\MaterialModel;
use App\Models\OccupationModel;
use App\Models\PatientModel;
use App\Models\PaymentCardModel;
use App\Models\PersonTaxModel;
use App\Services\AsideService;
use App\Services\InventoryService;
use App\Services\LensService;
use App\Services\PatientService;
use App\Services\PrescriptionService;
use App\Services\ReportService;
use App\Services\SaleService;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\I18n\Time;

class Home extends BaseController
{


    public function sale(): string
    {
        helper("inflector");
		$today = Time::today();
		$report = new ReportService();
        $reports = [];
        $lensService = new LensService();
        $data =[
            "lines" => model(LineModel::class)->findAll(),
            "catalogs" => $lensService->getCatalogs(),
            ...$lensService->getCatalogsData(),
            "accounts" => model(BankAccountModel::class)->findAll(),
            "cards" => model(PaymentCardModel::class)->where("active",true)->findAll(),
        ];
        
        
        if(auth()->user()->inGroup("admin")) {
            $reports['sales_today'] = $report->today($today);
            $reports['sales_week'] = $report->week();
            $reports['expenses_today'] = $report->expensesToday($today);
            $reports['debt'] = $report->total_debt();
        }
        
        
		$data['reports'] = $reports;
		$data['date'] = $today;
		$data['path'] = '/mostrador';
		$data['title'] = 'Mostrador';
        return view('components/sale', $data);
    }

    public function store(): string
    {
        $this->viewData['path'] = '/tiendas';
        $this->viewData['title'] = 'Tiendas';
        return view('components/store', $this->viewData);
    }

    public function articles(): string
    {
        $this->viewData['path'] = '/articulos';
        $this->viewData['title'] = 'Artículos';
        $this->viewData['lines'] = (new LineModel())
                                        ->orderBy('id', 'ASC')
                                        ->findAll();
        $this->viewData['suppliers'] = (new CompanyModel())
                                        ->where('type','supplier')
                                        ->orderBy('id', 'ASC')
                                        ->findAll();
        $this->viewData['brands'] = (new BrandModel())
                                        ->orderBy('id', 'ASC')
                                        ->findAll();
        $this->viewData['colors'] = (new ColorModel())
                                        ->orderBy('id', 'ASC')
                                        ->findAll();
        $this->viewData['materials'] = (new MaterialModel())
                                        ->orderBy('id', 'ASC')
                                        ->findAll();
        $this->viewData['styles'] = ['full'=>'Armazón completo','slotted'=> 'Ranurado','pieces'=> '3 Piezas'];
        return view('components/article/main', $this->viewData);
    }

    public function categories(): string
    {

        $this->viewData['path'] = '/categorias';
        $this->viewData['title'] = 'Categorías';
        return view('components/categories', $this->viewData);
    }

    public function suppliers(): string
    {
        $this->viewData['path'] = '/proveedores';
        $this->viewData['title'] = 'Proveedores';
        return view('components/companies/companies', $this->viewData);
    }

    public function labs(): string
    {
        $this->viewData['path'] = '/laboratorios';
        $this->viewData['title'] = 'Laboratorios';
        return view('components/companies/companies', $this->viewData);
    }

    public function contracts(): string
    {
        $this->viewData['path'] = '/convenios';
        $this->viewData['title'] = 'Convenios';
        return view('components/companies/companies', $this->viewData);
    }

    public function users(): string
    {
        $this->viewData['path'] = '/usuarios';
        $this->viewData['title'] = 'Usuarios';
        return view('components/users', $this->viewData);
    }

    public function patients(): string
    {
        $this->viewData['title'] = 'Pacientes';
        $data=[
            "next_card"=> model(PatientModel::class)
                ->select("max(card_id)+1 card_id")

                ->first(),
            ...$this->viewData,
            "occupations"=> model(OccupationModel::class)->findAll(),
            "companies"=> model(CompanyModel::class)->where(['type'=>'contract'])->findAll(),
        ];


        return view('components/patients',$data);
    }

    public function birthdays(): string
    {
        $birthdays = model(PatientModel::class)
            ->select([
                "patients.id",
                "patients.card_id",
                "persons.name",
                "persons.last_name",
                "persons.dob",
                "persons.main_phone",
            ])
            ->join("persons","persons.id = patients.person","left")
            ->where(["patients.store"=>session("store")->id])
            ->where("DATE_FORMAT(persons.dob, '%m-%d') = DATE_FORMAT(CURRENT_DATE(), '%m-%d')")
            ->findAll();
        $this->viewData['title'] = 'Cumpleañeros de hoy';
        return view('components/patients_birthdays', [
            ...$this->viewData,
            "birthdays" => $birthdays,
        ]);
    }

    public function patientDetail($id): RedirectResponse| string
    {
        if($id === '0') {
            $person = $this->request->getGet("person");
            try {
                $patient = (new PatientService)->setPatient($person);
                return redirect()->to("/nueva-consulta/".$patient->id);
            } catch (\ReflectionException $e) {
                return  redirect()->back()->with("error",$e->getMessage());
            }
        }
        $this->viewData['title'] = 'Paciente';
        $patientService = new PatientService();
        $patient = $patientService->getPatient($id);
        $data = [
            ...$this->viewData,
            "taxInfo"=> model(PersonTaxModel::class)->where(['person'=>$patient->person])->findAll(),
            "patient"=>$patient,
            "person"=>$this->request->getGet("person"),
            "prescriptions" => (new PrescriptionService)->getAllByPatient($patient->id),
            "sales" => (new SaleService)->getSaleByPatient($patient),


        ];


        return view('components/patients/detail',$data);
    }

    public function inventory(): string
    {
        helper("number");
        $inventory = new InventoryService();
        $this->viewData['path'] = '/inventario';
        $this->viewData['title'] = 'Inventario';
        $this->viewData['inventoryStats'] = $inventory->inventoryCost();
        return view('components/inventory', $this->viewData);
    }

    public function salesHistory(): string
    {
        $this->viewData['path'] = '/ventas';
        $this->viewData['title'] = 'Ventas';
        return view('components/salesHistory', $this->viewData);
    }

    public function profile(): string
    {
        $this->viewData['path'] = '/perfil';
        $this->viewData['title'] = 'Perfil';
        return view('components/profile', $this->viewData);
    }

    public function mySales(): string
    {
        $this->viewData['path'] = '/mis-ventas';
        $this->viewData['title'] = 'Mis Ventas';
        return view('components/my-sales', $this->viewData);
    }

    public function deliver(): string
    {
        $this->viewData['path'] = '/entregas';
        $this->viewData['title'] = 'Entregas';
        return view('components/deliver', $this->viewData);
    }

    public function historyItem($store, $item)
    {
        $inventory = new InventoryService();
        $history = $inventory->getInventory($store,"item",$item);
        $this->viewData['path'] = '/detalle';
        $this->viewData['title'] = 'Detalle';
        $this->viewData['history'] = $history;
       
        $export = $this->request->getGet("export");
        if($export==="xls") {
            $view = "xls";
            
            header("Pragma: public");
            header("Expires: 0");
            $filename ="Inventarios_".$history[0]->code."_".$history[0]->item_name.".xls";
            header("Content-type: application/x-msdownload");
            header("Content-Disposition: attachment; filename=$filename");
            header("Pragma: no-cache");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            
            
        } else {
            $view = "detail";
        }
       
        return view('components/inventory_'.$view, $this->viewData);
    }
    
    public function reports()
	{
		$range = $this->request->getGet();
		$today = empty($range) ? Time::today() : $range;
		$report = new ReportService();
		$reports = $report->index($today);
		$this->viewData['path'] = '/reportes';
		$this->viewData['title'] = 'Reportes';
		$this->viewData['reports'] = $reports;
		$this->viewData['date'] = $today;
		return view('components/report', $this->viewData);
	}

	public function credits(): string
	{
		$this->viewData['path'] = '/creditos';
		$this->viewData['title'] = 'Créditos';
		return view('components/credits', $this->viewData);
	}

	public function transfers(): string
	{
		$this->viewData['path'] = '/traspasos';
		$this->viewData['title'] = 'Traspasos';
		return view('components/transfers', $this->viewData);
	}

	public function aside(): string
	{
		$this->viewData['path'] = '/apartados';
		$this->viewData['title'] = 'Apartados';
		$aside = new AsideService();
		$asides = $aside->list();
		$this->viewData['asides'] = $asides;
		return view('components/aside', $this->viewData);
	}

    public function incomes(): string
    {
        $this->viewData['path'] = '/ingresos';
        $this->viewData['title'] = 'Ingresos';
        $this->viewData["today"] = date('Y-m-d');
        $this->viewData["categories"] = model(ExpensesCategoryModel::class)->findAll();
        $this->viewData["users"] = auth()->getProvider()->findAll();
        return view('components/incomes', $this->viewData);
    }

    public function occupations(): string
    {
        $this->viewData['path'] = '/occupaciones';
        $this->viewData['title'] = 'Ocupaciones';
        return view('components/occupations', $this->viewData);
    }

    public function warranty(): string
    {
        $this->viewData['path'] = '/garantias';
        $this->viewData['title'] = 'Garantías';
        return view('components/warranty', $this->viewData);
    }

    public function receipts(): string
    {
        $this->viewData['path'] = '/facturas';
        $this->viewData['title'] = 'Facturas';
        return view('components/receipts', $this->viewData);
    }

    public function purchases():string
    {
        $this->viewData['path'] = '/compras';
        $this->viewData['title'] = 'Compras';
        $this->viewData['providers'] = model(CompanyModel::class)->where('type', 'supplier')->findAll();
        $this->viewData['articles'] = model(ItemModel::class)->findAll();
        return view('components/purchases', $this->viewData);
    }
    
    public function paymentCards():string
    {
        $this->viewData['path'] = '/tarjetas-pago';
        $this->viewData['title'] = 'Tarjetas de Pago';
        $this->viewData['accounts'] = model(BankAccountModel::class)->findAll();
        return view('components/payment_cards', $this->viewData);
    }
}
