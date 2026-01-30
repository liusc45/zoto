<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PromotionModel;

class Promotions extends BaseController
{
    protected $promotionModel;

    public function __construct()
    {
        $this->promotionModel = new PromotionModel();
    }

    /**
     * Lista de promociones
     */
    public function index()
    {
        $data = [
            'title' => 'Gestión de Promociones',
            'promotions' => $this->promotionModel->orderBy('priority', 'ASC')->findAll()
        ];

        return view('admin/promotions/index', $data);
    }

    /**
     * Formulario de creación
     */
    public function create()
    {
        $data = [
            'title' => 'Nueva Promoción',
            'promotion' => null,
            'types' => $this->getPromotionTypes(),
            'scopes' => ['item' => 'Por ítem', 'order' => 'Por orden', 'mixed' => 'Mixto'],
            'channels' => ['store' => 'Tienda física', 'online' => 'En línea', 'both' => 'Ambos']
        ];

        return view('admin/promotions/form', $data);
    }

    /**
     * Guardar nueva promoción
     */
    public function store()
    {
        $rules = [
            'name' => 'required|min_length[3]|max_length[150]',
            'type' => 'required',
            'starts_at' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'code' => $this->request->getPost('code'),
            'description' => $this->request->getPost('description'),
            'type' => $this->request->getPost('type'),
            'scope' => $this->request->getPost('scope') ?? 'mixed',
            'priority' => $this->request->getPost('priority') ?? 100,
            'combinable' => $this->request->getPost('combinable') ? 1 : 0,
            'channel' => $this->request->getPost('channel') ?? 'both',
            'audience' => $this->buildAudienceJson(),
            'constraints_json' => $this->buildConstraintsJson(),
            'rule_json' => $this->buildRuleJson(),
            'starts_at' => $this->request->getPost('starts_at'),
            'ends_at' => $this->request->getPost('ends_at') ?: null,
            'active' => $this->request->getPost('active') ? 1 : 0
        ];

        if ($this->promotionModel->insert($data)) {
            return redirect()->to('/admin/promotions')->with('success', 'Promoción creada exitosamente');
        }

        return redirect()->back()->withInput()->with('error', 'Error al crear la promoción');
    }

    /**
     * Formulario de edición
     */
    public function edit($id)
    {
        $promotion = $this->promotionModel->find($id);

        if (!$promotion) {
            return redirect()->to('/admin/promotions')->with('error', 'Promoción no encontrada');
        }

        // Decodificar campos JSON
        $promotion['audience'] = json_decode($promotion['audience'] ?? '{}', true);
        $promotion['constraints_json'] = json_decode($promotion['constraints_json'] ?? '{}', true);
        $promotion['rule_json'] = json_decode($promotion['rule_json'] ?? '{}', true);

        $data = [
            'title' => 'Editar Promoción',
            'promotion' => $promotion,
            'types' => $this->getPromotionTypes(),
            'scopes' => ['item' => 'Por ítem', 'order' => 'Por orden', 'mixed' => 'Mixto'],
            'channels' => ['store' => 'Tienda física', 'online' => 'En línea', 'both' => 'Ambos']
        ];

        return view('admin/promotions/form', $data);
    }

    /**
     * Actualizar promoción
     */
    public function update($id)
    {
        $promotion = $this->promotionModel->find($id);

        if (!$promotion) {
            return redirect()->to('/admin/promotions')->with('error', 'Promoción no encontrada');
        }

        $data = [
            'name' => $this->request->getPost('name'),
            'code' => $this->request->getPost('code'),
            'description' => $this->request->getPost('description'),
            'type' => $this->request->getPost('type'),
            'scope' => $this->request->getPost('scope') ?? 'mixed',
            'priority' => $this->request->getPost('priority') ?? 100,
            'combinable' => $this->request->getPost('combinable') ? 1 : 0,
            'channel' => $this->request->getPost('channel') ?? 'both',
            'audience' => $this->buildAudienceJson(),
            'constraints_json' => $this->buildConstraintsJson(),
            'rule_json' => $this->buildRuleJson(),
            'starts_at' => $this->request->getPost('starts_at'),
            'ends_at' => $this->request->getPost('ends_at') ?: null,
            'active' => $this->request->getPost('active') ? 1 : 0
        ];

        if ($this->promotionModel->update($id, $data)) {
            return redirect()->to('/admin/promotions')->with('success', 'Promoción actualizada exitosamente');
        }

        return redirect()->back()->withInput()->with('error', 'Error al actualizar la promoción');
    }

    /**
     * Eliminar promoción
     */
    public function delete($id)
    {
        if ($this->promotionModel->delete($id)) {
            return redirect()->to('/admin/promotions')->with('success', 'Promoción eliminada exitosamente');
        }

        return redirect()->to('/admin/promotions')->with('error', 'Error al eliminar la promoción');
    }

