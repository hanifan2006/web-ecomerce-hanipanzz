<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CI_Controller
{
    public function index()
    {
        if (ENVIRONMENT === 'production') {
            show_error('Disabled in production', 403);
        }
        $this->load->library('migration');
        if ($this->migration->latest() === FALSE) {
            show_error($this->migration->error_string());
        }
        echo 'Migration OK - version ' . $this->config->item('migration_version');
    }
}
