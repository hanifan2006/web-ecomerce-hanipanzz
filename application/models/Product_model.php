<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model
{
    public function get($id)
    {
        $row = $this->db->select('products.*, categories.slug as category_slug, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id')
            ->get_where('products', array('products.id' => (int) $id))
            ->row_array();
        if ($row && $row['specs']) {
            $row['specs_array'] = json_decode($row['specs'], TRUE) ?: array();
        }
        return $row;
    }

    public function get_all($filters = array())
    {
        $this->db->select('products.*, categories.slug as category_slug, categories.name as category_name');
        $this->db->join('categories', 'categories.id = products.category_id');
        $this->db->where('products.is_active', 1);

        if (!empty($filters['category'])) {
            $this->db->where('categories.slug', $filters['category']);
        }
        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $this->db->group_start()
                ->like('products.name', $s)
                ->or_like('products.brand', $s)
                ->or_like('products.specs', $s)
                ->group_end();
        }
        if (!empty($filters['promo'])) {
            $this->db->where('products.old_price IS NOT NULL', NULL, FALSE);
            $this->db->where('products.old_price > products.price', NULL, FALSE);
        }

        $sort = !empty($filters['sort']) ? $filters['sort'] : 'default';
        switch ($sort) {
            case 'price-asc': $this->db->order_by('products.price', 'ASC'); break;
            case 'price-desc': $this->db->order_by('products.price', 'DESC'); break;
            case 'sold': $this->db->order_by('products.sold', 'DESC'); break;
            case 'rating': $this->db->order_by('products.rating', 'DESC'); break;
            default: $this->db->order_by('products.id', 'ASC');
        }

        return $this->db->get('products')->result_array();
    }

    public function get_admin_list($filters = array())
    {
        $this->db->select('products.*, categories.name as category_name');
        $this->db->join('categories', 'categories.id = products.category_id');
        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $this->db->group_start()
                ->like('products.name', $s)
                ->or_like('products.brand', $s)
                ->group_end();
        }
        $this->db->order_by('products.id', 'DESC');
        return $this->db->get('products')->result_array();
    }

    public function get_low_stock($limit = 5)
    {
        return $this->db->where('stock <=', 8)
            ->order_by('stock', 'ASC')
            ->limit($limit)
            ->get('products')->result_array();
    }

    public function get_total_sold()
    {
        $row = $this->db->select_sum('sold')->get('products')->row_array();
        return (int) ($row['sold'] ?? 0);
    }

    public function create($data)
    {
        if (isset($data['specs']) && is_array($data['specs'])) {
            $data['specs'] = json_encode($data['specs']);
        }
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->insert('products', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        if (isset($data['specs']) && is_array($data['specs'])) {
            $data['specs'] = json_encode($data['specs']);
        }
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', (int) $id)->update('products', $data);
    }

    public function delete($id)
    {
        return $this->db->delete('products', array('id' => (int) $id));
    }

    public function decrease_stock($id, $qty)
    {
        $this->db->set('stock', 'stock - ' . (int) $qty, FALSE);
        $this->db->set('sold', 'sold + ' . (int) $qty, FALSE);
        $this->db->where('id', (int) $id);
        $this->db->where('stock >=', (int) $qty);
        $this->db->update('products');
        return $this->db->affected_rows() > 0;
    }

    public function count_all()
    {
        return $this->db->count_all('products');
    }
}
