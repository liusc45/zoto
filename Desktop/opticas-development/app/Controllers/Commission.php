<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CommissionConfigModel;
use App\Models\ItemModel;
use App\Models\PaymentModel;
use App\Models\SaleCommissionModel;
use App\Models\SaleItemsModel;
use App\Models\SaleModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;

class Commission extends BaseController
{
    use ResponseTrait;

    public function settings()
    {
        $model = new CommissionConfigModel();
        if ($this->request->getMethod() === 'post') {
            $data = $this->request->getPost([
                'tax_rate',
                'bank_commission_rate',
                'percent_line1',
                'percent_line2',
                'percent_line13',
                'percent_bundle_1_13',
            ]);
            // Normalize percent inputs
            if (isset($data['tax_rate'])) $data['tax_rate'] = ((float)$data['tax_rate'])/100.0;
            if (isset($data['bank_commission_rate'])) $data['bank_commission_rate'] = ((float)$data['bank_commission_rate'])/100.0;
            // Ensure one row
            $row = $model->first();
            if ($row) {
                $model->update($row['id'], $data);
            } else {
                $model->insert($data);
            }
            return redirect()->to('/commission/settings')->with('message', 'Configuración guardada');
        }
        $config = $model->getConfig();
        return view('components/commission/settings', ['config' => $config]);
    }

    public function calculate($saleId)
    {
        $saleModel = new SaleModel();
        $sale = $saleModel->find($saleId);
        if (!$sale) return $this->failNotFound('Venta no encontrada');

        $configModel = new CommissionConfigModel();
        $config = $configModel->getConfig();
        $taxRate = (float)$config['tax_rate'];
        $bankRate = (float)$config['bank_commission_rate'];

        // Gather sale items and commissionable subsets
        $saleItemsModel = new SaleItemsModel();
        $items = $saleItemsModel
            ->select('sale_items.*, items.line')
            ->join('items', 'items.id = sale_items.item')
            ->where(['sale' => $sale->id])
            ->findAll();

        $commissionableLines = [1, 2, 13];
        $commissionableSubtotal = 0.0;
        $lineSubtotals = [1 => 0.0, 2 => 0.0, 13 => 0.0];
        foreach ($items as $it) {
            $line = (int)$it->line;
            if (in_array($line, $commissionableLines, true)) {
                $commissionableSubtotal += (float)$it->final_price;
                $lineSubtotals[$line] += (float)$it->final_price;
            }
        }

        $totalSaleAmount = (float)$sale->amount;
        $proportion = $totalSaleAmount > 0 ? ($commissionableSubtotal / $totalSaleAmount) : 0.0;

        // Bank commission computed from card/transfer payments, then apportioned by proportion
        $paymentModel = new PaymentModel();
        $payments = $paymentModel->where(['sale' => $sale->id])->findAll();
        $cardTransferTotal = 0.0;
        foreach ($payments as $p) {
            if (in_array($p->payment_type, ['card', 'transfer'], true)) {
                $cardTransferTotal += (float)$p->amount;
            }
        }
        $bankFeeTotal = $cardTransferTotal * $bankRate;
        $bankFeeCommissionable = $bankFeeTotal * $proportion;

        // Taxes on commissionable subtotal
        $taxesAmount = $commissionableSubtotal * $taxRate;

        $net = $commissionableSubtotal - $taxesAmount - $bankFeeCommissionable;
        if ($net < 0) $net = 0.0;

        // Determine commission percent application
        $has1 = $lineSubtotals[1] > 0;
        $has13 = $lineSubtotals[13] > 0;

        $percentLine1 = (float)$config['percent_line1'];
        $percentLine2 = (float)$config['percent_line2'];
        $percentLine13 = (float)$config['percent_line13'];
        $percentBundle = (float)$config['percent_bundle_1_13'];

        $commissionAmount = 0.0;
        if ($has1 && $has13) {
            $bundleNet = ($lineSubtotals[1] + $lineSubtotals[13])
                - (($lineSubtotals[1] + $lineSubtotals[13]) * $taxRate)
                - ($bankFeeCommissionable * (($lineSubtotals[1] + $lineSubtotals[13]) / max($commissionableSubtotal, 1e-9)));
            $commissionAmount += $bundleNet * ($percentBundle / 100.0);
        } else {
            if ($lineSubtotals[1] > 0) {
                $net1 = $lineSubtotals[1] - ($lineSubtotals[1] * $taxRate) - ($bankFeeCommissionable * ($lineSubtotals[1] / max($commissionableSubtotal, 1e-9)));
                $commissionAmount += $net1 * ($percentLine1 / 100.0);
            }
            if ($lineSubtotals[13] > 0) {
                $net13 = $lineSubtotals[13] - ($lineSubtotals[13] * $taxRate) - ($bankFeeCommissionable * ($lineSubtotals[13] / max($commissionableSubtotal, 1e-9)));
                $commissionAmount += $net13 * ($percentLine13 / 100.0);
            }
        }
        if ($lineSubtotals[2] > 0) {
            $net2 = $lineSubtotals[2] - ($lineSubtotals[2] * $taxRate) - ($bankFeeCommissionable * ($lineSubtotals[2] / max($commissionableSubtotal, 1e-9)));
            $commissionAmount += $net2 * ($percentLine2 / 100.0);
        }

        // Save or update ledger (only create if not exists; if exists and pending, update recalculation)
        $ledger = (new SaleCommissionModel())->where(['sale_id' => $sale->id])->first();
        $data = [
            'sale_id' => $sale->id,
            'seller_user_id' => $sale->created_by,
            'commissionable_amount' => round($commissionableSubtotal, 2),
            'taxes_amount' => round($taxesAmount, 2),
            'bank_commission_amount' => round($bankFeeCommissionable, 2),
            'net_amount' => round($net, 2),
            'commission_amount' => round($commissionAmount, 2),
        ];

        $model = new SaleCommissionModel();
        if ($ledger) {
            if ($ledger['status'] === 'paid') {
                // Do not overwrite a paid commission
                return $this->respond(['message' => 'Comisión ya pagada', 'commission' => $ledger]);
            }
            $model->update($ledger['id'], $data);
            $ledger = $model->find($ledger['id']);
        } else {
            $data['status'] = 'pending';
            $model->insert($data);
            $ledger = $model->where(['sale_id' => $sale->id])->first();
        }

        return $this->respond($ledger);
    }

    public function pay($saleId)
    {
        $model = new SaleCommissionModel();
        $ledger = $model->where(['sale_id' => $saleId])->first();
        if (!$ledger) return $this->failNotFound('Comisión no encontrada');
        if ($ledger['status'] === 'paid') return $this->failValidationErrors('La comisión ya está pagada');

        // Ensure only the original seller is credited. We mark paid and store timestamp.
        $model->update($ledger['id'], [
            'status' => 'paid',
            'paid_at' => Time::now()->toDateTimeString(),
        ]);
        return $this->respondUpdated($model->find($ledger['id']));
    }
}
