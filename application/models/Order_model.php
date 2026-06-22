<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model
{
    public function get($id)
    {
        $order = $this->db->get_where('orders', array('id' => (int) $id))->row_array();
        if ($order) {
            $order['items'] = $this->get_items($order['id']);
        }
        return $order;
    }

    public function get_by_number($number)
    {
        $order = $this->db->get_where('orders', array('order_number' => $number))->row_array();
        if ($order) {
            $order['items'] = $this->get_items($order['id']);
        }
        return $order;
    }

    public function get_items($order_id)
    {
        return $this->db->get_where('order_items', array('order_id' => (int) $order_id))->result_array();
    }

    public function get_all($filters = array())
    {
        if (!empty($filters['user_id'])) {
            $this->db->where('user_id', (int) $filters['user_id']);
        }
        if (!empty($filters['email'])) {
            $this->db->where('email', $filters['email']);
        }
        if (!empty($filters['status'])) {
            $this->db->where('status', $filters['status']);
        }
        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $this->db->group_start()
                ->like('order_number', $s)
                ->or_like('customer_name', $s)
                ->or_like('email', $s)
                ->group_end();
        }
        $this->db->order_by('created_at', 'DESC');
        $orders = $this->db->get('orders')->result_array();
        foreach ($orders as &$o) {
            $o['items'] = $this->get_items($o['id']);
        }
        return $orders;
    }

    public function get_recent($limit = 5)
    {
        return $this->db->order_by('created_at', 'DESC')->limit($limit)->get('orders')->result_array();
    }

    public function get_total_revenue()
    {
        $row = $this->db->select_sum('total')
            ->where_not_in('status', array('dibatalkan'))
            ->get('orders')->row_array();
        return (float) ($row['total'] ?? 0);
    }

    public function count_all()
    {
        return $this->db->count_all('orders');
    }

    public function generate_order_number()
    {
        $count = $this->db->count_all('orders') + 1;
        return 'INV-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    public function create($order_data, $items)
    {
        $this->db->trans_start();
        $order_data['created_at'] = date('Y-m-d H:i:s');
        $order_data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->insert('orders', $order_data);
        $order_id = $this->db->insert_id();

        foreach ($items as $item) {
            $item['order_id'] = $order_id;
            $this->db->insert('order_items', $item);
        }
        $this->db->trans_complete();
        return $this->db->trans_status() ? $order_id : FALSE;
    }

    public function update_status($id, $status)
    {
        return $this->db->where('id', (int) $id)->update('orders', array(
            'status' => $status,
            'updated_at' => date('Y-m-d H:i:s')
        ));
    }

    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', (int) $id)->update('orders', $data);
    }

    public function delete($id)
    {
        $this->db->delete('order_items', array('order_id' => (int) $id));
        return $this->db->delete('orders', array('id' => (int) $id));
    }
}
