<?php




namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\SaleModel;
use App\Services\ReportService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\I18n\Time;

class Report extends BaseController
{
    protected SaleModel $saleModel;
    protected ReportService $reportService;

    public function __construct()
    {
        #$this->saleModel = new SaleModel();
        $this->reportService = new ReportService();
    }
    public function index()
    {
        $date = $this->request->getGet("date")?? Time::today()->toDateString();
        return $this->response->setJSON($this->reportService->index($date));
    }


    public function today()
    {

    }
    public function emailme()
    {
        $date = $this->request->getGet("date")?? Time::today()->toDateString();
        $data= $this->response->setJSON($this->reportService->index($date));


        $html = view("report_pdf",$data);


        $pdf = new \PDF();
    }

    public function bestUtility(): ResponseInterface
    {
        return $this->response->setJSON($this->reportService->bestUtility($this->request->getGet()));
    }
}
