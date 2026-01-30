-- Insert a test promotion
INSERT INTO promotions (
    name, 
    description, 
    starts_at, 
    ends_at, 
    status, 
    created_at
) VALUES (
    'Test SQL Promotion',
    'This is a test promotion created via SQL',
    NOW(),
    DATE_ADD(NOW(), INTERVAL 30 DAY),
    'active',
    NOW()
);

-- Get the ID of the inserted promotion
SET @promotion_id = LAST_INSERT_ID();

-- Get some items to add to the promotion
SET @item1 = (SELECT id FROM items LIMIT 1);
SET @item2 = (SELECT id FROM items LIMIT 1,1);
SET @item3 = (SELECT id FROM items LIMIT 2,1);

-- Insert promotion items
INSERT INTO promotion_items (
    promotion_id,
    item_id,
    price,
    created_at
) VALUES
(@promotion_id, @item1, 100.00, NOW()),
(@promotion_id, @item2, 200.00, NOW()),
(@promotion_id, @item3, 300.00, NOW());

-- Verify the data was inserted
SELECT 'Promotion created with ID:' AS message, @promotion_id AS id;

-- Query the promotion with its items
SELECT 
    p.id AS promotion_id,
    p.name AS promotion_name,
    p.status,
    COUNT(pi.id) AS item_count
FROM 
    promotions p
LEFT JOIN 
    promotion_items pi ON p.id = pi.promotion_id
WHERE 
    p.id = @promotion_id
GROUP BY 
    p.id, p.name, p.status;

-- Query the promotion items
SELECT 
    pi.id,
    pi.promotion_id,
    pi.item_id,
    i.name AS item_name,
    i.key AS item_key,
    pi.price
FROM 
    promotion_items pi
JOIN 
    items i ON pi.item_id = i.id
WHERE 
    pi.promotion_id = @promotion_id;