<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('form_validation', 'auth_lib'));
        $this->load->model('User_model');
        $this->load->helper(array('url', 'form'));
    }

    public function login()
    {
        if ($this->auth_lib->is_logged_in()) {
            return $this->redirect_after_login();
        }

        $this->form_validation->set_rules('identity', 'Email/Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('login_as', 'Tipe Akun', 'required|in_list[user,admin]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('auth/login', array(
                'title' => 'Masuk - Nipzz!! Store',
                'redirect' => $this->input->get('redirect')
            ));
            return;
        }

        $remember = $this->input->post('remember') ? TRUE : FALSE;
        $login_as = $this->input->post('login_as', TRUE);
        $user = $this->auth_lib->login(
            $this->input->post('identity', TRUE),
            $this->input->post('password'),
            $remember
        );

        if (!$user) {
            $this->session->set_flashdata('error', 'Email/username atau password salah.');
            redirect('auth/login');
        }

        $is_admin = in_array($user['role_slug'], array('super_admin', 'admin'), TRUE);
        if ($login_as === 'admin' && !$is_admin) {
            $this->auth_lib->logout();
            $this->session->set_flashdata('error', 'Akun ini bukan admin. Pilih tab User atau gunakan akun admin.');
            redirect('auth/login');
        }
        if ($login_as === 'user' && $is_admin) {
            $this->auth_lib->logout();
            $this->session->set_flashdata('error', 'Akun admin tidak bisa masuk sebagai User. Pilih tab Admin.');
            redirect('auth/login');
        }

        $this->load->model('Activity_log_model');
        $this->Activity_log_model->create(array(
            'user_id' => $user['id'],
            'action' => 'login',
            'description' => 'User login',
            'ip_address' => $this->input->ip_address()
        ));

        $redirect = $this->input->post('redirect') ?: $this->input->get('redirect');
        if ($redirect) {
            redirect($redirect);
        }
        if ($login_as === 'admin') {
            redirect('admin/dashboard');
        }
        redirect('shop');
    }

    public function register()
    {
        if ($this->auth_lib->is_logged_in()) {
            redirect('shop');
        }

        $this->form_validation->set_rules('full_name', 'Nama Lengkap', 'required|trim|min_length[3]');
        $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[3]|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('phone', 'Telepon', 'trim');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Konfirmasi Password', 'required|matches[password]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('auth/register', array('title' => 'Daftar - Nipzz!! Store'));
            return;
        }

        $user_id = $this->auth_lib->register(array(
            'full_name' => $this->input->post('full_name', TRUE),
            'username' => $this->input->post('username', TRUE),
            'email' => $this->input->post('email', TRUE),
            'phone' => $this->input->post('phone', TRUE),
            'password' => $this->input->post('password'),
            'password_confirm' => $this->input->post('password_confirm')
        ));

        if ($user_id) {
            $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login.');
            redirect('auth/login');
        }

        $this->session->set_flashdata('error', 'Registrasi gagal. Coba lagi.');
        redirect('auth/register');
    }

    public function forgot()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('auth/forgot', array('title' => 'Lupa Password - Nipzz!! Store'));
            return;
        }

        $result = $this->auth_lib->create_reset_token($this->input->post('email', TRUE));
        if ($result) {
            $reset_url = site_url('auth/reset/' . $result['token']);
            $this->session->set_flashdata('info', 'Link reset password: ' . $reset_url . ' (demo mode - email tidak dikirim)');
        } else {
            $this->session->set_flashdata('info', 'Jika email terdaftar, link reset akan dikirim.');
        }
        redirect('auth/forgot');
    }

    public function reset($token = '')
    {
        if (!$token) {
            show_404();
        }

        $this->form_validation->set_rules('password', 'Password Baru', 'required|min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Konfirmasi Password', 'required|matches[password]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('auth/reset', array('title' => 'Reset Password', 'token' => $token));
            return;
        }

        if ($this->auth_lib->reset_password($token, $this->input->post('password'))) {
            $this->session->set_flashdata('success', 'Password berhasil diubah. Silakan login.');
            redirect('auth/login');
        }

        $this->session->set_flashdata('error', 'Token tidak valid atau sudah kadaluarsa.');
        redirect('auth/forgot');
    }

    public function logout()
    {
        if ($this->auth_lib->is_logged_in()) {
            $user = $this->auth_lib->user();
            $this->load->model('Activity_log_model');
            $this->Activity_log_model->create(array(
                'user_id' => $user['id'],
                'action' => 'logout',
                'description' => 'User logout',
                'ip_address' => $this->input->ip_address()
            ));
        }
        $this->auth_lib->logout();
        redirect('auth/login');
    }

    protected function redirect_after_login()
    {
        if ($this->auth_lib->can_access_admin()) {
            redirect('admin/dashboard');
        }
        redirect('shop');
    }
}
