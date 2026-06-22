<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Seed_data extends CI_Migration
{
    public function up()
    {
        $now = date('Y-m-d H:i:s');
        $pass = password_hash('password123', PASSWORD_BCRYPT);

        // Roles
        $this->db->insert_batch('roles', array(
            array('id' => 1, 'name' => 'Super Admin', 'slug' => 'super_admin', 'description' => 'Akses penuh sistem', 'created_at' => $now),
            array('id' => 2, 'name' => 'Admin', 'slug' => 'admin', 'description' => 'Kelola toko', 'created_at' => $now),
            array('id' => 3, 'name' => 'User', 'slug' => 'user', 'description' => 'Pelanggan', 'created_at' => $now),
        ));

        // Permissions
        $perms = array(
            array('name' => 'Dashboard', 'slug' => 'dashboard.view'),
            array('name' => 'Kelola Produk', 'slug' => 'products.manage'),
            array('name' => 'Kelola Pesanan', 'slug' => 'orders.manage'),
            array('name' => 'Kelola Pelanggan', 'slug' => 'customers.view'),
            array('name' => 'Kelola User', 'slug' => 'users.manage'),
            array('name' => 'Kelola Role', 'slug' => 'roles.manage'),
            array('name' => 'Kelola Menu', 'slug' => 'menus.manage'),
            array('name' => 'Pengaturan', 'slug' => 'settings.manage'),
            array('name' => 'Log Aktivitas', 'slug' => 'logs.view'),
        );
        foreach ($perms as $i => $p) {
            $p['id'] = $i + 1;
            $p['created_at'] = $now;
            $this->db->insert('permissions', $p);
        }

        // Super admin gets all permissions
        for ($i = 1; $i <= 9; $i++) {
            $this->db->insert('role_permissions', array('role_id' => 1, 'permission_id' => $i));
        }
        // Admin permissions (no users, roles, menus manage)
        foreach (array(1, 2, 3, 4, 8, 9) as $pid) {
            $this->db->insert('role_permissions', array('role_id' => 2, 'permission_id' => $pid));
        }

        // Menus
        $menus = array(
            array('id' => 1, 'parent_id' => NULL, 'title' => 'Dashboard', 'url' => 'admin/dashboard', 'icon' => 'fas fa-tachometer-alt', 'permission_slug' => 'dashboard.view', 'sort_order' => 1),
            array('id' => 2, 'parent_id' => NULL, 'title' => 'Produk', 'url' => 'admin/products', 'icon' => 'fas fa-laptop', 'permission_slug' => 'products.manage', 'sort_order' => 2),
            array('id' => 3, 'parent_id' => NULL, 'title' => 'Pesanan', 'url' => 'admin/orders', 'icon' => 'fas fa-shopping-cart', 'permission_slug' => 'orders.manage', 'sort_order' => 3),
            array('id' => 4, 'parent_id' => NULL, 'title' => 'Pelanggan', 'url' => 'admin/customers', 'icon' => 'fas fa-users', 'permission_slug' => 'customers.view', 'sort_order' => 4),
            array('id' => 5, 'parent_id' => NULL, 'title' => 'Riwayat', 'url' => 'admin/orders/history', 'icon' => 'fas fa-history', 'permission_slug' => 'orders.manage', 'sort_order' => 5),
            array('id' => 6, 'parent_id' => NULL, 'title' => 'Pengguna', 'url' => 'admin/users', 'icon' => 'fas fa-user-cog', 'permission_slug' => 'users.manage', 'sort_order' => 6),
            array('id' => 7, 'parent_id' => NULL, 'title' => 'Role & Permission', 'url' => 'admin/roles', 'icon' => 'fas fa-shield-alt', 'permission_slug' => 'roles.manage', 'sort_order' => 7),
            array('id' => 8, 'parent_id' => NULL, 'title' => 'Menu', 'url' => 'admin/menus', 'icon' => 'fas fa-bars', 'permission_slug' => 'menus.manage', 'sort_order' => 8),
            array('id' => 9, 'parent_id' => NULL, 'title' => 'Pengaturan', 'url' => 'admin/settings', 'icon' => 'fas fa-cog', 'permission_slug' => 'settings.manage', 'sort_order' => 9),
            array('id' => 10, 'parent_id' => NULL, 'title' => 'Log Aktivitas', 'url' => 'admin/activity_logs', 'icon' => 'fas fa-clipboard-list', 'permission_slug' => 'logs.view', 'sort_order' => 10),
        );
        foreach ($menus as $m) {
            $m['is_active'] = 1;
            $m['created_at'] = $now;
            $this->db->insert('menus', $m);
        }

        // Role menus
        for ($mid = 1; $mid <= 10; $mid++) {
            $this->db->insert('role_menus', array('role_id' => 1, 'menu_id' => $mid));
        }
        foreach (array(1, 2, 3, 4, 5, 9, 10) as $mid) {
            $this->db->insert('role_menus', array('role_id' => 2, 'menu_id' => $mid));
        }

        // Users
        $this->db->insert_batch('users', array(
            array('role_id' => 1, 'username' => 'superadmin', 'email' => 'superadmin@laptopku.id', 'password' => $pass, 'full_name' => 'Super Admin', 'phone' => '081234567890', 'is_active' => 1, 'created_at' => $now),
            array('role_id' => 2, 'username' => 'admin', 'email' => 'admin@laptopku.id', 'password' => $pass, 'full_name' => 'Admin Nipzz!! Store', 'phone' => '081234567891', 'is_active' => 1, 'created_at' => $now),
            array('role_id' => 3, 'username' => 'user', 'email' => 'user@laptopku.id', 'password' => $pass, 'full_name' => 'User Demo', 'phone' => '081234567892', 'is_active' => 1, 'created_at' => $now),
            array('role_id' => 3, 'username' => 'budi', 'email' => 'budi@gmail.com', 'password' => $pass, 'full_name' => 'Budi Santoso', 'phone' => '0812-3456-7890', 'is_active' => 1, 'created_at' => $now),
            array('role_id' => 3, 'username' => 'siti', 'email' => 'siti@yahoo.com', 'password' => $pass, 'full_name' => 'Siti Rahayu', 'phone' => '0823-4567-890', 'is_active' => 1, 'created_at' => $now),
        ));

        // Categories
        $cats = array(
            array('slug' => 'gaming', 'name' => 'Gaming'),
            array('slug' => 'ultrabook', 'name' => 'Ultrabook'),
            array('slug' => 'creator', 'name' => 'Creator'),
            array('slug' => 'business', 'name' => 'Business'),
        );
        foreach ($cats as $i => $c) {
            $c['id'] = $i + 1;
            $c['is_active'] = 1;
            $c['created_at'] = $now;
            $this->db->insert('categories', $c);
        }

        // Products from original demo data
        $products = array(
            array(1, 2, 'Apple', 'MacBook Air M3 15"', 18999000, 21000000, 15, 84, 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=300&fit=crop', '💻', 'Terlaris', 4.9, '["Apple M3 8-core","16GB Unified Memory","512GB SSD","15.3\\" Liquid Retina"]'),
            array(2, 1, 'ASUS', 'ROG Strix G16 RTX 4070', 22500000, 25000000, 8, 42, 'https://images.unsplash.com/photo-1588872657840-790ff3bde08c?w=400&h=300&fit=crop', '🎮', 'Gaming', 4.8, '["Intel Core i9-13980HX","32GB DDR5","1TB NVMe","RTX 4070 8GB"]'),
            array(3, 3, 'Dell', 'XPS 15 OLED 2024', 24000000, NULL, 6, 29, 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=400&h=300&fit=crop', '💻', 'Creator', 4.7, '["Intel i7-13700H","32GB RAM","1TB SSD","15.6\\" OLED 3.5K"]'),
            array(4, 4, 'Lenovo', 'ThinkPad X1 Carbon Gen 11', 19500000, 22000000, 12, 61, 'https://images.unsplash.com/photo-1516321497487-e288fb19713f?w=400&h=300&fit=crop', '💼', 'Business', 4.6, '["Intel i7-1365U","16GB LPDDR5","512GB SSD","14\\" IPS Anti-glare"]'),
            array(5, 2, 'HP', 'Spectre x360 14 OLED', 16200000, NULL, 20, 55, 'https://images.unsplash.com/photo-1588944537346-46baa4852f89?w=400&h=300&fit=crop', '💻', '2-in-1', 4.5, '["Intel i7-1355U","16GB RAM","512GB SSD","14\\" 2.8K OLED Touch"]'),
            array(6, 3, 'ASUS', 'Zenbook Pro Duo 14', 28000000, NULL, 4, 18, 'https://images.unsplash.com/photo-1570745067613-577f520fbb35?w=400&h=300&fit=crop', '🎨', 'Pro', 4.8, '["Intel i9-13900H","32GB DDR5","1TB SSD","14.5\\" OLED + ScreenPad+"]'),
            array(7, 1, 'Acer', 'Nitro 5 RTX 4060', 12500000, 14000000, 25, 97, 'https://images.unsplash.com/photo-1603642035953-7c7e9c904b2d?w=400&h=300&fit=crop', '⚡', 'Best Value', 4.4, '["Intel i5-13500H","16GB DDR5","512GB SSD","RTX 4060 8GB"]'),
            array(8, 1, 'MSI', 'Raider GE78 HX RTX 4090', 35000000, NULL, 3, 12, 'https://images.unsplash.com/photo-1613141957046-a1c374b5957b?w=400&h=300&fit=crop', '🔥', 'Flagship', 5.0, '["Intel i9-14900HX","64GB DDR5","2TB SSD","RTX 4090 16GB"]'),
            array(9, 2, 'Samsung', 'Galaxy Book4 Pro 360', 17800000, 19500000, 10, 33, 'https://images.unsplash.com/photo-1584622391261-3b0a3e4e3f95?w=400&h=300&fit=crop', '💻', 'Tipis', 4.5, '["Intel Core Ultra 7","16GB RAM","512GB SSD","16\\" AMOLED 2K Touch"]'),
            array(10, 1, 'Lenovo', 'LOQ 15 RTX 4060', 13999000, 15000000, 18, 76, 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=300&fit=crop', '🎮', 'Budget Gaming', 4.4, '["AMD Ryzen 7 7745HX","16GB DDR5","512GB SSD","RTX 4060 8GB"]'),
            // Gaming kategori - 2 produk tambahan
            array(11, 1, 'ASUS', 'TUF Gaming A16 Flip', 26000000, 28500000, 7, 31, 'https://images.unsplash.com/photo-1611532736597-de2d4265fba3?w=400&h=300&fit=crop', '🎮', 'Flip', 4.7, '["Intel Core i9-14900H","32GB DDR5","1TB SSD","16\\" IPS 165Hz","RTX 4080 12GB"]'),
            array(12, 1, 'Razer', 'Blade 16 RTX 4090', 32000000, NULL, 5, 18, 'https://images.unsplash.com/photo-1617638924702-92d37bc6291f?w=400&h=300&fit=crop', '🎮', 'Pro Gaming', 4.9, '["Intel i9-14900HX","64GB DDR5","2TB SSD","16\\" QHD 240Hz","RTX 4090 16GB"]'),
            // Ultrabook kategori - 2 produk tambahan
            array(13, 2, 'Lenovo', 'Yoga 9i Gen 8', 18500000, 20000000, 9, 44, 'https://images.unsplash.com/photo-1589933382359-29fb9d05cc9b?w=400&h=300&fit=crop', '💻', 'Tipis', 4.6, '["Intel Core Ultra 9","16GB LPDDR5X","512GB SSD","14\\" 2.8K OLED","2-in-1 Convertible"]'),
            array(14, 2, 'LG', 'Gram 17 Ultra', 20500000, 22000000, 8, 25, 'https://images.unsplash.com/photo-1588871657840-790ff3bde08c?w=400&h=300&fit=crop', '💻', 'Ringan', 4.5, '["Intel Core Ultra 7","16GB LPDDR5X","512GB SSD","17\\" 16:10 IPS","1.39kg"]'),
            // Creator kategori - 4 produk tambahan
            array(15, 3, 'MacBook', 'Pro 16 M3 Max', 32999000, 35000000, 4, 22, 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=300&fit=crop', '🎨', 'Pro', 5.0, '["Apple M3 Max 12-core","36GB Unified Memory","1TB SSD","16\\" Liquid Retina XDR"]'),
            array(16, 3, 'ASUS', 'ProArt Studiobook Pro 14', 29500000, 32000000, 6, 19, 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=400&h=300&fit=crop', '🎨', 'Studio', 4.8, '["Intel i9-14900H","48GB DDR5","2TB SSD","14\\" OLED Touch","RTX 4090 Ada"]'),
            array(17, 3, 'HP', 'ZBook Studio Pro 16', 28000000, 30500000, 5, 15, 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=300&fit=crop', '🎨', 'Workstation', 4.7, '["Intel Core i9-13900H","32GB DDR5","1TB SSD","16\\" 4K DCI","RTX 6000 Ada"]'),
            array(18, 3, 'Lenovo', 'ThinkBook Plus Gen 5', 21000000, 23000000, 10, 36, 'https://images.unsplash.com/photo-1588944537346-46baa4852f89?w=400&h=300&fit=crop', '🎨', 'Creator', 4.6, '["Intel Core i7-14700H","16GB DDR5","512GB SSD","14.4\\" OLED 2.8K"]'),
            // Business kategori - 5 produk tambahan
            array(19, 4, 'Dell', 'Latitude 5450', 17800000, 19500000, 14, 53, 'https://images.unsplash.com/photo-1516321497487-e288fb19713f?w=400&h=300&fit=crop', '💼', 'Business', 4.5, '["Intel Core i7-1365U","16GB LPDDR5","512GB SSD","14\\" FHD Anti-glare"]'),
            array(20, 4, 'HP', 'EliteBook 840 G10', 18500000, 20000000, 11, 48, 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=300&fit=crop', '💼', 'Enterprise', 4.6, '["Intel Core i7-1365U","16GB LPDDR5","512GB SSD","14\\" 16:10 IPS"]'),
            array(21, 4, 'ASUS', 'ExpertBook B7 Flip', 23500000, 25000000, 7, 28, 'https://images.unsplash.com/photo-1588871657840-790ff3bde08c?w=400&h=300&fit=crop', '💼', 'Konvertibel', 4.7, '["Intel Core i7-1395U","32GB DDR5","1TB SSD","14\\" FHD Touchscreen"]'),
            array(22, 4, 'Lenovo', 'ThinkPad T14s Gen 5', 21500000, 23000000, 9, 41, 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=300&fit=crop', '💼', 'Tipis', 4.8, '["Intel Core i7-1465U","16GB DDR5","512GB SSD","14\\" 2.8K IPS Touch"]'),
            array(23, 4, 'Fujitsu', 'LifeBook E5540', 19500000, 21000000, 8, 35, 'https://images.unsplash.com/photo-1588944537346-46baa4852f89?w=400&h=300&fit=crop', '💼', 'Bisnis', 4.4, '["Intel Core i5-1340U","16GB DDR5","512GB SSD","15.6\\" FHD IPS","AES128 Encryption"]'),
            // Ultrabook kategori - produk ke-6
            array(24, 2, 'MSI', 'Summit E14 Evo', 19800000, 21500000, 6, 22, 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=400&h=300&fit=crop', '💻', 'Tipis', 4.7, '["Intel Core i7-1495U","16GB DDR5","512GB SSD","14\\" 4K IPS Touch","1.29kg"]'),
        );
        foreach ($products as $p) {
            $this->db->insert('products', array(
                'id' => $p[0], 'category_id' => $p[1], 'brand' => $p[2], 'name' => $p[3],
                'slug' => url_title($p[2] . '-' . $p[3], '-', TRUE),
                'price' => $p[4], 'old_price' => $p[5], 'stock' => $p[6], 'sold' => $p[7],
                'image' => $p[8], 'icon' => $p[9], 'badge' => $p[10], 'rating' => $p[11],
                'specs' => $p[12], 'is_active' => 1, 'created_at' => $now
            ));
        }

        // Sample orders
        $orders = array(
            array('INV-0001', 4, 'Budi Santoso', 'budi@gmail.com', '0812-3456-7890', 'Jl. Merdeka No. 10', 'Jakarta Selatan', '12930', '', 'transfer', 18999000, 50000, 19049000, 'selesai', '2025-01-10'),
            array('INV-0002', 5, 'Siti Rahayu', 'siti@yahoo.com', '0823-4567-890', 'Jl. Sudirman No. 5', 'Bandung', '40111', '', 'qris', 22500000, 50000, 22550000, 'dikirim', '2025-01-11'),
            array('INV-0003', 4, 'Ahmad Fauzi', 'ahmad@mail.com', '0834-5678-901', 'Jl. Pahlawan 3', 'Surabaya', '60111', '', 'cod', 31499000, 50000, 31549000, 'diproses', '2025-01-12'),
            array('INV-0004', 5, 'Rina Wulandari', 'rina@gmail.com', '0845-6789-012', 'Jl. Gatot Subroto 7', 'Semarang', '50111', '', 'ewallet', 16200000, 50000, 16250000, 'selesai', '2025-01-13'),
        );
        foreach ($orders as $i => $o) {
            $this->db->insert('orders', array(
                'id' => $i + 1, 'order_number' => $o[0], 'user_id' => $o[1], 'customer_name' => $o[2],
                'email' => $o[3], 'phone' => $o[4], 'address' => $o[5], 'city' => $o[6],
                'zip_code' => $o[7], 'note' => $o[8], 'payment_method' => $o[9],
                'subtotal' => $o[10], 'shipping_cost' => $o[11], 'total' => $o[12],
                'status' => $o[13], 'created_at' => $o[14] . ' 10:00:00', 'updated_at' => $now
            ));
        }

        $items = array(
            array(1, 1, 1, 'MacBook Air M3 15"', 1, 18999000),
            array(2, 2, 2, 'ROG Strix G16 RTX 4070', 1, 22500000),
            array(3, 3, 7, 'Acer Nitro 5 RTX 4060', 1, 12500000),
            array(4, 3, 1, 'MacBook Air M3 15"', 1, 18999000),
            array(5, 4, 5, 'HP Spectre x360 14 OLED', 1, 16200000),
        );
        foreach ($items as $it) {
            $this->db->insert('order_items', array(
                'id' => $it[0], 'order_id' => $it[1], 'product_id' => $it[2],
                'product_name' => $it[3], 'qty' => $it[4], 'price' => $it[5]
            ));
        }

        // Settings
        $settings = array(
            'site_name' => 'Nipzz!! Store',
            'site_tagline' => 'Toko laptop terpercaya dengan ribuan pilihan dari brand ternama dunia.',
            'site_email' => 'cs@laptopku.id',
            'site_phone' => '0812-3456-7890',
            'site_address' => 'Jl. Teknologi No. 88, Kawasan Niaga Digital, Jakarta Selatan 12930',
            'shipping_cost' => '50000',
            'bank_account' => 'BCA 1234567890 a.n. Nipzz!! Store Indonesia',
        );
        foreach ($settings as $k => $v) {
            $this->db->insert('settings', array('setting_key' => $k, 'setting_value' => $v, 'updated_at' => $now));
        }
    }

    public function down()
    {
        $this->db->truncate('activity_logs');
        $this->db->truncate('settings');
        $this->db->truncate('order_items');
        $this->db->truncate('orders');
        $this->db->truncate('products');
        $this->db->truncate('categories');
        $this->db->truncate('users');
        $this->db->truncate('role_menus');
        $this->db->truncate('menus');
        $this->db->truncate('role_permissions');
        $this->db->truncate('permissions');
        $this->db->truncate('roles');
    }
}
