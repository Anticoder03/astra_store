-- Create database
CREATE DATABASE IF NOT EXISTS astra_store;
USE astra_store;

-- Create categories table
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create products table
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    category_id INT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    sale_price DECIMAL(10,2),
    stock INT NOT NULL DEFAULT 0,
    image_url VARCHAR(255),
    is_featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Insert categories
INSERT INTO categories (name, slug, description, image_url) VALUES
('Electronics', 'electronics', 'Latest gadgets and electronic devices', 'https://images.unsplash.com/photo-1523275335684-37898b6baf30'),
('Fashion', 'fashion', 'Trendy clothing and accessories', 'https://images.unsplash.com/photo-1560343090-f0409e92791a'),
('Home & Living', 'home-living', 'Everything for your home', 'https://images.unsplash.com/photo-1556228453-efd6c1ff04f6'),
('Beauty', 'beauty', 'Beauty and personal care products', 'https://images.unsplash.com/photo-1596462502278-27bfdc403348'),
('Sports', 'sports', 'Sports equipment and accessories', 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211');

-- Insert products (80 records)
INSERT INTO products (category_id, name, slug, description, price, sale_price, stock, image_url, is_featured) VALUES
-- Electronics (20 products)
(1, 'Wireless Headphones', 'wireless-headphones', 'Premium noise-cancelling wireless headphones', 199.99, 149.99, 50, 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e', true),
(1, 'Smart Watch', 'smart-watch', 'Feature-rich smartwatch with health tracking', 299.99, 249.99, 30, 'https://images.unsplash.com/photo-1546868871-7041f2a55e12', true),
(1, '4K Smart TV', '4k-smart-tv', '55-inch 4K Ultra HD Smart TV', 799.99, 699.99, 20, 'https://images.unsplash.com/photo-1593784991095-a205069470b6', false),
(1, 'Gaming Laptop', 'gaming-laptop', 'High-performance gaming laptop', 1299.99, 1199.99, 15, 'https://images.unsplash.com/photo-1603302576837-37561b2e2302', true),
(1, 'Wireless Earbuds', 'wireless-earbuds', 'True wireless earbuds with charging case', 149.99, 99.99, 100, 'https://images.unsplash.com/photo-1590658268037-6bf12165a8df', false),
(1, 'Digital Camera', 'digital-camera', 'Professional DSLR camera', 899.99, 799.99, 25, 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32', true),
(1, 'Tablet Pro', 'tablet-pro', '12.9-inch tablet with stylus', 999.99, 899.99, 40, 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0', false),
(1, 'Smart Speaker', 'smart-speaker', 'Voice-controlled smart speaker', 129.99, 99.99, 75, 'https://images.unsplash.com/photo-1589003077984-894e133dabab', false),
(1, 'Wireless Mouse', 'wireless-mouse', 'Ergonomic wireless mouse', 49.99, 39.99, 150, 'https://images.unsplash.com/photo-1527814050087-3793815479db', false),
(1, 'Mechanical Keyboard', 'mechanical-keyboard', 'RGB mechanical gaming keyboard', 129.99, 99.99, 60, 'https://images.unsplash.com/photo-1618384887929-16ec33fab9ef', false),
(1, 'Power Bank', 'power-bank', '20000mAh portable charger', 79.99, 59.99, 200, 'https://images.unsplash.com/photo-1609592425402-83c0fca0e0b0', false),
(1, 'Bluetooth Speaker', 'bluetooth-speaker', 'Waterproof portable speaker', 89.99, 69.99, 80, 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1', false),
(1, 'Monitor', 'monitor', '27-inch 4K monitor', 399.99, 349.99, 35, 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf', false),
(1, 'Printer', 'printer', 'All-in-one wireless printer', 199.99, 149.99, 45, 'https://images.unsplash.com/photo-1612815154858-60aa4c59eaa6', false),
(1, 'Router', 'router', 'High-speed WiFi router', 129.99, 99.99, 55, 'https://images.unsplash.com/photo-1592286927505-1def25115558', false),
(1, 'External SSD', 'external-ssd', '1TB portable SSD', 149.99, 129.99, 90, 'https://images.unsplash.com/photo-1597484662310-c6d5e47f1e2f', false),
(1, 'Webcam', 'webcam', '1080p HD webcam', 79.99, 59.99, 70, 'https://images.unsplash.com/photo-1611162617213-7d7a39e9b1d7', false),
(1, 'Microphone', 'microphone', 'USB condenser microphone', 99.99, 79.99, 40, 'https://images.unsplash.com/photo-1598440947619-2c35fc9aa908', false),
(1, 'Graphics Card', 'graphics-card', 'High-end gaming GPU', 699.99, 599.99, 25, 'https://images.unsplash.com/photo-1591488320449-011701bb6704', false),
(1, 'Motherboard', 'motherboard', 'Gaming motherboard', 299.99, 249.99, 30, 'https://images.unsplash.com/photo-1591799264318-7e6ef8ddb7ea', false),

-- Fashion (20 products)
(2, 'Running Shoes', 'running-shoes', 'Lightweight running shoes', 89.99, 69.99, 100, 'https://images.unsplash.com/photo-1542291026-7eec264c27ff', true),
(2, 'Leather Jacket', 'leather-jacket', 'Classic leather jacket', 199.99, 149.99, 50, 'https://images.unsplash.com/photo-1551028719-00167b16eac5', true),
(2, 'Designer Watch', 'designer-watch', 'Luxury stainless steel watch', 299.99, 249.99, 30, 'https://images.unsplash.com/photo-1524805444758-089113d48a6d', false),
(2, 'Sunglasses', 'sunglasses', 'UV protection sunglasses', 129.99, 99.99, 75, 'https://images.unsplash.com/photo-1577803645773-f96470509666', false),
(2, 'Backpack', 'backpack', 'Water-resistant backpack', 79.99, 59.99, 60, 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62', false),
(2, 'Denim Jeans', 'denim-jeans', 'Classic fit denim jeans', 69.99, 49.99, 120, 'https://images.unsplash.com/photo-1542272604-787c3835535d', false),
(2, 'Winter Coat', 'winter-coat', 'Warm winter coat', 149.99, 129.99, 40, 'https://images.unsplash.com/photo-1548624313-0396c75e4b1a', false),
(2, 'Formal Shirt', 'formal-shirt', 'Business casual shirt', 59.99, 49.99, 90, 'https://images.unsplash.com/photo-1598033129183-c4f50c736f10', false),
(2, 'Summer Dress', 'summer-dress', 'Floral summer dress', 79.99, 59.99, 70, 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1', false),
(2, 'Sports Shorts', 'sports-shorts', 'Quick-dry sports shorts', 39.99, 29.99, 150, 'https://images.unsplash.com/photo-1562183241-b937e95585b6', false),
(2, 'Swimwear', 'swimwear', 'Beach swimwear set', 49.99, 39.99, 80, 'https://images.unsplash.com/photo-1576872381149-7847515ce5d8', false),
(2, 'Winter Boots', 'winter-boots', 'Waterproof winter boots', 129.99, 99.99, 45, 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2', false),
(2, 'Scarf', 'scarf', 'Wool winter scarf', 29.99, 19.99, 200, 'https://images.unsplash.com/photo-1606760227091-3dd870d97f1d', false),
(2, 'Gloves', 'gloves', 'Leather winter gloves', 39.99, 29.99, 100, 'https://images.unsplash.com/photo-1608231387042-66d1773070a5', false),
(2, 'Socks Pack', 'socks-pack', '6 pairs of cotton socks', 24.99, 19.99, 300, 'https://images.unsplash.com/photo-1586350977771-0508ecb7e5e9', false),
(2, 'Belt', 'belt', 'Genuine leather belt', 49.99, 39.99, 60, 'https://images.unsplash.com/photo-1624222247344-550fb60583eb', false),
(2, 'Tie', 'tie', 'Silk business tie', 39.99, 29.99, 80, 'https://images.unsplash.com/photo-1598033129183-c4f50c736f10', false),
(2, 'Wallet', 'wallet', 'Leather bifold wallet', 59.99, 49.99, 70, 'https://images.unsplash.com/photo-1627123424574-724758594e93', false),
(2, 'Jewelry Set', 'jewelry-set', 'Sterling silver jewelry set', 89.99, 69.99, 40, 'https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f', false),
(2, 'Hair Accessories', 'hair-accessories', 'Set of hair clips and bands', 19.99, 14.99, 200, 'https://images.unsplash.com/photo-1630019852942-f89202989a59', false),

-- Home & Living (20 products)
(3, 'Coffee Table', 'coffee-table', 'Modern wooden coffee table', 299.99, 249.99, 30, 'https://images.unsplash.com/photo-1532372320572-cda25653a26f', true),
(3, 'Sofa Set', 'sofa-set', '3-piece living room set', 999.99, 899.99, 15, 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc', true),
(3, 'Dining Table', 'dining-table', '6-seater dining table', 499.99, 449.99, 20, 'https://images.unsplash.com/photo-1577140917170-285929fb55b7', false),
(3, 'Bed Frame', 'bed-frame', 'Queen size bed frame', 399.99, 349.99, 25, 'https://images.unsplash.com/photo-1505693314120-0d443867891c', false),
(3, 'Bookshelf', 'bookshelf', '5-shelf bookcase', 199.99, 179.99, 40, 'https://images.unsplash.com/photo-1497366216548-37526070297c', false),
(3, 'TV Stand', 'tv-stand', 'Modern TV cabinet', 249.99, 199.99, 35, 'https://images.unsplash.com/photo-1615873968403-89e068629265', false),
(3, 'Rug', 'rug', 'Area rug 5x7', 149.99, 129.99, 50, 'https://images.unsplash.com/photo-1543198123487-a3d6907b2a1a', false),
(3, 'Curtains', 'curtains', 'Blackout curtains', 79.99, 69.99, 60, 'https://images.unsplash.com/photo-1583847268964-b28dc8f51f92', false),
(3, 'Throw Pillows', 'throw-pillows', 'Set of 4 decorative pillows', 49.99, 39.99, 100, 'https://images.unsplash.com/photo-1584100936595-c0655b9a7b2d', false),
(3, 'Wall Clock', 'wall-clock', 'Modern wall clock', 39.99, 29.99, 80, 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad', false),
(3, 'Vase Set', 'vase-set', 'Ceramic vase set', 59.99, 49.99, 70, 'https://images.unsplash.com/photo-1589782182703-2aaa69037b5b', false),
(3, 'Picture Frames', 'picture-frames', 'Set of 3 frames', 29.99, 24.99, 120, 'https://images.unsplash.com/photo-1582555172866-f73bb12a2ab3', false),
(3, 'Table Lamp', 'table-lamp', 'Modern table lamp', 69.99, 59.99, 45, 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c', false),
(3, 'Floor Lamp', 'floor-lamp', 'Adjustable floor lamp', 89.99, 79.99, 30, 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c', false),
(3, 'Mirror', 'mirror', 'Full-length mirror', 129.99, 109.99, 25, 'https://images.unsplash.com/photo-1583847268964-b28dc8f51f92', false),
(3, 'Storage Boxes', 'storage-boxes', 'Set of 3 storage boxes', 49.99, 39.99, 90, 'https://images.unsplash.com/photo-1583847268964-b28dc8f51f92', false),
(3, 'Plant Stand', 'plant-stand', 'Wooden plant stand', 39.99, 29.99, 60, 'https://images.unsplash.com/photo-1583847268964-b28dc8f51f92', false),
(3, 'Wall Art', 'wall-art', 'Abstract wall art', 79.99, 69.99, 40, 'https://images.unsplash.com/photo-1583847268964-b28dc8f51f92', false),
(3, 'Cushions', 'cushions', 'Set of 2 floor cushions', 59.99, 49.99, 70, 'https://images.unsplash.com/photo-1583847268964-b28dc8f51f92', false),
(3, 'Doormat', 'doormat', 'Welcome doormat', 19.99, 14.99, 150, 'https://images.unsplash.com/photo-1583847268964-b28dc8f51f92', false),

-- Beauty (20 products)
(4, 'Skincare Set', 'skincare-set', 'Complete skincare routine set', 89.99, 69.99, 50, 'https://images.unsplash.com/photo-1571781926291-c477ebfd024b', true),
(4, 'Makeup Kit', 'makeup-kit', 'Professional makeup collection', 129.99, 99.99, 40, 'https://images.unsplash.com/photo-1596462502278-27bfdc403348', true),
(4, 'Perfume', 'perfume', 'Luxury fragrance', 79.99, 59.99, 60, 'https://images.unsplash.com/photo-1592945403244-b3fbafd7f539', false),
(4, 'Hair Care Set', 'hair-care-set', 'Complete hair care kit', 69.99, 49.99, 45, 'https://images.unsplash.com/photo-1527799820374-dcf8d9d4a388', false),
(4, 'Face Mask', 'face-mask', 'Hydrating face mask', 19.99, 14.99, 100, 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881', false),
(4, 'Lipstick Set', 'lipstick-set', 'Set of 5 lipsticks', 49.99, 39.99, 70, 'https://images.unsplash.com/photo-1586495777744-4413f21062fa', false),
(4, 'Eye Shadow Palette', 'eye-shadow-palette', 'Professional eye shadow set', 59.99, 49.99, 55, 'https://images.unsplash.com/photo-1583241475880-6833ddc5481d', false),
(4, 'Nail Polish Set', 'nail-polish-set', 'Set of 6 nail polishes', 39.99, 29.99, 80, 'https://images.unsplash.com/photo-1604654894606-2c077f3d7be4', false),
(4, 'Facial Cleanser', 'facial-cleanser', 'Gentle facial cleanser', 24.99, 19.99, 90, 'https://images.unsplash.com/photo-1556228578-0d85b1a4d571', false),
(4, 'Body Lotion', 'body-lotion', 'Moisturizing body lotion', 29.99, 24.99, 75, 'https://images.unsplash.com/photo-1556228578-0d85b1a4d571', false),
(4, 'Hair Brush', 'hair-brush', 'Professional hair brush', 19.99, 14.99, 120, 'https://images.unsplash.com/photo-1527799820374-dcf8d9d4a388', false),
(4, 'Makeup Brushes', 'makeup-brushes', 'Set of 12 brushes', 49.99, 39.99, 65, 'https://images.unsplash.com/photo-1596462502278-27bfdc403348', false),
(4, 'Face Serum', 'face-serum', 'Anti-aging face serum', 39.99, 29.99, 85, 'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881', false),
(4, 'Hair Spray', 'hair-spray', 'Strong hold hair spray', 14.99, 9.99, 150, 'https://images.unsplash.com/photo-1527799820374-dcf8d9d4a388', false),
(4, 'Mascara', 'mascara', 'Volumizing mascara', 24.99, 19.99, 95, 'https://images.unsplash.com/photo-1583241475880-6833ddc5481d', false),
(4, 'Foundation', 'foundation', 'Full coverage foundation', 34.99, 29.99, 70, 'https://images.unsplash.com/photo-1583241475880-6833ddc5481d', false),
(4, 'Eyeliner', 'eyeliner', 'Waterproof eyeliner', 19.99, 14.99, 110, 'https://images.unsplash.com/photo-1583241475880-6833ddc5481d', false),
(4, 'Blush', 'blush', 'Natural blush', 24.99, 19.99, 85, 'https://images.unsplash.com/photo-1583241475880-6833ddc5481d', false),
(4, 'Hair Mask', 'hair-mask', 'Deep conditioning mask', 29.99, 24.99, 75, 'https://images.unsplash.com/photo-1527799820374-dcf8d9d4a388', false),
(4, 'Makeup Remover', 'makeup-remover', 'Gentle makeup remover', 19.99, 14.99, 100, 'https://images.unsplash.com/photo-1583241475880-6833ddc5481d', false);

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    address TEXT,
    phone VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create cart table
CREATE TABLE IF NOT EXISTS cart (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Create orders table
CREATE TABLE IF NOT EXISTS orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    shipping_address TEXT NOT NULL,
    payment_method VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create order_items table
CREATE TABLE IF NOT EXISTS order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
); 