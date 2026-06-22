<?php
$conn = new mysqli('localhost', 'root', '', 'laptopku_db');
if($conn->connect_error) {
    die('Koneksi gagal: ' . $conn->connect_error);
}

// Truncate table
$conn->query('TRUNCATE TABLE products');
echo "Tabel produk dikosongkan\n";

$now = date('Y-m-d H:i:s');

// Data laptop dengan gambar
$products = array(
    array(1, 2, 'Apple', 'MacBook Air M3 15', 18999000, 21000000, 15, 84, 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=300&fit=crop', 'Terlaris', 4.9, '["Apple M3 8-core","16GB Unified Memory","512GB SSD","15.3 Liquid Retina"]'),
    array(2, 1, 'ASUS', 'ROG Strix G16 RTX 4070', 22500000, 25000000, 8, 42, 'https://images.unsplash.com/photo-1588871657840-790ff3bde08c?w=400&h=300&fit=crop', 'Gaming', 4.8, '["Intel Core i9-13980HX","32GB DDR5","1TB NVMe","RTX 4070 8GB"]'),
    array(3, 3, 'Dell', 'XPS 15 OLED 2024', 24000000, NULL, 6, 29, 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=400&h=300&fit=crop', 'Creator', 4.7, '["Intel i7-13700H","32GB RAM","1TB SSD","15.6 OLED 3.5K"]'),
    array(4, 4, 'Lenovo', 'ThinkPad X1 Carbon Gen 11', 19500000, 22000000, 12, 61, 'https://images.unsplash.com/photo-1516321497487-e288fb19713f?w=400&h=300&fit=crop', 'Business', 4.6, '["Intel i7-1365U","16GB LPDDR5","512GB SSD","14 IPS Anti-glare"]'),
    array(5, 2, 'HP', 'Spectre x360 14 OLED', 16200000, NULL, 20, 55, 'https://images.unsplash.com/photo-1588944537346-46baa4852f89?w=400&h=300&fit=crop', '2-in-1', 4.5, '["Intel i7-1355U","16GB RAM","512GB SSD","14 2.8K OLED Touch"]'),
    array(6, 3, 'ASUS', 'Zenbook Pro Duo 14', 28000000, NULL, 4, 18, 'https://images.unsplash.com/photo-1570745067613-577f520fbb35?w=400&h=300&fit=crop', 'Pro', 4.8, '["Intel i9-13900H","32GB DDR5","1TB SSD","14.5 OLED + ScreenPad+"]'),
    array(7, 1, 'Acer', 'Nitro 5 RTX 4060', 12500000, 14000000, 25, 97, 'https://images.unsplash.com/photo-1603642035953-7c7e9c904b2d?w=400&h=300&fit=crop', 'Best Value', 4.4, '["Intel i5-13500H","16GB DDR5","512GB SSD","RTX 4060 8GB"]'),
    array(8, 1, 'MSI', 'Raider GE78 HX RTX 4090', 35000000, NULL, 3, 12, 'https://images.unsplash.com/photo-1613141957046-a1c374b5957b?w=400&h=300&fit=crop', 'Flagship', 5.0, '["Intel i9-14900HX","64GB DDR5","2TB SSD","RTX 4090 16GB"]'),
    array(9, 2, 'Samsung', 'Galaxy Book4 Pro 360', 17800000, 19500000, 10, 33, 'https://images.unsplash.com/photo-1584622391261-3b0a3e4e3f95?w=400&h=300&fit=crop', 'Tipis', 4.5, '["Intel Core Ultra 7","16GB RAM","512GB SSD","16 AMOLED 2K Touch"]'),
    array(10, 1, 'Lenovo', 'LOQ 15 RTX 4060', 13999000, 15000000, 18, 76, 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=300&fit=crop', 'Budget Gaming', 4.4, '["AMD Ryzen 7 7745HX","16GB DDR5","512GB SSD","RTX 4060 8GB"]'),
    array(11, 1, 'ASUS', 'TUF Gaming A16 Flip', 26000000, 28500000, 7, 31, 'https://images.unsplash.com/photo-1611532736597-de2d4265fba3?w=400&h=300&fit=crop', 'Flip', 4.7, '["Intel Core i9-14900H","32GB DDR5","1TB SSD","16 IPS 165Hz"]'),
    array(12, 1, 'Razer', 'Blade 16 RTX 4090', 32000000, NULL, 5, 18, 'https://images.unsplash.com/photo-1617638924702-92d37bc6291f?w=400&h=300&fit=crop', 'Pro Gaming', 4.9, '["Intel i9-14900HX","64GB DDR5","2TB SSD","16 QHD 240Hz"]'),
    array(13, 2, 'Lenovo', 'Yoga 9i Gen 8', 18500000, 20000000, 9, 44, 'https://images.unsplash.com/photo-1589933382359-29fb9d05cc9b?w=400&h=300&fit=crop', 'Tipis', 4.6, '["Intel Core Ultra 9","16GB LPDDR5X","512GB SSD","14 2.8K OLED"]'),
    array(14, 2, 'LG', 'Gram 17 Ultra', 20500000, 22000000, 8, 25, 'https://images.unsplash.com/photo-1588871657840-790ff3bde08c?w=400&h=300&fit=crop', 'Ringan', 4.5, '["Intel Core Ultra 7","16GB LPDDR5X","512GB SSD","17 16:10 IPS"]'),
    array(15, 3, 'MacBook', 'Pro 16 M3 Max', 32999000, 35000000, 4, 22, 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=300&fit=crop', 'Pro', 5.0, '["Apple M3 Max 12-core","36GB Unified Memory","1TB SSD","16 Liquid Retina XDR"]'),
    array(16, 3, 'ASUS', 'ProArt Studiobook Pro 14', 29500000, 32000000, 6, 19, 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=400&h=300&fit=crop', 'Studio', 4.8, '["Intel i9-14900H","48GB DDR5","2TB SSD","14 OLED Touch"]'),
    array(17, 3, 'HP', 'ZBook Studio Pro 16', 28000000, 30500000, 5, 15, 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=300&fit=crop', 'Workstation', 4.7, '["Intel Core i9-13900H","32GB DDR5","1TB SSD","16 4K DCI"]'),
    array(18, 3, 'Lenovo', 'ThinkBook Plus Gen 5', 21000000, 23000000, 10, 36, 'https://images.unsplash.com/photo-1588944537346-46baa4852f89?w=400&h=300&fit=crop', 'Creator', 4.6, '["Intel Core i7-14700H","16GB DDR5","512GB SSD","14.4 OLED 2.8K"]'),
    array(19, 4, 'Dell', 'Latitude 5450', 17800000, 19500000, 14, 53, 'https://images.unsplash.com/photo-1516321497487-e288fb19713f?w=400&h=300&fit=crop', 'Business', 4.5, '["Intel Core i7-1365U","16GB LPDDR5","512GB SSD","14 FHD Anti-glare"]'),
    array(20, 4, 'HP', 'EliteBook 840 G10', 18500000, 20000000, 11, 48, 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=300&fit=crop', 'Enterprise', 4.6, '["Intel Core i7-1365U","16GB LPDDR5","512GB SSD","14 16:10 IPS"]'),
    array(21, 4, 'ASUS', 'ExpertBook B7 Flip', 23500000, 25000000, 7, 28, 'https://images.unsplash.com/photo-1588871657840-790ff3bde08c?w=400&h=300&fit=crop', 'Konvertibel', 4.7, '["Intel Core i7-1395U","32GB DDR5","1TB SSD","14 FHD Touchscreen"]'),
    array(22, 4, 'Lenovo', 'ThinkPad T14s Gen 5', 21500000, 23000000, 9, 41, 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=300&fit=crop', 'Tipis', 4.8, '["Intel Core i7-1465U","16GB DDR5","512GB SSD","14 2.8K IPS Touch"]'),
    array(23, 4, 'Fujitsu', 'LifeBook E5540', 19500000, 21000000, 8, 35, 'https://images.unsplash.com/photo-1588944537346-46baa4852f89?w=400&h=300&fit=crop', 'Bisnis', 4.4, '["Intel Core i5-1340U","16GB DDR5","512GB SSD","15.6 FHD IPS"]'),
    array(24, 2, 'MSI', 'Summit E14 Evo', 19800000, 21500000, 6, 22, 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=300&fit=crop', 'Tipis', 4.7, '["Intel Core i7-1495U","16GB DDR5","512GB SSD","14 4K IPS Touch"]'),
);

foreach ($products as $p) {
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $p[2] . '-' . $p[3]), '-'));
    $old_price = $p[5] ? $p[5] : 'NULL';
    
    $sql = "INSERT INTO products (id, category_id, brand, name, slug, price, old_price, stock, sold, image, badge, rating, specs, is_active, created_at) 
            VALUES ({$p[0]}, {$p[1]}, '{$p[2]}', '{$p[3]}', '{$slug}', {$p[4]}, {$old_price}, {$p[6]}, {$p[7]}, '{$p[8]}', '{$p[9]}', {$p[10]}, '{$p[11]}', 1, '{$now}')";
    
    if(!$conn->query($sql)) {
        echo "Error: " . $conn->error . "\n";
    }
}

$result = $conn->query('SELECT COUNT(*) as total FROM products');
$row = $result->fetch_assoc();
echo "Total produk berhasil ditambahkan: " . $row['total'] . "\n";

$conn->close();
?>
