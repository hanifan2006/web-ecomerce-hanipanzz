<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Order_model');
    }

    public function index()
    {
        $this->require_permission('orders.manage');
        $this->render('admin/orders/index', array(
            'title' => 'Manajemen Pesanan',
            'orders' => $this->Order_model->get_all(array(
                'status' => $this->input->get('status', TRUE),
                'search' => $this->input->get('q', TRUE)
            ))
        ));
    }

    public function history()
    {
        $this->require_permission('orders.manage');
        $this->render('admin/orders/history', array(
            'title' => 'Riwayat Transaksi',
            'orders' => $this->Order_model->get_all()
        ));
    }

    public function view($id)
    {
        $this->require_permission('orders.manage');
        $order = $this->Order_model->get((int) $id);
        if (!$order) show_404();
        $this->render('admin/orders/view', array('title' => 'Detail Pesanan', 'order' => $order));
    }

    public function update_status($id)
    {
        $this->require_permission('orders.manage');
        $status = $this->input->post('status', TRUE);
        $allowed = array('diproses', 'dikirim', 'selesai', 'dibatalkan');
        if (!in_array($status, $allowed, TRUE)) {
            show_error('Status tidak valid', 400);
        }
        $this->Order_model->update_status((int) $id, $status);
        $this->log_activity('order.status', 'Ubah status pesanan ID ' . $id . ' ke ' . $status);
        $this->session->set_flashdata('success', 'Status pesanan diperbarui.');
        redirect('admin/orders');
    }

    public function export_excel()
    {
        $this->require_permission('orders.manage');
        $orders = $this->Order_model->get_all();
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=pesanan_' . date('Ymd') . '.csv');
        $out = fopen('php://output', 'w');
        fputcsv($out, array('No Pesanan', 'Customer', 'Email', 'Total', 'Status', 'Tanggal'));
        foreach ($orders as $o) {
            fputcsv($out, array($o['order_number'], $o['customer_name'], $o['email'], $o['total'], $o['status'], $o['created_at']));
        }
        fclose($out);
        exit;
    }
}
