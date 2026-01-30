<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\InvoiceModel;
use App\Models\PaymentModel;
use App\Models\PersonTaxModel;
use App\Models\SaleModel;
use CodeIgniter\API\ResponseTrait;

class Invoice extends BaseController
{
    use ResponseTrait;

    protected InvoiceModel $invoiceModel;
    protected PaymentModel $paymentModel;
    protected PersonTaxModel $personTaxModel;
    protected SaleModel $saleModel;

    public function __construct()
    {
        $this->invoiceModel = new InvoiceModel();
        $this->paymentModel = new PaymentModel();
        $this->personTaxModel = new PersonTaxModel();
        $this->saleModel = new SaleModel();
    }

    public function main()
    {
        $data = [
            'path' => '/facturas',
            'title' => 'Facturas',
        ];
        return view('components/invoice/main', $data);
    }

    // Listado de facturas (JSON)
    public function index()
    {
        $invoices = $this->invoiceModel
            ->select('invoices.*, sales.amount as sale_amount')
            ->join('sales', 'sales.id = invoices.sale', 'left')
            ->orderBy('invoices.created_at', 'DESC')
            ->findAll();
        return $this->respond($invoices);
    }

    // Información de venta para facturar: cliente, posibles RFCs y pagos
    public function saleDetails($id): \CodeIgniter\HTTP\ResponseInterface
    {
        $sale = $this->saleModel->find($id);

        if (!$sale) return $this->failNotFound('Venta no encontrada');

        $personTaxes = [];
        if (!empty($sale->patient)) {
            $personTaxes = $this->personTaxModel
                ->where('person', $sale->patient)
                ->findAll();
        }

        $payments = $this->paymentModel
            ->where('sale', $id)
            ->findAll();

        $paid = 0.0;
        foreach ($payments as $p) {
            $paid += (float)$p->amount;
        }
        $pending = max(0, (float)$sale->amount - $paid);

        return $this->respond([
            'sale' => $sale,
            'personTaxes' => $personTaxes,
            'payments' => $payments,
            'paid' => $paid,
            'pending' => $pending,
        ]);
    }

    // Crear factura a partir de los datos de una venta
    public function createFromSale()
    {
        $payload = $this->request->getJSON(true) ?: $this->request->getPost();
        $saleId = (int)($payload['sale'] ?? 0);
        if (!$saleId) return $this->failValidationErrors(['sale' => 'Venta requerida']);

        $sale = $this->saleModel->find($saleId);
        if (!$sale) return $this->failNotFound('Venta no encontrada');

        $personTaxId = $payload['person_tax'] ?? null;
        $taxRate = (float)($payload['tax_rate'] ?? 16.00);
        $series = $payload['series'] ?? 'A';

        $subtotal = round(((float)$sale->amount) / (1 + ($taxRate/100)), 2);
        $taxAmount = round(((float)$sale->amount) - $subtotal, 2);

        // siguiente folio para la serie
        $last = $this->invoiceModel->where('series', $series)->orderBy('folio', 'DESC')->first();
        $nextFolio = $last && !empty($last['folio']) ? ((int)$last['folio'] + 1) : 1;

        $invoiceData = [
            'sale' => $saleId,
            'person_tax' => $personTaxId,
            'series' => $series,
            'folio' => $nextFolio,
            'subtotal' => $subtotal,
            'discount' => 0,
            'tax_rate' => $taxRate,
            'tax_amount' => $taxAmount,
            'total' => (float)$sale->amount,
            'status' => 'draft',
            'created_by' => auth()->user()->id ?? null,
        ];

        if (!$this->invoiceModel->insert($invoiceData)) {
            return $this->failValidationErrors($this->invoiceModel->errors());
        }

        $created = $this->invoiceModel->find($this->invoiceModel->getInsertID());
        return $this->respondCreated($created);
    }
}
