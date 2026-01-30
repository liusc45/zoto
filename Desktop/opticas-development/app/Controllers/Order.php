<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\LabModel;
use App\Models\LensModel;
use App\Models\OrderModel;
use App\Models\CompanyModel;
use App\Models\SaleItemsModel;
use App\Models\SaleModel;
use App\Services\PatientService;
use App\Services\SaleItemService;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;

class Order extends BaseController
{
    use ResponseTrait;
    protected OrderModel $orderModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
    }

    public function index()
    {
        $orders = $this->orderModel
            ->select([
                'orders.*',
                'persons.name as patient_name',
                'persons.last_name as patient_lastname',
                'companies.name as lab_name'
            ])
            ->join('sales', 'sales.id = orders.sale')
            ->join('patients', "sales.patient = patients.id")
            ->join('persons', "persons.id = patients.person")
            ->join('labs', "labs.id = orders.lab")
            ->join('companies', "companies.id = labs.company")
            ->findAll();
        return $this->respond($orders);
    }

    public function show($id = null)
    {
        $order = $this->orderModel->find($id);
        return $this->respond($order);
    }

    /**
     *
     * @return ResponseInterface
     */
    public function create(): ResponseInterface
    {
        $errors = [];
        $orders = $this->request->getPost("orders");
        if(is_array($orders)){
            $newOrders = [];
            foreach ($orders as $order) {
                $newOrder  = new \App\Entities\Order($order);
                $newOrder->sale = $this->request->getPost("sale");
                //$newOrder->vertex = json_encode($newOrder->vertex);
                $newOrders[] = $newOrder;
            }
        }else{
            return $this->fail("Sin datos de orden");
        }
        try {
           $save = $this->orderModel->insertBatch($newOrders);
        } catch (\ReflectionException | DatabaseException $e) {
            $errors = $e->getMessage();
            $save = false;
        }
        return $save ?
            $this->respondCreated($newOrders):
            $this->fail($errors);
    }

    /**
     * Update an order
     *
     * @param int $id
     * @return ResponseInterface
     */
    public function update($id = null): ResponseInterface
    {
        $order = $this->orderModel->find($id);

        if ($order === null) {
            return $this->failNotFound('Order not found');
        }

        $order->fill($this->request->getRawInput());

        try {
            $updated = $this->orderModel->save($order);
        } catch (\ReflectionException | DatabaseException $e) {
            return $this->fail($e->getMessage());
        }

        return $updated ? 
            $this->respondUpdated($this->orderModel->find($id)) : 
            $this->fail($this->orderModel->errors());
    }

    /**
     * Delete an order
     *
     * @param int $id
     * @return ResponseInterface
     */
    public function delete($id = null): ResponseInterface
    {
        $order = $this->orderModel->find($id);

        if ($order === null) {
            return $this->failNotFound('Order not found');
        }

        $deleted = $this->orderModel->delete($id);

        return $deleted ? 
            $this->respondDeleted(['id' => $id]) : 
            $this->fail('Failed to delete order');
    }

    /**
     * Render the orders view
     */
    public function main()
    {
        $consultationId = $this->request->getGet('consultation');
        $paramsToOrder = $this->request->getGet();

        $lenses = (new SaleItemService)->getSaleLens($paramsToOrder);


        $data = [
            'title' => 'Órdenes',
            'labs' => model(LabModel::class)->findAll(),
            'sales' => model(SaleModel::class)
                ->select('sales.*, persons.name as patient_name, persons.last_name as patient_lastname')
                ->join('patients', "patients.id = sales.patient")
                ->join('persons', "persons.id = patients.person")
                ->where('date(sales.created_at)', date('Y-m-d'))
                ->findAll(),
            'consultation_id' => $consultationId,
            "lenses" => $lenses,
        ];

        return view('components/order/main', $data);
    }
    public function new($saleId ,$patientId = null)
    {
        $saleItemsModel = new SaleItemsModel();
        if(!is_null($patientId)){
            $saleItemsModel->where('patient', $patientId);

        }

        $sale = model(SaleModel::class)->find($saleId);

        $saleItems =$saleItemsModel
            ->select([
                'sale_items.patient',
                'sale_items.item',
                'sale_items.item as item_obj',
                'sale_items.qty',
                'sale_items.unit_price',
                'persons.name as patient_name',
                'persons.last_name as patient_lastname',
                'items.key',
                'items.name as item_name',
            ])
            ->join('patients', "patients.id = sale_items.patient")
            ->join('persons', "persons.id = patients.person")
            ->join("items", "items.id = sale_items.item")
            ->where('sale', $saleId)->findAll();

        $patientService = new PatientService();
        $itemsToOrder = array_reduce($saleItems, function ($carry, $item) use ($patientService) {
            $carry[(string)$item->patient]["patient"] = $patientService->getPatient($item->patient);
            $carry[(string)$item->patient]["items"][] = $item;
            return $carry;
        },[]);

        $data = [
            'title' => 'Nueva Orden',
            'sale' => $sale,
            'labs' => model(LabModel::class)->findAll(),
            'saleItems' => $saleItems,
            "patientItems" => $itemsToOrder,

        ];

//        dd($data);
        return view('components/order/new', $data);


    }
}
