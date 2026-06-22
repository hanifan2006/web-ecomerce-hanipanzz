<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function index()
    {
        $this->require_permission('customers.view');
        $this->render('admin/customers/index', array(
            'title' => 'Data Pelanggan',
            'customers' => $this->User_model->get_customers()
        ));
    }

    public function export_excel()
    {
        $this->require_permission('customers.view');
        $customers = $this->User_model->get_customers();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=pelanggan_' . date('Ymd') . '.csv');
        $out = fopen('php://output', 'w');
        fputcsv($out, array('Nama', 'Email', 'Telepon', 'Pesanan', 'Total Belanja', 'Bergabung'));
        foreach ($customers as $c) {
            fputcsv($out, array($c['full_name'], $c['email'], $c['phone'], $c['order_count'], $c['total_spent'], $c['created_at']));
        }
        fclose($out);
        exit;
    }
}
