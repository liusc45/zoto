<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class PromotionItem extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [
        'id'           => 'integer',
        'promotion_id' => 'integer',
        'item_id'      => 'integer',
        'price'        => 'double',
    ];

    /**
     * Get the promotion this item belongs to
     */
    public function getPromotion()
    {
        $promotionModel = model('PromotionModel');
        return $promotionModel->find($this->promotion_id);
    }

    /**
     * Get the item details
     */
    public function getItem()
    {
        $itemModel = model('ItemModel');
        return $itemModel->find($this->item_id);
    }

    /**
     * Calculate the discount percentage compared to regular price
     */
    public function getDiscountPercentage()
    {
        $itemPriceModel = model('ItemPriceModel');
        $regularPrice = $itemPriceModel
            ->where('item', $this->item_id)
            ->where('type', 'regular')
            ->first();

        if (!$regularPrice) {
            return 0;
        }

        $discount = $regularPrice->amount - $this->price;
        if ($regularPrice->amount <= 0) {
            return 0;
        }

        return round(($discount / $regularPrice->amount) * 100, 2);
    }
}