<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Initial_schema extends CI_Migration
{
    public function up()
    {
        // Roles
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'name' => array('type' => 'VARCHAR', 'constraint' => 50),
            'slug' => array('type' => 'VARCHAR', 'constraint' => 50),
            'description' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
            'created_at' => array('type' => 'DATETIME', 'null' => TRUE),
            'updated_at' => array('type' => 'DATETIME', 'null' => TRUE),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('slug');
        $this->dbforge->create_table('roles', TRUE);

        // Permissions
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'name' => array('type' => 'VARCHAR', 'constraint' => 100),
            'slug' => array('type' => 'VARCHAR', 'constraint' => 100),
            'description' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
            'created_at' => array('type' => 'DATETIME', 'null' => TRUE),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('slug');
        $this->dbforge->create_table('permissions', TRUE);

        // Role permissions
        $this->dbforge->add_field(array(
            'role_id' => array('type' => 'INT', 'unsigned' => TRUE),
            'permission_id' => array('type' => 'INT', 'unsigned' => TRUE),
        ));
        $this->dbforge->add_key(array('role_id', 'permission_id'), TRUE);
        $this->dbforge->create_table('role_permissions', TRUE);

        // Menus
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'parent_id' => array('type' => 'INT', 'unsigned' => TRUE, 'null' => TRUE),
            'title' => array('type' => 'VARCHAR', 'constraint' => 100),
            'url' => array('type' => 'VARCHAR', 'constraint' => 255),
            'icon' => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => TRUE),
            'permission_slug' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => TRUE),
            'sort_order' => array('type' => 'INT', 'default' => 0),
            'is_active' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
            'created_at' => array('type' => 'DATETIME', 'null' => TRUE),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('menus', TRUE);

        // Role menus
        $this->dbforge->add_field(array(
            'role_id' => array('type' => 'INT', 'unsigned' => TRUE),
            'menu_id' => array('type' => 'INT', 'unsigned' => TRUE),
        ));
        $this->dbforge->add_key(array('role_id', 'menu_id'), TRUE);
        $this->dbforge->create_table('role_menus', TRUE);

        // Users
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'role_id' => array('type' => 'INT', 'unsigned' => TRUE),
            'username' => array('type' => 'VARCHAR', 'constraint' => 50),
            'email' => array('type' => 'VARCHAR', 'constraint' => 100),
            'password' => array('type' => 'VARCHAR', 'constraint' => 255),
            'full_name' => array('type' => 'VARCHAR', 'constraint' => 100),
            'phone' => array('type' => 'VARCHAR', 'constraint' => 20, 'null' => TRUE),
            'avatar' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
            'remember_token' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
            'remember_expires' => array('type' => 'DATETIME', 'null' => TRUE),
            'reset_token' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
            'reset_expires' => array('type' => 'DATETIME', 'null' => TRUE),
            'is_active' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
            'last_login' => array('type' => 'DATETIME', 'null' => TRUE),
            'created_at' => array('type' => 'DATETIME', 'null' => TRUE),
            'updated_at' => array('type' => 'DATETIME', 'null' => TRUE),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('username');
        $this->dbforge->add_key('email');
        $this->dbforge->create_table('users', TRUE);

        // Categories
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'slug' => array('type' => 'VARCHAR', 'constraint' => 50),
            'name' => array('type' => 'VARCHAR', 'constraint' => 100),
            'is_active' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
            'created_at' => array('type' => 'DATETIME', 'null' => TRUE),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('slug');
        $this->dbforge->create_table('categories', TRUE);

        // Products
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'category_id' => array('type' => 'INT', 'unsigned' => TRUE),
            'brand' => array('type' => 'VARCHAR', 'constraint' => 50),
            'name' => array('type' => 'VARCHAR', 'constraint' => 200),
            'slug' => array('type' => 'VARCHAR', 'constraint' => 220, 'null' => TRUE),
            'price' => array('type' => 'DECIMAL', 'constraint' => '15,2'),
            'old_price' => array('type' => 'DECIMAL', 'constraint' => '15,2', 'null' => TRUE),
            'stock' => array('type' => 'INT', 'default' => 0),
            'sold' => array('type' => 'INT', 'default' => 0),
            'image' => array('type' => 'VARCHAR', 'constraint' => 255, 'null' => TRUE),
            'icon' => array('type' => 'VARCHAR', 'constraint' => 20, 'null' => TRUE),
            'badge' => array('type' => 'VARCHAR', 'constraint' => 50, 'null' => TRUE),
            'rating' => array('type' => 'DECIMAL', 'constraint' => '2,1', 'default' => '4.0'),
            'specs' => array('type' => 'TEXT', 'null' => TRUE),
            'is_active' => array('type' => 'TINYINT', 'constraint' => 1, 'default' => 1),
            'created_at' => array('type' => 'DATETIME', 'null' => TRUE),
            'updated_at' => array('type' => 'DATETIME', 'null' => TRUE),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('category_id');
        $this->dbforge->create_table('products', TRUE);

        // Orders
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'order_number' => array('type' => 'VARCHAR', 'constraint' => 20),
            'user_id' => array('type' => 'INT', 'unsigned' => TRUE, 'null' => TRUE),
            'customer_name' => array('type' => 'VARCHAR', 'constraint' => 100),
            'email' => array('type' => 'VARCHAR', 'constraint' => 100),
            'phone' => array('type' => 'VARCHAR', 'constraint' => 20),
            'address' => array('type' => 'TEXT'),
            'city' => array('type' => 'VARCHAR', 'constraint' => 100),
            'zip_code' => array('type' => 'VARCHAR', 'constraint' => 10, 'null' => TRUE),
            'note' => array('type' => 'TEXT', 'null' => TRUE),
            'payment_method' => array('type' => 'VARCHAR', 'constraint' => 20),
            'subtotal' => array('type' => 'DECIMAL', 'constraint' => '15,2'),
            'shipping_cost' => array('type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0),
            'total' => array('type' => 'DECIMAL', 'constraint' => '15,2'),
            'status' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => 'diproses'),
            'created_at' => array('type' => 'DATETIME', 'null' => TRUE),
            'updated_at' => array('type' => 'DATETIME', 'null' => TRUE),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('order_number');
        $this->dbforge->add_key('user_id');
        $this->dbforge->create_table('orders', TRUE);

        // Order items
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'order_id' => array('type' => 'INT', 'unsigned' => TRUE),
            'product_id' => array('type' => 'INT', 'unsigned' => TRUE, 'null' => TRUE),
            'product_name' => array('type' => 'VARCHAR', 'constraint' => 200),
            'qty' => array('type' => 'INT'),
            'price' => array('type' => 'DECIMAL', 'constraint' => '15,2'),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('order_id');
        $this->dbforge->create_table('order_items', TRUE);

        // Settings
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'setting_key' => array('type' => 'VARCHAR', 'constraint' => 100),
            'setting_value' => array('type' => 'TEXT', 'null' => TRUE),
            'updated_at' => array('type' => 'DATETIME', 'null' => TRUE),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('setting_key');
        $this->dbforge->create_table('settings', TRUE);

        // Activity logs
        $this->dbforge->add_field(array(
            'id' => array('type' => 'INT', 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'user_id' => array('type' => 'INT', 'unsigned' => TRUE, 'null' => TRUE),
            'action' => array('type' => 'VARCHAR', 'constraint' => 100),
            'description' => array('type' => 'TEXT', 'null' => TRUE),
            'ip_address' => array('type' => 'VARCHAR', 'constraint' => 45, 'null' => TRUE),
            'created_at' => array('type' => 'DATETIME', 'null' => TRUE),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('activity_logs', TRUE);
    }

    public function down()
    {
        $tables = array('activity_logs', 'settings', 'order_items', 'orders', 'products', 'categories', 'users', 'role_menus', 'menus', 'role_permissions', 'permissions', 'roles');
        foreach ($tables as $table) {
            $this->dbforge->drop_table($table, TRUE);
        }
    }
}
