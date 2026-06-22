<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    public function get_all()
    {
        return $this->db->order_by('sort_order')->get('menus')->result_array();
    }

    public function get($id)
    {
        return $this->db->get_where('menus', array('id' => (int) $id))->row_array();
    }

    public function get_for_user($role_id)
    {
        return $this->db->select('menus.*')
            ->join('role_menus', 'role_menus.menu_id = menus.id')
            ->where('role_menus.role_id', (int) $role_id)
            ->where('menus.is_active', 1)
            ->where('menus.parent_id IS NULL', NULL, FALSE)
            ->order_by('menus.sort_order')
            ->get('menus')->result_array();
    }

    public function get_role_menu_ids($role_id)
    {
        $rows = $this->db->select('menu_id')->get_where('role_menus', array('role_id' => (int) $role_id))->result_array();
        return array_column($rows, 'menu_id');
    }

    public function sync_role_menus($role_id, $menu_ids)
    {
        $this->db->delete('role_menus', array('role_id' => (int) $role_id));
        foreach ($menu_ids as $mid) {
            $this->db->insert('role_menus', array('role_id' => (int) $role_id, 'menu_id' => (int) $mid));
        }
    }

    public function create($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert('menus', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id', (int) $id)->update('menus', $data);
    }

    public function delete($id)
    {
        $this->db->delete('role_menus', array('menu_id' => (int) $id));
        return $this->db->delete('menus', array('id' => (int) $id));
    }
}
