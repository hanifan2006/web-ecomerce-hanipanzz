<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('User_model', 'Role_model'));
        $this->load->library('form_validation');
        $this->load->helper('form');
    }

    public function index()
    {
        $this->require_permission('users.manage');
        $this->render('admin/users/index', array(
            'title' => 'Pengguna',
            'users' => $this->User_model->get_all(array('search' => $this->input->get('q', TRUE))),
            'roles' => $this->Role_model->get_all()
        ));
    }

    public function create()
    {
        $this->require_permission('users.manage');
        $this->set_user_rules();
        if ($this->form_validation->run() === FALSE) {
            $this->render('admin/users/form', array('title' => 'Tambah Pengguna', 'user' => NULL, 'roles' => $this->Role_model->get_all()));
            return;
        }
        $this->User_model->create(array(
            'role_id' => (int) $this->input->post('role_id'),
            'username' => $this->input->post('username', TRUE),
            'email' => $this->input->post('email', TRUE),
            'full_name' => $this->input->post('full_name', TRUE),
            'phone' => $this->input->post('phone', TRUE),
            'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
            'is_active' => $this->input->post('is_active') ? 1 : 0
        ));
        $this->log_activity('user.create', 'Menambah pengguna');
        $this->session->set_flashdata('success', 'Pengguna berhasil ditambahkan.');
        redirect('admin/users');
    }

    public function edit($id)
    {
        $this->require_permission('users.manage');
        $user = $this->User_model->get((int) $id);
        if (!$user) show_404();
        $this->set_user_rules($id);
        if ($this->form_validation->run() === FALSE) {
            $this->render('admin/users/form', array('title' => 'Edit Pengguna', 'user' => $user, 'roles' => $this->Role_model->get_all()));
            return;
        }
        $data = array(
            'role_id' => (int) $this->input->post('role_id'),
            'username' => $this->input->post('username', TRUE),
            'email' => $this->input->post('email', TRUE),
            'full_name' => $this->input->post('full_name', TRUE),
            'phone' => $this->input->post('phone', TRUE),
            'is_active' => $this->input->post('is_active') ? 1 : 0
        );
        if ($this->input->post('password')) {
            $data['password'] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
        }
        $this->User_model->update($id, $data);
        $this->log_activity('user.update', 'Mengubah pengguna ID ' . $id);
        $this->session->set_flashdata('success', 'Pengguna diperbarui.');
        redirect('admin/users');
    }

    public function delete($id)
    {
        $this->require_permission('users.manage');
        if ((int) $id === (int) $this->current_user['id']) {
            $this->session->set_flashdata('error', 'Tidak dapat menghapus akun sendiri.');
            redirect('admin/users');
        }
        $this->User_model->delete((int) $id);
        $this->log_activity('user.delete', 'Menghapus pengguna ID ' . $id);
        $this->session->set_flashdata('success', 'Pengguna dihapus.');
        redirect('admin/users');
    }

    protected function set_user_rules($id = NULL)
    {
        $this->form_validation->set_rules('full_name', 'Nama', 'required|trim');
        $this->form_validation->set_rules('role_id', 'Role', 'required|integer');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username' . ($id ? '.id.' . $id : '') . ']');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email' . ($id ? '.id.' . $id : '') . ']');
        if (!$id) {
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        }
    }
}
