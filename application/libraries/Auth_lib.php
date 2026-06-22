<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_lib
{
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->model('User_model');
        $this->CI->load->model('Role_model');
        $this->CI->load->config('laptopku');
        $this->check_remember_me();
    }

    public function login($identity, $password, $remember = FALSE)
    {
        $user = $this->CI->User_model->find_by_identity($identity);
        if (!$user || !$user['is_active']) {
            return FALSE;
        }
        if (!password_verify($password, $user['password'])) {
            return FALSE;
        }

        $this->set_session($user);

        if ($remember) {
            $token = bin2hex(random_bytes(32));
            $this->CI->User_model->update($user['id'], array(
                'remember_token' => hash('sha256', $token),
                'remember_expires' => date('Y-m-d H:i:s', strtotime('+' . $this->CI->config->item('remember_me_days') . ' days'))
            ));
            $this->CI->input->set_cookie(array(
                'name' => 'remember_token',
                'value' => $user['id'] . ':' . $token,
                'expire' => 86400 * (int) $this->CI->config->item('remember_me_days'),
                'httponly' => TRUE
            ));
        }

        $this->CI->User_model->update($user['id'], array('last_login' => date('Y-m-d H:i:s')));
        return $this->user();
    }

    public function register($data)
    {
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        $data['role_id'] = $this->CI->Role_model->get_id_by_slug('user');
        $data['is_active'] = 1;
        unset($data['password_confirm']);
        return $this->CI->User_model->create($data);
    }

    public function logout()
    {
        $user = $this->user();
        if ($user) {
            $this->CI->User_model->update($user['id'], array('remember_token' => NULL, 'remember_expires' => NULL));
        }
        $this->CI->input->set_cookie('remember_token', '', -3600);
        $this->CI->session->unset_userdata(array('user_id', 'role_id', 'role_slug', 'logged_in'));
        $this->CI->session->sess_destroy();
    }

    public function is_logged_in()
    {
        return (bool) $this->CI->session->userdata('logged_in');
    }

    public function user()
    {
        if (!$this->is_logged_in()) {
            return NULL;
        }
        static $cached;
        if ($cached === NULL) {
            $cached = $this->CI->User_model->get_with_role($this->CI->session->userdata('user_id'));
        }
        return $cached;
    }

    public function can_access_admin()
    {
        $slug = $this->CI->session->userdata('role_slug');
        return in_array($slug, array('super_admin', 'admin'), TRUE);
    }

    public function has_permission($permission_slug)
    {
        $role_id = (int) $this->CI->session->userdata('role_id');
        if (!$role_id) {
            return FALSE;
        }
        if ($this->CI->session->userdata('role_slug') === 'super_admin') {
            return TRUE;
        }
        return $this->CI->Role_model->has_permission($role_id, $permission_slug);
    }

    public function create_reset_token($email)
    {
        $user = $this->CI->User_model->find_by_email($email);
        if (!$user) {
            return FALSE;
        }
        $token = bin2hex(random_bytes(32));
        $this->CI->User_model->update($user['id'], array(
            'reset_token' => hash('sha256', $token),
            'reset_expires' => date('Y-m-d H:i:s', strtotime('+' . $this->CI->config->item('reset_token_hours') . ' hours'))
        ));
        return array('user' => $user, 'token' => $token);
    }

    public function reset_password($token, $password)
    {
        $user = $this->CI->User_model->find_by_reset_token(hash('sha256', $token));
        if (!$user) {
            return FALSE;
        }
        $this->CI->User_model->update($user['id'], array(
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'reset_token' => NULL,
            'reset_expires' => NULL
        ));
        return TRUE;
    }

    protected function set_session($user)
    {
        $role = $this->CI->Role_model->get($user['role_id']);
        $this->CI->session->set_userdata(array(
            'user_id' => $user['id'],
            'role_id' => $user['role_id'],
            'role_slug' => $role ? $role['slug'] : 'user',
            'logged_in' => TRUE
        ));
    }

    protected function check_remember_me()
    {
        if ($this->is_logged_in()) {
            return;
        }
        $cookie = $this->CI->input->cookie('remember_token');
        if (!$cookie || strpos($cookie, ':') === FALSE) {
            return;
        }
        list($user_id, $token) = explode(':', $cookie, 2);
        $user = $this->CI->User_model->get((int) $user_id);
        if (!$user || !$user['remember_token'] || !$user['remember_expires']) {
            return;
        }
        if (strtotime($user['remember_expires']) < time()) {
            return;
        }
        if (!hash_equals($user['remember_token'], hash('sha256', $token))) {
            return;
        }
        $this->set_session($user);
    }
}