    /**
     * Toggle activo/inactivo
     */
    public function toggleActive($id)
    {
        $promotion = $this->promotionModel->find($id);

        if (!$promotion) {
            return $this->response->setJSON(['success' => false, 'message' => 'Promoción no encontrada']);
        }

        $newStatus = $promotion['active'] ? 0 : 1;
        
        if ($this->promotionModel->update($id, ['active' => $newStatus])) {
            return $this->response->setJSON(['success' => true, 'active' => $newStatus]);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Error al actualizar']);
    }

    /**
     * Vista previa de cálculo de descuento
     */
    public function preview()
    {
        $promotionId = $this->request->getPost('promotion_id');
        $context = [
            'amount' => (float) $this->request->getPost('amount'),
            'quantity' => (int) $this->request->getPost('quantity'),
            'unit_price' => (float) $this->request->getPost('unit_price')
        ];

        $result = $this->promotionModel->calculateDiscount($promotionId, $context);

        return $this->response->setJSON($result);
    }

    // Métodos auxiliares privados

    private function getPromotionTypes(): array
    {
        return [
            'percent' => 'Porcentaje de descuento',
            'fixed' => 'Descuento fijo',
            'bogo' => 'Compra y lleva (BOGO)',
            'bundle' => 'Paquete de productos',
            'tier_amount' => 'Descuento por monto',
            'tier_qty' => 'Descuento por cantidad',
            'upgrade' => 'Mejora de producto',
            'cashback' => 'Devolución de efectivo',
            'points' => 'Puntos de lealtad',
            'shipping' => 'Envío gratis',
            'financing' => 'Financiamiento',
            'warranty' => 'Garantía extendida'
        ];
    }

    private function buildAudienceJson(): ?string
    {
        $audience = [];

        $customerGroups = $this->request->getPost('audience_customer_groups');
        if ($customerGroups) {
            $audience['customer_groups'] = is_array($customerGroups) ? $customerGroups : explode(',', $customerGroups);
        }

        $customerIds = $this->request->getPost('audience_customer_ids');
        if ($customerIds) {
            $audience['customer_ids'] = is_array($customerIds) ? $customerIds : array_map('intval', explode(',', $customerIds));
        }

        return !empty($audience) ? json_encode($audience) : null;
    }

    private function buildConstraintsJson(): ?string
    {
        $constraints = [];

        if ($minAmount = $this->request->getPost('constraint_min_amount')) {
            $constraints['min_amount'] = (float) $minAmount;
        }

        if ($minQty = $this->request->getPost('constraint_min_qty')) {
            $constraints['min_qty'] = (int) $minQty;
        }

        $productIds = $this->request->getPost('constraint_product_ids');
        if ($productIds) {
            $constraints['product_ids'] = is_array($productIds) ? $productIds : array_map('intval', explode(',', $productIds));
        }

        $categoryIds = $this->request->getPost('constraint_category_ids');
        if ($categoryIds) {
            $constraints['category_ids'] = is_array($categoryIds) ? $categoryIds : array_map('intval', explode(',', $categoryIds));
        }

        return !empty($constraints) ? json_encode($constraints) : null;
    }

    private function buildRuleJson(): string
    {
        $type = $this->request->getPost('type');
        $rules = [];

        switch ($type) {
            case 'percent':
                $rules = [
                    'percent' => (float) $this->request->getPost('rule_percent'),
                    'max_discount' => $this->request->getPost('rule_max_discount') ? (float) $this->request->getPost('rule_max_discount') : null
                ];
                break;

            case 'fixed':
                $rules = [
                    'amount' => (float) $this->request->getPost('rule_amount')
                ];
                break;

            case 'bogo':
                $rules = [
                    'buy' => (int) $this->request->getPost('rule_buy'),
                    'get' => (int) $this->request->getPost('rule_get'),
                    'discount_percent' => (float) ($this->request->getPost('rule_discount_percent') ?? 100)
                ];
                break;

            case 'tier_amount':
            case 'tier_qty':
                $tiers = $this->request->getPost('rule_tiers');
                $rules = ['tiers' => json_decode($tiers, true) ?? []];
                break;

            case 'bundle':
                $items = $this->request->getPost('rule_bundle_items');
                $rules = [
                    'items' => json_decode($items, true) ?? [],
                    'discount_amount' => (float) $this->request->getPost('rule_discount_amount')
                ];
                break;

            case 'cashback':
                $rules = [
                    'percent' => (float) $this->request->getPost('rule_cashback_percent')
                ];
                break;

            case 'points':
                $rules = [
                    'points_per_unit' => (float) $this->request->getPost('rule_points_per_unit')
                ];
                break;
        }

        return json_encode($rules);
    }
}
