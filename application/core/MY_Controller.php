<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    protected $current_user;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('auth_lib');
        $this->current_user = $this->auth_lib->user();
    }
}

class Admin_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->auth_lib->is_logged_in()) {
            redirect('auth/login?redirect=' . urlencode(current_url()));
        }
        if (!$this->auth_lib->can_access_admin()) {
            $this->session->set_flashdata('error', 'Anda tidak memiliki akses ke panel admin.');
            redirect('shop');
        }
        $this->load->model('Menu_model');
        $this->load->model('Setting_model');
    }

    protected function render($view, $data = array(), $layout = 'admin/layouts/main')
    {
        $data['current_user'] = $this->current_user;
        $data['sidebar_menus'] = $this->Menu_model->get_for_user($this->current_user['role_id']);
        $data['settings'] = $this->Setting_model->get_all();
        $data['content'] = $this->load->view($view, $data, TRUE);
        $this->load->view($layout, $data);
    }

    protected function require_permission($permission)
    {
        if (!$this->auth_lib->has_permission($permission)) {
            show_error('Akses ditolak.', 403);
        }
    }

    protected function log_activity($action, $description = '')
    {
        $this->load->model('Activity_log_model');
        $this->Activity_log_model->create(array(
            'user_id' => $this->current_user['id'],
            'action' => $action,
            'description' => $description,
            'ip_address' => $this->input->ip_address()
        ));
    }
}

class Shop_Controller extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Setting_model');
    }

    protected function render($view, $data = array())
    {
        $data['current_user'] = $this->current_user;
        $data['settings'] = $this->Setting_model->get_all();
        $data['cart_count'] = $this->cart_count();
        $data['content'] = $this->load->view($view, $data, TRUE);
        $this->load->view('layouts/store', $data);
    }

    protected function cart_count()
    {
        $cart = $this->session->userdata('cart');
        if (!is_array($cart)) {
            return 0;
        }
        return array_sum(array_column($cart, 'qty'));
    }

    protected function require_login()
    {
        if (!$this->auth_lib->is_logged_in()) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu.');
            redirect('auth/login?redirect=' . urlencode(current_url()));
        }
    }
}
