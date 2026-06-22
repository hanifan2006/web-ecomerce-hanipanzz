<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Install extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (ENVIRONMENT === 'production') {
            show_error('Install disabled in production.', 403);
        }
        $this->load->library('migration');
    }

    public function index()
    {
        $db_ok = FALSE;
        $message = '';

        try {
            $this->load->database();
            $db_ok = $this->db->conn_id ? TRUE : FALSE;
        } catch (Exception $e) {
            $message = $e->getMessage();
        }

        if ($this->input->get('run') === '1' && $db_ok) {
            if ($this->migration->latest() === FALSE) {
                $message = $this->migration->error_string();
            } else {
                $message = 'Database berhasil diinstall! Login: superadmin@laptopku.id / password123';
            }
        }

        $this->load->view('install', array(
            'db_ok' => $db_ok,
            'message' => $message,
            'current_version' => $this->migration->current() ? $this->config->item('migration_version') : 0
        ));
    }
}
