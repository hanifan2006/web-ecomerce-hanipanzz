<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_logs extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Activity_log_model');
    }

    public function index()
    {
        $this->require_permission('logs.view');
        $this->render('admin/activity_logs/index', array(
            'title' => 'Log Aktivitas',
            'logs' => $this->Activity_log_model->get_all(200)
        ));
    }
}
