<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('form');
    }

    public function index()
    {
        $this->require_permission('settings.manage');
        if ($this->input->method() === 'post') {
            $this->Setting_model->update_batch(array(
                'site_name' => $this->input->post('site_name', TRUE),
                'site_tagline' => $this->input->post('site_tagline', TRUE),
                'site_email' => $this->input->post('site_email', TRUE),
                'site_phone' => $this->input->post('site_phone', TRUE),
                'site_address' => $this->input->post('site_address', TRUE),
                'shipping_cost' => $this->input->post('shipping_cost', TRUE),
                'bank_account' => $this->input->post('bank_account', TRUE),
            ));
            $this->log_activity('settings.update', 'Memperbarui pengaturan');
            $this->session->set_flashdata('success', 'Pengaturan disimpan.');
            redirect('admin/settings');
        }
        $this->render('admin/settings/index', array(
            'title' => 'Pengaturan',
            'settings' => $this->Setting_model->get_all()
        ));
    }
}
