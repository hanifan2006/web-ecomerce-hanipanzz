<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    protected $table = 'users';

    public function get($id)
    {
        return $this->db->get_where($this->table, array('id' => (int) $id))->row_array();
    }

    public function get_with_role($id)
    {
        return $this->db->select('users.*, roles.name as role_name, roles.slug as role_slug')
            ->join('roles', 'roles.id = users.role_id')
            ->get_where('users', array('users.id' => (int) $id))
            ->row_array();
    }

    public function find_by_identity($identity)
    {
        return $this->db->group_start()
            ->where('email', $identity)
            ->or_where('username', $identity)
            ->group_end()
            ->get($this->table)->row_array();
    }

    public function find_by_email($email)
    {
        return $this->db->get_where($this->table, array('email' => $email))->row_array();
    }

    public function find_by_reset_token($token)
    {
        return $this->db->where('reset_token', $token)
            ->where('reset_expires >=', date('Y-m-d H:i:s'))
            ->get($this->table)->row_array();
    }

    public function get_all($filters = array())
    {
        $this->db->select('users.*, roles.name as role_name');
        $this->db->join('roles', 'roles.id = users.role_id');
        if (!empty($filters['role_id'])) {
            $this->db->where('users.role_id', (int) $filters['role_id']);
        }
        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $this->db->group_start()
                ->like('users.full_name', $s)
                ->or_like('users.email', $s)
                ->or_like('users.username', $s)
                ->group_end();
        }
        $this->db->order_by('users.id', 'DESC');
        return $this->db->get('users')->result_array();
    }

    public function get_customers()
    {
        $this->db->select('users.*, COUNT(orders.id) as order_count, COALESCE(SUM(orders.total), 0) as total_spent');
        $this->db->from('users');
        $this->db->join('roles', 'roles.id = users.role_id');
        $this->db->join('orders', 'orders.user_id = users.id', 'left');
        $this->db->where('roles.slug', 'user');
        $this->db->group_by('users.id');
        $this->db->order_by('total_spent', 'DESC');
        return $this->db->get()->result_array();
    }

    public function create($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', (int) $id)->update($this->table, $data);
        return $this->db->affected_rows();
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, array('id' => (int) $id));
    }

    public function count_by_role($role_slug)
    {
        return $this->db->from('users')
            ->join('roles', 'roles.id = users.role_id')
            ->where('roles.slug', $role_slug)
            ->count_all_results();
    }
}
