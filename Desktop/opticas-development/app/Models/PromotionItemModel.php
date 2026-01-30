<?php

namespace App\Models;

use CodeIgniter\Model;

class PromotionItemModel extends Model
{
    protected $table            = 'promotion_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = \App\Entities\PromotionItem::class;
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'promotion_id',
        'item_id',
        'price',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'promotion_id' => 'required|numeric|is_not_unique[promotions.id]',
        'item_id'      => 'required|numeric|is_not_unique[items.id]',
        'price'        => 'required|numeric|greater_than[0]',
    ];
    protected $validationMessages   = [
        'promotion_id' => [
            'required'      => 'La promoción es requerida',
            'numeric'       => 'La promoción debe ser numérica',
            'is_not_unique' => 'La promoción seleccionada no existe'
        ],
        'item_id' => [
            'required'      => 'El artículo es requerido',
            'numeric'       => 'El artículo debe ser numérico',
            'is_not_unique' => 'El artículo seleccionado no existe'
        ],
        'price' => [
            'required'     => 'El precio es requerido',
            'numeric'      => 'El precio debe ser numérico',
            'greater_than' => 'El precio debe ser mayor a 0'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['checkUniqueItem'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Check if the item is already in the promotion
     */
    protected function checkUniqueItem(array $data)
    {
        if (isset($data['data']['promotion_id']) && isset($data['data']['item_id'])) {
            $existing = $this->where('promotion_id', $data['data']['promotion_id'])
                            ->where('item_id', $data['data']['item_id'])
                            ->first();
            
            if ($existing) {
                // Item already exists in this promotion, update instead of insert
                $this->update($existing->id, [
                    'price' => $data['data']['price']
                ]);
                
                // Return empty data to prevent insert
                return ['data' => []];
            }
        }
        
        return $data;
    }

    /**
     * Get items for a specific promotion
     */
    public function getPromotionItems($promotionId)
    {
        return $this->select('promotion_items.*, items.name as item_name, items.key as item_key')
                    ->join('items', 'items.id = promotion_items.item_id')
                    ->where('promotion_id', $promotionId)
                    ->findAll();
    }

    /**
     * Get all promotions for a specific item
     */
    public function getItemPromotions($itemId)
    {
        return $this->select('promotion_items.*, promotions.name as promotion_name, promotions.starts_at, promotions.ends_at, promotions.status')
                    ->join('promotions', 'promotions.id = promotion_items.promotion_id')
                    ->where('item_id', $itemId)
                    ->where('promotions.status', 'active')
                    ->findAll();
    }

    /**
     * Batch insert or update promotion items
     */
    public function batchUpsert($items)
    {
        $result = ['success' => 0, 'failed' => 0];
        
        foreach ($items as $item) {
            // Check if item already exists in this promotion
            $existing = $this->where('promotion_id', $item['promotion_id'])
                            ->where('item_id', $item['item_id'])
                            ->first();
            
            if ($existing) {
                // Update existing item
                if ($this->update($existing->id, $item)) {
                    $result['success']++;
                } else {
                    $result['failed']++;
                }
            } else {
                // Insert new item
                if ($this->insert($item)) {
                    $result['success']++;
                } else {
                    $result['failed']++;
                }
            }
        }
        
        return $result;
    }
}