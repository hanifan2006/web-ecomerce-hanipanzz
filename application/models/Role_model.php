<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends CI_Model
{
    public function get($id)
    {
        return $this->db->get_where('roles', array('id' => (int) $id))->row_array();
    }

    public function get_id_by_slug($slug)
    {
        $row = $this->db->get_where('roles', array('slug' => $slug))->row_array();
        return $row ? (int) $row['id'] : 0;
    }

    public function get_all()
    {
        return $this->db->order_by('id')->get('roles')->result_array();
    }

    public function has_permission($role_id, $permission_slug)
    {
        return (bool) $this->db->from('role_permissions')
            ->join('permissions', 'permissions.id = role_permissions.permission_id')
            ->where('role_permissions.role_id', (int) $role_id)
            ->where('permissions.slug', $permission_slug)
            ->count_all_results();
    }

    public function get_permissions($role_id)
    {
        return $this->db->select('permissions.*')
            ->join('permissions', 'permissions.id = role_permissions.permission_id')
            ->where('role_permissions.role_id', (int) $role_id)
            ->get('role_permissions')->result_array();
    }

    public function get_all_permissions()
    {
        return $this->db->order_by('id')->get('permissions')->result_array();
    }

    public function sync_permissions($role_id, $permission_ids)
    {
        $this->db->delete('role_permissions', array('role_id' => (int) $role_id));
        foreach ($permission_ids as $pid) {
            $this->db->insert('role_permissions', array(
                'role_id' => (int) $role_id,
                'permission_id' => (int) $pid
            ));
        }
    }

    public function create($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->insert('roles', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', (int) $id)->update('roles', $data);
    }

    public function delete($id)
    {
        $this->db->delete('role_permissions', array('role_id' => (int) $id));
        $this->db->delete('role_menus', array('role_id' => (int) $id));
        return $this->db->delete('roles', array('id' => (int) $id));
    }
}
