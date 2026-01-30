<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class PromotionSeeder extends Seeder
{
    public function run()
    {
        $tz = config('App')->appTimezone ?? 'UTC';
        $now = Time::now($tz);
        $starts = $now->subHours(1)->toDateTimeString();
        $in30d = $now->addDays(30)->toDateTimeString();

        $rows = [
            // 1) 10% de descuento en orden, combinable, canal tienda
            [
                'name' => '10% en mostrador',
                'code' => 'POS10',
                'description' => '10% de descuento en compras en mostrador',
                'type' => 'percent',
                'scope' => 'order',
                'priority' => 50,
                'combinable' => 1,
                'channel' => 'store',
                'audience' => null,
                'constraints_json' => json_encode(['min_amount' => 0]),
                'rule_json' => json_encode(['percent' => 10, 'max_discount' => 200]),
                'starts_at' => $starts,
                'ends_at' => null,
                'active' => 1,
                'created_at' => $now->toDateTimeString(),
                'updated_at' => $now->toDateTimeString(),
            ],
            // 2) $100 MXN fijo sobre el total, requiere monto mínimo 800, combinable
            [
                'name' => 'Cupon $100 a partir de $800',
                'code' => 'FIJO100',
                'description' => 'Descuento fijo de $100 en compras desde $800',
                'type' => 'fixed',
                'scope' => 'order',
                'priority' => 60,
                'combinable' => 1,
                'channel' => 'both',
                'audience' => null,
                'constraints_json' => json_encode(['min_amount' => 800]),
                'rule_json' => json_encode(['amount' => 100]),
                'starts_at' => $starts,
                'ends_at' => $in30d,
                'active' => 1,
                'created_at' => $now->toDateTimeString(),
                'updated_at' => $now->toDateTimeString(),
            ],
            // 3) BOGO: compra 2 y lleva 1 con 100% de descuento (no combinable, alta prioridad)
            [
                'name' => '2x1 en armazones seleccionados',
                'code' => 'BOGO2x1',
                'description' => 'Compra 2 y lleva 1 gratis (aplica al ítem de menor precio equivalente)',
                'type' => 'bogo',
                'scope' => 'item',
                'priority' => 10,
                'combinable' => 0,
                'channel' => 'store',
                // puedes restringir por categoría/ítems reales si lo deseas
                'audience' => null,
                'constraints_json' => json_encode(['min_qty' => 3]),
                'rule_json' => json_encode(['buy' => 2, 'get' => 1, 'discount_percent' => 100]),
                'starts_at' => $starts,
                'ends_at' => $in30d,
                'active' => 1,
                'created_at' => $now->toDateTimeString(),
                'updated_at' => $now->toDateTimeString(),
            ],
            // 4) Tiers por monto (no combinable): 2000=>5%, 4000=>10%, 6000=>15%
            [
                'name' => 'Escalonado por monto',
                'code' => 'TIERS$',
                'description' => 'Descuento por monto acumulado en la orden',
                'type' => 'tier_amount',
                'scope' => 'order',
                'priority' => 20,
                'combinable' => 0,
                'channel' => 'both',
                'audience' => null,
                'constraints_json' => json_encode(['min_amount' => 2000]),
                'rule_json' => json_encode(['tiers' => [
                    ['min_amount' => 2000, 'percent' => 5],
                    ['min_amount' => 4000, 'percent' => 10],
                    ['min_amount' => 6000, 'percent' => 15],
                ]]),
                'starts_at' => $starts,
                'ends_at' => null,
                'active' => 1,
                'created_at' => $now->toDateTimeString(),
                'updated_at' => $now->toDateTimeString(),
            ],
            // 5) Bundle (opcional): combo de 2 productos, descuento 300
            [
                'name' => 'Combo Lente + Armazón',
                'code' => 'BUNDLE300',
                'description' => 'Combo de 2 productos con $300 de descuento',
                'type' => 'bundle',
                'scope' => 'mixed',
                'priority' => 40,
                'combinable' => 1,
                'channel' => 'both',
                'audience' => null,
                // NOTA: Ajusta product_id reales existentes para garantizar match
                'constraints_json' => null,
                'rule_json' => json_encode([
                    'items' => [
                        ['product_id' => 1, 'quantity' => 1],
                        ['product_id' => 2, 'quantity' => 1],
                    ],
                    'discount_amount' => 300
                ]),
                'starts_at' => $starts,
                'ends_at' => $in30d,
                'active' => 1,
                'created_at' => $now->toDateTimeString(),
                'updated_at' => $now->toDateTimeString(),
            ],
        ];

        // Insert batch
        $this->db->table('promotions')->insertBatch($rows);
    }
}
