<?php

// Load the CodeIgniter instance
require 'spark';

// Get model instances
$promotionModel = model('PromotionModel');
$promotionItemModel = model('PromotionItemModel');
$itemModel = model('ItemModel');

// Get some items to add to the promotion
$items = $itemModel->findAll(3);

if (empty($items)) {
    echo "No items found in the database. Please add some items first.\n";
    exit;
}

// Create a test promotion
$promotionData = [
    'name' => 'Test Promotion ' . date('Y-m-d H:i:s'),
    'description' => 'This is a test promotion created via script',
    'starts_at' => date('Y-m-d H:i:s'),
    'ends_at' => date('Y-m-d H:i:s', strtotime('+30 days')),
    'status' => 'active'
];

echo "Creating test promotion...\n";
$promotionId = $promotionModel->insert($promotionData);

if (!$promotionId) {
    echo "Failed to create promotion: " . json_encode($promotionModel->errors()) . "\n";
    exit;
}

echo "Promotion created with ID: $promotionId\n";

// Add items to the promotion
$successCount = 0;
foreach ($items as $item) {
    $promotionItemData = [
        'promotion_id' => $promotionId,
        'item_id' => $item->id,
        'price' => $item->price * 0.9 // 10% discount
    ];
    
    $result = $promotionItemModel->insert($promotionItemData);
    
    if ($result) {
        $successCount++;
        echo "Added item {$item->id} ({$item->name}) to promotion\n";
    } else {
        echo "Failed to add item {$item->id}: " . json_encode($promotionItemModel->errors()) . "\n";
    }
}

echo "Added $successCount items to promotion\n";

// Verify items were added
$promotionItems = $promotionItemModel->where('promotion_id', $promotionId)->findAll();
echo "Found " . count($promotionItems) . " items in the promotion\n";

// Display the promotion with items
$promotionWithItems = $promotionModel->getPromotionsWithItems($promotionId);
echo "Promotion details:\n";
echo "Name: {$promotionWithItems->name}\n";
echo "Status: {$promotionWithItems->status}\n";
echo "Items:\n";

if (isset($promotionWithItems->items) && !empty($promotionWithItems->items)) {
    foreach ($promotionWithItems->items as $item) {
        echo "- Item ID: {$item->item_id}, Price: {$item->price}\n";
    }
} else {
    echo "No items found in the promotion\n";
}

echo "Test completed successfully!\n";