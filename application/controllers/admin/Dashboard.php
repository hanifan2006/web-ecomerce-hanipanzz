<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Order_model', 'Product_model', 'User_model'));
    }

    public function index()
    {
        $this->require_permission('dashboard.view');
        $this->render('admin/dashboard', array(
            'title' => 'Dashboard',
            'revenue' => $this->Order_model->get_total_revenue(),
            'order_count' => $this->Order_model->count_all(),
            'customer_count' => $this->User_model->count_by_role('user'),
            'total_sold' => $this->Product_model->get_total_sold(),
            'recent_orders' => $this->Order_model->get_recent(4),
            'low_stock' => $this->Product_model->get_low_stock(5)
        ));
    }
}
