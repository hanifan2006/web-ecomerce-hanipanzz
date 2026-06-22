<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Role_model');
        $this->load->library('form_validation');
        $this->load->helper('form');
    }

    public function index()
    {
        $this->require_permission('roles.manage');
        $roles = $this->Role_model->get_all();
        foreach ($roles as &$role) {
            $role['permissions'] = $this->Role_model->get_permissions($role['id']);
        }
        $this->render('admin/roles/index', array(
            'title' => 'Role & Permission',
            'roles' => $roles,
            'all_permissions' => $this->Role_model->get_all_permissions()
        ));
    }

    public function edit($id)
    {
        $this->require_permission('roles.manage');
        $role = $this->Role_model->get((int) $id);
        if (!$role || $role['slug'] === 'super_admin') {
            $this->session->set_flashdata('error', 'Role tidak dapat diubah.');
            redirect('admin/roles');
        }

        if ($this->input->method() === 'post') {
            $perm_ids = $this->input->post('permissions') ?: array();
            $this->Role_model->sync_permissions($id, $perm_ids);
            $this->log_activity('role.update', 'Mengubah permission role ID ' . $id);
            $this->session->set_flashdata('success', 'Permission role diperbarui.');
            redirect('admin/roles');
        }

        $this->render('admin/roles/edit', array(
            'title' => 'Edit Role: ' . $role['name'],
            'role' => $role,
            'permissions' => $this->Role_model->get_all_permissions(),
            'role_permission_ids' => array_column($this->Role_model->get_permissions($id), 'id')
        ));
    }
}
