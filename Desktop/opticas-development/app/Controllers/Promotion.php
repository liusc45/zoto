<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BrandModel;
use App\Models\ColorModel;
use App\Models\ItemModel;
use App\Models\LineModel;
use App\Models\PromotionModel;
use App\Models\SupplierModel;
use CodeIgniter\HTTP\ResponseInterface;

class Promotion extends BaseController
{
    protected PromotionModel $promotionModel;

    public function __construct()
    {
        $this->promotionModel = new PromotionModel();
    }

    /**
     * Lista de promociones
     */
    public function main(): string
    {
        $data = [
            'title' => 'Gestión de Promociones',
            'promotions' => $this->promotionModel->orderBy('priority', 'ASC')->findAll(),

        ];

        return view('components/promotion/main', $data);
    }

    /**
     * Formulario de creación
     */
    public function create()
    {
        $data = $this->formData(true);
        $data['title'] = 'Nueva Promoción';
        $data['promotion'] = null;
        return view('components/promotion/form', $data);
    }

    /**
     * Guardar nueva promoción
     */
    public function store()
    {
        if (!$this->validate($this->validationRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Validar que ends_at > starts_at si viene
        $startsAt = $this->request->getPost('starts_at');
        $endsAt = $this->request->getPost('ends_at');
        if (!empty($endsAt) && strtotime($endsAt) <= strtotime($startsAt)) {
            return redirect()->back()->withInput()->with('errors', ['ends_at' => 'La fecha de término debe ser posterior a la de inicio']);
        }

        $data = $this->buildPromotionDataFromRequest($startsAt, $endsAt ?: null);

        if ($this->promotionModel->insert($data)) {
            return redirect()->to('/promociones')->with('success', 'Promoción creada exitosamente');
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
            return redirect()->to('/promociones')->with('error', 'Promoción no encontrada');
        }

        // Decodificar campos JSON
        $promotion['audience'] = json_decode($promotion['audience'] ?? '{}', true);
        $promotion['constraints_json'] = json_decode($promotion['constraints_json'] ?? '{}', true);
        $promotion['rule_json'] = json_decode($promotion['rule_json'] ?? '{}', true);

        $data = $this->formData(true);
        $data['title'] = 'Editar Promoción';
        $data['promotion'] = $promotion;
        return view('components/promotion/form', $data);
    }

    /**
     * Actualizar promoción
     */
    public function update($id)
    {
        $promotion = $this->promotionModel->find($id);

        if (!$promotion) {
            return redirect()->to('/promociones')->with('error', 'Promoción no encontrada');
        }

        if (!$this->validate($this->validationRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $startsAt = $this->request->getPost('starts_at');
        $endsAt = $this->request->getPost('ends_at');
        if (!empty($endsAt) && strtotime($endsAt) <= strtotime($startsAt)) {
            return redirect()->back()->withInput()->with('errors', ['ends_at' => 'La fecha de término debe ser posterior a la de inicio']);
        }

        $data = $this->buildPromotionDataFromRequest($startsAt, $endsAt ?: null);

        if ($this->promotionModel->update($id, $data)) {
            return redirect()->to('/promociones')->with('success', 'Promoción actualizada exitosamente');
        }

        return redirect()->back()->withInput()->with('error', 'Error al actualizar la promoción');
    }

    /**
     * Eliminar promoción
     */
    public function delete($id)
    {
        if ($this->promotionModel->delete($id)) {
            return redirect()->to('/promociones')->with('success', 'Promoción eliminada exitosamente');
        }

        return redirect()->to('/promociones')->with('error', 'Error al eliminar la promoción');
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
        $promotionId = (int) $this->request->getPost('promotion_id');
        $context = [
            'amount' => (float) $this->request->getPost('amount'),
            'quantity' => (int) $this->request->getPost('quantity'),
            'unit_price' => (float) $this->request->getPost('unit_price'),
            'channel' => (string) ($this->request->getPost('channel') ?? 'store'),
            'customer_id' => $this->request->getPost('customer_id'),
            'customer_group' => $this->request->getPost('customer_group'),
            'product_id' => $this->request->getPost('product_id'),
            'category_id' => $this->request->getPost('category_id'),
            'items' => $this->request->getPost('items') ? json_decode($this->request->getPost('items'), true) : null,
            'shipping_cost' => $this->request->getPost('shipping_cost') ? (float)$this->request->getPost('shipping_cost') : null,
        ];

        $result = $this->promotionModel->calculateDiscount($promotionId, $context);

        return $this->response->setJSON($result);
    }

    /**
     * Listado JSON de promociones activas para el canal
     */
    public function getActivePromotions(): ResponseInterface
    {
        $channel = $this->request->getGet('channel');
        $promotions = $this->promotionModel->getActiveForNow($channel);
        return $this->response->setJSON(['data' => $promotions]);
    }

    // Métodos auxiliares privados

    private function getPromotionTypes(): array
    {
        return [
            'percent' => [
                'label' => 'Descuento en Porcentaje',
                'description' => 'Ideal para rebajas generales (ej. 10% de descuento)',
                'icon' => 'mdi-percent'
            ],
            'fixed' => [
                'label' => 'Descuento de Monto Fijo',
                'description' => 'Resta una cantidad exacta (ej. $100 de regalo)',
                'icon' => 'mdi-cash-multiple'
            ],
            'bogo' => [
                'label' => 'Compra y Lleva (BOGO)',
                'description' => '2x1, 3x2, o descuento en la segunda unidad',
                'icon' => 'mdi-tag-multiple'
            ],
            'bundle' => [
                'label' => 'Paquete (Combo)',
                'description' => 'Precio especial al comprar productos específicos juntos',
                'icon' => 'mdi-package-variant'
            ],
            'tier_amount' => [
                'label' => 'Escalas por Monto',
                'description' => 'Más descuento mientras más gasten',
                'icon' => 'mdi-chart-line'
            ],
            'tier_qty' => [
                'label' => 'Escalas por Cantidad',
                'description' => 'Más descuento mientras más piezas lleven',
                'icon' => 'mdi-numeric-plus-box-multiple'
            ],
            'cashback' => [
                'label' => 'Monedero (Cashback)',
                'description' => 'Devuelve un porcentaje para compras futuras',
                'icon' => 'mdi-wallet-giftcard'
            ],
            'points' => [
                'label' => 'Puntos de Lealtad',
                'description' => 'Asigna puntos por cada unidad comprada',
                'icon' => 'mdi-star-circle'
            ]
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

        $minAmount = $this->request->getPost('constraint_min_amount');
        if ($minAmount !== null && $minAmount !== '') {
            $amount = filter_var($minAmount, FILTER_VALIDATE_FLOAT);
            if ($amount !== false) {
                $constraints['min_amount'] = round((float)$amount, 2);
            }
        }

        $minQty = $this->request->getPost('constraint_min_qty');
        if ($minQty !== null && $minQty !== '') {
            $qty = filter_var($minQty, FILTER_VALIDATE_INT);
            if ($qty !== false) {
                $constraints['min_qty'] = (int)$qty;
            }
        }

        $productIds = $this->request->getPost('constraint_product_ids');
        if ($productIds) {
            $ids = is_array($productIds) ? $productIds : explode(',', $productIds);
            $ids = array_values(array_unique(array_map(function ($v) {
                return (int)trim((string)$v);
            }, $ids)));
            $ids = array_filter($ids, fn($v) => $v > 0);
            sort($ids);
            if (!empty($ids)) $constraints['product_ids'] = $ids;
        }

        $categoryIds = $this->request->getPost('constraint_category_ids');
        if ($categoryIds) {
            $ids = is_array($categoryIds) ? $categoryIds : explode(',', $categoryIds);
            $ids = array_values(array_unique(array_map(function ($v) {
                return (int)trim((string)$v);
            }, $ids)));
            $ids = array_filter($ids, fn($v) => $v > 0);
            sort($ids);
            if (!empty($ids)) $constraints['category_ids'] = $ids;
        }

        return !empty($constraints) ? json_encode($constraints) : null;
    }

    private function buildRuleJson(): string
    {
        $type = $this->request->getPost('type');
        $rules = [];

        switch ($type) {
            case 'percent':
                $percent = (float) ($this->request->getPost('rule_percent') ?? 0);
                if ($percent < 0) $percent = 0; if ($percent > 100) $percent = 100;
                $max = $this->request->getPost('rule_max_discount');
                $max = $max !== null && $max !== '' ? round((float)$max, 2) : null;
                $rules = [
                    'percent' => $percent,
                    'max_discount' => $max
                ];
                break;

            case 'fixed':
                $amount = round((float) ($this->request->getPost('rule_amount') ?? 0), 2);
                $rules = [
                    'amount' => $amount
                ];
                break;

            case 'bogo':
                $buy = max(1, (int) ($this->request->getPost('rule_buy') ?? 1));
                $get = max(1, (int) ($this->request->getPost('rule_get') ?? 1));
                $dp = (float) ($this->request->getPost('rule_discount_percent') ?? 100);
                if ($dp < 0) $dp = 0; if ($dp > 100) $dp = 100;
                $rules = [
                    'buy' => $buy,
                    'get' => $get,
                    'discount_percent' => $dp
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
                    'discount_amount' => round((float) ($this->request->getPost('rule_discount_amount') ?? 0), 2)
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

    private function validationRules(): array
    {
        return [
            'name' => 'required|min_length[3]|max_length[150]',
            'type' => 'required',
            'starts_at' => 'required|valid_date',
            'ends_at' => 'permit_empty|valid_date'
        ];
    }

    private function buildPromotionDataFromRequest(string $startsAt, ?string $endsAt): array
    {
        return [
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
            'starts_at' => $startsAt,
            'ends_at' => $endsAt ?: null,
            'active' => $this->request->getPost('active') ? 1 : 0
        ];
    }

    private function formData(bool $withCatalog = true): array
    {
        $data = [
            'title' => 'Promoción',
            'promotion' => null,
            'types' => $this->getPromotionTypes(),
            'scopes' => ['item' => 'Por ítem', 'order' => 'Por orden', 'mixed' => 'Mixto'],
            'channels' => ['store' => 'Tienda física', 'online' => 'En línea', 'both' => 'Ambos'],
        ];

        if ($withCatalog) {
            $data['items'] = model(ItemModel::class)->findAll();
            $data['lines'] = model(LineModel::class)->findAll();
            $data['brands'] = model(BrandModel::class)->findAll();
            $data['colors'] = model(ColorModel::class)->findAll();
            $data['models'] = model(ItemModel::class)
                ->select(["distinct (model) as model"])
                ->orderBy("model","ASC")
                ->where("model ","IS NOT NULL")
                ->findAll();
            $data['suppliers'] = model(SupplierModel::class)->findAll();
            $data['sizes'] = model(ItemModel::class)
                ->select(["distinct(size) as model"])
                ->orderBy("model","ASC")
                ->findAll();
        }

        return $data;
    }
}
