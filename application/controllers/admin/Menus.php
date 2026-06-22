<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menus extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Menu_model', 'Role_model'));
        $this->load->library('form_validation');
        $this->load->helper('form');
    }

    public function index()
    {
        $this->require_permission('menus.manage');
        $roles = $this->Role_model->get_all();
        $role_menus = array();
        foreach ($roles as $role) {
            $role_menus[$role['id']] = $this->Menu_model->get_role_menu_ids($role['id']);
        }
        $this->render('admin/menus/index', array(
            'title' => 'Manajemen Menu',
            'menus' => $this->Menu_model->get_all(),
            'roles' => $roles,
            'role_menus' => $role_menus
        ));
    }

    public function create()
    {
        $this->require_permission('menus.manage');
        $this->set_menu_rules();
        if ($this->form_validation->run() === FALSE) {
            $this->render('admin/menus/form', array('title' => 'Tambah Menu', 'menu' => NULL));
            return;
        }
        $this->Menu_model->create($this->collect_menu_data());
        $this->session->set_flashdata('success', 'Menu ditambahkan.');
        redirect('admin/menus');
    }

    public function edit($id)
    {
        $this->require_permission('menus.manage');
        $menu = $this->Menu_model->get((int) $id);
        if (!$menu) show_404();
        $this->set_menu_rules();
        if ($this->form_validation->run() === FALSE) {
            $this->render('admin/menus/form', array('title' => 'Edit Menu', 'menu' => $menu));
            return;
        }
        $this->Menu_model->update($id, $this->collect_menu_data());
        $this->session->set_flashdata('success', 'Menu diperbarui.');
        redirect('admin/menus');
    }

    public function delete($id)
    {
        $this->require_permission('menus.manage');
        $this->Menu_model->delete((int) $id);
        $this->session->set_flashdata('success', 'Menu dihapus.');
        redirect('admin/menus');
    }

    public function assign_role($role_id)
    {
        $this->require_permission('menus.manage');
        if ($this->input->method() === 'post') {
            $menu_ids = $this->input->post('menus') ?: array();
            $this->Menu_model->sync_role_menus((int) $role_id, $menu_ids);
            $this->session->set_flashdata('success', 'Menu role diperbarui.');
        }
        redirect('admin/menus');
    }

    protected function set_menu_rules()
    {
        $this->form_validation->set_rules('title', 'Judul', 'required|trim');
        $this->form_validation->set_rules('url', 'URL', 'required|trim');
    }

    protected function collect_menu_data()
    {
        return array(
            'title' => $this->input->post('title', TRUE),
            'url' => $this->input->post('url', TRUE),
            'icon' => $this->input->post('icon', TRUE),
            'permission_slug' => $this->input->post('permission_slug', TRUE),
            'sort_order' => (int) $this->input->post('sort_order'),
            'is_active' => $this->input->post('is_active') ? 1 : 0
        );
    }
}
