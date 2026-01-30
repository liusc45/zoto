<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PromotionSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $monthAfter = date('Y-m-d H:i:s', strtotime('+1 month'));

        $data = [
            [
                'name' => 'Segunda mica al 50%',
                'code' => '2ND_LENS_50',
                'description' => 'La segunda mica al 50% (la de menor precio).',
                'type' => 'percent',
                'scope' => 'item',
                'priority' => 10,
                'combinable' => 0,
                'channel' => 'both',
                'audience' => null,
                'constraints_json' => json_encode([
                    'categories' => ['lens'], // micas
                    'minQty' => 2,            // al menos dos micas en el carrito
                    'minSubtotal' => 0
                ]),
                'rule_json' => json_encode([
                    'method' => 'second_half',
                    'on' => 'same_category',   // agrupar por categoría
                    'target' => 'lower_price'
                ]),
                'starts_at' => $now,
                'ends_at' => $monthAfter,
                'active' => 1,
            ],
            [
                'name' => 'Paquete Básico Monofocal',
                'code' => 'PKG_MONO_1499',
                'description' => 'Armazón selección + micas monofocales + AR estándar a $1,499',
                'type' => 'bundle',
                'scope' => 'order',
                'priority' => 20,
                'combinable' => 0,
                'channel' => 'both',
                'audience' => null,
                'constraints_json' => json_encode([
                    'categories' => [], // se valida por includes del bundle
                ]),
                'rule_json' => json_encode([
                    'method' => 'bundle',
                    'price' => 1499,
                    'includes' => ['frame_basic','lens_mono','ar_standard'], // etiquetas/tags requeridas
                    'applyTo' => 'order'
                ]),
                'starts_at' => $now,
                'ends_at' => $monthAfter,
                'active' => 1,
            ],
            [
                'name' => 'Progresivos -20%',
                'code' => 'PROG_20',
                'description' => '20% de descuento en lentes progresivos',
                'type' => 'percent',
                'scope' => 'item',
                'priority' => 30,
                'combinable' => 1,
                'channel' => 'both',
                'audience' => null,
                'constraints_json' => json_encode([
                    'categories' => ['lens'],
                    'includeTags' => ['progressive'], // tag en los ítems
                    'minSubtotal' => 0
                ]),
                'rule_json' => json_encode([
                    'method' => 'percent',
                    'value' => 0.20,
                    'applyTo' => 'items',
                    'maxDiscount' => null
                ]),
                'starts_at' => $now,
                'ends_at' => $monthAfter,
                'active' => 1,
            ],
        ];

        $this->db->table('promotions')->insertBatch($data);
    }
}