<?php

namespace App\Models;

use App\Entities\Promotion;
use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class PromotionModel extends Model
{
    protected $table = 'promotions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    // Usaremos arreglos para mantener consistencia con el controlador actual
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $allowedFields = [
        'name', 'code', 'description', 'type', 'scope', 'priority',
        'combinable', 'channel', 'audience', 'constraints_json',
        'rule_json', 'starts_at', 'ends_at', 'active'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[150]',
        'type' => 'required|in_list[percent,fixed,bogo,bundle,tier_amount,tier_qty,upgrade,cashback,points,shipping,financing,warranty]',
        'scope' => 'in_list[item,order,mixed]',
        'starts_at' => 'required|valid_date',
        'ends_at' => 'permit_empty|valid_date'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'El nombre de la promoción es requerido'
        ]
    ];

    protected $beforeInsert = ['castJsonFields'];
    protected $beforeUpdate = ['castJsonFields'];

    protected function castJsonFields(array $data)
    {
        if (isset($data['data']['audience']) && is_array($data['data']['audience'])) {
            $data['data']['audience'] = json_encode($data['data']['audience']);
        }
        if (isset($data['data']['constraints_json']) && is_array($data['data']['constraints_json'])) {
            $data['data']['constraints_json'] = json_encode($data['data']['constraints_json']);
        }
        if (isset($data['data']['rule_json']) && is_array($data['data']['rule_json'])) {
            $data['data']['rule_json'] = json_encode($data['data']['rule_json']);
        }
        return $data;
    }

    /**
     * Obtiene promociones activas según filtros
     */
    public function getActivePromotions(array $filters = []): array
    {
        $now = Time::now()->format('Y-m-d H:i:s');

        $builder = $this->where('active', 1)
            ->where('starts_at <=', $now)
            ->groupStart()
                ->where('ends_at >=', $now)
                ->orWhere('ends_at', null)
            ->groupEnd();

        if (!empty($filters['channel'])) {
            $builder->groupStart()
                ->where('channel', $filters['channel'])
                ->orWhere('channel', 'both')
            ->groupEnd();
        }

        if (!empty($filters['type'])) {
            $builder->where('type', $filters['type']);
        }

        return $builder->orderBy('priority', 'ASC')->findAll();
    }

    public function getActiveForNow(?string $channel = null): array
    {
        $filters = [];
        if ($channel) { $filters['channel'] = $channel; }
        return $this->getActivePromotions($filters);
    }

    /**
     * Valida si una promoción es aplicable
     */
    public function isApplicable(int $promotionId, array $context): bool
    {
        $promotion = $this->find($promotionId);
        
        if (!$promotion || empty($promotion['active'])) {
            return false;
        }

        // Validar fechas con TZ y tolerar ends_at nulo
        $tz = new \DateTimeZone(config('App')->appTimezone ?? 'UTC');
        $now = new \DateTimeImmutable('now', $tz);
        $starts = new \DateTimeImmutable($promotion['starts_at'], $tz);
        
        if ($now < $starts) {
            return false;
        }

        if (!empty($promotion['ends_at'])) {
            $ends = new \DateTimeImmutable($promotion['ends_at'], $tz);
            if ($now > $ends) {
                return false;
            }
        }

        // Validar canal
        if (!empty($context['channel']) && $promotion['channel'] !== 'both') {
            if ($context['channel'] !== $promotion['channel']) {
                return false;
            }
        }

        // Validar audiencia
        if (!empty($promotion['audience'])) {
            $audience = json_decode($promotion['audience'], true) ?: [];
            if (!$this->validateAudience($audience, $context)) {
                return false;
            }
        }

        // Validar restricciones
        if (!empty($promotion['constraints_json'])) {
            $constraints = json_decode($promotion['constraints_json'], true) ?: [];
            if (!$this->validateConstraints($constraints, $context)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Calcula el descuento según el tipo de promoción
     */
    public function calculateDiscount(int $promotionId, array $context): array
    {
        // Verificar aplicabilidad primero
        if (!$this->isApplicable($promotionId, $context)) {
            return ['discount' => 0.0, 'meta' => ['reason' => 'not_applicable']];
        }

        $promotion = $this->find($promotionId);
        if (!$promotion) {
            return ['discount' => 0.0, 'meta' => []];
        }

        $rules = json_decode($promotion['rule_json'] ?? '[]', true) ?: [];
        $amount = max(0.0, (float)($context['amount'] ?? 0));
        $discount = 0.0;
        $meta = [];

        switch ($promotion['type']) {
            case 'percent':
                $pct = max(0.0, (float)($rules['percent'] ?? 0));
                $discount = $amount * $pct / 100.0;
                $max = isset($rules['max_discount']) ? (float)$rules['max_discount'] : null;
                if ($max !== null) { $discount = min($discount, max(0.0, $max)); }
                $meta['percent'] = $pct;
                break;

            case 'fixed':
                $discount = max(0.0, (float)($rules['amount'] ?? 0));
                break;

            case 'bogo':
                $qty = max(0, (int)($context['quantity'] ?? 0));
                $price = max(0.0, (float)($context['unit_price'] ?? 0));
                $buy = max(1, (int)($rules['buy'] ?? 1));
                $get = max(0, (int)($rules['get'] ?? 0));
                $dp = max(0.0, min(100.0, (float)($rules['discount_percent'] ?? 100)));
                $free = intdiv($qty, $buy) * $get;
                $discount = $free * $price * $dp / 100.0;
                $meta['free_items'] = $free;
                $meta['buy'] = $buy;
                $meta['get'] = $get;
                break;

            case 'tier_amount':
                $chosen = null;
                foreach ((array)($rules['tiers'] ?? []) as $tier) {
                    if ($amount >= (float)$tier['min_amount']) { $chosen = $tier; }
                }
                if ($chosen) {
                    $pct = max(0.0, (float)($chosen['percent'] ?? 0));
                    $discount = $amount * $pct / 100.0;
                    $meta['tier'] = $chosen;
                }
                break;

            case 'tier_qty':
                $qty = max(0, (int)($context['quantity'] ?? 0));
                $chosen = null;
                foreach ((array)($rules['tiers'] ?? []) as $tier) {
                    if ($qty >= (int)$tier['min_qty']) { $chosen = $tier; }
                }
                if ($chosen) {
                    $pct = max(0.0, (float)($chosen['percent'] ?? 0));
                    $discount = $amount * $pct / 100.0;
                    $meta['tier'] = $chosen;
                }
                break;

            case 'bundle':
                if (!empty($context['items']) && $this->validateBundle((array)($rules['items'] ?? []), (array)$context['items'])) {
                    $discount = max(0.0, (float)($rules['discount_amount'] ?? 0));
                    $meta['bundle_matched'] = true;
                }
                break;

            case 'shipping':
                $discount = max(0.0, (float)($context['shipping_cost'] ?? 0));
                break;

            case 'cashback':
                $meta['cashback_amount'] = round($amount * max(0.0, (float)($rules['percent'] ?? 0)) / 100.0, 2);
                break;

            case 'points':
                $ppu = max(0.0, (float)($rules['points_per_unit'] ?? 1));
                $meta['points_earned'] = (int) floor($amount * $ppu);
                break;
        }

        $discount = round(max(0.0, min($discount, $amount)), 2);

        return [
            'discount' => $discount,
            'meta' => array_merge($meta, ['promotion_name' => $promotion['name'] ?? ''])
        ];
    }

    private function validateAudience(array $audience, array $context): bool
    {
        // Validar segmento de clientes
        if (!empty($audience['customer_groups'])) {
            $customerGroup = $context['customer_group'] ?? null;
            if (!in_array($customerGroup, $audience['customer_groups'])) {
                return false;
            }
        }

        // Validar clientes específicos
        if (!empty($audience['customer_ids'])) {
            $customerId = $context['customer_id'] ?? null;
            if (!in_array($customerId, $audience['customer_ids'])) {
                return false;
            }
        }

        return true;
    }

    private function validateConstraints(array $constraints, array $context): bool
    {
        // Monto mínimo
        if (isset($constraints['min_amount'])) {
            if (($context['amount'] ?? 0) < $constraints['min_amount']) {
                return false;
            }
        }

        // Cantidad mínima
        if (isset($constraints['min_qty'])) {
            if (($context['quantity'] ?? 0) < $constraints['min_qty']) {
                return false;
            }
        }

        // Productos específicos
        if (!empty($constraints['product_ids'])) {
            $productId = $context['product_id'] ?? null;
            if (!in_array($productId, $constraints['product_ids'])) {
                return false;
            }
        }

        // Categorías específicas
        if (!empty($constraints['category_ids'])) {
            $categoryId = $context['category_id'] ?? null;
            if (!in_array($categoryId, $constraints['category_ids'])) {
                return false;
            }
        }

        return true;
    }

    private function validateBundle(array $requiredItems, array $cartItems): bool
    {
        foreach ($requiredItems as $required) {
            $found = false;
            foreach ($cartItems as $item) {
                if ($item['product_id'] == $required['product_id']) {
                    if (($item['quantity'] ?? 0) >= ($required['quantity'] ?? 1)) {
                        $found = true;
                        break;
                    }
                }
            }
            if (!$found) {
                return false;
            }
        }
        return true;
    }
}